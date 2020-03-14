<?php

namespace Tests\Feature;

use Mockery;
use App\Models\Artist;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\FacebookProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginSocialiteTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_authenticate_from_facebook_drive()
    {
        $this->withoutExceptionHandling();
        $providerMock = \Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $providerMock->shouldReceive('redirect')->andReturn(new RedirectResponse('/teste'));
        Socialite::shouldReceive('driver')->with('facebook')->andReturn($providerMock);

        $response = $this->get('/register/facebook');

        $response->assertRedirect('/teste');
    }

    /**
     * @test
     */
    public function can_authenticate_user_by_socialite_provider()
    {
        $artist = make(Artist::class);
        $this->withoutExceptionHandling();
        $abstractUser = Mockery::mock(FacebookProvider::class);
        $abstractUser
            ->shouldReceive('getId')
            ->andReturn($artist->facebookId)
            ->shouldReceive('getName')
            ->andReturn($artist->name)
            ->shouldReceive('getEmail')
            ->andReturn($artist->email)
            ->shouldReceive('getAvatar')
            ->andReturn($artist->avatar);
        Socialite::shouldReceive('driver->user')->andReturn($abstractUser);

        $response = $this->get('/register/facebook/callback')
            ->assertRedirect('/complete-registration');

        $saved = Artist::first();
        $response->assertSessionHas('artist');
        $this->assertEquals(1, Artist::all()->count());
        $this->assertNotEmpty($saved->name);
        $this->assertNotEmpty($saved->email);
        $this->assertNotEmpty($saved->avatar);
        $this->assertNotEmpty($saved->facebookId);
        $this->assertEmpty($saved->isActive);
        $this->assertEquals($artist->name, $saved->name);
        $this->assertEquals($artist->email, $saved->email);
        $this->assertEquals($artist->avatar, $saved->avatar);
        $this->assertEquals($artist->facebookId, $saved->facebookId);
        $this->assertEquals(0, $saved->isActive);
    }

    /**
     * @test
     */
    public function can_only_access_complete_registration_if_has_artist_session()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/complete-registration');

        $response->assertRedirect('/');
        $response->assertSessionHas('errors');
    }

    /**
     * @test
     */
    public function can_only_access_complete_registration_if_not_active()
    {
        $this->withoutExceptionHandling();

        $artist = create(Artist::class, ['isActive' => 1]);

        $response = $this->withSession(['artist' => $artist])->get('/complete-registration');

        $response->assertRedirect('/');
        $response->assertSessionHas('errors');
    }

    /**
     * @test
     */
    public function not_show_complete_registration_if_user_is_already_active_when_logged_in_by_provider()
    {
        $this->withoutExceptionHandling();

        $artist = create(Artist::class, ['isActive' => 1]);
        $this->withoutExceptionHandling();

        $abstractUser = Mockery::mock(FacebookProvider::class);
        $abstractUser
            ->shouldReceive('getId')
            ->andReturn($artist->facebookId)
            ->shouldReceive('getName')
            ->andReturn($artist->name)
            ->shouldReceive('getEmail')
            ->andReturn($artist->email)
            ->shouldReceive('getAvatar')
            ->andReturn($artist->avatar);
        Socialite::shouldReceive('driver->user')->andReturn($abstractUser);

        $response = $this->get('/register/facebook/callback')
            ->assertRedirect('/');

    }
}
