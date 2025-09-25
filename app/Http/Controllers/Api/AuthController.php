<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $data = $request->validate(
                [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'role' => ['required', 'in:' . implode(',', User::$roles)], // in:seller,customer
                    'password' => ['required', 'confirmed', Password::min(8)],
                    'dob'     => ['nullable', 'date', 'before:today'],
                ]
            );

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'password' => Hash::make($data['password']),
                'dob'     => $data['dob'] ?? null,
            ]);

            $token = $user->createToken('mobile')->plainTextToken;

            $userArray = $user->toArray();
            $userArray['token'] = $token;

            return response()->json([
                'user'  => $userArray,
            ], 201);
        } catch (AuthorizationException | ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'       => ['required', 'email'],
            'password'    => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        try {
            $token = $user->createToken('mobile')->plainTextToken;
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }

        $userArray = $user->toArray();
        $userArray['token'] = $token;

        return response()->json([
            'user'  => $userArray,
        ], 201);
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logged out'], 201);
        } catch (AuthorizationException | ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
