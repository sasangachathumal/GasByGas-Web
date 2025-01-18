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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'phone_no' => 'required|string',
            'address' => 'required|string',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make('secret'),
            'type' => 'OUTLET'
        ]);
        if ($user) {
            $outlet = outlet::create([
                'user_id' => $user->id,
                'email' => $request->email,
                'name' => $request->name,
                'phone_no' => $request->phone_no,
                'address' => $request->address,
                'status' => StatusType::Pending->value
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
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User creation failed',
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
            'status' => 'nullable|string',
        ]);

        $outlet = outlet::findOrFail($id);
        if ($outlet) {
            $result = $outlet->update([
                'name' => $request->name,
                'phone_no' => $request->phone_no,
                'address' => $request->address,
                'status' => $request->status
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

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $outlet = outlet::findOrFail($id);
        if ($outlet) {
            $result = $outlet->update([
                'status' => $request->status
            ]);
            if ($result > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Outlet status updated successfully',
                    'data' => $outlet
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Outlet status updated failed'
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
        $user = User::query()->where('id', '=', $id)->firstOrFail();
        if ($user) {
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'Outlet user deleted successfully'
            ], 204);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Outlet not found'
            ], 400);
        }
    }
}
