<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class Ppkrequest extends FormRequest
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
            "nama" => 'required',
            "kode_unit" => 'required',
            "no_sk" => 'required',
            "tanggal_sk" => 'required',
            "no_hp" => 'required|numeric',
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $this->route('ppk') ?? 0
            ],
        ];

        if ($this->getMethod() == 'POST') {
            $rules += [
                'password' => 'required',
                'password_konfirmasi' => 'required|same:password',
            ];
        }

        return $rules;
    }
}
