<?php

namespace App\Http\Controllers;

use App\Models\gas;
use Illuminate\Http\Request;

class GasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Gas retrieved successfully',
            'data' => gas::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'weight' => 'required',
            'price' => 'required',
            'image' => 'string'
        ]);

        $gas = gas::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Gas created successfully',
            'data' => $gas
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $gas = gas::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Gas found successfully',
            'data' => $gas
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'weight' => 'nullable|sting',
            'price' => 'nullable|string',
            'image' => 'nullable|string'
        ]);

        $gas = gas::findOrFail($id);
        $gas->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Gas updated successfully',
            'data' => $gas
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gas = gas::findOrFail($id);
        $gas->delete();

        return response()->json([
            'status' => true,
            'message' => 'Gas deleted successfully'
        ], 204);
    }
}
