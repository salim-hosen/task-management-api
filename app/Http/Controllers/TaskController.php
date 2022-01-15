<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\Task\TaskIndexResource;
use App\Http\Resources\Task\TaskShowResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    public function index(Request $request)
    {
        if ($request->q) {

            $tasks = Task::whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', "%$request->q%");
            })
            ->get();

            return TaskIndexResource::collection($tasks);

        }

        $tasks = $request->per_page ? Task::paginate($request->per_page) : Task::all();
        return TaskIndexResource::collection($tasks);
    }


    public function store(StoreTaskRequest $request)
    {

        Task::create([
            "user_id" => $request->user()->id,
            "project_id" => $request->project_id,
            "start_date" => $request->start_date,
            "close_date" => $request->close_date,
            "description" => $request->description,
        ]);

        return response([
            "success" => true,
            "message" => "Created Successfully"
        ], Response::HTTP_CREATED);

    }


    public function show(Task $task)
    {
        return new TaskShowResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update([
            "close_date" => $request->close_date,
            "status" => $request->status,
            "is_complete" => $request->status == "Complete" ? true : false
        ]);

        return response([
            "success" => true,
            "message" => "Updated Successfully"
        ], Response::HTTP_OK);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response([
            "success" => true,
            "message" => "Deleted Successfully"
        ], Response::HTTP_OK);
    }
}
