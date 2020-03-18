<?php

namespace Tests\Feature;

use App\Models\Artist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterFlowTest extends TestCase
{
    use DatabaseMigrations;

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

    /**
     * @test
     */
    public function can_create_account_if_not_comming_from_social_registration()
    {
        $this->withoutExceptionHandling();
        $artist = make(Artist::class, [
            'isRegistrationComplete' => 0,
        ]);

        $response = $this->post('/registration', $artist->toArray());

        $response->assertRedirect('/');
        $this->assertDatabaseHas('artists', [
            'realName' => $artist->realName,
            'name' => $artist->name,
            'email' => $artist->email,
            'isRegistrationComplete' => 1,
            'address' => $artist->address,
            'city' => $artist->city,
            'postalCode' => $artist->postalCode,
            'vat' => $artist->vat,
            'iban' => $artist->iban,
            'activityProof' => $artist->activityProof,
            'wantDonation' => $artist->wantDonation
        ]);
    }

    /**
     * @test
     */
    public function some_fields_are_required_in_order_to_register()
    {
        $response = $this->post('/registration', ['city' => 'Espinho']);

        $response->assertSessionHasErrors([
            'name', 'realName', 'email'
        ]);

        $this->assertDatabaseMissing('artists', [
            'city' => 'Espinho',
        ]);
    }

    /**
     * @test
     */
    public function if_artist_want_receive_donation_must_provide_iban_data()
    {
        $artist = make(Artist::class, [
            'isRegistrationComplete' => 0,
            'wantDonation' => 1,
            'iban' => ''
        ]);

        $response = $this->post('/registration', $artist->toArray());

        $this->assertDatabaseMissing('artists', [
            'realName' => $artist->realName,
            'name' => $artist->name,
            'email' => $artist->email,
            'address' => $artist->address,
            'city' => $artist->city,
            'postalCode' => $artist->postalCode,
            'vat' => $artist->vat,
            'activityProof' => $artist->activityProof,
            'wantDonation' => $artist->wantDonation
        ]);
    }

    /** @test */
    public function email_must_be_unique()
    {
        create(Artist::class, [
            'isRegistrationComplete' => 1,
            'email' => 'jonathan.fontes@creativecodesolutions.pt'
        ]);

        $artist = make(Artist::class, [
            'isRegistrationComplete' => 0,
            'name' => 'Jonathan Fontes',
            'email' => 'jonathan.fontes@creativecodesolutions.pt'
        ]);

        $response = $this->post('/registration', $artist->toArray());

        $this->assertDatabaseMissing('artists', [
            'name' => $artist->name,
            'email' => $artist->email
        ]);
    }
}
