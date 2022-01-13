<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class VerificationController extends Controller
{


    use VerifiesEmails;

    public function __construct()
    {
        // $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request, User $user){

        // Check if the url is a valid signed url
        if(!URL::hasValidSignature($request)){
            return response()->json(["errors" => [
                "message" => "Invalid Verification Link"
            ]], 422);
        }

        // Check if the user is already verified account
        if($user->hasVerifiedEmail()){
            return response()->json(["errors" => [
                "message" => "Email address already verified"
            ]], 422);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json(["message" => "Email Successfully Verified"], 200);
    }

    public function resend(Request $request){

        $this->validate($request, [
            'email' => "required"
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json(["errors" => [
                "email" => "No User found with this email address"
            ]], 422);
        }

        if($user->hasVerifiedEmail()){
            return response()->json(["errors" => [
                "email" => "Email address already Verified"
            ]], 422);
        }

        $user->sendEmailVerificationNotification();
        return response()->json(["message" => "Verification Link Resent"], 200);
    }
}
