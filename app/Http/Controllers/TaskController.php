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

    public function index()
    {
        $tasks = Task::all();
        return TaskIndexResource::collection($tasks);
    }


    public function store(StoreTaskRequest $request)
    {

        Task::create($request->all());

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
        $task->update($request->all());

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
