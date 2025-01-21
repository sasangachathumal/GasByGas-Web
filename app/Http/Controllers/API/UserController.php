<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\admin;
use App\Models\consumer;
use App\Models\outlet;
use App\UserType;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $usertype = null;
        $outletStatus = null;

        if ($request->has('type')) {
            $usertype = $request->input('type');
        }

        if ($request->has('outletStatus')) {
            $outletStatus = $request->input('outletStatus');
        }

        if (!$usertype) {
            $adminData = Admin::join('users', 'admins.user_id', '=', 'users.id')
                ->select('users.id', 'users.type', 'admins.email', 'admins.name', 'admins.phone_no')
                ->get();
            $outletData = Outlet::join('users', 'outlets.user_id', '=', 'users.id')
                ->select('users.id', 'users.type', 'outlets.email', 'outlets.name', 'outlets.phone_no', 'outlets.address', 'outlets.status')
                ->get();

            $combinedData = $adminData->merge($outletData);

            return response()->json([
                'status' => true,
                'message' => 'All users retrieved successfully',
                'data' => $combinedData
            ], 200);
        }

        if ($usertype && $usertype == 'admin') {
            $adminOnlyData = Admin::join('users', 'admins.user_id', '=', 'users.id')
                ->select('users.id', 'users.type', 'admins.email', 'admins.name', 'admins.phone_no')
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'All users retrieved successfully',
                'data' => $adminOnlyData
            ], 200);
        }

        if ($usertype && $usertype == 'outlet_manager') {
            $outletQuery = Outlet::join('users', 'outlets.user_id', '=', 'users.id')
                ->select('users.id', 'users.type', 'outlets.email', 'outlets.name', 'outlets.phone_no', 'outlets.address', 'outlets.status');
            if ($outletStatus) {
                $outletQuery->where('outlets.status', $outletStatus);
            }
            $outletOnlyData = $outletQuery->get();
            return response()->json([
                'status' => true,
                'message' => 'All users retrieved successfully',
                'data' => $outletOnlyData
            ], 200);
        }
    }

    public function me()
    {
        $user = Auth::user();
        if ($user && $user->type === UserType::Admin->value) {
            $adminQuery = Admin::join('users', 'admins.user_id', '=', 'users.id')
                ->select('users.id as user_id', 'users.type as user_type', 'admins.*')
                ->where('admins.user_id', '=', $user->id)
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'user retrieved successfully',
                'data' => $adminQuery->first() ?? (object)[]
            ], 200);
        } else if ($user && $user->type === UserType::Outlet_Manager->value) {
            $outletQuery = Outlet::join('users', 'outlets.user_id', '=', 'users.id')
                ->select('users.id as user_id', 'users.type as user_type', 'outlets.*')
                ->where('outlets.user_id', '=', $user->id)
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'user retrieved successfully',
                'data' => $outletQuery->first() ?? (object)[]
            ], 200);
        } else if ($user && $user->type === UserType::Consumer->value) {
            $consumerQuery = consumer::join('users', 'consumers.user_id', '=', 'users.id')
                ->select('users.id as user_id', 'users.type as user_type', 'consumers.*')
                ->where('consumers.user_id', '=', $user->id)
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'consumer retrieved successfully',
                'data' => $consumerQuery->first() ?? (object)[]
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User Not Found'
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
