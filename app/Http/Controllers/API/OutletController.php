<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\outlet;
use App\Models\User;
use App\StatusType;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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

    public function count()
    {
        $outletDataCount = outlet::query()
            ->get()
            ->count();
        return response()->json([
            'status' => true,
            'message' => 'Outlet count retrieved successfully',
            'data' => $outletDataCount
        ], 200);
    }

    public function searchByName(Request $request)
    {
        $search = $request->input('search');
        $result = outlet::where('name', 'like', '%' . $search . '%')->get();
        return response()->json([
            'status' => true,
            'message' => 'Outlet data retrieved successfully',
            'data' => $result
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'phone_no' => 'required|string',
            'address' => 'required|string'
        ]);

        $outlet = outlet::create([
            'email' => $request->email,
            'name' => $request->name,
            'phone_no' => $request->phone_no,
            'address' => $request->address
        ]);
        if ($outlet) {
            return response()->json([
                'status' => true,
                'message' => 'Outlet created successfully',
                'data' => $outlet
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Outlet creation failed',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $outlet = outlet::findOrFail($id);
        if ($outlet) {
            return response()->json([
                'status' => true,
                'message' => 'Outlet found successfully',
                'data' => $outlet
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Outlet not found'
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string',
            'phone_no' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $outlet = outlet::findOrFail($id);
        if ($outlet) {
            $result = $outlet->update([
                'name' => $request->name,
                'phone_no' => $request->phone_no,
                'address' => $request->address,
            ]);
            if ($result > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Outlet updated successfully',
                    'data' => $outlet
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Outlet updated failed'
                ], 400);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Outlet not found'
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $outlet = outlet::findOrFail($id);
        if ($outlet) {
            $outlet->delete();
            return response()->json([
                'status' => true,
                'message' => 'Outlet deleted successfully'
            ], 204);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Outlet not found'
            ], 400);
        }
    }
}
