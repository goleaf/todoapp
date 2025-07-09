<?php

namespace App\Http\Controllers;

use App\Enums\TodoPriority;
use App\Enums\TodoStatus;
use App\Models\Todo;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class TodoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's todos.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $query = Todo::query()
            ->where('user_id', $userId)
            ->with(['category', 'subtasks']);

        // Filter by parent_id (show top-level or specific subtasks)
        $parentId = $request->input('parent_id');
        if ($parentId === null) {
            $query->whereNull('parent_id'); // Default: show only top-level tasks
        } elseif (is_numeric($parentId) && $parentId > 0) {
            $query->where('parent_id', (int)$parentId);
        }

        // Filtering by category
        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        // Filtering by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Sorting
        if ($sort = $request->input('sort')) {
            $direction = $request->input('direction', 'asc');
            $query->orderBy($sort, $direction);
        } else {
            $query->latest(); // Default sort by creation date
        }

        $todos = $query->paginate(10);
        $categories = Category::all(); // Get all categories for the filter dropdown

        return view('todos.index', compact('todos', 'categories'));
    }

    /**
     * Show the form for creating a new todo.
     */
    public function create()
    {
        $categories = Category::all();
        $parentTodos = Todo::where('user_id', Auth::id())
            ->whereNull('parent_id')
            ->get();
        
        $statuses = collect(TodoStatus::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()]);
        $priorities = collect(TodoPriority::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()]);

        return view('todos.create', compact('categories', 'parentTodos', 'statuses', 'priorities'));
    }

    /**
     * Store a newly created todo in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|string|in:low,medium,high',
            'status' => 'nullable|string|in:pending,in_progress,completed',
            'category_id' => 'nullable|exists:categories,id',
            'parent_id' => 'nullable|exists:todos,id',
            'is_recurring' => 'nullable|boolean',
            'repeat_frequency' => 'required_if:is_recurring,1|nullable|in:daily,weekly,monthly,custom',
            'repeat_interval' => 'required_if:is_recurring,1|nullable|integer|min:1|max:365',
            'repeat_days' => 'nullable|array',
            'repeat_days.*' => 'nullable|integer|min:1|max:7',
            'repeat_until' => 'nullable|date|after_or_equal:due_date',
        ]);

        // Set user ID
        $validated['user_id'] = Auth::id();
        
        // Handle repeat_days field, convert to JSON
        if (isset($validated['repeat_days']) && is_array($validated['repeat_days'])) {
            $validated['repeat_days'] = array_filter($validated['repeat_days']); // Remove empty values
        }
        
        // If not recurring, unset recurring fields
        if (!($validated['is_recurring'] ?? false)) {
            unset($validated['repeat_frequency']);
            unset($validated['repeat_interval']);
            unset($validated['repeat_days']);
            unset($validated['repeat_until']);
        }
        
        // Create the todo
        $todo = Todo::create($validated);
        
        // If it's a recurring todo, generate the first instance
        if ($todo->is_recurring) {
            // Run the generate command to create the first instance
            $this->dispatch(new \App\Jobs\GenerateRecurringTodoInstances($todo));
        }

        return redirect()->route('todos.index')
            ->with('success', __('messages.todo_created'));
    }

    /**
     * Display the specified todo.
     */
    public function show(Todo $todo)
    {
        // Check if the todo belongs to the authenticated user
        if (Auth::id() !== $todo->user_id) {
            abort(403, __('messages.unauthorized'));
        }

        // Load relationships
        $todo->load(['category', 'subtasks', 'recurrenceInstances']);

        return view('todos.show', compact('todo'));
    }

    /**
     * Show the form for editing the specified todo.
     */
    public function edit(Todo $todo)
    {
        // Check if the todo belongs to the authenticated user
        if (Auth::id() !== $todo->user_id) {
            abort(403, __('messages.unauthorized'));
        }

        $categories = Category::all();
        $parentTodos = Todo::where('user_id', Auth::id())
            ->whereNull('parent_id')
            ->where('id', '!=', $todo->id) // Exclude the current todo
            ->get();
            
        $statuses = collect(TodoStatus::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()]);
        $priorities = collect(TodoPriority::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()]);

        return view('todos.edit', compact('todo', 'categories', 'parentTodos', 'statuses', 'priorities'));
    }

    /**
     * Update the specified todo in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        // Check if the todo belongs to the authenticated user
        if (Auth::id() !== $todo->user_id) {
            abort(403, __('messages.unauthorized'));
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|string|in:low,medium,high',
            'status' => 'required|string|in:pending,in_progress,completed',
            'category_id' => 'nullable|exists:categories,id',
            'parent_id' => 'nullable|exists:todos,id',
            'is_recurring' => 'nullable|boolean',
            'repeat_frequency' => 'required_if:is_recurring,1|nullable|in:daily,weekly,monthly,custom',
            'repeat_interval' => 'required_if:is_recurring,1|nullable|integer|min:1|max:365',
            'repeat_days' => 'nullable|array',
            'repeat_days.*' => 'nullable|integer|min:1|max:7',
            'repeat_until' => 'nullable|date|after_or_equal:due_date',
        ]);

        // Ensure a todo can't be its own parent
        if (isset($validated['parent_id']) && $validated['parent_id'] == $todo->id) {
            return redirect()->back()
                ->withErrors(['parent_id' => __('messages.todo_self_parent')])
                ->withInput();
        }
        
        // Handle repeat_days field, convert to JSON
        if (isset($validated['repeat_days']) && is_array($validated['repeat_days'])) {
            $validated['repeat_days'] = array_filter($validated['repeat_days']); // Remove empty values
        }
        
        // If not recurring, unset recurring fields
        if (!($validated['is_recurring'] ?? false)) {
            $validated['repeat_frequency'] = null;
            $validated['repeat_interval'] = null;
            $validated['repeat_days'] = null;
            $validated['repeat_until'] = null;
        }
        
        // Only allow updating recurring properties on parent todos, not instances
        if ($todo->recurring_parent_id !== null) {
            unset($validated['is_recurring']);
            unset($validated['repeat_frequency']);
            unset($validated['repeat_interval']);
            unset($validated['repeat_days']);
            unset($validated['repeat_until']);
        }

        $todo->update($validated);
        
        // If it's a recurring todo and the fields have changed, regenerate instances
        if ($todo->is_recurring && $todo->isDirty([
            'due_date', 'repeat_frequency', 'repeat_interval', 'repeat_days', 'repeat_until'
        ])) {
            // Remove future instances
            $todo->recurrenceInstances()
                ->where('due_date', '>', now())
                ->delete();
                
            // Regenerate instances
            $this->dispatch(new \App\Jobs\GenerateRecurringTodoInstances($todo));
        }

        return redirect()->route('todos.index')
            ->with('success', __('messages.todo_updated'));
    }

    /**
     * Remove the specified todo from storage.
     */
    public function destroy(Todo $todo)
    {
        // Check if the todo belongs to the authenticated user
        if (Auth::id() !== $todo->user_id) {
            abort(403, __('messages.unauthorized'));
        }
        
        // If this is a recurring parent, delete all its instances
        if ($todo->is_recurring) {
            $todo->recurrenceInstances()->delete();
        }

        $todo->delete();

        return redirect()->route('todos.index')
            ->with('success', __('messages.todo_deleted'));
    }

    /**
     * Update the status of a todo item via AJAX
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, Todo $todo)
    {
        $request->validate([
            'status' => 'required|string|in:not_started,in_progress,completed,on_hold,cancelled',
        ]);
        
        $status = $request->input('status');
        $oldStatus = $todo->status;
        $todo->status = $status;
        $todo->save();
        
        $parentUpdated = false;
        $parentId = null;
        
        // If this is a subtask, update the parent todo's completion status
        if ($todo->parent_id) {
            $parent = Todo::find($todo->parent_id);
            if ($parent) {
                $parentId = $parent->id;
                $totalSubtasks = $parent->children()->count();
                $completedSubtasks = $parent->children()->where('status', 'completed')->count();
                
                // Update parent status calculation logic here if needed
                $parentUpdated = true;
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => __('messages.todo_status_updated'),
            'parentUpdated' => $parentUpdated,
            'parentId' => $parentId,
            'status' => $status,
            'oldStatus' => $oldStatus
        ]);
    }
} 