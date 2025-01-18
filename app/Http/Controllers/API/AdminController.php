<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\admin;
use App\Models\User;
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
            'name' => 'required|string',
            'phone_no' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'password' => 'required|min:8'
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'ADMIN'
        ]);

        if ($user) {
            $admin = admin::create([
                'user_id' => $user->id,
                'email' => $request->email,
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
        $admin = admin::findOrFail($id);
        if ($admin) {
            return response()->json([
                'status' => true,
                'message' => 'Admin found successfully',
                'data' => $admin
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Admin not found'
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
        $user = User::query()->where('id', '=', $id)->firstOrFail();
        if ($user) {
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'Admin user deleted successfully'
            ], 204);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Admin not found'
            ], 400);
        }
    }
}
