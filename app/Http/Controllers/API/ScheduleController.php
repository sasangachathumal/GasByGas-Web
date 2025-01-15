<?php

namespace App\Http\Controllers;

use App\Models\schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Schedules retrieved successfully',
            'data' => schedule::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'outlet_id' => 'required|exists:outlets,id',
            'approved_by' => 'nullable',
            'approved_date' => 'nullable'
        ]);

        $schedule = schedule::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Schedule created successfully',
            'data' => $schedule
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $schedule = schedule::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Schedule found successfully',
            'data' => $schedule
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'nullable',
            'outlet_id' => 'prohibited',
            'approved_by' => 'nullable',
            'approved_date' => 'nullable'
        ]);

        $schedule = schedule::findOrFail($id);
        $schedule->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Schedule updated successfully',
            'data' => $schedule
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $schedule = schedule::findOrFail($id);
        $schedule->delete();

        return response()->json([
            'status' => true,
            'message' => 'Schedule deleted successfully'
        ], 204);
    }
}
