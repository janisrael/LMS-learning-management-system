<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class MaintenanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //        $schedule = explode(' - ', $this->schedule);
        $schedule_start = Carbon::parse($this->schedule[0])->toDateTimeString();
        $schedule_end = Carbon::parse($this->schedule[1])->toDateTimeString();
        $this->request->set('schedule_start', $schedule_start);
        $this->request->set('schedule_end', $schedule_end);
        $this->request->set('is_active', ($this->request->has('is_active') ? 1 : 0));
        $this->request->set('auto_up_on_schedule_end', ($this->request->has('auto_up_on_schedule_end') ? 1 : 0));

        if (\Route::currentRouteName() == 'maintenance.store') {
            $this->request->set('ticket_no', date('Yds').mt_rand(10, 99));
            $this->request->set('added_by', \Auth::id());
        }
        $rules = [
            'schedule' => 'required',
            'notification_message' => 'required',
            'notification_display_datetime' => 'required',
            'message' => 'required',
        ];

        $this->request->set('updated_by', \Auth::id());
        return $rules;
    }
}
