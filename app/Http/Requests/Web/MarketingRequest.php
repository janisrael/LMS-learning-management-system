<?php

namespace App\Http\Requests\Web;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MarketingRequest extends FormRequest
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
        $this->request->set('name', $this->name);
        $this->request->set('description', $this->description);
        $this->request->set('service_name', $this->service_name);
        $this->request->set('folder_name', $this->folder_name);
        $this->request->set('created_by', Auth::id());

        $rules = [
            'name' => 'required',
            'description' => 'required',
            'service_name' => 'required',
            'folder_name' => 'required',
        ];


        $this->request->set('updated_by', Auth::id());
        return $rules;
    }
}
