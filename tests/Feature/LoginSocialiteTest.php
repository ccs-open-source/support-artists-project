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
            ->andReturn($artist->realName)
            ->shouldReceive('getEmail')
            ->andReturn($artist->email)
            ->shouldReceive('getAvatar')
            ->andReturn($artist->avatar);
        Socialite::shouldReceive('driver->user')->andReturn($abstractUser);

        $response = $this->get('/register/facebook/callback')
            ->assertRedirect('/registration');

        $saved = Artist::first();
        $response->assertSessionHas('artist');
        $this->assertEquals(1, Artist::all()->count());
        $this->assertNotEmpty($saved->realName);
        $this->assertNotEmpty($saved->email);
        $this->assertNotEmpty($saved->avatar);
        $this->assertNotEmpty($saved->facebookId);
        $this->assertEmpty($saved->isActive);
        $this->assertEquals($artist->realName, $saved->realName);
        $this->assertEquals($artist->email, $saved->email);
        $this->assertEquals($artist->avatar, $saved->avatar);
        $this->assertEquals($artist->facebookId, $saved->facebookId);
        $this->assertEquals(0, $saved->isActive);
    }

    /**
     * @test
     */
    public function can_only_access_registration_if_not_active()
    {
        $this->withoutExceptionHandling();

        $artist = create(Artist::class, ['isRegistrationComplete' => 1]);

        $response = $this->withSession(['artist' => $artist])->get('/registration');

        $response->assertRedirect('/');
        $response->assertSessionHas('errors');
    }

    /**
     * @test
     */
    public function not_show_registration_if_user_is_already_active_when_logged_in_by_provider()
    {
        $this->withoutExceptionHandling();

        $artist = create(Artist::class, ['isRegistrationComplete' => 1]);
        $this->withoutExceptionHandling();

        $abstractUser = Mockery::mock(FacebookProvider::class);
        $abstractUser
            ->shouldReceive('getId')
            ->andReturn($artist->facebookId)
            ->shouldReceive('getName')
            ->andReturn($artist->realName)
            ->shouldReceive('getEmail')
            ->andReturn($artist->email)
            ->shouldReceive('getAvatar')
            ->andReturn($artist->avatar);
        Socialite::shouldReceive('driver->user')->andReturn($abstractUser);

        $this->get('/register/facebook/callback')
            ->assertRedirect('/');
    }

    /**
     * @test
     */
    public function uncomplete_registration_can_complete_registration()
    {
        $this->withoutExceptionHandling();

        $artist = create(Artist::class, ['isRegistrationComplete' => 0]);

        $response = $this->withSession(['artist' => $artist])->post('/registration', [
            'name' => 'Jonathan Fontes',
            'realName' => 'Jonathan Fontes',
            'email' => 'me@jonathan.pt',
            'address' => 'Rua Jacinto',
            'city' => 'Espinho',
            'postalCode' => '4500-001',
            'vat' => '243091834',
            'countryCode' => 'PT',
            'iban' => 'PT500007000010000100001',
            'activityProof' => 'https://www.facebook.com/activity-proof',
            'wantDonation' => 1
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('artists', [
            'realName' => 'Jonathan Fontes',
            'isRegistrationComplete' => 1,
            'address' => 'Rua Jacinto',
            'city' => 'Espinho',
            'postalCode' => '4500-001',
            'vat' => '243091834',
            'iban' => 'PT500007000010000100001',
            'activityProof' => 'https://www.facebook.com/activity-proof',
            'wantDonation' => 1
        ]);
    }
}
