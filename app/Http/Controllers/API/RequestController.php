<?php

namespace App\Http\Controllers\API;

use App\ConsumerType;
use App\Http\Controllers\Controller;

use App\Models\requestModel;
use App\Models\consumer;
use App\Models\gas;
use App\Models\outlet;
use App\Models\outlet_manager;
use App\Models\schedule;
use App\Models\User;
use App\RequestStatusType;
use App\StatusType;
use App\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\GasRequestConfirmMail;
use Illuminate\Support\Facades\Mail;

class RequestController extends Controller
{
    /**
     * Display a listing of gas requests.
     */
    public function index()
    {
        // get all the gas requests
        $allRequests = requestModel::all();

        $combinedResults = $allRequests->map(function ($request) {
            // Get gas data for the current request
            $gasData = gas::query()
                ->where('id', $request->gas_id)
                ->select('*')
                ->first();

            // Get consumer data for the current request
            $consumerData = consumer::query()
                ->where('id', $request->consumer_id)
                ->select('*')
                ->first();

            // Get user email data for the current request
            $consumerEmail = User::query()
                ->select('email')
                ->where('id', $consumerData->user_id)
                ->first();

            $consumerData->email = $consumerEmail->email;

            // Get schedule data for the current request
            $scheduleData = schedule::query()
                ->where('id', $request->schedule_id)
                ->select('*')
                ->first();

            // Get outlet data for the current request
            $outletData = outlet::query()
                ->where('id', $scheduleData->outlet_id)
                ->select('*')
                ->first();

            // Return the combined data for the current request
            return [
                'request' => $request,
                'gas' => $gasData,
                'consumer' => $consumerData,
                'schedule' => $scheduleData,
                'outlet' => $outletData
            ];
        });

        // send 200 response with gas requests
        return response()->json([
            'status' => true,
            'message' => 'Requests retrieved successfully',
            'data' => $combinedResults
        ], 200);
    }

    /**
     * Get all the gas request belongs to loged in user
     */
    public function getAllByLoginUser()
    {
        // get login user
        $user = Auth::user();
        $combinedResults = null;
        // check user type and call separate methods to get requests
        if ($user && $user->type === UserType::Outlet_Manager->value) {
            $combinedResults = $this->outletManagerRequests($user->id);
        } else if ($user && $user->type === UserType::Consumer->value) {
            $combinedResults = $this->consumerRequests($user->id);
        }

        // send 200 response with gas requests
        return response()->json([
            'status' => true,
            'message' => 'Requests retrieved successfully',
            'data' => $combinedResults
        ], 200);
    }

    /**
     * Return gas requests that related to the outlet that login outlet manager belongs
     */
    public function outletManagerRequests($userId)
    {
        $allOutletRequests = array();
        // get outlet ID by joining user with outlet_manager tables
        $outletId = outlet_manager::join('users', 'outlet_managers.user_id', '=', 'users.id')
            ->select('outlet_managers.outlet_id')
            ->where('outlet_managers.user_id', '=', $userId)
            ->first();

        if ($outletId->outlet_id) {
            // get all the schedules related to that outlet
            $outletSchedules = schedule::query()
                ->where('outlet_id', '=', $outletId->outlet_id)
                ->get();

            if (count($outletSchedules) > 0) {
                // loop through schedule list
                foreach ($outletSchedules as $schedule) {
                    // get requests related to each schedule
                    $scheduleRequest = requestModel::query()
                        ->where('schedule_id', '=', $schedule->id)
                        ->get();

                    if (count($scheduleRequest) > 0) {
                        // loop through request list
                        foreach ($scheduleRequest as $request) {
                            // Get gas data for the current request
                            $gasData = gas::query()
                                ->where('id', $request->gas_id)
                                ->select('*')
                                ->first();

                            // Get consumer data for the current request
                            $consumerData = consumer::query()
                                ->where('id', $request->consumer_id)
                                ->select('*')
                                ->first();

                            // Get user email data for the current request
                            $consumerEmail = User::query()
                                ->select('email')
                                ->where('id', $consumerData->user_id)
                                ->first();

                            $consumerData->email = $consumerEmail->email;

                            // Get schedule data for the current request
                            $scheduleData = schedule::query()
                                ->where('id', $request->schedule_id)
                                ->select('*')
                                ->first();

                            // Get outlet data for the current request
                            $outletData = outlet::query()
                                ->where('id', $scheduleData->outlet_id)
                                ->select('*')
                                ->first();

                            // Return the combined data for the current request
                            array_push($allOutletRequests, [
                                'request' => $request,
                                'gas' => $gasData,
                                'consumer' => $consumerData,
                                'schedule' => $scheduleData,
                                'outlet' => $outletData
                            ]);
                        }
                    }
                }
                return $allOutletRequests;
            }
        }
    }

