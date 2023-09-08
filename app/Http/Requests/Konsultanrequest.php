<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Konsultanrequest extends FormRequest
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
            "nama_konsultan" => 'required',
            "no_hp" => 'required|numeric',
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $this->route('ppk') ?? 0
            ],
        ];
    }
}
