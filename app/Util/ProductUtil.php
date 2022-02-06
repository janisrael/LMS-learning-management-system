<?php


namespace App\Util;

use App\Http\Resources\CoursePaymentScheduleCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ProductUtil
{
    private $chargebeeClient;
    private $guzzleClient;

    /**
     * ProductUtil constructor.
     * @param ChargebeeUtil $chargebeeClient
     * @param MarketingJourneyUtil $guzzleClient
     */
    public function __construct(ChargebeeUtil $chargebeeClient, MarketingJourneyUtil $guzzleClient)
    {
        $this->chargebeeClient = $chargebeeClient;
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @return array
     */
    public function retrievePlan(Request $request)
    {

        $planParams = array(
            'limit' => 100,
            'status[is]' => 'active'
        );

        $plan = [];

        $this->chargebeeClient->retrieveAllPlan($planParams);
        $all = $this->chargebeeClient->getResult();

        foreach ($all as $entry) {

            if($entry->plan()->cfPlanGroup == $request->plan_group){

                $plan[] = $entry->plan();

            }

        }

        return $plan;
    }

    /**
     * @return array
     */
    public function retrieveAddons()
    {
        $addonsParams = array(
            'limit' => 100,
            'status[is]' => 'active'
        );
        $addons = [];
        $this->chargebeeClient->retrieveAllAddons($addonsParams);
        $all = $this->chargebeeClient->getResult();
        foreach ($all as $entry) {
            $addons[] = $entry->addon();

        }

        return $addons;
    }

    public function verify(Request $request)
    {
        $baseUrl = config('phonesales.base_url');
        $endPoint = config('phonesales.endpoint.verify');
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

        $this->guzzleClient->setRequestType('POST');
        $this->guzzleClient->setAddress($baseUrl.$endPoint);
        $this->guzzleClient->request($requestParams, $requestHeaders);
        return $this->guzzleClient->getResponse();
    }

    public function purchase(Request $request)
    {
        $baseUrl = config('phonesales.base_url');
        $endPoint = config('phonesales.endpoint.purchase');
        $newPrice = $request->price * 100;
        $addonsArr = json_decode($request->addons);

        if(is_array($addonsArr) AND count($addonsArr) > 0) {

            $newAddons = [];

            for ($i=0; $i < count($addonsArr); $i++) {

                if($addonsArr[$i]->payment_method == 'Installment'){

                    $installment = [];

                    foreach ($addonsArr[$i]->installmentList as $value) {
                        array_push($installment, [
                            'amount' => $value->amount,
                            'due_date' => $value->date,
                            'currency' => $addonsArr[$i]->currency,
                            'payment_method' => $addonsArr[$i]->payment_method,
                            'tokenId' => '',
                            'sequence_no' => $value->seq 
                        ]);
                        
                    }

                    array_push($newAddons, [
                        'payment_sale' => [
                            'id' => $addonsArr[$i]->id,
                            'payment_schedule' => $installment
                        ]
                    ]);
                }
                else{

                    array_push($newAddons, [
                        'payment_sale' => [
                            'id' => $addonsArr[$i]->id,
                            'payment_schedule' => ''
                        ]
                    ]);
                }
                
            }
        }

        $requestParams = [
            'customer' => [
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'locale' => 'en-GB',
                'billingAddress' => [
                    'firstName' => $request->firstName,
                    'lastName' => $request->lastName,
                    'line1' => '',
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip' => $request->zip,
                    'country' => $request->country,
                ]
            ],
            'card' => [
                'customerId' => $request->customerId,
                'tokenId' => $request->tokenId,
                'src' => $request->srcId ?? ''
            ],
            'subscription' => [
                'planId' => $request->planId,
                'planUnitPrice' => $newPrice,
                'currencyCode' => $request->currencyCode,
                'metaData' => [
                    'campaign_id' => $request->campaigndId,
                    'campaign_name' => $request->campaignName,
                    'order_page_url' => URL::to('/'),
                    'subscription_purchase_origin' => URL::to('/')
                ],
                'addons' => $newAddons ?? ''
            ]

        ];

        if($request->purchaseError == "card" || $request->purchaseError == "subscription"){
            $collection = collect($requestParams);
            $merged = $collection->merge(['customer' => ['email' => $request->email],]);
            $requestParams = $merged->all();
        }
        if($request->purchaseError == "payment"){
            $requestParams = collect($requestParams);
            $merged = $collection->merge([
                'customer' => [
                    'email' => $request->email
                ],
                'card' => [
                    'customerId' => $request->customerId,
                    'tokenId' => $request->tokenId,
                    'src' => $request->srcId ?? ''
                ],
                'subscription' => null
            ]);
            $requestParams = $merged->all();
        }

        $requestHeaders = [
            'Accept' => 'application/json',
            'x-api-key' => bcrypt($request->email . config('app.mj_key')),
        ];

        $this->guzzleClient->setRequestType('POST');
        $this->guzzleClient->setAddress($baseUrl.$endPoint);
        $this->guzzleClient->request($requestParams, $requestHeaders);

        return $this->guzzleClient->getResponse();
        
    }

    public function emailTC(Request $request)
    {
        $baseUrl = config('phonesales.base_url');
        $endPoint = config('phonesales.endpoint.email_tc');

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

        $this->guzzleClient->setRequestType('POST');
        $this->guzzleClient->setAddress($baseUrl.$endPoint);
        $this->guzzleClient->request($requestParams, $requestHeaders);

        return $this->guzzleClient->getResponse();
    }
}
