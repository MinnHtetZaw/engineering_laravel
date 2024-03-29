<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormListRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
             'form_name' => 'required',
             'prefix' => 'required',
             'approve_by' => 'required',
             'check_by' => 'required',
             'prepare_by' => 'required',
        ];
    }
}
