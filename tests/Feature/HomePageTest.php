<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * @test
     */
    public function i_can_access_to_homepage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(config('app.name'));
        $response->assertSee(config('app.description'));
        $response->assertSee('/register/facebook');
        $response->assertSee('/register/twitter');
    }
}
