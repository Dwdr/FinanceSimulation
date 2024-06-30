<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->json('POST', '/products',
            [
                'name' => 'Sally',
                'description' => 'Sally Desc'
            ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);

        //$this->assertTrue(true);
    }
}