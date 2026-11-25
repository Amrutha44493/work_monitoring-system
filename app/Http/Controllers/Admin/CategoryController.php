<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('fittingTypes')
            ->latest()
            ->paginate(10);

        return view('admin.categories.index',
            compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
         $request->validate([
        'name'        => 'required|string|max:255|min:2|unique:categories,name',
        'description' => 'nullable|string|max:500',
    ], [
        'name.required' => 'Category name is required!',
        'name.min'      => 'Name must be at least 2 characters!',
        'name.unique'   => 'This category already exists!',
        'description.max' => 'Description cannot exceed 500 characters!',
    ]);

        Category::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit',
            compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,'.$category->id,
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ]);

        $category->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted!');
    }
}