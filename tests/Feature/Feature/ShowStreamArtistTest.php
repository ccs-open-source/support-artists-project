<?php

namespace Tests\Feature\Feature;

use App\Models\Artist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShowStreamArtistTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Can access Artist Page
     *
     * @test
     * @return void
     */
    public function can_go_to_artist_page()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/artist/red-hot-chili-peppers');

        $response->assertStatus(200);
        $response->assertViewHas('artist');
        $response->assertSee('Red Hot Chili Peppers');
    }

    /**
     * @test
     */
    public function can_get_list_of_artists()
    {
        $this->withoutExceptionHandling();
        $artists = create(Artist::class, [], 2);

        $response = $this->get('/artists');

        $response->assertStatus(200);
        $response->assertViewHas('artists');

        foreach ($artists as $artist) {
            $response->assertSee($artist->name);
        }
    }
}
