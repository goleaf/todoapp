<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TodoRequest;
use App\Http\Resources\TodoCollection;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth; // Import TodoRequest
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request; // Add this line

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $query = Todo::query()
            ->where('user_id', $userId)
            ->with(['category', 'subtasks']); // Eager load category and subtasks

        // --- DEBUGGING --- >>
        /* dd([
            'userId' => $userId,
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
            'count_before_filters' => $query->count(),
        ]); */
        // --- DEBUGGING --- <<

        // Filter by parent_id (show top-level or specific subtasks)
        $parentId = $request->input('parent_id');
        if ($parentId === 'null' || $parentId === '0' || $parentId === null) {
            $query->whereNull('parent_id'); // Default: show only top-level tasks
        } elseif (is_numeric($parentId) && $parentId > 0) {
            $query->where('parent_id', (int)$parentId);
        } // If parent_id is not provided or invalid, default behaviour (top-level) applies

        // Filtering by category
        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        // Filtering
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($priority = $request->input('priority')) {
            $query->where('priority', $priority);
        }
        if ($dueDate = $request->input('due_date')) {
            $query->whereDate('due_date', $dueDate);
        }

        // Sorting
        if ($sort = $request->input('sort')) {
            $direction = $request->input('direction', 'asc');
            $query->orderBy($sort, $direction);
        } else {
            $query->latest(); // Default sort for top-level tasks
        }

        $todos = $query->paginate($request->input('per_page', 15)); // Use configurable per_page

        return new TodoCollection($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoRequest $request)
    {
        // Ensure parent_id belongs to the user if provided
        if ($request->filled('parent_id') && !$request->user()->todos()->where('id', $request->parent_id)->exists()) {
             return response()->json([
                'message' => __('messages.invalid_parent'),
                'errors' => [
                    'parent_id' => [__('messages.invalid_parent')]
                ]
            ], 422);
        }

        $todo = $request->user()->todos()->create($request->validated());
        $todo->load('category'); // Load relationship for response

        return (new TodoResource($todo))
            ->additional(['message' => __('messages.todo_created')])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Todo $todo)
    {
        if ($request->user()->id !== $todo->user_id) {
            return response()->json([
                'message' => __('messages.unauthorized'),
                'errors' => ['authorization' => [__('messages.unauthorized')]]
            ], 403);
        }

        $todo->load(['category', 'parent', 'subtasks']); // Eager load all related data

        return new TodoResource($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        if ($request->user()->id !== $todo->user_id) {
            return response()->json([
                'message' => __('messages.unauthorized'),
                'errors' => ['authorization' => [__('messages.unauthorized')]]
            ], 403);
        }

        // Ensure parent_id belongs to the user if provided and is valid
        if ($request->filled('parent_id')) {
            if ($request->parent_id == $todo->id) { // Already checked by Rule::notIn in request, but double-check
                 return response()->json([
                    'message' => __('messages.todo_self_parent'),
                    'errors' => [
                        'parent_id' => [__('messages.todo_self_parent')]
                    ]
                ], 422);
            }
            if (!$request->user()->todos()->where('id', $request->parent_id)->exists()) {
                 return response()->json([
                    'message' => __('messages.invalid_parent'),
                    'errors' => [
                        'parent_id' => [__('messages.invalid_parent')]
                    ]
                ], 422);
            }
        }

        $todo->update($request->validated());
        $todo->load('category', 'subtasks'); // Load relationships for response

        return (new TodoResource($todo))
            ->additional(['message' => __('messages.todo_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Todo $todo)
    {
        if ($request->user()->id !== $todo->user_id) {
            return response()->json([
                'message' => __('messages.unauthorized'),
                'errors' => ['authorization' => [__('messages.unauthorized')]]
            ], 403);
        }

        // Note: Deleting a parent task will cascade delete subtasks due to DB constraint
        $todo->delete();

        return response()->json([
            'message' => __('messages.todo_deleted')
        ], 204);
    }
}
