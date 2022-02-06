<?php

namespace App\Http\Controllers\Web\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    private $roles;
    private $permissions;
    private $data;
    public $validator = null;
    public function __construct(Role $roles, Permission $permissions)
    {
        $this->roles = $roles;
        $this->permissions = $permissions;
        // $this->validator = $validator;
        $this->data = config('page.roles');
    }
    /**
     * Display a listing of the resource.
     *
     *  * @param \Illuminate\Http\Resquest
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if(!$this->checkRolePermission('role_and_permission.view'))
            return $this->respondError();

        $this->data['columns'] = array_map(function ($val) {
            return ['data' => $val];
        }, array_keys(config('page.roles-management.table_header')));

        if ($request->ajax()) {
            return DataTables::of($this->roles->get())->make(true);
        }
        return view('pages.roles-management.index', $this->data);
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
        if(!$this->checkRolePermission('role_and_permission.create'))
            return $this->respondError();

        $permissions = $request->permissions;
        // $data = $request->only($this->roles->getModel()->fillable);

        // $validated = $this->validate($data, $this->validator->store_rules($data['name']), $this->validator->getMessages());

        // if ($validated->fails()) {
        //     return $this->validationErrors($validated->errors());
        // } else {
            $newRole = $this->roles->create(['name'=>$request->name, 'guard_name'=>$request->guard_name]);
            $newRole->givePermissionTo($permissions);
            return $this->respondSuccess('New Role Created!');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

        $data = Permission::findOrFail($id);
        
        if($data) {
            return $this->toJson(['data'=>$data],200);
        } else {
            return $this->toJson(['status','not found'],200);
        }

    }

    /**
     * Get list of permission upon selected role id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPermissions($id)
    {
        $permissions = $this->permissions->where('label','!=','')->get();
        $role = Role::find($id);
        $query = $role->getAllPermissions();
        if($permissions) {
            return $this->toJson(['permissions'=>$permissions->toArray(),'permissionsInRole'=>$query->toArray()],200);
        } else {
            return $this->respondError('Not Found!');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        if(!$this->checkRolePermission('role_and_permission.update',$id))
            return $this->respondError();

        $updatedRole = Role::findorfail($id);
        // $data = $request->only($this->roles->getModel()->fillable);
        $permissions = $request->permissions;

        // $validated = $this->validate($data, $this->validator->rules($data['id']), $this->validator->getMessages());
        // if ($validated->fails()) {
        //     return $this->validationErrors($validated->errors());
        // } else {
            $updatedRole->update(['guard_name'=>$request->guard_name]);
            $updatedRole->syncPermissions($permissions);
            return $this->respondSuccess('Role Updated!');
        // }
    }

    /**
     * Remove the specified resource from storage.
     * TODO deleting Roles not allowed if a user is assigned
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        if(!$this->checkRolePermission('role_and_permission.delete',$id))
            return $this->respondError();
        
        $role = Role::findorfail($id);
        $role->syncPermissions([]);
        if ($role) {
            $role->delete($id);
            
            return $this->respondSuccess('Role Deleted!');
        }
        return $this->respondError('Role not deleted.');
    }
}
