<?php

namespace App\Http\Controllers;

use App\helpers\ResponseFormatter;
use App\Http\Resources\UserProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        $data = User::where('email', $request->email)->first();

        if (!$data) {
            return ResponseFormatter::error('user gagal ditambahkan');
        }

        return ResponseFormatter::success($data);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['email atau password salah'],
            ]);
        }

        $token = $user->createToken($request->email)->plainTextToken;

        $data = [
            'user' => $user,
            'token' => 'Bearer ' . $token
        ];

        return ResponseFormatter::success($data);
    }

    public function profile(Request $request)
    {
        $user = User::with('article')->where('email', $request->email)->first();

        $data = new UserProfileResource($user);

        return ResponseFormatter::success($data);
    }

    public function logout(Request $request)
    {
        $data = PersonalAccessToken::findToken($request->bearerToken());

        if ($data == null) {
            return ResponseFormatter::error('logout gagal, token tidak ditemukan');
        }

        $data->delete();

        return ResponseFormatter::success($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $data = User::where('email', $request->email);

        $update = $data->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if (!$update) {
            return ResponseFormatter::error('tidak berhasil mengubah data diri');
        }

        return ResponseFormatter::success($data->get());
    }
}
