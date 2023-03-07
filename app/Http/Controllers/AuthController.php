<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register']);
    }

    public function register(Request $request)
    {
        $validator = Validator::make(request()->all(),[
            'name'=> 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|min:8'
        ]);

        if($validator->fails()){
            return response()->json([$validator->messages()]);
        }

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
        ]);

        if($user){
            return response()->json([
                'message'=>'successfully register',
            ]);
        }else{
            return response()->json([
                'message'=>'cannot register',
            ]);
        }

        
        // $request->validate([
        //     'name'=> 'required',
        //     'email'=> 'required',
        //     'password'=> 'required',
        // ]);

        // $user = User::create([
        //     'name'=>$request->name,
        //     'email'=>$request->email,
        //     'password'=>bcrypt($request->password),
        // ]);

        // return response()->json([
        //     'message'=>'successfully registered',
        //     'user'=>$user
        // ]);
    }
    public function respondWithToken($token)
    {
        return response()->json([
            'access_token'=>$token,
            'type'=>'Bearer',
            'expires_in'=>auth('api' )->factory()->getTTL()*1440
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }


    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
      }

    public function refresh()
    {
        return $this->responseToken(auth()->refresh());
    }

    public function user()
    {
        return auth()->user();
    }
    public function logout()
    {
        auth()->logout();
        return response()->json([
            'message'=>'successfully logged out',
        ]);
    }
}
