<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Traits\ApiRessourceTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    
    use ApiRessourceTrait;

    public function register(Request $request){

        try{
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
            return $this->returnData($user,'User created successfully',201);
        }catch(\Exception $e){

            return response()->json([
                'message' => 'Failed to create user',
                'error' => $e->getMessage()
            ],500);
        }

    }
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        if(! $user || ! Hash::check($request->password, $user->password)){

            return $this->errorMessage('Invalid credentials', 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);

    }

    public function logout(Request $request)
    {
        $user = $request->user();
       if($user->curentAccessToken()->delete()){
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
    return response()->json([
        'message' => 'Failed to logout'
    ]);

    }


}
