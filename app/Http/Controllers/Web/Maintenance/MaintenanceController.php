<?php

namespace App\Http\Controllers\Web\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Validator\MaintenanceValidator;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use App\Http\Requests\Web\MaintenanceRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    private $maintenance;
    private $data;
    public $validator = null;

    public function __construct(Maintenance $maintenance, MaintenanceValidator $validator)
    {
        $this->maintenance = $maintenance;
        $this->validator = $validator;
        $this->data = config('page.maintenance');
        $this->auth_user = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if(!$this->checkRolePermission('maintenance_schedule.view'))
            return $this->respondError();

        $this->data['columns'] = array_map(function ($val) {
            return ['data' => $val];
        }, array_keys(config('page.maintenance.table_header')));

        if ($request->ajax()) {
            return Datatables::of($this->maintenance->get())->make(true);
        }

        return view('layouts.app', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.maintenance.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MaintenanceRequest $request)
    {
        if(!$this->checkRolePermission('maintenance_schedule.create'))
            return $this->respondError();

        $data = $request->only($this->maintenance->getModel()->fillable);
        $data['added_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $data['ticket_no'] = date('Yds').mt_rand(10, 99);
        $validated = $this->validate($data, $this->validator->store_rules(), $this->validator->getMessages());

        if ($validated->fails()) {
            return $this->validationErrors($validated->errors());
        } else {
            $this->maintenance->create($data);
            
            return $this->respondSuccess('Maintenance Schedule Created!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Maintenance $maintenance
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Maintenance $maintenance)
    {
        $this->data['data'] = $maintenance;

        return view('pages.maintenance.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Maintenance  $maintenance
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MaintenanceRequest $request, Maintenance $maintenance)
    {
        $id = isset($request->id) ? $request->id : '';
        if(!$this->checkRolePermission('maintenance_schedule.update', $id))
            return $this->respondError();

        if ($maintenance->update($request->all())) {
            return $this->respondSuccess('Maintenance Schedule Updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Maintenance $maintenance
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Maintenance $maintenance)
    {
        $id = isset($maintenance->id) ? $maintenance->id : '';
        if(!$this->checkRolePermission('maintenance_schedule.delete',$id))
            return $this->respondError();

        if ($maintenance->delete()) {
            return $this->respondSuccess('Maintenance Schedule Deleted!');
        }
    }
}
