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

class SocialiteTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_access_registration_provider_endpoint()
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
    public function can_see_registration_form_after_been_redirect_from_social_provider()
    {
        $this->withoutExceptionHandling();

        $artist = make(Artist::class,
        [
            'realName' => 'Jonathan Fontes',
            'email' => 'jonathan.alexey16@gmail.com',
            'avatar' => 'test.png'
        ]);
        $this->createProvider(123, $artist->realName, $artist->email, $artist->avatar, $artist->toArray());

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
        $this->createProvider(123, $artist->realName, $artist->email, $artist->avatar, $artist->toArray());

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
        $this->createProvider(123, $artist->realName, $artist->email, $artist->avatar, $artist->toArray());

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
    public function ensure_after_logged_with_provider_have_one_account_only()
    {
        $this->withoutExceptionHandling();

        $artist = create(Artist::class, ['isRegistrationComplete' => 1, 'email' => 'jonathan.alexey16@gmail.com']);
        create(Social::class, ['provider' => 'facebook', 'provider_id' => 123, 'artist_id' => $artist->id, 'data' => $artist->toJson()]);
        $this->createProvider(123, $artist->realName, $artist->email, $artist->avatar, $artist->toArray());

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

    /**
     * @test
     */
     public function if_provider_has_different_email_from_account_artist_need_to_merge_account_in_case_already_logged_in()
     {
         $this->withoutExceptionHandling();

         $artist = create(Artist::class, ['isRegistrationComplete' => 1, 'email' => 'jonathan.alexey16@gmail.com']);
         $this->logIn($artist);
         create(Social::class, ['provider' => 'facebook', 'provider_id' => 123, 'artist_id' => $artist->id, 'data' => $artist->toJson()]);
         $this->createProvider(123, $artist->realName, "geral@geral.com", $artist->avatar, $artist->toArray());

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

    /**
     * @test
     */
     public function can_hit_redirect_provider_with_url_redirect_query_string()
     {
         $providerMock = \Mockery::mock('Laravel\Socialite\Contracts\Provider');
         $providerMock->shouldReceive('redirect')->andReturn(new RedirectResponse('https://outside.com'));
         Socialite::shouldReceive('driver')->with('facebook')->andReturn($providerMock);

         $response = $this->get('/register/facebook?redirectTo=/profiles/social');

         $response->assertRedirect('https://outside.com');
         $response->assertSessionHas('redirectTo');
     }

     /**
      * @test
      */
      public function if_have_redirectto_session_must_be_follow_that()
      {
          $this->withoutExceptionHandling();
          $this->session(['redirectTo' => '/profiles/social']);
          $this->createProvider(123, "teste", "geral@geral.com", "teste", []);

          $this->get('/register/facebook/callback')
              ->assertRedirect('/profiles/social');
      }

      /**
       * @test
       */
       public function can_have_multiple_provider_registed_by_artist()
       {
           $artist = $this->logIn();
           create(Social::class, ['provider' => 'twitter', 'provider_id' => 456, 'artist_id' => $artist->id, 'data' => $artist->toJson()]);
           $this->createProvider(123, $artist->realName, "myotheremail@email.com", $artist->avatar, $artist->toArray());

           $this->get('/register/facebook/callback')
               ->assertRedirect('/');

           $this->assertEquals(1, Artist::all()->count());
           $this->assertEquals(2, Social::all()->count());

           $this->assertDatabaseHas('artists', [
               'id' => 1,
               'email' => $artist->email,
           ]);

           $this->assertDatabaseHas('socials', [
               'provider_id' => 123,
               'provider' => 'facebook',
               'artist_id' => 1
           ]);

           $this->assertDatabaseHas('socials', [
               'provider_id' => 456,
               'provider' => 'twitter',
               'artist_id' => 1
           ]);
       }

    /**
     * @param int $id
     * @param string $realName
     * @param string $email
     * @param string $avatar
     * @param array $rawData
     * @return FacebookProvider|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    protected function createProvider($id, $realName, $email, $avatar, $rawData)
    {
        $abstractUser = Mockery::mock(FacebookProvider::class);
        $abstractUser
            ->shouldReceive('getId')
            ->andReturn($id)
            ->shouldReceive('getName')
            ->andReturn($realName)
            ->shouldReceive('getEmail')
            ->andReturn($email)
            ->shouldReceive('getAvatar')
            ->andReturn($avatar)
            ->shouldReceive('getRaw')
            ->andReturn($rawData);

        Socialite::shouldReceive('driver->user')->andReturn($abstractUser);

        return $abstractUser;
    }
}
