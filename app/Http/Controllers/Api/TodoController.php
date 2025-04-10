<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TodoRequest;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth; // Import TodoRequest
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request; // Add this line

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // Inject Request
    {
        // Use $request->user()->id for explicit user scope
        $userId = $request->user()->id;
        $query = Todo::query()->where('user_id', $userId);

        // --- DEBUGGING --- >>
        /* dd([
            'userId' => $userId,
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
            'count_before_filters' => $query->count(),
        ]); */
        // --- DEBUGGING --- <<

        // Filtering
        if ($status = $request->input('status')) { // Use $request->input()
            $query->where('status', $status);
        }
        if ($priority = $request->input('priority')) { // Use $request->input()
            $query->where('priority', $priority);
        }
        if ($dueDate = $request->input('due_date')) { // Use $request->input()
            $query->whereDate('due_date', $dueDate);
        }

        // Sorting
        if ($sort = $request->input('sort')) { // Use $request->input()
            $direction = $request->input('direction', 'asc'); // Use $request->input()
            $query->orderBy($sort, $direction);
        } else {
            $query->latest();
        }

        // Eager load the user relationship
        // $todos = $query->with('user')->paginate(10);
        $todos = $query->paginate(10); // Revert back to paginate()
        // $todos = $query->get(); // Use get() instead of paginate()

        return response()->json($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoRequest $request)
    {
        $todo = Auth::user()->todos()->create($request->validated());

        return response()->json($todo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo) // Use route model binding
    {
        // Check if the authenticated user owns this todo
        if (Auth::id() !== $todo->user_id) {
            return response()->json(['message' => Lang::get('messages.unauthorized')], 403); // Forbidden
        }

        return response()->json($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoRequest $request, Todo $todo) // Use route model binding
    {
        // Check if the authenticated user owns this todo
        if (Auth::id() !== $todo->user_id) {
            return response()->json(['message' => Lang::get('messages.unauthorized')], 403); // Forbidden
        }
        $todo->update($request->validated());

        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo) // Use route model binding
    {
        // Check if the authenticated user owns this todo
        if (Auth::id() !== $todo->user_id) {
            return response()->json(['message' => Lang::get('messages.unauthorized')], 403); // Forbidden
        }

        $todo->delete();

        return response()->json(null, 204);
    }
}
