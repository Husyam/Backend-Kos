<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        //get all products or search by category_id pagination
        $products = Product::when($request->category_id, function ($query) use ($request) {
            return $query->where('category_id', $request->category_id);
        })->paginate(10);

        // Dekode string JSON fasilitas untuk setiap produk
        $products->getCollection()->transform(function ($product) {
            $product->fasilitas = json_decode($product->fasilitas, true);
            return $product;
        });

        $products->getCollection()->transform(function ($product) {
            $product->multi_image = json_decode($product->multi_image, true);
            return $product;
        });

        // Tambahkan URL lengkap untuk gambar
        $products->getCollection()->transform(function ($product) {
            $product->image = $this->getFullImageUrl($product->image);
            return $product;
        });

        //tambahkan URL lengkap untuk multiImage with array
        $products->getCollection()->transform(function ($product) {
            if (!empty($product->multi_image)) {
                $product->multi_image = $this->getFullMultiImageUrl($product->multi_image);
            } else {
                $product->multi_image = []; // or some other default value
            }
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

    // fungsi getmultiimage
    private function getFullMultiImageUrl($multi_image)
    {
        $urls = [];
        foreach ($multi_image as $image) {
            $urls[] = url('storage/public/products/multi/' . $image);
        }
        return $urls;
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
