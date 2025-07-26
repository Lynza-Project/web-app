<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\LostAndFoundRequest;
use Tests\TestCase;

class LostAndFoundRequestTest extends TestCase
{
    /**
     * Test that the rules method returns the expected validation rules.
     */
    public function test_rules_method_returns_expected_validation_rules()
    {
        // Arrange
        $request = new LostAndFoundRequest();

        // Act
        $rules = $request->rules();

        // Assert
        $this->assertEquals([
            'organization_id' => ['required', 'exists:organizations'],
            'title' => ['required'],
            'description' => ['required'],
            'lost_and_found_category_id' => ['required', 'exists:lost_and_found_categories'],
            'date_lost' => ['required', 'date'],
            'location' => ['required'],
            'status' => ['required'],
        ], $rules);
    }

    /**
     * Test that the authorize method returns true.
     */
    public function test_authorize_method_returns_true()
    {
        // Arrange
        $request = new LostAndFoundRequest();

        // Act
        $authorize = $request->authorize();

        // Assert
        $this->assertTrue($authorize);
    }
}
