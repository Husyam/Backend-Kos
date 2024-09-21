<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonalDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $personalData = DB::table('personal_data')->where('id_user', $request->user()->id_user)->get();
        return response()->json([
            'status' => 'success',
            'data' => $personalData
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //save personaldata
        $personalData = DB::table('personal_data')->insert([
            'name' => $request->name,
            'gender'=> $request->gender,
            'profession'=> $request->profession,
            'contact'=> $request->contact,
            'id_user'=> $request->user()->id_user,
            'is_default'=> $request->is_default,

        ]);

        if ($personalData) {
            return response()->json([
                'status' => 'success',
                'data' => $personalData,
                'message' => 'Data personal berhasil disimpan',
            ], 201);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Data personal gagal disimpan'
            ], 400);
        }
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

    // edit personal data yang sedang login
    public function editProfileById(Request $request)
    {
         $personalData = DB::table('personal_data')->where('id_user', $request->user()->id_user)->first();

        $request->validate([
            'name' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'profession' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
        ]);

        $personalData = DB::table('personal_data')->where('id_user', $request->user()->id_user)->update([
            'name' => $request->name,
            'gender' => $request->gender,
            'profession' => $request->profession,
            'contact' => $request->contact,
        ]);

        if ($personalData) {
            return response()->json([
                'status' => 'success',
                'data' => $personalData,
                'message' => 'Data personal berhasil diupdate',
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Data personal gagal diupdate'
            ], 400);
        }

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
