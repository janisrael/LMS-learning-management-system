<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class FePurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
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
                'planUnitPrice' => $$request->price * 100,
                'currencyCode' => $request->currencyCode,
                'metaData' => [
                    'campaign_id' => $request->campaigndId,
                    'campaign_name' => $request->campaignName,
                    'order_page_url' => URL::to('/'),
                    'subscription_purchase_origin' => URL::to('/')
                ],
                'addons' => ''
            ]
        ];

        $addons = json_decode($request->addons);

        if(is_array($addons) && count($addons) > 0) {
            $newAddons = [];

            for ($i=0; $i < count($addons); $i++) {

                if($addons[$i]->payment_method == 'Installment'){
                    $installment = [];

                    foreach ($addons[$i]->installmentList as $value) {
                        array_push($installment, [
                            'amount' => $value->amount,
                            'due_date' => $value->date,
                            'currency' => $addons[$i]->currency,
                            'payment_method' => $addons[$i]->payment_method,
                            'tokenId' => '',
                            'sequence_no' => $value->seq 
                        ]);
                        
                    }

                    array_push($newAddons, [
                        'payment_sale' => [
                            'id' => $addons[$i]->id,
                            'payment_schedule' => $installment
                        ]
                    ]);
                }
                else{
                    array_push($newAddons, [
                        'payment_sale' => [
                            'id' => $addons[$i]->id,
                            'payment_schedule' => ''
                        ]
                    ]);
                }
                
            }

            $result['addons'] = $newAddons;
        }
        

        return $result;
    }
}
