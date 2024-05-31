<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            // validating data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            // new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // returning json
            return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
        } catch (QueryException $e) {

            // return error message in case of exception such as unique key violation
            if ($e->errorInfo[1] == 1062) {
                return response()->json(['message' => 'Email address already exists. Please choose a different email.'], 409);
            } else {
                return response()->json(['message' => 'Failed to register user. Please try again later.', 'error' => $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            // generic error
            \Log::error('Error registering user: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while processing your request.', 'error' => $e->getMessage()], 500);
        }
    }
}
