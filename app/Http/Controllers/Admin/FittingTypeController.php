<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FittingType;
use App\Models\Category;
use Illuminate\Http\Request;

class FittingTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = FittingType::with('category')->latest();

        if($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if($request->filled('search')) {
            $query->where('name', 'LIKE', '%'.$request->search.'%');
        }

        $fittingTypes = $query->paginate(15);
        $categories   = Category::active()->get();

        return view('admin.fitting-types.index',
            compact('fittingTypes', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->orderBy('sort_order')->get();
        return view('admin.fitting-types.create',
            compact('categories'));
    }

    public function store(Request $request)
    {
         $request->validate([
        'category_id'   => 'required|exists:categories,id',
        'name'          => 'required|string|max:255|min:2',
        'standard_time' => 'required|integer|min:1|max:9999',
        'unit'          => 'required|string|max:50',
        'description'   => 'nullable|string|max:500',
    ], [
        'category_id.required'   => 'Please select a category!',
        'name.required'          => 'Product name is required!',
        'name.min'               => 'Name must be at least 2 characters!',
        'standard_time.required' => 'Standard time is required!',
        'standard_time.min'      => 'Standard time must be at least 1 minute!',
        'standard_time.integer'  => 'Standard time must be a number!',
        'unit.required'          => 'Unit is required! (e.g. per box, per sheet)',
    ]);

        FittingType::create([
            'category_id'   => $request->category_id,
            'name'          => $request->name,
            'standard_time' => $request->standard_time,
            'unit'          => $request->unit,
            'description'   => $request->description,
            'sort_order'    => $request->sort_order ?? 0,
            'is_active'     => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.fitting-types.index')
            ->with('success', 'Products created!');
    }

    public function edit(FittingType $fittingType)
    {
        $categories = Category::active()->orderBy('sort_order')->get();
        return view('admin.fitting-types.edit',
            compact('fittingType', 'categories'));
    }

    public function update(Request $request, FittingType $fittingType)
    {
        $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'name'          => 'required|string|max:255',
            'standard_time' => 'required|integer|min:1',
            'unit'          => 'required|string|max:100',
        ]);

        $fittingType->update([
            'category_id'   => $request->category_id,
            'name'          => $request->name,
            'standard_time' => $request->standard_time,
            'unit'          => $request->unit,
            'description'   => $request->description,
            'sort_order'    => $request->sort_order ?? 0,
            'is_active'     => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.fitting-types.index')
            ->with('success', 'Products updated!');
    }

    public function destroy(FittingType $fittingType)
    {
        $fittingType->delete();
        return redirect()
            ->route('admin.fitting-types.index')
            ->with('success', 'Product deleted!');
    }
}