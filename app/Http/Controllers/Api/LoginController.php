<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $credentials = ['email'=>$request->email, 'password'=>$request->password];
        
        if(!auth()->attempt($credentials)){
            // throw new \Exception('Unauthorized.');
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

       $token = auth()->user()->createToken('access_token');

       return response()->json([
            "access_token"=>$token->plainTextToken,        
       ]);
    }

}
