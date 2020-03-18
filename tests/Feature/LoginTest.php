<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Artist;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_authenticate()
    {
        $this->withoutExceptionHandling();
        

        $artist = create(Artist::class, [
            'email' => 'jonathan.alexey16@gmail.com', 
            'password' => \Hash::make('12345678'),
            'isRegistrationComplete' => 1
        ]);

        $response = $this->post('/login', ['email' => 'jonathan.alexey16@gmail.com', 'password' => '12345678']);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($artist, 'web-artists');
    }

    /** @test */
    public function as_authenticated_i_can_see_my_name_on_top()
    {
        $artist = create(Artist::class);
        $this->actingAs($artist, 'web-artists');

        $response = $this->get('/');

        $response->assertSee($artist->realName);
    }
}
