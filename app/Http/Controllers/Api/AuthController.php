<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   public function register(Request $request)
   {
       $validated = $request->validate([
           'name' => 'required|max:100',
           'email' => 'required|email|unique:users',
           'password' => 'required|min:8',
           'phone' => 'required|max:15',
        //    'roles' => 'required|max:10',
       ]);

       $validated['password'] = Hash::make($validated['password']);
       $validated['roles'] = 'USER';  // Set default role to USER


       $user = User::create($validated);

       $token = $user->createToken('auth_token')->plainTextToken;

       return response()->json([
           'access_token' => $token,
           'user' => $user,
        //    'token_type' => 'Bearer',
       ],200);
   }



   //logout
    public function logout(Request $request)
    {
         $request->user()->currentAccessToken()->delete();
         return response()->json([
              'message' => 'Logout success',
         ],200);
    }

    //login
    public function login(Request $request)
    {

        $validated = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if(!$user){
            return response()->json([
                'message' => 'User Not Found'
            ], 401);
        }

        // Memeriksa role pengguna sebelum memberikan akses
        if ($user->roles !== 'USER') {
            return response()->json([
                'message' => 'User atau email tidak ditemukan'
            ], 403);
        }

        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid Password'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'message' => 'Login success'
        ], 200);
    }

    //login by user id
    public function loginById(Request $request, $id)
    {
        // Cari pengguna berdasarkan id
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User Not Found'
            ], 404);
        }

        return response()->json([
            'user' => $user,
        ], 200);
    }



    public function updateFcmId(Request $request){
        $validated = $request->validate([
            'fcm_id' => 'required'
        ]);

        $user = $request->user();
        $user->fcm_id = $validated['fcm_id'];
        $user->save();

        return response()->json([
            'message' => 'FCM ID updated'
        ], 200);
    }
}
