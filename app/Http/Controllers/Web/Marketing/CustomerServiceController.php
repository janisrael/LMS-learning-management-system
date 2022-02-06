<?php

namespace App\Http\Controllers\Web\Marketing;

use App\Http\Controllers\Controller;
use App\Models\MarketingEverwebinar;
use App\Util\CustomerLookupUtil;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use GuzzleHttp\Exception\ClientException;

class CustomerServiceController extends Controller
{

    private $data;
    public $validator = null;
    private $guzzleClient;

    public function __construct(CustomerLookupUtil $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
        $this->data = config('page.customer-service');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyEmail(Request $request)
    {
        if(!$this->checkRolePermission('customer_lookup.view'))
            return $this->respondError();

        $email = $request->email;
        $baseUrl = config('customerlookup.base_url');
        $endPoint = config('customerlookup.endpoint.verify_email');
        $requestParams = [
            'email' => $email
        ];
        $apiKey = bcrypt($email . config('app.customer_lookup_key'));

        try {
            $this->guzzleClient->setRequestType('POST');
            $this->guzzleClient->setAddress($baseUrl.$endPoint);
            $this->guzzleClient->request($requestParams, $apiKey);
            return $this->guzzleClient->getResponse();
        } catch (ClientException $e) {
            return $this->respondError('Customer not found!');
        }
    }

    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
