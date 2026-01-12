<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        // sanitize handle
        $basehandle = Str::lower(preg_replace('/\s+/', '', $request->name));
        $handle = $basehandle;
        // already exist? generate random string of 8 long, caps at 5
        $attempts = 0;
        while (User::where('handle', $handle)->exists() && $attempts < 5) {
            $handle = $basehandle.'_'.Str::lower(Str::random(8));
            $attempts++;
        }

        // no chance of getting here but what if. generate random string of 16 long, caps at 5
        if (User::where('handle', $handle)->exists()) {
            $attempts = 0;
            while (User::where('handle', $handle)->exists() && $attempts < 5) {
                $handle = $basehandle.'_'.Str::lower(Str::random(16));
                $attempts++;
            }
        }
        try {
            $user = User::create(array_merge($validated, ['handle' => $handle]));
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Could not create user']);
        }

        $token = $user->createToken($request->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return [
                'errors' => [
                    'email' => ['The provided credentials are incorrect.'],
                ],
            ];
        }

        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'Logged out',
        ];
    }

    public function getuserdata(User $user)
    {
        $user->load([
            'posts.category',
            'posts.tags',
        ]);

        $user->load([
            'posts' => fn ($q) => $q->withCount([
                'votes as upvote' => fn ($q) => $q->where('vote', 1),
                'votes as downvote' => fn ($q) => $q->where('vote', -1),
            ])->with(['category', 'tags']),
            'comment' => fn ($q) => $q->withCount([
                'votes as upvote' => fn ($q) => $q->where('vote', 1),
                'votes as downvote' => fn ($q) => $q->where('vote', -1),
            ]),
        ]);

        UserResource::withoutWrapping();

        return new UserResource($user);
    }
}
