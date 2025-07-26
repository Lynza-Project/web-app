<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\ActualityRequest;
use Tests\TestCase;

class ActualityRequestTest extends TestCase
{
    /**
     * Test that the rules method returns the expected validation rules.
     */
    public function test_rules_method_returns_expected_validation_rules()
    {
        // Arrange
        $request = new ActualityRequest();

        // Act
        $rules = $request->rules();

        // Assert
        $this->assertEquals([
            'organization_id' => ['required', 'exists:organizations'],
            'user_id' => ['required', 'exists:users'],
            'title' => ['required'],
            'content' => ['required'],
        ], $rules);
    }

    /**
     * Test that the authorize method returns true.
     */
    public function test_authorize_method_returns_true()
    {
        // Arrange
        $request = new ActualityRequest();

        // Act
        $authorize = $request->authorize();

        // Assert
        $this->assertTrue($authorize);
    }
}