    /**
     * Return gas requests that related to the consumer that login.
     */
    public function consumerRequests($userId)
    {
        // get consumer ID by joining users with consumers tables
        $consumerId = consumer::join('users', 'consumers.user_id', '=', 'users.id')
            ->select('consumers.id')
            ->where('consumers.user_id', '=', $userId)
            ->first();

        if ($consumerId) {
            // get all the request related to the consumer id
            $consumerRequest = requestModel::query()
                ->where('consumer_id', '=', $consumerId->id)
                ->get();
            if (count($consumerRequest) > 0) {
                // loop through each request and get data
                $combinedResults = $consumerRequest->map(function ($request) {
                    // Get gas data for the current request
                    $gasData = gas::query()
                        ->where('id', $request->gas_id)
                        ->select('*')
                        ->first();

                    // Get consumer data for the current request
                    $consumerData = consumer::query()
                        ->where('id', $request->consumer_id)
                        ->select('*')
                        ->first();

                    // Get user email data for the current request
                    $consumerEmail = User::query()
                        ->select('email')
                        ->where('id', $consumerData->user_id)
                        ->first();

                    $consumerData->email = $consumerEmail->email;

                    // Get schedule data for the current request
                    $scheduleData = schedule::query()
                        ->where('id', $request->schedule_id)
                        ->select('*')
                        ->first();

                    // Get outlet data for the current request
                    $outletData = outlet::query()
                        ->where('id', $scheduleData->outlet_id)
                        ->select('*')
                        ->first();

                    // Return the combined data for the current request
                    return [
                        'request' => $request,
                        'gas' => $gasData,
                        'consumer' => $consumerData,
                        'schedule' => $scheduleData,
                        'outlet' => $outletData
                    ];
                });
                return $combinedResults;
            }
        }
    }

    /**
     * Get row count of request table in the database
     */
    public function count()
    {
        $requestDataCount = requestModel::query()
            ->get()
            ->count();
        return response()->json([
            'status' => true,
            'message' => 'Request count retrieved successfully',
            'data' => $requestDataCount
        ], 200);
    }

