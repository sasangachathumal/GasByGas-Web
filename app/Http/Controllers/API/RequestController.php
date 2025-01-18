<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\requestModel;
use App\Models\consumer;
use App\Models\gas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                ->where('request_id', $request->id)
                ->select('*')
                ->first();

            // Return the combined data for the current request
            return [
                'request' => $request,
                'gas' => $gasData,
                'consumer' => $consumerData,
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'gas_id' => 'required|exists:gases,id',
            'type' => 'required|string',
            'quantity' => 'required|string',
            'status' => 'required|string',
            'con_email' => 'required|email|string',
            'con_phone_no' => 'required|string',
            'con_type' => 'required|string',
            'con_status' => 'required|string',
            'con_nic' => 'nullable|string',
            'con_business_no' => 'nullable|string',
        ]);

        $newRequest = requestModel::create([
            'schedule_id' => $request->get('schedule_id'),
            'gas_id' => $request->get('gas_id'),
            'type' => $request->get('type'),
            'quantity' => $request->get('quantity'),
            'status' => $request->get('status'),
            'expired_at' => date('Y-m-d', strtotime(now() . ' + 14 days')),
            'token' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 6)
        ]);

        if ($newRequest) {
            $newConsumer = consumer::create([
                'request_id' => $newRequest->id,
                'nic' => $request->get('con_nic'),
                'email' => $request->get('con_email'),
                'phone_no' => $request->get('con_phone_no'),
                'type' => $request->get('con_type'),
                'business_no' => $request->get('con_business_no'),
                'status' => $request->get('con_status'),
            ]);
            if ($newConsumer) {
                $newResponse = (object)array_merge((array)$newRequest, (array)$newConsumer);
                return response()->json([
                    'status' => true,
                    'message' => 'Request created successfully',
                    'data' => $newResponse
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Request created failed',
                ], 400);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Request created failed',
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Request created successfully',
            'data' => $requestModel
        ], 201);
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
                ->where('request_id', $request->id)
                ->select('*')
                ->first();

            // Return the combined data for the current request
            return [
                'request' => $request,
                'gas' => $gasData,
                'consumer' => $consumerData,
            ];
        });
        return response()->json([
            'status' => true,
            'message' => 'Request found successfully',
            'data' => $combinedResults
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

    public function updateRequestConsumerStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $consumer = Consumer::where('request_id', $id)->firstOrFail();
        $consumer->update(['status' => $request->get('status')]);
        return response()->json([
            'status' => true,
            'message' => 'Request consumer status updated successfully'
        ], 201);
    }

    public function assignRequestToNewConsumer(Request $request, $id)
    {
        $request->validate([
            'email' => 'nullable|email|string',
            'phone_no' => 'nullable|string',
            'type' => 'nullable|string',
            'status' => 'nullable|string',
            'nic' => 'nullable|string',
            'business_no' => 'nullable|string',
        ]);

        $consumer = Consumer::where('request_id', $id)->firstOrFail();
        $consumer->update([
            'status' => $request->get('status'),
            'email' => $request->get('email'),
            'phone_no' => $request->get('phone_no'),
            'type' => $request->get('type'),
            'nic' => $request->get('nic'),
            'business_no' => $request->get('business_no')
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Request assign to a consumer successfully',
            'data' => $consumer
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
