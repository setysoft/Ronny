<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'branch' => 'required|min:2',
            'series' => 'required|min:2',
            'model' => 'required|min:2',
            'case_size' => 'required|integer',
            'bracelet_material' => 'required|min:2',
            'dial_color' => 'required|array',
            'status' => 'required|integer',
        ];
    }
}
