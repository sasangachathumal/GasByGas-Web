<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\schedule;
use App\Models\outlet;
use App\StatusType;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scheduleData = schedule::join('outlets', 'schedules.outlet_id', '=', 'outlets.id')
            ->select('schedules.id as id', 'outlets.id as outlet_id', 'outlets.name', 'outlets.email', 'schedules.status', 'schedules.schedule_date', 'schedules.max_quantity', 'schedules.available_quantity')
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
            'outlet_id' => 'required|exists:outlets,id',
            'schedule_date' => 'required',
            'max_quantity' => 'required'
        ]);

        $schedule = schedule::create([
            'outlet_id' => $request->outlet_id,
            'schedule_date' => $request->schedule_date,
            'max_quantity' => $request->max_quantity,
            'status' => StatusType::Pending->value
        ]);
        if ($schedule) {
            return response()->json([
                'status' => true,
                'message' => 'Schedule created successfully',
                'data' => $schedule
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Schedule creation failed',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $scheduleData = schedule::join('outlets', 'schedules.outlet_id', '=', 'outlets.id')
            ->select('schedules.id', 'outlets.id as outlet_id', 'outlets.name as out_name', 'outlets.email as out_email', 'outlets.phone_no as out_phone_no', 'outlets.status as out_status', 'outlets.address as out_address', 'schedules.status', 'schedules.schedule_date', 'schedules.max_quantity', 'schedules.available_quantity')
            ->where('schedules.id', '=', $id)
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Schedule found successfully',
            'data' => $scheduleData[0]
        ], 200);
    }

    public function getByOutletID($id)
    {
        $scheduleData = schedule::join('outlets', 'schedules.outlet_id', '=', 'outlets.id')
            ->select('schedules.id', 'outlets.id as outlet_id', 'outlets.name as out_name', 'outlets.email as out_email', 'outlets.phone_no as out_phone_no', 'outlets.status as out_status', 'outlets.address as out_address', 'schedules.status', 'schedules.schedule_date', 'schedules.max_quantity', 'schedules.available_quantity')
            ->where('outlets.id', '=', $id)
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Schedules found successfully',
            'data' => $scheduleData
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
