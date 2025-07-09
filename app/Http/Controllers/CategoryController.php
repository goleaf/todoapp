<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Auth::user()->categories()->withCount('todos')->latest()->get();
        
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        ]);

        Auth::user()->categories()->create($validated);

        return redirect()->route('categories.index')
            ->with('status', __('messages.category_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): View
    {
        $this->authorize('view', $category);
        
        $todos = $category->todos()->latest()->paginate(10);
        
        return view('categories.show', compact('category', 'todos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        $this->authorize('update', $category);
        
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->authorize('update', $category);
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('status', __('messages.category_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $this->authorize('delete', $category);
        
        // When a category is deleted, associated todos will have their category_id set to null
        // because of the nullOnDelete constraint in the migration
        $category->delete();

        return redirect()->route('categories.index')
            ->with('status', __('messages.category_deleted'));
    }
}
