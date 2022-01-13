<?php

namespace App\Http\Controllers;

use App\Http\Requests\Worksheet\StoreWorksheetRequest;
use App\Http\Requests\Worksheet\UpdateWorksheetRequest;
use App\Http\Resources\Worksheet\WorksheetIndexResource;
use App\Http\Resources\Worksheet\WorksheetShowResource;
use App\Models\Worksheet;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorksheetController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    public function index()
    {
        $worksheets = Worksheet::all();
        return WorksheetIndexResource::collection($worksheets);
    }


    public function store(StoreWorksheetRequest $request)
    {

        Worksheet::create($request->all());

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
        $worksheet->update($request->all());

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
