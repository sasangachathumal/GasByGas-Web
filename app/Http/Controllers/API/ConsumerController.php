<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\consumer;
use Illuminate\Http\Request;

class ConsumerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Consumers retrieved successfully',
            'data' => consumer::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone_no' => 'required',
            'type' => 'required',
            'status' => 'required',
            'request_id' => 'required|exists:requests,id',
        ]);

        $consumer = consumer::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Consumer created successfully',
            'data' => $consumer
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $consumer = consumer::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Consumer found successfully',
            'data' => $consumer
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'prohibited',
            'phone_no' => 'prohibited',
            'type' => 'prohibited',
            'status' => 'nullable|sting',
            'request_id' => 'rprohibited',
        ]);

        $consumer = consumer::findOrFail($id);
        $consumer->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Consumer updated successfully',
            'data' => $consumer
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $consumer = consumer::findOrFail($id);
        $consumer->delete();

        return response()->json([
            'status' => true,
            'message' => 'Consumer deleted successfully'
        ], 204);
    }
}
