<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\GasPickupReminderMail;
use App\Mail\GasRequestPaymentReminderMail;
use App\Models\consumer;
use App\Models\gas;
use App\Models\schedule;
use App\Models\outlet;
use App\Models\requestModel;
use App\Models\User;
use App\StatusType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            'available_quantity' => $request->max_quantity,
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
            ->select('schedules.id', 'outlets.id as outlet_id', 'outlets.name as out_name', 'outlets.email as out_email', 'outlets.phone_no as out_phone_no', 'outlets.address as out_address', 'schedules.status', 'schedules.schedule_date', 'schedules.max_quantity', 'schedules.available_quantity')
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
            ->select('schedules.id', 'outlets.id as outlet_id', 'outlets.name as out_name', 'outlets.email as out_email', 'outlets.phone_no as out_phone_no', 'outlets.address as out_address', 'schedules.status', 'schedules.schedule_date', 'schedules.max_quantity', 'schedules.available_quantity')
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
            'schedule_date' => 'nullable',
            'max_quantity' => 'nullable'
        ]);
        // get schedule from id
        $schedule = schedule::findOrFail($id);

        // check the new request status is approved and status in database and new status not the same
        // if yes then send the emails to consumers
        if (($request->status === StatusType::Approved->value) && ($request->status != $schedule->status)) {
            $this->sendStatusEmails($schedule);
        }

        // Update schedule with new data
        $schedule->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Schedule updated successfully',
            'data' => $schedule
        ], 201);
    }

    public function sendStatusEmails($schedule)
    {
        // get outlet name
        $outletName = outlet::query()->select('name')->where('id', '=', $schedule->outlet_id)->first();

        // get all the request related to the schedule
        $requestList = requestModel::query()
            ->select('consumer_id', 'token', 'gas_id', 'id', 'quantity')
            ->where('schedule_id', '=', $schedule->id)
            ->get();
        foreach ($requestList as $singleRequest) {
            // get gas price
            $gasPrice = gas::query()->select('price')->where('id', '=', $singleRequest->gas_id)->first();
            // calculate total
            $totalPrice = ($singleRequest->quantity * $gasPrice->price);
            // get consumer data from the consumer tabel
            $consumer = consumer::query()->where('id', '=', $singleRequest->consumer_id)->first();
            // get consumer email from the user tabel
            $consumerEmail = User::query()->select('email')->where('id', '=', $consumer->user_id)->first();
            // get the request token
            $token = $singleRequest->token;
            // Send confimation Email
            // @TODO - commented for now
            // Mail::to($consumerEmail->email)->send(new GasRequestPaymentReminderMail($token, $totalPrice, $outletName->name, $consumer->name));
        }
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

    // @TODO need to replace with realtime event that check and send emails automaticaly
    // for now pickup enamils send to the first schedule when this method get called
    public function sendPickupEmails()
    {
        // get schedule from id
        $schedule = schedule::all()->first();
        // get outlet name
        $outletName = outlet::query()->select('name')->where('id', '=', $schedule->outlet_id)->first();

        $pickupDate = date('Y-m-d', strtotime(now() . ' + 1 day'));

        // get all the request related to the schedule
        $requestList = requestModel::query()
            ->select('consumer_id', 'token', 'gas_id', 'id', 'quantity')
            ->where('schedule_id', '=', $schedule->id)
            ->get();
        foreach ($requestList as $singleRequest) {
            // get consumer data from the consumer tabel
            $consumer = consumer::query()->where('id', '=', $singleRequest->consumer_id)->first();
            // get consumer email from the user tabel
            $consumerEmail = User::query()->select('email')->where('id', '=', $consumer->user_id)->first();
            // Send confimation Email
            // @TODO - commented for now
            // Mail::to($consumerEmail->email)->send(new GasPickupReminderMail($outletName->name, $pickupDate, $consumer->name));
        }
    }
}
