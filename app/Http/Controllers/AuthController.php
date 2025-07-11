<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
     public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // image validation

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
 $imagePath = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time().'_'.$image->getClientOriginalName();
        $imagePath = $image->storeAs('uploads', $imageName, 'public');
    }
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'image'         => $imagePath, 

        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'token' => $token,
            'user' => Auth::guard('api')->user(),
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
