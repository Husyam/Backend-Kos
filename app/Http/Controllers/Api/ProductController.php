<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = $this->getProducts($request);
        $this->transformProducts($products);

        return response()->json([
            'status' => 'success',
            'data' => $products
        ], 200);
    }

    private function getProducts(Request $request)
    {
        return Product::when($request->id_category, function ($query) use ($request) {
            return $query->where('id_category', $request->id_category);
        })->paginate(10);
    }

    private function transformProducts($products)
    {
        $products->getCollection()->transform(function ($product) {
            $product->fasilitas = json_decode($product->fasilitas, true);
            $product->multi_image = $this->processMultiImage($product->multi_image);
            $product->image = $this->getFullImageUrl($product->image);
            return $product;
        });
    }

    private function processMultiImage($multiImage)
    {
        $decodedImages = json_decode($multiImage, true);
        return !empty($decodedImages) ? $this->getFullMultiImageUrl($decodedImages) : [];
    }

    private function getFullImageUrl($image)
    {
        return filter_var($image, FILTER_VALIDATE_URL)
            ? $image
            : url('storage/public/products/' . $image);
    }

    private function getFullMultiImageUrl($multiImage)
    {
        return array_map(function ($image) {
            return url('storage/public/products/multi/' . $image);
        }, $multiImage);
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
