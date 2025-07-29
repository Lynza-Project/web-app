<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\TicketMessageRequest;
use Tests\TestCase;

class TicketMessageRequestTest extends TestCase
{
    /**
     * Test that the rules method returns the expected validation rules.
     */
    public function test_rules_method_returns_expected_validation_rules()
    {
        // Arrange
        $request = new TicketMessageRequest();

        // Act
        $rules = $request->rules();

        // Assert
        $this->assertEquals([
            'ticket_id' => ['required', 'exists:tickets'],
            'user_id' => ['required', 'exists:users'],
            'organization_id' => ['required', 'exists:organizations'],
            'content' => ['required'],
        ], $rules);
    }

    /**
     * Test that the authorize method returns true.
     */
    public function test_authorize_method_returns_true()
    {
        // Arrange
        $request = new TicketMessageRequest();

        // Act
        $authorize = $request->authorize();

        // Assert
        $this->assertTrue($authorize);
    }
}
