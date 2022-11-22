<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'unit' => 'required|unique:units,unit,' . $this->id
        ];
    }
}
