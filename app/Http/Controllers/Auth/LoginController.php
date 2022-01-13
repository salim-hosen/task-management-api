<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class LoginController extends Controller
{


    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['logout']);
    }


    public function attemptLogin(Request $request)
    {

        // attempt to issue a token to the user based on the login credentials
        $token = $this->guard()->attempt($this->credentials($request));

        if(!$token){
            return false;
        }

        // Get the authenticated user
        $user = $this->guard()->user();
        if($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()){
            return false;
        }

        return true;
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        $user = $this->guard()->user();
        // get the tokem from the authentication guard (JWT)
        $token = $user->createToken($request->device_name ?? "Unknown")->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'user' => $user
        ]);
    }


    protected function sendFailedLoginResponse()
    {
        $user = $this->guard()->user();

        if($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()){
            return response()->json(["errors" => [
                "need_verification" => true,
                "email" => "You need to verify your email account"
            ]], 422);
        }

        throw ValidationException::withMessages([
            $this->username() => "Invalid credentials"
        ]);
    }

    public function logout()
    {
        request()->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully!']);
    }

}
