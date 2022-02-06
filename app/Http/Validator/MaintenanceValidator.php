<?php


namespace App\Http\Validator;


class MaintenanceValidator
{
    const CREATE = [
        'ticket_no' => 'required',
        'schedule_start' => 'required',
        'schedule_end' => 'required',
        'message' => 'required',
        'notification_message' => 'required',
        'notification_display_datetime' => 'required',
        'added_by' => 'required',
        'updated_by' => 'required',
    ];
    static function store_rules()
    {
        return [
            'ticket_no' => 'required',
            'schedule_start' => 'required',
            'schedule_end' => 'required',
            'message' => 'required',
            'notification_message' => 'required',
            'notification_display_datetime' => 'required',
            'added_by' => 'required',
            'updated_by' => 'required',
        ];
    }
    static function rules($id)
    {
        return [
            'name' => 'required|unique:roles,name,'.$id,
            'guard_name' => 'required'
        ];
    }
    static function getMessages(){
        return [
            'ticket_no.required' => 'Ticket No is required',
            'schedule_start' => 'Start Schedule is required',
            'schedule_end' => 'End Schedule is required',
            'message' => 'Message is required',
            'notification_message' => 'notification message is required',
            'notification_display_datetime' => 'notification display time is required',
            'added_by' => 'added by is required',
            'updated_by' => 'updated by is required'
        ];

    }
}
