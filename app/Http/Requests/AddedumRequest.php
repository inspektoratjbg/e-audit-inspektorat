<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddedumRequest extends FormRequest
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
            "no_sk_addedum" => "required",
            "tanggal_sk_addedum" => "required",
            "nilai_kontrak_addedum" => "required",
            "tanggal_mulai_addedum" => "required",
            "tanggal_selesai_addedum" => "required"
        ];
    }
}
