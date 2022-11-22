<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kelas' => 'required|unique:grades,kelas,' . $this->id
        ];
    }
}
