<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //return pages category
    public function index()
    {
        $categories = \App\Models\Category::paginate(5);
        return view('pages.category.index', compact('categories'));
        // return view('pages.category.index');
    }

    //create
    public function create()
    {
        return view('pages.category.create');
    }

    //store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'description' => 'required|max:100',
        ]);

        $category = \App\Models\Category::create($validated);
        return redirect()->route('category.index')->with('success', 'Category has been added');

    }

    //edit
    public function edit($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        return view('pages.category.edit', compact('category'));
    }

    //update
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'description' => 'required|max:100',
        ]);

        $category = \App\Models\Category::findOrFail($id);
        $category->update($validated);
        return redirect()->route('category.index')->with('success', 'Category has been updated');
    }

    //destroy
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category has been deleted');
    }
}
