<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }
    // Return pages category
    public function index(Request $request)
    {
        $categories = DB::table('categories')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->paginate(5);

        return view('pages.category.index', compact('categories'));
    }

    // Create
    public function create()
    {
        return view('pages.category.create');
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/categories', $filename);

        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->image = $filename;
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category has been added');
    }

    // Edit
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.category.edit', compact('category'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            // Delete the old image
            if ($category->image && Storage::exists('public/categories/' . $category->image)) {
                Storage::delete('public/categories/' . $category->image);
            }

            // Store the new image
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/categories', $filename);
            $category->image = $filename;
        }

        $category->save();

        return redirect()->route('category.index')->with('success', 'Category has been updated');
    }

    // Destroy
    public function destroy($category_id)
    {
        $category = Category::findOrFail($category_id);

        // Delete the image from storage
        if ($category->image && Storage::exists('public/categories/' . $category->image)) {
            Storage::delete('public/categories/' . $category->image);
        }

        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category has been deleted');
    }
}
