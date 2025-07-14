<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Log;


class AuthService
{
    public function register(array $data)
    {
        $imagePath = ImageHelper::store($data['image'] ?? null);

        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),
            'image' => $imagePath,
        ]);

        $token = JWTAuth::fromUser($user);

        return compact('user', 'token');
    }

public function login(array $credentials)
{
    \Log::info('Login attempt with:', $credentials);

    if (!$token = JWTAuth::attempt($credentials)) {
        \Log::warning('Login failed for:', ['email' => $credentials['email']]);
        return null;
    }

    $user = auth()->user();
    $ttl = JWTAuth::factory()->getTTL() * 60;

    \Log::info('Login successful for:', ['user_id' => $user->id]);

    return compact('token', 'user', 'ttl');
}


}
