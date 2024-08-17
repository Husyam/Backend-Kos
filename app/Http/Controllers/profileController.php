<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class profileController extends Controller
{
    public function showProfile()
    {
        $user = auth()->user();
        return view('pages.setting.profile');
    }
    public function editProfile()
    {
        $user = auth()->user();
        return view('pages.setting.edit', compact('user'));
    }


    //update profile by id_user yang sedang login
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
        ]);

        User::where('id_user', $user->id_user)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            //update password
            'password' => Hash::make($request->password),
        ]);

        //update password
        if ($request->password) {
            User::where('id_user', $user->id_user)->update([
                'password' => Hash::make($request->password),
            ]);
        }


        return redirect()->route('profile')->with('success', 'Profile berhasil diupdate');
    }
}
