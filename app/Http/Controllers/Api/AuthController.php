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
           'roles' => 'required|max:10',
       ]);

       $validated['password'] = Hash::make($validated['password']);

       $user = User::create($validated);

       $token = $user->createToken('auth_token')->plainTextToken;

       return response()->json([
           'access_token' => $token,
           'user' => $user,
        //    'token_type' => 'Bearer',
       ],201);
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

        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid Password '
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'acces_token' => $token,
            'user' => $user,
        ], 200);
    }
}
