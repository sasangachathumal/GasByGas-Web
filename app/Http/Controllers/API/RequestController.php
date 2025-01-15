<?php

namespace App\Http\Controllers;

use App\Models\requestModel;
use App\Models\consumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allRequest = DB::table('requests')
        ->join('consumers' ,'requests.id', '=', 'consumers.id')
        ->join('gas' ,'gas.id', '=', 'consumers.gas_id')
        ->select('requests.*', 'gas.weight', 'gas.price', 'gas.image', 'consumer.nic', 'consumer.email', 'consumer.phone_no', 'consumer.type', 'consumer.business_no', 'consumer.status')
        ->get();
        return response()->json([
            'status' => true,
            'message' => 'Requests retrieved successfully',
            'data' => $allRequest
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
            'expired_at' => date('Y-m-d', strtotime(now().' + 14 days')),
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
        $singleRequest = DB::table('requests')
        ->join('consumers' ,'requests.id', '=', 'consumers.id')
        ->join('gas' ,'gas.id', '=', 'consumers.gas_id')
        ->select('requests.*', 'gas.weight', 'gas.price', 'gas.image', 'consumer.nic', 'consumer.email', 'consumer.phone_no', 'consumer.type', 'consumer.business_no', 'consumer.status')
        ->where('request.id', '=', $id)
        ->get();
        return response()->json([
            'status' => true,
            'message' => 'Request found successfully',
            'data' => $singleRequest
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
