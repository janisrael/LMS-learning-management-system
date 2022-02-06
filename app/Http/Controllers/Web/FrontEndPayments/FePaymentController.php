<?php

namespace App\Http\Controllers\Web\FrontEndPayments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\FeEmailTNCRequest;
use App\Http\Requests\Web\FeEventsRequest;
use App\Http\Requests\Web\FePurchaseRequest;
use App\Http\Requests\Web\FeVerifyRequest;
use App\Http\Resources\FeEventsResource;
use App\Http\Resources\FePurchaseResource;
use App\Http\Resources\PlanAddOnCollection;
use App\Http\Resources\PlanCollection;
use App\Jobs\MakePurchaseJob;
use App\Util\ChargebeeUtil;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Models\FEProcessPayment;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\json_decode;

class FePaymentController extends Controller
{
    private $chargebeeUtil;
    private $feProcessPayment;

    /**
     * ProductUtil constructor.
     * @param ChargebeeUtil $chargebeeClient
     */
    public function __construct(ChargebeeUtil $chargebeeUtil, FEProcessPayment $feProcessPayment)
    {
        $this->chargebeeUtil = $chargebeeUtil;
        $this->feProcessPayment = $feProcessPayment;
    }

    /**
     * @return PlanCollection
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @return PlanCollection
     */
    public function getPlans()
    {
        $planParams = [
            'limit' => 100,
            'status[is]' => 'active'
        ];

        $plans = [];

        $this->chargebeeUtil->retrieveAllPlan($planParams);
        $all = $this->chargebeeUtil->getResult();
        
        foreach ($all as $item) {
            $plans[] = $item->plan();
        }

        return new PlanCollection($plans);
    }

    /**
     * @return PlanAddOnCollection
     */
    public function getAddOns()
    {
        $addonsParams = array(
            'limit' => 100,
            'status[is]' => 'active'
        );

        $addons = [];
        
        $this->chargebeeUtil->retrieveAllAddons($addonsParams);
        $all = $this->chargebeeUtil->getResult();
        
        foreach ($all as $item) {
            $addons[] = $item->addon();
        }

        return new PlanAddOnCollection($addons);
    }

    public function processPayment(Request $request)
    {
        $processPayment = FEProcessPayment::create([
            'user_id' => Auth::user()->id,
            'request_payload' => $request->all(),
        ]);

        dispatch(new MakePurchaseJob($request->all(), $processPayment->id));

        return true;
    }

    /**
     * @param FeVerifyRequest $request
     * @return mixed
     */
    public function doVerify(FeVerifyRequest $request)
    {
        $uri = config('phonesales.base_url') . config('phonesales.endpoint.verify');

        $requestParams = [
            'customer' => [
                'email' => $request->email
            ],
            'subscription' => [
                'planId' => $request->planID
            ]
        ];

        $requestHeaders = [
            'Accept' => 'application/json',
            'x-api-key' => bcrypt($request->email . config('app.mj_key')),
        ];

        $client = new Client();

        $response = $client->post($uri, ['headers' => $requestHeaders, 'json' => $requestParams]);

        return $response->getBody()->getContents();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function emailTnC(FeEmailTNCRequest $request)
    {
        $uri = config('phonesales.base_url') . config('phonesales.endpoint.email_tnc');

        $requestParams = [
            'customer' => [
                'email' => $request->email,
                'name' => $request->name
            ]
        ];

        $requestHeaders = [
            'Accept' => 'application/json',
            'x-api-key' => bcrypt($request->email . config('app.mj_key')),
        ];

        $client = new Client();
        $response = $client->post($uri, ['headers' => $requestHeaders, 'json' => $requestParams]);

        return $response->getBody()->getContents();
    }

    /**
     * @param FeEventsRequest $request
     * @return mixed
     */
    public function getEvents(FeEventsRequest $request)
    {
        $uri = config('phonesales.base_url') . config('phonesales.endpoint.events');
        
        $requestParams = [
            'customer' => [
                "email" => $request->email
            ],
            'event_type_id' => $request->event_type_id,
            'date' => $request->date,
            'region' => $request->region
        ];

        $requestHeaders = [
            'Accept' => 'application/json',
            'x-api-key' => bcrypt($request->email . config('app.mj_key')),
        ];

        $client = new Client();
        $response = $client->post($uri, ['headers' => $requestHeaders, 'json' => $requestParams]);

        return $response->getBody()->getContents();
    }

    public function checkProcessPayment() {
        $result = $this->feProcessPayment->unProcessed()->first();

        if ( empty($result) ) {
            return null;
        }

        if ( $result->request_status == 'processing') {
            return 'processing';
        }

        $result->is_processed = 1;
        $result->save();

        return response()->json([
            'request' => $result->request_payload,
            'response' => json_decode($result->response_payload)
        ]);
    }

    public function getPaymentTransactions() {
        $uri = config('phonesales.base_url') . config('phonesales.endpoint.payments');

        $requestHeaders = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '. config('app.portal_bearer_token')
        ];

        $client = new Client();
        $response = $client->post($uri, ['headers' => $requestHeaders]);

        return $response->getBody()->getContents();
    }
    
}
