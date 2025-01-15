<?php

namespace App\Http\Controllers;

use App\Models\outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Outlet retrieved successfully',
            'data' => outlet::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'phone_no' => 'required',
            'address' => 'required',
            'status' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);

        $outlet = outlet::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Outlet created successfully',
            'data' => $outlet
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $outlet = outlet::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Outlet found successfully',
            'data' => $outlet
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'nullable|string|email',
            'name' => 'nullable|string',
            'phone_no' => 'nullable|string',
            'address' => 'nullable|string',
            'status' => 'nullable|string',
            'user_id' => 'prohibited'
        ]);

        $outlet = outlet::findOrFail($id);
        $outlet->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Outlet updated successfully',
            'data' => $outlet
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $outlet = outlet::findOrFail($id);
        $outlet->delete();

        return response()->json([
            'status' => true,
            'message' => 'Outlet deleted successfully'
        ], 204);
    }
}
