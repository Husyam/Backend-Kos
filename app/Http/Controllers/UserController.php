<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');

    }
    //index
    public function index(Request $request)
    {

        //get users with paginate
        $users = DB::table('users')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->paginate(5);
        return view('pages.user.index', compact('users'));
    }

    //create
    public function create()
    {
        return view('pages.user.create');
    }

    //store
    public function store(Request $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($request->input('password'));
        User::create($data);
        return redirect()->route('user.index');
    }

    //show
    public function show($id)
    {
        return view('pages.dashboard');
    }

    public function showProfile()
    {
        $user = auth()->user();
        return view('pages.setting.profile');
    }

    //edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.edit', compact('user'));
    }

    //update
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $user = User::findOrFail($id);
        //check if password is empty
        if ($request->input('password')) {
            $data['password'] = Hash::make($request->input('password'));
        } else {
            $data['password'] = $user->password;
        }
        $user->update($data);
        return redirect()->route('user.index');
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

    //destroy
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
}
