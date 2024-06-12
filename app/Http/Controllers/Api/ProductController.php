<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //get all products or search by category_id pagination
        $products = Product::when($request->category_id, function ($query) use ($request) {
            return $query->where('category_id', $request->category_id);
        })->paginate(10);

        // Tambahkan URL lengkap untuk gambar
        $products->getCollection()->transform(function ($product) {
            $product->image = $this->getFullImageUrl($product->image);
            return $product;
        });

        return response()->json([
            'status' => 'success',
            'data' => $products
        ], 200);

    }

    private function getFullImageUrl($image)
    {
        // Jika gambar sudah merupakan URL lengkap, tidak perlu mengubahnya
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }

        // Menghasilkan URL gambar yang lengkap
        return url('storage/public/products/' . $image);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
