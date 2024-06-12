<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // //get all categories
        // $categories = Category::all();
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $categories
        // ], 200);

        // Get all categories
        // $categories = Category::all()->map(function ($category) {
        //     // Tambahkan URL lengkap untuk gambar
        //     if (!filter_var($category->image, FILTER_VALIDATE_URL)) {
        //         $category->image = url('storage/categories/' . $category->image);
        //     }
        //     return $category;
        // });

        // return response()->json([
        //     'status' => 'success',
        //     'data' => $categories
        // ], 200);
        // Get all categories

        $categories = Category::all()->map(function ($category) {
            // Tambahkan URL lengkap untuk gambar
            $category->image = $this->getFullImageUrl($category->image);
            return $category;
        });

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ], 200);
    }

    private function getFullImageUrl($image)
    {
        // Jika gambar sudah merupakan URL lengkap, tidak perlu mengubahnya
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }

        // Menghasilkan URL gambar yang lengkap
        return url('storage/public/categories/' . $image);
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
