<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'organization_id' => ['required', 'exists:organizations,id'],
            'title' => ['required'],
            'primary' => ['required'],
            'danger' => ['required'],
            'gray' => ['required'],
            'info' => ['required'],
            'success' => ['required'],
            'warning' => ['required'],
            'font' => ['required'],
            'background_color' => ['nullable', 'string'],
            'text_color' => ['nullable', 'string'],
            'button_color' => ['nullable', 'string'],
            'logo_path' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
