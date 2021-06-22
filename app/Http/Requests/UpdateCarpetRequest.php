<?php

namespace App\Http\Requests;

use App\Models\Carpet;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCarpetRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('carpet_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
