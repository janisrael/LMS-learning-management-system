<?php

namespace App\Http\Validator;

class CourseValidator{
    const CREATE  = [
        'course_number' => 'required',
        'name' => 'required|unique:courses,name',
        'sort_order' => 'required',
        'is_global' => 'required',
        'is_featured' => 'required',
        'is_active' => 'required',
        'created_by' => 'required'
    ];

    static function rules($id) {
        return [
            'course_number' => 'required',
            'name' => 'required|unique:courses,name',
            'sort_order' => 'required',
            'is_global' => 'required',
            'is_featured' => 'required',
            'is_active' => 'required',
            'created_by' => 'required'
        ];
    }

    static function getMessages() {
        return [
            'course_number.required' => 'Course ID is required',
            'name.required' => 'Course Name is required',
            'name.unique' => 'Course Name Already Taken',
            'sort_order.required' => 'Sort Order is required',
            'is_global.required' => 'If Global is required',
            'is_featured.required' => 'if Featured is required',
            'is_active.required' => 'If Active is required',
            'created_by.required' => 'required'
        ];
    }
}