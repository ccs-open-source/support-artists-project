<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Artist;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_access_profile_page()
    {   
        $artist = $this->logIn();

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertViewHas('artist');
        $response->assertSee($artist->realName);
    }

    /** @test */
    public function if_account_isnt_verified_we_can_see_alert_on_profile()
    {
        $artist = $this->logIn(create(Artist::class, ['isVerified' => 0]));

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertSee(trans('profile.unverified-account-can-be-verified'));
    }

    /** @test */
    public function it_show_gravatar_by_email()
    {
        $this->withoutExceptionHandling();
        
        $artist = $this->logIn(create(Artist::class, ['avatar' => null]));

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertSee("https://www.gravatar.com/avatar/" . md5(strtolower(trim($artist->email))));
    }
}
