<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'type' => ['required'],
            'logo' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
