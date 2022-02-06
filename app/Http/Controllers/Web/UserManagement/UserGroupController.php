<?php

namespace App\Http\Controllers\Web\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Validator\UserGroupValidator;
use DataTables;
// use Yajra\DataTables\Facades\DataTables;
use App\Models\UserGroup;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserGroupController extends Controller
{
    public function __construct(UserGroup $group, UserGroupValidator $validator)
    {
        $this->group = $group;
        $this->validator = $validator;
        $this->data = config('page.user-group');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!isset($request->is_active) and !$this->checkRolePermission('user_group.view'))
            return $this->respondError();

        $this->data['columns'] = array_map(function ($val) {
            return ['data' => $val];
        }, array_keys(config('page.user-group.table_header')));
        if ($request->ajax()) {
            $groups = $this->group;
            if(isset($request->is_active)){
                $groups = $groups->scopeActive();
            }
            return DataTables::of($groups->get())->make(true);
        }
        return view('pages.user-group.index', $this->data);
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
        if(!$this->checkRolePermission('user_group.create'))
            return $this->respondError();

        $data = $request->only($this->group->getModel()->fillable);
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $validated = $this->validate($data, $this->validator->store_rules(), $this->validator->getMessages());
        
        if ($validated->fails()) {
            return $this->validationErrors($validated->errors());
        }
        else {
            if($this->group->create($data)){
                return $this->respondSuccess('User Group Created!');
            }
        }
        return $this->respondError('User Group not created.');
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
        if(!$this->checkRolePermission('user_group.update',$id))
            return $this->respondError();
        
        $newdata = UserGroup::findOrFail($id);
        $data = $request->only($this->group->getModel()->fillable);
        
        $validated = $this->validate($data, $this->validator->update_rules($data['id'],$data['name']), $this->validator->getMessages());
        if ($validated->fails()) {
            return $this->validationErrors($validated->errors());
        }
        else {
            $newdata->update($data);
            return $this->respondSuccess('User Group Updated!');
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
        if(!$this->checkRolePermission('user_group.delete',$id))
            return $this->respondError();

        $data = UserGroup::findOrFail($id);
        if ($data->destroy($id)) {
            return $this->respondSuccess('User Group Deleted!');
        }
        return $this->respondError('User Group not deleted.');
    }
}
