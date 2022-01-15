<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\Project\ProjectIndexResource;
use App\Http\Resources\Project\ProjectShowResource;
use App\Http\Resources\Task\TaskIndexResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{


    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    public function index(Request $request)
    {
        if ($request->q) {

            $projects = Project::where("name", "like", "%$request->q%")
                ->orWhere("description", "like", "%$request->q%")
                ->get();

            return ProjectIndexResource::collection($projects);

        }

        $projects = $request->per_page ? Project::paginate($request->per_page) : Project::all();

        return ProjectIndexResource::collection($projects);
    }

    public function dashboard($id)
    {

        $project = Project::findOrFail($id);

        $data['totalTasks'] = $project->tasks()->count();
        $data['completedTasks'] = $project->tasks()->where("is_complete", true)->count();
        $data['totalWorkingHours'] = $project->worksheets()->sum("time");

        return response($data, Response::HTTP_OK);
    }

    public function tasks($id){
        $project = Project::find($id);
        $tasks = $project->tasks;
        return  TaskIndexResource::collection($tasks);
    }

    public function store(StoreProjectRequest $request)
    {

        Project::create([
            "user_id" => $request->user()->id,
            "name" => $request->name,
            "description" => $request->description,
            "status" => $request->status,
            "manager" => $request->user()->id
        ]);

        return response([
            "success" => true,
            "message" => "Created Successfully"
        ], Response::HTTP_CREATED);

    }


    public function show(Project $project)
    {
        return new ProjectShowResource($project);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->all());

        return response([
            "success" => true,
            "message" => "Updated Successfully"
        ], Response::HTTP_OK);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response([
            "success" => true,
            "message" => "Deleted Successfully"
        ], Response::HTTP_OK);
    }
}
