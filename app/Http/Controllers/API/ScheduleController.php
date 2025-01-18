<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\schedule;
use App\Models\outlet;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scheduleData = schedule::join('outlets', 'schedules.outlet_id', '=', 'outlets.id')
            ->select('schedules.id', 'outlets.id', 'outlets.name', 'outlets.email', 'schedules.status', 'schedules.schedule_date', 'schedules.max_quantity', 'schedules.available_quantity')
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Schedules retrieved successfully',
            'data' => $scheduleData
        ], 200);
    }

    public function count()
    {
        $scheduleDataCount = schedule::query()
            ->get()
            ->count();
        return response()->json([
            'status' => true,
            'message' => 'Schedules count retrieved successfully',
            'data' => $scheduleDataCount
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
            'schedule_date' => 'required',
            'max_quantity' => 'required'
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
            'schedule_date' => 'nullable',
            'max_quantity' => 'nullable'
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
