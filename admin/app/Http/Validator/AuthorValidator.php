<?php

namespace App\Http\Validator;

class AuthorValidator
{
const CREATE  = [
        // 'course_id' => 'required',
        // 'name' => 'required',
        // 'sort_order' => 'required',
        // 'course_percentage' => 'required',
        // 'created_by' => 'required'
    ];

    static function rules($id){
        return [
            // 'course_id' => 'required',
            // 'name' => 'required',
            // 'sort_order' => 'required',
            // 'course_percentage' => 'required',
            // 'created_by' => 'required'
        ];
    }

    static function getMessages()
    {
        return [
            // 'course_id.required' => 'Course ID is required',
            // 'name.required' => 'Course Name is required',
            // 'sort_order.required' => 'Sort Order is required',
            // 'course_percentage.required' => 'required',
            // 'created_by.required' => 'required'
        ];
    }
  }