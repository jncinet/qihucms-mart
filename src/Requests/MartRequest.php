<?php

namespace Qihucms\Mart\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MartRequest extends FormRequest
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
        return [
            'name' => ['required', 'max:255'],
            'logo' => ['max:255'],
            'banner' => ['max:255'],
            'return_name' => ['max:255'],
            'return_phone' => ['max:255'],
            'return_address' => ['max:255'],
            'status' => ['filled', 'integer']
        ];
    }

    public function attributes()
    {
        return trans('mart::mart');
    }
}