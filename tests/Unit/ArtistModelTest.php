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
}
