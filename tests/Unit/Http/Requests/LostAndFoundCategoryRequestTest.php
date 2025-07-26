<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\LostAndFoundCategoryRequest;
use Tests\TestCase;

class LostAndFoundCategoryRequestTest extends TestCase
{
    /**
     * Test that the rules method returns the expected validation rules.
     */
    public function test_rules_method_returns_expected_validation_rules()
    {
        // Arrange
        $request = new LostAndFoundCategoryRequest();

        // Act
        $rules = $request->rules();

        // Assert
        $this->assertEquals([
            'name' => ['required'],
        ], $rules);
    }

    /**
     * Test that the authorize method returns true.
     */
    public function test_authorize_method_returns_true()
    {
        // Arrange
        $request = new LostAndFoundCategoryRequest();

        // Act
        $authorize = $request->authorize();

        // Assert
        $this->assertTrue($authorize);
    }
}
