<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
 use Illuminate\Database\Eloquent\Relations\MorphMany;


class AuthController extends Controller
{
    public function register(Request $request) { 

        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password'=> 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email'=> $fields['email'],
            'password'=> Hash::make($fields['password']),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'status'=> 'success',
            'message'=> 'The user registered succesfully',
            'user' => $user,
            'token' => $token,
            
        ];

        return response()->json($response, 201);


    }


    public function login(Request $request) {

        $fields = $request->validate([    
            'email' => 'required|string',
            'password'=> 'required|string',
        ]);

        // check email if exists
        $user = User::where('email', $fields['email'])->first();
        $password = User::where('password', $fields['password'])->first();

        // if do not exists user_email in db, if is not registered || hask::check za proverka na pw so se vnesuva za login
        // dali e ist so pw vo db
        if(!$user || !Hash::check($fields['password'], $user->password)) {
    
            return response()->json([ 
                'message' => 'Bad credentials',
            ], 401);

        }

      // prodolzuva da kreira token 
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'status'=> 'success',
            'message'=> 'The user logged in succesfully',
            'user' => $user,
            'token' => $token,
        ];

        return response()->json($response, 201);


    }



     public function logout(Request $request) { 

        auth()->user()->tokens()->delete();
    
        // return [
        //     'message' => 'Logged out'
        // ];

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
    
    
}
