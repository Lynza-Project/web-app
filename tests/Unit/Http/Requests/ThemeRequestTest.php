<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\ThemeRequest;
use Tests\TestCase;

class ThemeRequestTest extends TestCase
{
    /**
     * Test that the rules method returns the expected validation rules.
     */
    public function test_rules_method_returns_expected_validation_rules()
    {
        // Arrange
        $request = new ThemeRequest();

        // Act
        $rules = $request->rules();

        // Assert
        $this->assertEquals([
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
        ], $rules);
    }

    /**
     * Test that the authorize method returns true.
     */
    public function test_authorize_method_returns_true()
    {
        // Arrange
        $request = new ThemeRequest();

        // Act
        $authorize = $request->authorize();

        // Assert
        $this->assertTrue($authorize);
    }
}
