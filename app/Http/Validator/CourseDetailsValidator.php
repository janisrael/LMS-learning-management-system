<?php

namespace App\Http\Validator;

class CourseDetailsValidator{
    const CREATE  = [
        'course_id' => 'required',
        'subscription_id' => 'required',
        'created_by' => 'required'
    ];

    static function rules($subsciption_id) {
        return [
          'course_id' => 'required|unique:courde_details,coure_id,NULL,NULL,subscription_id,'.$subsciption_id,
          'subscription_id' => 'required',
          'created_by' => 'required'
        ];
    }

    static function getMessages() {
        return [
          'course_id.required' => 'Course ID is required',
          'course_id.unique' => 'Error, duplicate course id with subscription id',
          'subscription_id.required' => 'Subsctiption is required',
          'created_by.required' => 'required'
        ];
    }
}