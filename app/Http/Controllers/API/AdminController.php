<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\admin;
use App\Models\User;
use App\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adminOnlyData = Admin::join('users', 'admins.user_id', '=', 'users.id')
            ->select('users.id as user_id', 'users.type', 'users.email', 'admins.id', 'admins.name', 'admins.phone_no')
            ->get();

        if ($adminOnlyData) {
            return response()->json([
                'status' => true,
                'message' => 'Admins retrieved successfully',
                'data' => $adminOnlyData
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Admins retrieved Failed',
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
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make('secret'),
            'type' =>  UserType::Admin->value
        ]);

        if ($user) {
            $admin = admin::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'phone_no' => $request->phone_no
            ]);
            if ($admin) {
                return response()->json([
                    'status' => true,
                    'message' => 'Admin created successfully',
                    'data' => $admin
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Admin creation failed',
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
        $adminQuery = Admin::join('users', 'admins.user_id', '=', 'users.id')
            ->select('users.id as user_id', 'users.type as user_type', 'admins.*')
            ->where('admins.id', '=', $id)
            ->get();
        if ($adminQuery) {
            return response()->json([
                'status' => true,
                'message' => 'user retrieved successfully',
                'data' => $adminQuery->first() ?? (object)[]
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'user retrieved fail',
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
            'phone_no' => 'nullable|string'
        ]);

        $admin = admin::findOrFail($id);
        if ($admin) {
            $result = $admin->update([
                'name' => $request->name,
                'phone_no' => $request->phone_no
            ]);
            if ($result > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Admin updated successfully',
                    'data' => $admin
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Admin updated failed'
                ], 400);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Admin not found'
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $admin = admin::findOrFail($id);
        if ($admin) {
            $user = User::query()->where('id', '=', $admin->user_id)->firstOrFail();
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Admin user deleted successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Admin not found'
                ], 400);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Admin not found'
            ], 400);
        }
    }
}
