<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    public function getMe(){
        return request()->user();
    }

    public function updateProfile(Request $request){

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->user()->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [];
        if($request->password && $request->password_confirmation){
            $data['password'] = \Hash::make($request->password);
        }

        $request->user()->update(array_merge(
            [
                'name' => $request->name,
                'email' => $request->email,
            ],
            $data
        ));

        return response([
            "success" => true,
            "message" => "Updated Successfully"
        ], Response::HTTP_OK);
    }
}
