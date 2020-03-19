<?php

namespace Tests\Feature\Unit;

use App\Models\Artist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArtistModelTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function can_get_slug_from_name()
    {
        $artist = make(Artist::class);
        $this->assertEquals(\Str::slug($artist->name, '-'), $artist->slug);
    }

    /** @test */
    public function i_can_display_avatar_if_not_was_provider_avatar_attribute()
    {
        $artist = make(Artist::class, ['avatar' => null]);
        $this->assertEquals($artist->avatar, "https://www.gravatar.com/avatar/" . md5(strtolower(trim($artist->email))));
    }

    /** @test */
    public function if_exists_avatar_must_show_that()
    {
        $artist = make(Artist::class);
        $this->assertNotEquals($artist->avatar, "https://www.gravatar.com/avatar/" . md5(strtolower(trim($artist->email))));
    }
}
