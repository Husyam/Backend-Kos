<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Import the User model
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;



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
       if (!$user) {
           return response()->json([
               'message' => 'Gagal membuat akun'
           ], 500);
       }
       $user->sendVerificationEmail();

       $token = $user->createToken('auth_token')->plainTextToken;

       return response()->json([
           'access_token' => $token,
           'user' => $user,
           'message' => 'Registrasi berhasil, Silahkan cek email untuk verifikasi akun',
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
        if (!$user) {
            return response()->json([
                'message' => 'User atau email tidak ditemukan'
            ], 401);
        }

        // Memeriksa role pengguna sebelum memberikan akses
        if ($user->roles !== 'USER') {
            return response()->json([
                'message' => 'User atau email tidak ditemukan'
            ], 403);
        }

        // Check password first
        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Password yang anda masukkan salah'
            ], 401);
        }

        // If password is correct, then check email verification
        if ($user->email_verified_at === null) {
            // Only resend verification email if password is correct
            $this->resend($request);
            return response()->json([
                'message' => 'Email belum terverifikasi, silahkan cek email untuk verifikasi'
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

    //edit akun by id_user yang sedang login
    public function editProfileById(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
            'phone' => 'nullable|string|max:20',
            // 'password' => 'nullable|string|min:8',
            //password bisa diisi atau tidak dan minimal 8 karakter dan unik berupa abjad dan angka
            'password' => 'nullable|string|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
        ]);

        //dapatkan access token yang ada
        $token = $user->currentAccessToken();

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

        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'message' => 'Profile berhasil diupdate'

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

    public function verify(Request $request, $id_user)
    {
        $user = User::find($id_user);
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email already verified'
            ], 200);
        }

        $user->markEmailAsVerified();
        $message = 'Email verified';
        // return view('verified-views', compact('message'));
        return view('pages.emails.verified-views', compact('message'));


    }

    // resend
    // resend
    // resend
    public function resend(Request $request = null)
    {
        if ($request) {
            $validated = $request->validate([
                'email' => 'required|email',
            ]);

            $user = User::where('email', $validated['email'])->first();
        } else {
            $user = auth()->user();
        }

        if (!$user) {
            return response()->json([
                'message' => 'User   not found'
            ], 404);
        }

        if ($user->email_verified_at !== null) {
            return response()->json([
                'message' => 'Email already verified'
            ], 200);
        }

        $user->sendVerificationEmail();
        return response()->json([
            'message' => 'Email verification sent'
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Reset password link sent to your email'], 200);
        } else {
            return response()->json(['message' => 'Unable to send reset link'], 400);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Check if the token is valid
        if (!Password::getRepository()->exists($request->email, $request->token)) {
            return response()->json(['message' => 'Token is invalid or has expired'], 400);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password has been successfully reset'], 200);
        }

        return response()->json(['message' => 'Unable to reset password'], 400);
    }

    public function checkResetToken(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
        ]);

        $status = Password::getRepository()->exists(
            $request->input('email'),
            $request->input('token')
        );

        if ($status) {
            return response()->json(['message' => 'Token is valid'], 200);
        } else {
            return response()->json(['message' => 'Token is invalid or has expired'], 400);
        }
    }


}
