<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminte\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Requests\UserLoginRequest;

class AuthController extends Controller
{
    public function register(UserRegistrationRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'surname' => $request['surname'],
            'role' => $request['role'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);

        $token = $user->createToken('basic', ['read'])->plainTextToken;

        return response(['user' => $user, 'token' => $token], 201);
    }

    public function login(UserLoginRequest $request)
    {
        if(!auth()->attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return response(['message' => 'Incorrect credentials'], 401);
        }

        $user = User::where('email', $request['email'])->get();

        if($user && count(array($user)) == 1) {
            if($user->role == 1) {
                $token = $request->user()->createToken('admin', ['admin', 'create', 'update', 'delete'])->plainTextToken;
            } else if($user->role == 2) {
                $token = $request->user()->createToken('member', ['create', 'update', 'delete'])->plainTextToken;
            } else if($user->role == 3) {
                $token = $request->user()->createToken('basic', ['read'])->plainTextToken;
            }
        } else {
            return response(['message' => 'There is a problem with credentials'], 401);
        }

        return response(['user' => $user, 'token' => $token], 200);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response(['message' => 'Logged Out'], 200);
    }
}
