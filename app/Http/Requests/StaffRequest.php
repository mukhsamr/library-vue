<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama' => 'required',
            'nik' => 'required|unique:staff,nik,' . $this->id,
            'unit_id' => 'required|exists:units,id'
        ];
    }
}
