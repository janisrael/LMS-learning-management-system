<?php

namespace App\Http\Controllers\Web\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    private $permission;
    private $data;
    public $validator = null;

    public function __construct(Permission $permission, Role $role)
    {
        $this->permission = $permission;
        $this->role = $role;
        // $this->validator = $validator;
        $this->data = config('page.roles');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $role_id = $request->role_id;
        if(!$this->checkRolePermission('role_and_permission.create')){
            return $this->respondError();
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
        if(!$this->checkRolePermission('role_and_permission.update',$id))
            return $this->respondError();

        $permission_id = $id;
        $role_id = $request->role_id;
        $is_allowed = $request->is_allowed;

        $role = Role::find($role_id);
        $permissions = $role->getAllPermissions();
        $permissions = collect($permissions);
        $permission = Permission::find($permission_id);

        if($permissions->contains('id',$permission_id)){    // if permission already exists
            if(!$is_allowed){
                $role->revokePermissionTo($permission->name);
            }
        }else{
            if($is_allowed){
                $role->givePermissionTo($permission->name);
            }
        }
        

        return $this->respondSuccess('Permission for Role Updated!');
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

    /**
     * Get list of permission all
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPermissions($id)
    {
        $permissions = Permission::where('label','!=','')->get();

        $modules = [];
        $groups = [];
        $key = 0;
        foreach($permissions as $value){
            if(!isset($modules[$value->module])){
                $modules[$value->module] = [
                    'checked'   => false,
                    'data'      => []
                ];
                $key = 0;
            }
            if(!isset($modules[$value->module]['data'][$value->group])){
                $modules[$value->module]['data'][$value->group] = [
                    'checked'   => false,
                    'data'      => []
                ];
                $key = 0;
            }
            $modules[$value->module]['data'][$value->group]['data'][$key] = [
                'checked'   => false,
                'data'      => $value
            ];

            if($id!='-'){
                $roles = collect($value->roles->all());

                if($roles->contains('id',$id)){
                    $modules[$value->module]['data'][$value->group]['data'][$key]['checked'] = true;
                }
            }
            $key++;
        }

        if($modules) {
            return $this->toJson(['data'=>$modules],200);
        } else {
            return $this->toJson(['status','not found'],200);
        }

    }

}
