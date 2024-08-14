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


    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        if ($request->input('password')) {
            $data['password'] = Hash::make($request->input('password'));
        } else {
            $data['password'] = $user->password;
        }
        $user->save();
        // return redirect()->route('pages.setting.profile')->with('success', 'Profile updated successfully!');
        return redirect()->route('profile')->with('success', 'Profile updated successfully!');

    }
}
