<?php

namespace Tests\Feature;

use App\Models\Social;
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
        $this->withoutExceptionHandling();

        $artist = make(Artist::class,
        [
            'realName' => 'Jonathan Fontes',
            'email' => 'jonathan.alexey16@gmail.com',
            'avatar' => 'test.png'
        ]);
        $abstractUser = Mockery::mock(FacebookProvider::class);
        $abstractUser
            ->shouldReceive('getId')
            ->andReturn(123)
            ->shouldReceive('getName')
            ->andReturn($artist->realName)
            ->shouldReceive('getEmail')
            ->andReturn($artist->email)
            ->shouldReceive('getAvatar')
            ->andReturn($artist->avatar)
            ->shouldReceive('getRaw')
            ->andReturn($artist->toArray());

        Socialite::shouldReceive('driver->user')->andReturn($abstractUser);

        $response = $this->get('/register/facebook/callback')
            ->assertRedirect('/registration');

        $this->assertDatabaseHas('artists', [
            'realName' => 'Jonathan Fontes',
            'email' => 'jonathan.alexey16@gmail.com',
            'avatar' => 'test.png',
            'isRegistrationComplete' => 0
        ]);

        $this->assertDatabaseHas('socials', [
            'artist_id' => 1,
            'provider_id' => 123,
            'provider' => 'facebook',
            'data' => json_encode($artist->toArray())
        ]);
        $response->assertSessionHas('artist');
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
            ->andReturn(123)
            ->shouldReceive('getName')
            ->andReturn($artist->realName)
            ->shouldReceive('getEmail')
            ->andReturn($artist->email)
            ->shouldReceive('getAvatar')
            ->andReturn($artist->avatar)
            ->shouldReceive('getRaw')
            ->andReturn($artist->toArray());

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
            'password' => '12345678',
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

    /** @test */
    public function after_complete_registration_artist_session_key_is_deleted()
    {
        $artist = make(Artist::class);
        $response = $this->withSession(['artist' => $artist])
        ->post('/registration', $artist->toArray());

        $response->assertRedirect("/");
        $this->assertDatabaseHas('artists', ['id' => 1, 'name' => $artist->name]);
        $response->assertSessionMissing('artist');
    }

    /** @test */
    public function in_case_email_already_exists_on_database_we_must_merge_account()
    {
        create(Artist::class, ['isRegistrationComplete' => 1, 'email' => 'jonathan.alexey16@gmail.com']);
        $artist = make(Artist::class, ['email' => 'jonathan.alexey16@gmail.com']);

        $abstractUser = Mockery::mock(FacebookProvider::class);
        $abstractUser
            ->shouldReceive('getId')
            ->andReturn(123)
            ->shouldReceive('getName')
            ->andReturn($artist->realName)
            ->shouldReceive('getEmail')
            ->andReturn($artist->email)
            ->shouldReceive('getAvatar')
            ->andReturn($artist->avatar)
            ->shouldReceive('getRaw')
            ->andReturn($artist->toArray());

        Socialite::shouldReceive('driver->user')->andReturn($abstractUser);

        $this->get('/register/facebook/callback')
            ->assertRedirect('/');

        $this->assertEquals(1, Artist::all()->count());

        $this->assertDatabaseHas('artists', [
            'id' => 1,
            'email' => 'jonathan.alexey16@gmail.com',
        ]);
        $this->assertDatabaseHas('socials', [
            'provider_id' => 123,
            'provider' => 'facebook',
            'artist_id' => 1
        ]);
    }

    /** @test */
    public function if_account_already_exists_and_connect_with_provider_but_logged_again_with_provider_must_show_only_one_account()
    {
        $this->withoutExceptionHandling();

        $artist = create(Artist::class, ['isRegistrationComplete' => 1, 'email' => 'jonathan.alexey16@gmail.com']);
        create(Social::class, ['provider' => 'facebook', 'provider_id' => 123, 'artist_id' => $artist->id, 'data' => $artist->toJson()]);

        $abstractUser = Mockery::mock(FacebookProvider::class);
        $abstractUser
            ->shouldReceive('getId')
            ->andReturn(123)
            ->shouldReceive('getName')
            ->andReturn($artist->realName)
            ->shouldReceive('getEmail')
            ->andReturn($artist->email)
            ->shouldReceive('getAvatar')
            ->andReturn($artist->avatar)
            ->shouldReceive('getRaw')
            ->andReturn($artist->toArray());

        Socialite::shouldReceive('driver->user')->andReturn($abstractUser);

        $this->get('/register/facebook/callback')
            ->assertRedirect('/');

        $this->assertEquals(1, Artist::all()->count());
        $this->assertEquals(1, Social::all()->count());

        $this->assertDatabaseHas('artists', [
            'id' => 1,
            'email' => 'jonathan.alexey16@gmail.com',
        ]);

        $this->assertDatabaseHas('socials', [
            'provider_id' => 123,
            'provider' => 'facebook',
            'artist_id' => 1
        ]);

    }
}
