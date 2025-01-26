<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\outlet_manager;
use Illuminate\Http\Request;
use App\Models\outlet;
use App\Models\User;
use App\StatusType;
use App\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OutletManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outletManagers = outlet_manager::query()
            ->join('users', 'outlet_managers.user_id', '=', 'users.id')
            ->join('outlets', 'outlets.id', '=', 'outlet_managers.outlet_id')
            ->select('outlet_managers.*', 'users.email as user_email', 'outlets.name as outlet_name')
            ->get();

        if ($outletManagers) {
            return response()->json([
                'status' => true,
                'message' => 'outlet manager retrieved successfully',
                'data' => $outletManagers
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'outlet manager retrieved fail',
            ], 400);
        }
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
            'outlet_id' => 'required'
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make('qwertyui'),
            'type' =>  UserType::Outlet_Manager->value
        ]);
        if ($user) {
            $outlet_manager = outlet_manager::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'phone_no' => $request->phone_no,
                'outlet_id' => $request->outlet_id,
            ]);
            if ($outlet_manager) {
                return response()->json([
                    'status' => true,
                    'message' => 'outlet manager created successfully',
                    'data' => $outlet_manager
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'outlet manager creation failed',
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
        $outletManagerQuery = outlet_manager::query()
            ->join('users', 'outlet_managers.user_id', '=', 'users.id')
            ->join('outlets', 'outlets.id', '=', 'outlet_managers.outlet_id')
            ->select('outlet_managers.*', 'users.email as user_email', 'outlets.name as outlet_name')
            ->where('outlet_managers.id', '=', $id)
            ->get();

        if ($outletManagerQuery) {
            return response()->json([
                'status' => true,
                'message' => 'outlet manager retrieved successfully',
                'data' => $outletManagerQuery->first() ?? (object)[]
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'outlet manager retrieved fail',
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable',
            'phone_no' => 'nullable',
        ]);

        $outletManager = outlet_manager::findOrFail($id);
        if ($outletManager) {
            $result = $outletManager->update([
                'name' => $request->name,
                'phone_no' => $request->phone_no,
                'address' => $request->address,
            ]);
            if ($result > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'outlet manager updated successfully',
                    'data' => $outletManager
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'outlet manager updated failed'
                ], 400);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'outlet manager not found'
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $outletManager = outlet_manager::findOrFail($id);
        if ($outletManager) {
            $user = User::query()->where('id', '=', $outletManager->user_id)->firstOrFail();
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'outlet manager deleted successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'outlet manager not found'
                ], 400);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'outlet manager not found'
            ], 400);
        }
    }
}
