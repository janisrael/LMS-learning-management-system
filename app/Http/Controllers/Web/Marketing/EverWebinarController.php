<?php

namespace App\Http\Controllers\Web\Marketing;

use App\Http\Controllers\Controller;
use App\Http\Validator\MarketingEverwebinarValidator;
use App\Models\MarketingEverwebinar;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
class EverWebinarController extends Controller
{
    private $everwebinar;
    private $data;
    public $validator = null;
    
    public function __construct(MarketingEverwebinar $everwebinar, MarketingEverwebinarValidator $validator)
    {
        $this->everwebinar = $everwebinar;
        // $this->validator = $validator;
        // $this->data = config('page.marketing-everwebinar');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if(!$this->checkRolePermission('everwebinar_page.view'))
            return $this->respondError();

        return DataTables::of($this->everwebinar->get())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function courses(Request $request)
    {
        $data = DataTables::of($this->everwebinar->get())->make(true);
 
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if(!$this->checkRolePermission('everwebinar_page.create'))
            return $this->respondError();

        $data = $request->only($this->everwebinar->getModel()->fillable);

        $validated = $this->validate($data, $this->validator->rules($data['gid_code']), $this->validator->getMessages());

        if ($validated->fails()) {
            return $this->validationErrors($validated->errors());
        }
        else {
            $data['created_by'] = Auth::id();
            $data['hash'] = Str::random(7);
            $this->everwebinar->create($data);
            
            return $this->respondSuccess('New EverWebinar Page Created!');
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
        if(!$this->checkRolePermission('everwebinar_page.update', $id))
            return $this->respondError();

        $newdata = MarketingEverwebinar::findorfail($id);
        $data = $request->only($this->everwebinar->getModel()->fillable);
        $validated = $this->validate($data, $this->validator->update_rules($data['id']), $this->validator->getMessages());

        if ($validated->fails()) {
            return $this->validationErrors($validated->errors());
        }
        else {
            $newdata->update($data);
            return $this->respondSuccess('EverWebinar Page Updated!');
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
        if(!$this->checkRolePermission('everwebinar_page.delete', $id))
            return $this->respondError();

        $data = MarketingEverwebinar::findOrFail($id);
        $data->destroy($id);
        return $this->respondSuccess('EverWebinar Page Deleted!');
    }
}
