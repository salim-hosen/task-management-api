<?php

namespace App\Http\Controllers;

use App\Http\Requests\Worksheet\StoreWorksheetRequest;
use App\Http\Requests\Worksheet\UpdateWorksheetRequest;
use App\Http\Resources\Worksheet\WorksheetIndexResource;
use App\Http\Resources\Worksheet\WorksheetShowResource;
use App\Models\Task;
use App\Models\Worksheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorksheetController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    public function index(Request $request)
    {
        if ($request->q) {

            $worksheets = Worksheet::whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', "%$request->q%");
            })
            ->get();

            return WorksheetIndexResource::collection($worksheets);

        }else if($request->start_date && $request->close_date){

            $worksheets = Worksheet::whereDate("created_at", ">=", $request->start_date)
                            ->whereDate('created_at', '<=', $request->close_date)->get();
            return WorksheetIndexResource::collection($worksheets);

        }else if($request->start_date){

            $worksheets = Worksheet::where("created_at", ">=", $request->start_date)->get();
            return WorksheetIndexResource::collection($worksheets);

        }else if($request->close_date){

            $worksheets = Worksheet::where('created_at', '<=', $request->close_date)->get();
            return WorksheetIndexResource::collection($worksheets);

        }

        $worksheets = $request->per_page ? Worksheet::paginate($request->per_page) : Worksheet::all();
        return WorksheetIndexResource::collection($worksheets);
    }


    public function store(StoreWorksheetRequest $request)
    {

        $task = Task::findOrFail($request->task_id);

        Worksheet::create([
            "project_id" => $task->project_id,
            "task_id" => $task->id,
            "user_id" => $request->user()->id,
            "time" => $request->hours,
            "date" => Carbon::now(),
            "note" => $request->note
        ]);

        return response([
            "success" => true,
            "message" => "Created Successfully"
        ], Response::HTTP_CREATED);

    }


    public function show(Worksheet $worksheet)
    {
        return new WorksheetShowResource($worksheet);
    }

    public function update(UpdateWorksheetRequest $request, Worksheet $worksheet)
    {
        $worksheet->update([
            "time" => $request->hours,
            "note" => $request->note
        ]);

        return response([
            "success" => true,
            "message" => "Updated Successfully"
        ], Response::HTTP_OK);
    }

    public function destroy(Worksheet $worksheet)
    {
        $worksheet->delete();

        return response([
            "success" => true,
            "message" => "Deleted Successfully"
        ], Response::HTTP_OK);
    }
}
