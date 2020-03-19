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
        $response->assertViewHas('record');
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

    /** @test */
    public function it_show_form_to_edit_account()
    {
        $this->withoutExceptionHandling();
        
        $artist = $this->logIn();

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertSee(route('profile.update'));
    }

    /** @test */
    public function i_can_updated_my_personal_information_from_profile()
    {   
        $this->withoutExceptionHandling();
        
        $artist = $this->logIn();
        $update = $artist->toArray();
        $update['name'] = 'Jonathan Fontes';
        unset($update['password']);

        $response = $this->post('/profile/update', $update);

        $response->assertRedirect('/profile');
        $this->assertDatabaseHas('artists', [
            'id' => 1,
            'name' => 'Jonathan Fontes'
        ]);
    }

    /** @test */
    public function i_cannot_change_my_email_from_form()
    {
        $this->withoutExceptionHandling();
        
        $artist = $this->logIn();
        $update = $artist->toArray();
        $update['email'] = 'jonathan.alexey16@gmail.com';
        unset($update['password']);

        $response = $this->post('/profile/update', $update);

        $response->assertRedirect('/profile');
        $this->assertDatabaseHas('artists', [
            'id' => 1,
            'email' => $artist->email
        ]);
        $this->assertDatabaseMissing('artists', [
            'email' => 'jonathan.alexey16@gmail.com'
        ]);
    }

    /** @test */
    public function some_fields_is_required_in_order_to_update_profile()
    {
          
        $artist = $this->logIn();

        $response = $this->post('/profile/update', []);

        $response->assertSessionHasErrors([
            'name', 'realName'
        ]);
    }
}
