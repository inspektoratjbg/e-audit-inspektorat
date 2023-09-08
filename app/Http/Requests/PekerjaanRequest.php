<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PekerjaanRequest extends FormRequest
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
            "tahun_anggaran" => "required|numeric",
            "ppk_id" => "required",
            "nama_kegiatan" => "required",
            "nama_penyedia" => "required",
            "pagu_anggaran" => "required",
            "harga_perkiraan" => "required",
            "konsultan_id" => "required",
            "no_sk" => "required",
            "tanggal_sk" => "required",
            "nilai_kontrak" => "required",
            "tanggal_mulai" => "required",
            "tanggal_selesai" => "required"
        ];
    }
}
