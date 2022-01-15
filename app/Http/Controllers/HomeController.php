<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Worksheet;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $data['totalProjects'] = Project::all()->count();
        $data['completedProjects'] = Project::where('status', 'complete')->count();

        $data['totalTasks'] = Task::all()->count();
        $data['completedTasks'] = Task::where("is_complete", true)->count();

        $data['totalWorkingHours'] = Worksheet::all()->sum("time");

        return response($data, Response::HTTP_OK);
    }
}
