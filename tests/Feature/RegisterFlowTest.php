<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterFlowTest extends TestCase
{
    /**
     * @test
     */
    public function can_access_register_form()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee("email");
        $response->assertSee("password");
        $response->assertSee(route('home.login'));
        $response->assertSee("/register/facebook");
        $response->assertSee("/register/twitter");
        $response->assertSee('/registration');
    }

    /**
     * @test
     */
    public function i_can_access_registration_form()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/registration');

        $response->assertStatus(200);

        $response->assertSee("email");
    }
}
