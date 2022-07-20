<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;

class MainControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->get('/');

        $response->assertJson(['hello' => "MacPaw Internship 2022!"]);
    }
}
