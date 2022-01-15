<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserIndexResource;
use App\Http\Resources\User\UserShowResource;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    public function index(Request $request)
    {
        if ($request->q) {

            $tasks = User::where("name", "like", "%$request->q%")
                    ->where("email", "like", "%$request->q%")
                    ->get();

            return UserIndexResource::collection($tasks);

        }

        $tasks = $request->per_page ? User::paginate($request->per_page) : User::all();
        return UserIndexResource::collection($tasks);
    }


    public function store(StoreUserRequest $request)
    {

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => \Hash::make($request->password),
            "role" => $request->role,
            "status" => $request->status
        ]);

        return response([
            "success" => true,
            "message" => "Created Successfully"
        ], Response::HTTP_CREATED);

    }


    public function show(User $user)
    {
        return new UserShowResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = [];
        if($request->password && $request->password_confirmation){
            $data['password'] = \Hash::make($request->password);
        }

        $user->update(array_merge(
            [
                'name' => $request->name,
                'email' => $request->email,
                'status' => $request->status
            ],
            $data
        ));

        return response([
            "success" => true,
            "message" => "Updated Successfully"
        ], Response::HTTP_OK);

        return response([
            "success" => true,
            "message" => "Updated Successfully"
        ], Response::HTTP_OK);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response([
            "success" => true,
            "message" => "Deleted Successfully"
        ], Response::HTTP_OK);
    }
}
