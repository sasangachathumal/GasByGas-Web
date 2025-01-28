<?php

namespace App\Http\Controllers;

use App\ConsumerType;
use App\Models\consumer;
use App\Models\User;
use App\StatusType;
use App\UserType;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('session.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'agreement' => 'accepted',
            'type' => 'required',
            'nic' => 'nullable',
            'phone_no' => 'required',
            'business_no' => 'nullable'
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' =>  UserType::Consumer->value,
            'agreement' => $request->agreement
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
                session()->flash('success', 'Your account has been created.');
                $authUser = Auth::login($user);
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => 'Registration successful',
                    'user' => $authUser,
                    'access_token' => $token
                ], 200);
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
