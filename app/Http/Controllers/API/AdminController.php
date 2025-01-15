<?php

namespace App\Http\Controllers;

use App\Models\admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Admins retrieved successfully',
            'data' => admin::all()
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
            'user_id' => 'required|exists:users,id'
        ]);

        $admin = admin::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Admin created successfully',
            'data' => $admin
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $admin = admin::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Admin found successfully',
            'data' => $admin
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'prohibited',
            'name' => 'nullable|string',
            'phone_no' => 'nullable|string',
            'user_id' => 'prohibited'
        ]);

        $admin = admin::findOrFail($id);
        $admin->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Admin updated successfully',
            'data' => $admin
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $admin = admin::findOrFail($id);
        $admin->delete();

        return response()->json([
            'status' => true,
            'message' => 'Admin deleted successfully'
        ], 204);
    }
}
