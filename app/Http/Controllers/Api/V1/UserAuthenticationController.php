<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
        ], Response::HTTP_OK);
    }

    public function register(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'message' => 'The provided email is already registered.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
        ], Response::HTTP_CREATED);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json($user, Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
        ]);

        return response()->json($user, Response::HTTP_OK);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'new_password' => 'required|string|min:8',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'message' => 'The provided old password is incorrect.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        if (Hash::check($request->new_password, $user->password)) {
            return response()->json([
                'message' => 'The provided password is same as old password.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($request->new_password !== $request->confirm_password) {
            return response()->json([
                'message' => 'The provided password confirmation does not match.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json($user, Response::HTTP_OK);
    }

    public function delete(Request $request)
    {
        $user = $request->user();
        $user->delete();

        return response()->json([
            'message' => 'The user has been deleted.'
        ], Response::HTTP_OK);
    }
}
