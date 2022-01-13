<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    public function getMe(){
        return request()->user();
    }
}
