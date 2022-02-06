<?php


namespace App\Http\Validator;


use App\Models\User;

class UserValidator
{
    const CREATE = [
        // 'name' => 'required',
        'email' => 'required',
        'email_verified_at' => 'required',
        'username' => 'required',
        'password' => 'required',
        'is_active' => 'required',
        // 'role_id' =>'required'

    ];
    static function store_rules()
    {
        return [
            // 'name' => 'required|unique:users,name',
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'is_active' => 'required',
            // 'role_id' =>'required'
        ];
    }
    static function update_rules($id, $username, $email)
    {
        $check_username_duplicate = User::where('username','=',$username)->where('id','!=',$id)->exists();
        // $check_name_duplicate = User::where('name','=',$name)->where('id','!=',$id)->exists();
        $check_email_duplicate = User::where('email','=',$email)->where('id','!=',$id)->exists();

        if($check_username_duplicate) {
            return [
                'username' => 'unique:users,username',
            ];
        }

        // if($check_name_duplicate) {
        //     return [
        //         'name' => 'unique:users,name',
        //     ];
        // }
        if($check_email_duplicate) {
            return [
                'email' => 'unique:users,email',
            ];
        }
        return [
            // 'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'is_active' => 'required',
            // 'role_id' =>'required'
        ];
    }
    static function getMessages(){
        return [
            // 'name.required' => 'Name required',
            // 'name.unique' => 'Name already exist',
            'email.required' => 'Email required',
            'email.unique' => 'Email already exist',
            'username.required' => 'username required',
            'username.unique' => 'Username already taken',
            'is_active.required' => 'is_active required',
        ];

    }
}
