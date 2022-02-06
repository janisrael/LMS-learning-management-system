<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user and $this->user->hasRole('SuperAdmin')) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->request->set('is_active', ($this->request->has('is_active') ? 1 : 0));

        if (Route::currentRouteName() == 'user.store') {
            $this->request->set('email_verified_at', now());
            $this->request->set('created_by', Auth::id());
            $this->request->set('password', $this->request->has('password'));
        }

        $rules = [
            // 'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed|min:6',
            'email' => 'required|email|unique:users,email',
        ];

        if (Route::currentRouteName() == 'user.update') {
            $rules['email'] .= ','.$this->user->id;
            $rules['username'] .= ','.$this->user->id;

            if (empty($this->password)) {
                $rules['password'] = '';
            }
        }

        return $rules;
    }
}
