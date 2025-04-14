<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the user's categories.
     */
    public function index(Request $request)
    {
        $categories = $request->user()->categories()
            ->withCount('todos')
            ->latest()
            ->get();
            
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();
        $category = $request->user()->categories()->create($validated);
        
        return (new CategoryResource($category))
            ->additional(['message' => __('messages.category_created')])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified category.
     */
    public function show(Request $request, Category $category)
    {
        // Implicit model binding handles not found, check ownership
        if ($request->user()->id !== $category->user_id) {
            return response()->json([
                'message' => __('messages.unauthorized')
            ], 403);
        }
        
        return new CategoryResource($category->loadCount('todos'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        if ($request->user()->id !== $category->user_id) {
            return response()->json([
                'message' => __('messages.unauthorized')
            ], 403);
        }

        $validated = $request->validated();
        $category->update($validated);
        
        return (new CategoryResource($category))
            ->additional(['message' => __('messages.category_updated')]);
    }

    /**
     * Remove the specified category from storage.
     * Note: Associated todos will have category_id set to null due to DB constraint.
     */
    public function destroy(Request $request, Category $category)
    {
        if ($request->user()->id !== $category->user_id) {
            return response()->json([
                'message' => __('messages.unauthorized')
            ], 403);
        }

        $category->delete();

        return response()->json([
            'message' => __('messages.category_deleted')
        ], 200);
    }
}
