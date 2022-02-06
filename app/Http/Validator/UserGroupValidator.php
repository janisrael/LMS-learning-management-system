<?php


namespace App\Http\Validator;


use App\Models\UserGroup;

class UserGroupValidator
{
    const CREATE = [
        'name' => 'required',
        'description' => 'required',
        'is_active' => 'required'

    ];
    static function store_rules()
    {
        return [
            'name' => 'required|unique:user_groups,name',
            'description'  => 'required'
        ];
    }
    static function update_rules($id, $name)
    {
        $check_name_duplicate = UserGroup::where('name','=',$name)->where('id','!=',$id)->exists();

        if($check_name_duplicate) {
            return [
                'name' => 'required|unique:user_groups,name',
            ];
        }
        return [
            'name' => 'required',
            'description'  => 'required'
        ];
    }
    static function getMessages(){
        return [
            'name.required' => 'Name required',
            'name.unique' => 'Name already exist',
            'description.required' => 'Description required',
            'is_active.required' => 'is_active required',
        ];

    }
}
