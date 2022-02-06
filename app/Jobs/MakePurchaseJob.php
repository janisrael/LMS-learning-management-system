<?php

namespace App\Jobs;

use App\Http\Controllers\Web\FrontEndPayments\FePaymentController;
use App\Models\FEProcessPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use GuzzleHttp\Client;
use DateTime;

class MakePurchaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $request;
    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $request, string $id)
    {
        $this->request = (object) $request;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {        
        $response = $this->makePurchase($this->request);

        $fEProcessPayment = FEProcessPayment::find($this->id);
        $fEProcessPayment->response_payload = $response;
        $fEProcessPayment->request_status = 'completed';
        $fEProcessPayment->save();

    }

    public function makePurchase($request)
    {
        $uri = config('phonesales.base_url') . config('phonesales.endpoint.purchase');

        $addons = json_decode($request->addons);
        $productId = $request->productId ? json_decode($request->productId) : [];
        
        if(is_array($addons) && count($addons) > 0) {
            $newAddons = [];
            $event = null;
            for ($i=0; $i < count($addons); $i++) {

                for ($j=0; $j <  count($addons[$i]->events); $j++) { 
                    
                    if($addons[$i]->events[$j]->selected == 'true'){
                        $event = $addons[$i]->events[$j]->id; 
                    }

                }

                if($addons[$i]->payment_method == 'Installment'){
                    $installment = [];
                    // dd($addons[$i]->installmentList);
                    foreach ($addons[$i]->installmentList as $key => $value) {
                        array_push($installment, [
                            'amount' => $value->amount,
                            'due_date' => DateTime::createFromFormat('m-d-Y', $value->date)->format('Y-m-d'), //needs refactoring on the front end
                            'currency' => $addons[$i]->currency,
                            'sequence_no' => $value->seq,
                            'payment_method' => $value->payment_method
                        ]);
                        
                    }

                    array_push($newAddons, [
                        'id' => $addons[$i]->id,
                        'unit_price' => $addons[$i]->price,
                        'event_id' => $event ?? '',
                        'product_id' => count($productId) ? json_decode($request->productId)[0] : '', //TO DO: fix iteration
                        'payment_schedule' => $installment
                    ]);
                }
                else{
                    array_push($newAddons, [
                        'id' => $addons[$i]->id,
                        'unit_price' => $addons[$i]->price,
                        'event_id' => $event ?? '',
                        'product_id' => count($productId) ? json_decode($request->productId)[0] : '',
                        'payment_schedule' => []
                    ]);
                }
                
            }

        }

        $requestParams = [
            'customer' => [
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'dateOfBirth' => $request->dateOfBirth,
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
                'newCardDetails' => $request->tokenId,
                'src' => $request->srcId ?? ''
            ],
            'subscription' => [
                'planId' => $request->planId,
                'planUnitPrice' => $request->price * 100,
                'currencyCode' => $request->currencyCode,
                'metaData' => [
                    'campaign_id' => $request->campaigndId ?? '',
                    'campaign_name' => $request->campaignName ?? '',
                    'order_page_url' => URL::to('/'),
                    'subscription_purchase_origin' => URL::to('/')
                ],
                'addons' => $newAddons ?? '',
                'sale_type' => $request->saleType
            ],
            'staff' => [
                'sf_id' => '',
                'sc2_id' => ''
            ]
        ];
    
        if($request->purchaseError == "card" || $request->purchaseError == "subscription"){
            $collection = collect($requestParams);
            $merged = $collection->merge(['customer' => ['email' => $request->email],]);
            $requestParams = $merged->all();
        }

        if($request->purchaseError == "payment"){
            $collection = collect($requestParams);
            $merged = $collection->merge([
                'customer' => [
                    'email' => $request->email
                ],
                'card' => [
                    'customerId' => $request->customerId,
                    'newCardDetails' => $request->tokenId,
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
        
        $client = new Client();
        $response = $client->post($uri, ['headers' => $requestHeaders, 'json' => $requestParams]);

        return $response->getBody()->getContents();
    }
}
