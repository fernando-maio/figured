<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ValidateInputRequestTest extends TestCase
{
    use WithFaker;

    /**
     * Test error message request with a empty value.
     *
     * @return void
     */
    public function testNotEmptyValidationRequest()
    {
        $response = $this->postJson('/', [
            'input_apply' => '',
        ]);
        
        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'A quantity is required',
                'errors' => [
                    'input_apply' => [
                        'A quantity is required'
                    ],
                ],
            ]);
    }

    /**
     * Test error message request with a integer number.
     *
     * @return void
     */
    public function testIntegerValueValidationRequest()
    {
        $response = $this->postJson('/', [
            'input_apply' => $this->faker()->word(),
        ]);
        
        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'A quantity need to be an integer',
                'errors' => [
                    'input_apply' => [
                        'A quantity need to be an integer'
                    ],
                ],
            ]);
    }

    /**
     * Test error message request with a negative number.
     *
     * @return void
     */
    public function testNegativeNumberValidationRequest()
    {
        $negativeNumber = -1 * ($this->faker()->randomDigitNotNull());

        $response = $this->postJson('/', [
            'input_apply' => $negativeNumber,
        ]);
        
        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'A quantity need to be higher than 0',
                'errors' => [
                    'input_apply' => [
                        'A quantity need to be higher than 0'
                    ],
                ],
            ]);
    }

    /**
     * Test error message when the requested quantity is higher than amount in stock.
     *
     * @return void
     */
    public function testRequestMoreThanAvailableInventory()
    {
        $response = $this->post('/', [
            'input_apply' => 1000,
        ]);

        $response->assertStatus(302);
    }
}