    /**
     * Generate new unique gas request token
     */
    public function generateUniqueToken()
    {
        do {
            $token = 'GAS-' . Str::random(3) . '-' . Str::random(3); // Generate the token
        } while (requestModel::where('token', $token)->exists()); // Check uniqueness

        return $token;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request body data
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'gas_id' => 'required|exists:gas,id',
            'consumer_id' => 'required|exists:consumers,id',
            'type' => 'required|string',
            'quantity' => 'required|string',
        ]);

        // get All requests related to got consumer_id
        $allRequests = requestModel::all()->where('consumer_id', '=', $request->consumer_id);

        // check if there any incompete request there for the same consumer
        // if yes, then return 400 response with error message
        if (count($allRequests) > 0) {
            foreach ($allRequests as $singleRequest) {
                if (($singleRequest->status == RequestStatusType::Pending->value) || ($singleRequest->status == RequestStatusType::Paid->value)) {
                    $errorData = [
                        'ACTIVE_REQ' => [
                            'message' => 'Consumer already have active request'
                        ]
                    ];
                    return response()->json([
                        'status' => false,
                        'message' => 'Request created failed',
                        'errors' => $errorData
                    ], 400);
                }
            }
        }

        // get consumer data from the consumer tabel
        $consumer = consumer::query()->where('id', '=', $request->consumer_id)->first();

        // get consumer email from the user tabel
        $consumerEmail = User::query()->select('email')->where('id', '=', $consumer->user_id)->first();

        // get the token and expire date generated
        $token = $this->generateUniqueToken();
        $expire_date = date('Y-m-d', strtotime(now() . ' + 14 days'));

        // Save new request to database
        $newRequest = requestModel::create([
            'schedule_id' => $request->get('schedule_id'),
            'gas_id' => $request->get('gas_id'),
            'consumer_id' => $request->get('consumer_id'),
            'type' => $request->get('type'),
            'quantity' => $request->get('quantity'),
            'status' => RequestStatusType::Pending->value,
            'expired_at' => $expire_date,
            'token' => $token
        ]);

        if ($newRequest) {
            // if request save then update schedule available quantity
            $schedule = schedule::findOrFail($newRequest->schedule_id);
            $schedule->update([
                'available_quantity' => ($schedule->available_quantity - $newRequest->quantity)
            ]);
            // Send confimation Email
            // @TODO - commented for now
            // Mail::to($consumerEmail->email)->send(new GasRequestConfirmMail($token, $expire_date, $consumer->name));
            // send 200 response back
            return response()->json([
                'status' => true,
                'message' => 'Request created successfully',
                'data' => $newRequest
            ], 201);
        } else {
            // send 400 response back if request save fail
            return response()->json([
                'status' => false,
                'message' => 'Request created failed',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $allRequests = requestModel::all()->where('id', '=', $id);

        $combinedResults = $allRequests->map(function ($request) {
            // Get gas data for the current request
            $gasData = gas::query()
                ->where('id', $request->gas_id)
                ->select('*')
                ->first();

            // Get consumer data for the current request
            $consumerData = consumer::query()
                ->where('id', $request->consumer_id)
                ->select('*')
                ->first();

            // Get user email data for the current request
            $consumerEmail = User::query()
                ->select('email')
                ->where('id', $consumerData->user_id)
                ->first();

            $consumerData->email = $consumerEmail->email;

            // Get schedule data for the current request
            $scheduleData = schedule::query()
                ->where('id', $request->schedule_id)
                ->select('*')
                ->first();

            // Get outlet data for the current request
            $outletData = outlet::query()
                ->where('id', $scheduleData->outlet_id)
                ->select('*')
                ->first();

            // Return the combined data for the current request
            return [
                'request' => $request,
                'gas' => $gasData,
                'consumer' => $consumerData,
                'schedule' => $scheduleData,
                'outlet' => $outletData
            ];
        });
        return response()->json([
            'status' => true,
            'message' => 'Request found successfully',
            'data' => $combinedResults->first() ?? (object)[]
        ], 200);
    }

    /**
     * Search a request by token and get all the data related to it
     */
    public function searchByToken($token)
    {
        $allRequests = requestModel::all()->where('token', '=', $token);

        $combinedResults = $allRequests->map(function ($request) {
            // Get gas data for the current request
            $gasData = gas::query()
                ->where('id', $request->gas_id)
                ->select('*')
                ->first();

            // Get consumer data for the current request
            $consumerData = consumer::query()
                ->where('id', $request->consumer_id)
                ->select('*')
                ->first();

            // Get user email data for the current request
            $consumerEmail = User::query()
                ->select('email')
                ->where('id', $consumerData->user_id)
                ->first();

            $consumerData->email = $consumerEmail->email;

            // Get schedule data for the current request
            $scheduleData = schedule::query()
                ->where('id', $request->schedule_id)
                ->select('*')
                ->first();

            // Get outlet data for the current request
            $outletData = outlet::query()
                ->where('id', $scheduleData->outlet_id)
                ->select('*')
                ->first();

            // Return the combined data for the current request
            return [
                'request' => $request,
                'gas' => $gasData,
                'consumer' => $consumerData,
                'schedule' => $scheduleData,
                'outlet' => $outletData
            ];
        });
        return response()->json([
            'status' => true,
            'message' => 'Request found successfully',
            'data' => $combinedResults->first() ?? (object)[]
        ], 200);
    }

    /**
     * Update the request status.
     */
    public function updateRequestStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        // get request by id
        $requestModel = requestModel::findOrFail($id);

        $requestModel->update(['status' => $request->get('status')]);
        return response()->json([
            'status' => true,
            'message' => 'Request status updated successfully'
        ], 201);
    }

    /**
     * Assign new consumer to the same request
     */
    public function assignRequestToNewConsumer(Request $request, $id)
    {
        $request->validate([
            'consumer_id' => 'required'
        ]);

        // get request by id
        $requestModel = requestModel::where('id', $id)->firstOrFail();


        // get old consumer data from the consumer tabel
        // $oldConsumer = consumer::query()->where('id', '=', $requestModel->consumer_id)->first();

        // get old consumer email from the user tabel
        // $oldConsumerEmail = User::query()->select('email')->where('id', '=', $oldConsumer->user_id)->first();

        // get new consumer data from the consumer tabel
        // $newConsumer = consumer::query()->where('id', '=', $request->consumer_id)->first();

        // get new consumer email from the user tabel
        // $newConsumerEmail = User::query()->select('email')->where('id', '=', $newConsumer->user_id)->first();

        // update reuest with new consumer
        $requestModel->update(['consumer_id' => $request->get('consumer_id')]);

        // Send confimation Email to old consumer
        // Mail::to($oldConsumerEmail->email)->send(new GasRequestConfirmMail($token, $expire_date, $consumer->email));

        return response()->json([
            'status' => true,
            'message' => 'Request assign to a consumer successfully',
            'data' => $requestModel
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $requestModel = requestModel::findOrFail($id);
        $requestModel->delete();

        return response()->json([
            'status' => true,
            'message' => 'Request deleted successfully'
        ], 204);
    }
}
