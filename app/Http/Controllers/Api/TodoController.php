<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TodoRequest;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth; // Import TodoRequest
use Illuminate\Support\Facades\Lang;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Auth::user()->todos();

        // Filtering
        if ($status = request('status')) {
            $query->where('status', $status);
        }
        if ($priority = request('priority')) {
            $query->where('priority', $priority);
        }
        if ($dueDate = request('due_date')) {
            $query->whereDate('due_date', $dueDate);
        }

        // Sorting
        if ($sort = request('sort')) {
            $direction = request('direction', 'asc');
            $query->orderBy($sort, $direction);
        } else {
            $query->latest();
        }

        return response()->json($query->paginate(10));
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
