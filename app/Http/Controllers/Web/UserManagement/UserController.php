<?php

namespace App\Http\Controllers\Web\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Validator\UserValidator;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Requests\Web\UserRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    private $user;
    private $profile;
    private $data;
    public $validator = null;

    public function __construct(User $user, Profile $profile, UserValidator $validator)
    {
        $this->user = $user;
        $this->profile = $profile;
        $this->validator = $validator;
        $this->data = config('page.user');
    }


    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if(!$this->checkRolePermission('user_account.view')){
            return $this->respondError();
        }

        $this->data['columns'] = array_map(function ($val) {
            return ['data' => $val];
        }, array_keys(config('page.user.table_header')));

        if ($request->ajax()) {
          return Datatables::of($this->user->with(['permissions','roles.permissions'])->get())->make(true);
        }

        return view('pages.user.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.user.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        if(!$this->checkRolePermission('user_account.create'))
            return $this->respondError();

        $data = $request->except(['profile', 'permissions', 'role_name']);
        $data['created_by'] = Auth::id();
        $data['email_verified_at'] = now();
        $profile = $request->profile;

        $validated = $this->validate($data, $this->validator->store_rules(), $this->validator->getMessages());

        if ($validated->fails()) {
            return $this->validationErrors($validated->errors());
        }
        else {
            if ($user = $this->user->create($data)){
                // $user->allowUpdateProfile($request->permissions['profile_update']);
                $user->setPermissions($request->permissions);
                $user->assignRole($request->role_name);
                $profile['user_id'] = $user->id;
                $profile['avatar'] = "";
                $p = $this->profile->create($profile);
                $p->setAvatar($request->profile['avatar']);
                return $this->respondSuccess('New User Account Created!');
            }
        }

        return $this->respondError('User Account not created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->data['data'] = $user;

        return view('pages.user.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if(!$this->checkRolePermission('user_account.update',$id))
            return $this->respondError();
        
        $newdata = User::findorfail($id);
        $data = $request->only($this->user->getModel()->fillable);
        $profile = collect($request->profile)->except(['avatar'])->toArray();
        
        $validated = $this->validate($data, $this->validator->update_rules($data['id'],$data['username'],$data['email']), $this->validator->getMessages());

        if ($validated->fails()) {
            return $this->validationErrors($validated->errors());
        }
        else {
            $newdata->update($data);
            $newdata->setPermissions($request->permissions);
            $newdata->syncRoles($request->role_name);
            $newdata->profile->update($profile);
            $newdata->profile->setAvatar($request->profile['avatar']);      
            $newdata->touch();      

            return $this->respondSuccess('User Account Updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if(!$this->checkRolePermission('user_account.delete',$id))
            return $this->respondError();
        
        $data = User::findorfail($id);
        if($data->destroy($id)) {
            
            return $this->respondSuccess('User Account Deleted!');
        };
        return $this->respondError('User Account not deleted.');
    }

    /**
     * Get User Details after login.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userinfo(Request $request)
    {
        $userinfo = Auth::user();
        $u = User::find($userinfo->id);

        $roles = auth()->user()->getRoleNames()->toArray();
        $profile = auth()->user()->profile()->first();
        $group = $profile->userGroup()->first();
        $last_login = empty(auth()->user()->last_login_at) ? '---' : auth()->user()->last_login_at->diffForHumans();
        $userinfo['prev_log_in'] = $last_login;

        $permissions = $u->getAllPermissions()->toArray();
        if ((collect($permissions))->contains('name', '*.*,create,view,update,delete,restore,force_delete')){
            $permissions = (Permission::all())->toArray();
        }

        $userinfo['permissions'] = $permissions;
        $userinfo['profile']['group'] = [];
        $userinfo['profile']['group'] = $group;


        return response()->json($userinfo);
    }
}
