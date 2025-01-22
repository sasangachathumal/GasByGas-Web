<?php

namespace App\Http\Controllers\API;

use App\ConsumerType;
use App\Http\Controllers\Controller;

use App\Models\consumer;
use App\Models\User;
use App\StatusType;
use App\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ConsumerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consumerQuery = consumer::join('users', 'consumers.user_id', '=', 'users.id')
            ->select('users.id as user_id', 'users.type as user_type', 'consumers.*')
            ->get();
        if ($consumerQuery) {
            return response()->json([
                'status' => true,
                'message' => 'consumer retrieved successfully',
                'data' => $consumerQuery
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'consumer retrieved fail',
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
            'nic' => 'nullable',
            'phone_no' => 'required',
            'type' => 'required',
            'business_no' => 'nullable'
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make('secret'),
            'type' => UserType::Consumer->value
        ]);
        if ($user) {
            $consumer = consumer::create([
                'user_id' => $user->id,
                'phone_no' => $request->phone_no,
                'type' => $request->type,
                'nic' => $request->nic ? $request->nic : null,
                'business_no' => $request->business_no ? $request->business_no : null,
                'status' => $request->type == ConsumerType::Business->value ? StatusType::Pending->value : StatusType::Approved->value
            ]);
            if ($consumer) {
                return response()->json([
                    'status' => true,
                    'message' => 'Consumer created successfully',
                    'data' => $consumer
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
        $consumerQuery = consumer::join('users', 'consumers.user_id', '=', 'users.id')
            ->select('users.id as user_id', 'users.type as user_type', 'consumers.*')
            ->where('consumers.id', '=', $id)
            ->get();
        if ($consumerQuery) {
            return response()->json([
                'status' => true,
                'message' => 'consumer retrieved successfully',
                'data' => $consumerQuery->first() ?? (object)[]
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'consumer retrieved fail',
            ], 400);
        }
    }

    public function count()
    {
        $consumerDataCount = consumer::query()
            ->get()
            ->count();
        return response()->json([
            'status' => true,
            'message' => 'Consumer count retrieved successfully',
            'data' => $consumerDataCount
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nic' => 'nullable',
            'phone_no' => 'nullable',
            'status' => 'nullable'
        ]);

        $consumer = consumer::findOrFail($id);
        $consumer->update(
            [
                'nic' => $request->nic,
                'phone_no' => $request->phone_no,
                'status' => $request->status
            ]
        );
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
        $admin = consumer::findOrFail($id);
        if ($admin) {
            $user = User::query()->where('id', '=', $admin->user_id)->firstOrFail();
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Consumer user deleted successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Consumer not found'
                ], 400);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Consumer not found'
            ], 400);
        }
    }
}
