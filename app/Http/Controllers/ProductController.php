<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    //index
    public function index(Request $request)
    {
        // $products = \App\Models\Product::paginate(5);
        // // $products = Product::all();
        // return view('pages.product.index', compact('products'));

        //$products = \App\Models\Product::paginate(5);

        // $products = DB::table('products')
        //     ->when($request->input('name'), function ($query, $name) {
        //         return $query->where('name', 'like', '%' . $name . '%');
        //     })
        //     ->paginate(5);

        // foreach ($products as $product) {
        //     $product->fasilitas = json_decode($product->fasilitas, true);
        // }
        // return view('pages.product.index', compact('products'));

        if (Auth::user()->roles == 'ADMIN') {
            $products = Product::when($request->has('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%'. $request->name. '%');
            })->paginate(10);
        } else {
            $products = Product::where('user_id', auth()->id())
                ->when($request->has('name'), function ($query) use ($request) {
                    $query->where('name', 'like', '%'. $request->name. '%');
                })->paginate(10);
        }

        foreach ($products as $product) {
            $product->fasilitas = json_decode($product->fasilitas, true);
        }
        return view('pages.product.index', compact('products'));
    }

    //create
    public function create()
    {
        $categories = \App\Models\Category::all();
        $facilities =['AC', 'Non AC', 'Kipas', 'Wifi', 'Kulkas', 'TV', 'Kamar Mandi', 'Smoking Area'];

        return view('pages.product.create', compact('categories', 'facilities'));
    }

    //store
    public function store(Request $request)
    {
        //filename
        $filename = time() . '.' . $request->image->extension();
        //upload image
        $request->image->storeAs('public/products', $filename);

        // Upload multiple images
        $images = [];
        if ($request->hasFile('images')) {
            $counter = 1;
            foreach ($request->file('images') as $image) {
                $filenameMulti = time() . '_' . $counter . '.' . $image->extension();
                $image->storeAs('public/products/multi', $filenameMulti);
                $images[] = $filenameMulti;
                $counter++;
            }
        }
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
        // $product->fasilitas = json_encode($request->fasilitas);
        //user_id save
        // $product->user_id = auth()->id();
        $product->fasilitas = json_encode($request->input('fasilitas', []));
        $product->user_id = auth()->id();
        $product->multi_image = json_encode($images);
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product created successfully berhasil');
    }

    //edit
    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = \App\Models\Category::all();
        $facilities = ['AC', 'Wifi', 'Kulkas', 'TV', 'Kamar Mandi', 'smoking area'];

        return view('pages.product.edit', compact('product', 'categories', 'facilities'));
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
        $product->fasilitas = json_encode($request->input('fasilitas', []));
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
