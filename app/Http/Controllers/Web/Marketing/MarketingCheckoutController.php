<?php

namespace App\Http\Controllers\Web\Marketing;

use App\Http\Controllers\Controller;
use App\Models\MarketingCheckout;
use Illuminate\Http\Request;
use App\Http\Validator\MarketingCheckoutValidator;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use \GuzzleHttp\json_encode;

class MarketingCheckoutController extends Controller
{
    private $checkout;
    private $data;
    private $validator = null;

    public function __construct(MarketingCheckout $checkout, MarketingCheckoutValidator $validator )
    {
        $this->checkout = $checkout;
        $this->validator =  $validator;
        $this->data = config('page.marketing-checkout');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if(!$this->checkRolePermission('checkout_page.view'))
            return $this->respondError();

        if ($request->ajax()) {
            $query  = MarketingCheckout::query()->get();
           return $query;
//            return DataTables::of($this->checkout->get())->make(true);
        }
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if(!$this->checkRolePermission('checkout_page.create'))
            return $this->respondError();

        $data = $request->only($this->checkout->getModel()->fillable);

        $validated = $this->validate($data, $this->validator->rules($data['plan_id']), $this->validator->getMessages());

        if ($validated->fails()) {
            return $this->validationErrors($validated->errors());
        }
        else {
            $data['created_by'] = Auth::id();
            $val = $request->addons;
            $data['addons'] = $val;
            $data['hash'] = Str::random(7);
            $this->checkout->create($data);
            
            return $this->respondSuccess('New Checkout Page Created!');
        }
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if(!$this->checkRolePermission('checkout_page.update', $id))
            return $this->respondError();

        $newdata = MarketingCheckout::findorfail($id);
        $data = $request->only($this->checkout->getModel()->fillable);
        $validated = $this->validate($data, $this->validator->update_rules($data['id']), $this->validator->getMessages());

        if ($validated->fails()) {
            return $this->validationErrors($validated->errors());
        }
        else {
            $newdata->update($data);
            return $this->respondSuccess('Checkout Page Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        if(!$this->checkRolePermission('checkout_page.delete', $id))
            return $this->respondError();

        $data = MarketingCheckout::findOrFail($id);
        if($data->destroy($id)) {
            return $this->respondSuccess('Checkout Page Deleted');
        }

    }
}
