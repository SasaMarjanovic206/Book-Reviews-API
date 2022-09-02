<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminte\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $register = $request->validate([
            'name' => 'required|string|min:3',
            'surname' => 'string|min:3|nullable',
            'role' => 'required|in:1,2,3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);

        $user = new User;
        $user->name = $register['name'];
        $user->surname = $register['surname'];
        $user->role = $register['role'];
        $user->email = $register['email'];
        $user->password = bcrypt($register['password']);
        $user->save();

        $token = $user->createToken('basic', ['read'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if(!auth()->attempt($login)) {
            return response(['message' => 'Incorrect credentials'], 401);
        }

        // $user = DB::table('users')->where('email', $login['email'])->get();
        $user = User::where('email', $login['email'])->first();

        // if($user && count($user) == 1) {
        if($user) {
            if($user->role == 1) {
                $token = $user->createToken('admin', ['admin', 'create', 'update', 'delete'])->plainTextToken;
            } else if($user->role == 2) {
                $token = $user->createToken('member', ['create', 'update', 'delete'])->plainTextToken;
            } else if($user->role == 3) {
                $token = $user->createToken('basic', ['read'])->plainTextToken;
            }
        } else {
            return response(['message' => 'There is a problem with credentials'], 401);
        }

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response(['message' => 'Logged Out'], 200);
    }
}
