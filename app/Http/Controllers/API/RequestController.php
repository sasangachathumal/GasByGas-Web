<?php

namespace App\Http\Controllers\API;

use App\ConsumerType;
use App\Http\Controllers\Controller;

use App\Models\requestModel;
use App\Models\consumer;
use App\Models\gas;
use App\Models\outlet;
use App\Models\schedule;
use App\Models\User;
use App\RequestStatusType;
use App\StatusType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allRequests = requestModel::all();

        $combinedResults = $allRequests->map(function ($request) {
            // Get gas data for the current request
            $gasData = gas::query()
                ->where('id', $request->gas_id)
                ->select('*')
                ->first();

            // Get consumer data for the current request
            $consumerData = consumer::query()
                ->where('id', $request->consumer_id)
                ->select('*')
                ->first();

            // Get user email data for the current request
            $consumerEmail = User::query()
                ->select('email')
                ->where('id', $consumerData->user_id)
                ->first();

            $consumerData->email = $consumerEmail->email;

            // Get schedule data for the current request
            $scheduleData = schedule::query()
                ->where('id', $request->schedule_id)
                ->select('*')
                ->first();

            // Get outlet data for the current request
            $outletData = outlet::query()
                ->where('id', $scheduleData->outlet_id)
                ->select('*')
                ->first();

            // Return the combined data for the current request
            return [
                'request' => $request,
                'gas' => $gasData,
                'consumer' => $consumerData,
                'schedule' => $scheduleData,
                'outlet' => $outletData
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Requests retrieved successfully',
            'data' => $combinedResults
        ], 200);
    }

    public function count()
    {
        $requestDataCount = requestModel::query()
            ->get()
            ->count();
        return response()->json([
            'status' => true,
            'message' => 'Request count retrieved successfully',
            'data' => $requestDataCount
        ], 200);
    }

    public function generateUniqueToken()
    {
        do {
            $token = 'GAS-' . Str::random(3) . '-' . Str::random(3); // Generate the token
        } while (requestModel::where('token', $token)->exists()); // Check uniqueness

        return $token;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'gas_id' => 'required|exists:gas,id',
            'consumer_id' => 'required|exists:consumers,id',
            'type' => 'required|string',
            'quantity' => 'required|string',
        ]);

        $allRequests = requestModel::all()->where('consumer_id', '=', $request->consumer_id);

        if (count($allRequests) > 0) {
            foreach ($allRequests as $singleRequest) {
                if (($singleRequest->status == RequestStatusType::Pending->value) || ($singleRequest->status == RequestStatusType::Paid->value)) {
                    $errorData = [
                        'ACTIVE_REQ' => [
                            'message' => 'Consumer already have active request'
                        ]
                    ];
                    return response()->json([
                        'status' => false,
                        'message' => 'Request created failed',
                        'errors' => $errorData
                    ], 400);
                }
            }
        }

        $newRequest = requestModel::create([
            'schedule_id' => $request->get('schedule_id'),
            'gas_id' => $request->get('gas_id'),
            'consumer_id' => $request->get('consumer_id'),
            'type' => $request->get('type'),
            'quantity' => $request->get('quantity'),
            'status' => RequestStatusType::Pending->value,
            'expired_at' => date('Y-m-d', strtotime(now() . ' + 14 days')),
            'token' => $this->generateUniqueToken()
        ]);

        if ($newRequest) {
            $schedule = schedule::findOrFail($newRequest->schedule_id);
            $schedule->update([
                'available_quantity' => ($schedule->available_quantity - $newRequest->quantity)
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Request created successfully',
                'data' => $newRequest
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Request created failed',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $allRequests = requestModel::all()->where('id', '=', $id);

        $combinedResults = $allRequests->map(function ($request) {
            // Get gas data for the current request
            $gasData = gas::query()
                ->where('id', $request->gas_id)
                ->select('*')
                ->first();

            // Get consumer data for the current request
            $consumerData = consumer::query()
                ->where('id', $request->consumer_id)
                ->select('*')
                ->first();

            // Get user email data for the current request
            $consumerEmail = User::query()
                ->select('email')
                ->where('id', $consumerData->user_id)
                ->first();

            $consumerData->email = $consumerEmail->email;

            // Get schedule data for the current request
            $scheduleData = schedule::query()
                ->where('id', $request->schedule_id)
                ->select('*')
                ->first();

            // Get outlet data for the current request
            $outletData = outlet::query()
                ->where('id', $scheduleData->outlet_id)
                ->select('*')
                ->first();

            // Return the combined data for the current request
            return [
                'request' => $request,
                'gas' => $gasData,
                'consumer' => $consumerData,
                'schedule' => $scheduleData,
                'outlet' => $outletData
            ];
        });
        return response()->json([
            'status' => true,
            'message' => 'Request found successfully',
            'data' => $combinedResults->first() ?? (object)[]
        ], 200);
    }

    public function searchByToken($token)
    {
        $allRequests = requestModel::all()->where('token', '=', $token);

        $combinedResults = $allRequests->map(function ($request) {
            // Get gas data for the current request
            $gasData = gas::query()
                ->where('id', $request->gas_id)
                ->select('*')
                ->first();

            // Get consumer data for the current request
            $consumerData = consumer::query()
                ->where('id', $request->consumer_id)
                ->select('*')
                ->first();

            // Get user email data for the current request
            $consumerEmail = User::query()
                ->select('email')
                ->where('id', $consumerData->user_id)
                ->first();

            $consumerData->email = $consumerEmail->email;

            // Get schedule data for the current request
            $scheduleData = schedule::query()
                ->where('id', $request->schedule_id)
                ->select('*')
                ->first();

            // Get outlet data for the current request
            $outletData = outlet::query()
                ->where('id', $scheduleData->outlet_id)
                ->select('*')
                ->first();

            // Return the combined data for the current request
            return [
                'request' => $request,
                'gas' => $gasData,
                'consumer' => $consumerData,
                'schedule' => $scheduleData,
                'outlet' => $outletData
            ];
        });
        return response()->json([
            'status' => true,
            'message' => 'Request found successfully',
            'data' => $combinedResults->first() ?? (object)[]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateRequestStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $requestModel = requestModel::findOrFail($id);
        $requestModel->update(['status' => $request->get('status')]);
        return response()->json([
            'status' => true,
            'message' => 'Request status updated successfully'
        ], 201);
    }

    public function assignRequestToNewConsumer(Request $request, $id)
    {
        $request->validate([
            'consumer_id' => 'required'
        ]);

        $requestModel = requestModel::where('id', $id)->firstOrFail();
        $requestModel->update(['consumer_id' => $request->get('consumer_id')]);
        return response()->json([
            'status' => true,
            'message' => 'Request assign to a consumer successfully',
            'data' => $requestModel
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $requestModel = requestModel::findOrFail($id);
        $requestModel->delete();

        return response()->json([
            'status' => true,
            'message' => 'Request deleted successfully'
        ], 204);
    }
}
