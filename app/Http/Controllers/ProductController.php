<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //index
    public function index()
    {
        $products = \App\Models\Product::paginate(5);
        // $products = Product::all();
        return view('pages.product.index', compact('products'));
    }

    //create
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('pages.product.create', compact('categories'));
    }

    //store
    public function store(Request $request)
    {
        //filename
        $filename = time() . '.' . $request->image->extension();
        //upload image
        $request->image->storeAs('public/products', $filename);

        // $data = request()->all();
        $product = new \App\Models\Product;
        $product->name = $request->name;
        $product->name_owner = $request->name_owner;
        $product->no_kontak = $request->no_kontak;
        $product->price = (int) $request->price;
        $product->description = $request->description;
        $product->stock = (int) $request->stock;
        $product->latitude = $request->latitude;
        $product->longitude = $request->longitude;
        $product->address = $request->address;
        $product->category_gender = $request->category_gender;
        $product->category_id = $request->category_id;
        $product->image = $filename;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product created successfully berhasil');
    }

    //edit
    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('pages.product.edit', compact('product', 'categories'));
    }

    //update
    public function update(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->name = $request->name;
        $product->name_owner = $request->name_owner;
        $product->category_gender = $request->category_gender;
        $product->no_kontak = $request->no_kontak;
        $product->price = (int) $request->price;
        $product->description = $request->description;
        $product->stock = (int) $request->stock;
        $product->address = $request->address;
        $product->latitude = $request->latitude;
        $product->longitude = $request->longitude;
        $product->category_id = $request->category_id;

        if ($request->image) {
            //filename
            $filename = time() . '.' . $request->image->extension();
            //upload image
            $request->image->storeAs('public/products', $filename);
            $product->image = $filename;
        }

        $product->save();

        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    //destroy
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }
}
