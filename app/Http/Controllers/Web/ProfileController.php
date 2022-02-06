<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Validator\ProfileValidator;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Requests\Web\UserRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(Profile $profile, ProfileValidator $validator)
    {
        $this->profile = $profile;
        $this->validator = $validator;
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
        if(!$this->checkRolePermission('profile.update'))
            return $this->respondError();

        $newdata = Profile::findorfail($id);
        $data = $request->except(['avatar']);

        $validated = $this->validate($data, $this->validator->update_rules($id, $data['name']), $this->validator->getMessages());

        if ($validated->fails()) {
            return $this->validationErrors($validated->errors());
        } else {
            $newdata->update($data);
            $newdata->setAvatar($request->avatar);      
            $newdata->user()->touch();    

            return $this->respondSuccess('Profile Account Updated!');
        }
    }
}
