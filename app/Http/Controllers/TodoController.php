<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('todos.create', compact('categories', 'parentTodos'));
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
        ]);

        // Set user ID
        $validated['user_id'] = Auth::id();
        
        // Create the todo
        Todo::create($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Todo created successfully.');
    }

    /**
     * Display the specified todo.
     */
    public function show(Todo $todo)
    {
        // Check if the todo belongs to the authenticated user
        if (Auth::id() !== $todo->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Load relationships
        $todo->load(['category', 'subtasks']);

        return view('todos.show', compact('todo'));
    }

    /**
     * Show the form for editing the specified todo.
     */
    public function edit(Todo $todo)
    {
        // Check if the todo belongs to the authenticated user
        if (Auth::id() !== $todo->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        $parentTodos = Todo::where('user_id', Auth::id())
            ->whereNull('parent_id')
            ->where('id', '!=', $todo->id) // Exclude the current todo
            ->get();

        return view('todos.edit', compact('todo', 'categories', 'parentTodos'));
    }

    /**
     * Update the specified todo in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        // Check if the todo belongs to the authenticated user
        if (Auth::id() !== $todo->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|string|in:low,medium,high',
            'status' => 'required|string|in:pending,in_progress,completed',
            'category_id' => 'nullable|exists:categories,id',
            'parent_id' => 'nullable|exists:todos,id',
        ]);

        // Ensure a todo can't be its own parent
        if (isset($validated['parent_id']) && $validated['parent_id'] == $todo->id) {
            return redirect()->back()
                ->withErrors(['parent_id' => 'A todo cannot be its own parent.'])
                ->withInput();
        }

        $todo->update($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Todo updated successfully.');
    }

    /**
     * Remove the specified todo from storage.
     */
    public function destroy(Todo $todo)
    {
        // Check if the todo belongs to the authenticated user
        if (Auth::id() !== $todo->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $todo->delete();

        return redirect()->route('todos.index')
            ->with('success', 'Todo deleted successfully.');
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
            'message' => __('Todo status updated successfully'),
            'parentUpdated' => $parentUpdated,
            'parentId' => $parentId,
            'status' => $status,
            'oldStatus' => $oldStatus
        ]);
    }
} 