<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama' => 'required',
            'nis' => 'required|unique:students,nis,' . $this->id,
            'grade_id' => 'required|exists:grades,id'
        ];
    }
}
