<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PejabatRequest extends FormRequest
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
        $rules = [
            "nama_pejabat" => 'required',
            'email' => [
                'required',
                'email',
                // 'unique:users,email,' . $this->route('ppk') ?? 0
            ],
        ];
        return $rules;
    }
}
