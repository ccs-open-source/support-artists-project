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

        $response = $this->followingRedirects()
            ->post('/login', [
                'email' => 'jonathan.alexey16@gmail.com',
                'password' => '12345678'
            ]);

        $this->assertAuthenticatedAs($artist, 'web-artists');
        $response->assertSee(trans('profile.welcome-log-in-message', ['name' => $artist->name]));
    }

    /** @test */
    public function as_authenticated_i_can_see_my_name_on_top()
    {
        $artist = create(Artist::class);
        $this->actingAs($artist, 'web-artists');

        $response = $this->get('/');

        $response->assertSee($artist->realName);
        $response->assertSee(route('profile.index'));
    }

    /** @test */
    public function i_can_loggout()
    {
        $this->withoutExceptionHandling();
        $artist = create(Artist::class);
        $this->actingAs($artist, 'web-artists');

        $response = $this->followingRedirects()->post('/logout');

        $response->assertLocation('/');
        $response->assertDontSee($artist->realName);
        $response->assertDontSee(route('profile.index'));

    }

}
