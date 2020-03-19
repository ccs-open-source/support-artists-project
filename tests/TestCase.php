<?php

namespace Tests;

use App\Models\Artist;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function logIn(Artist $artist = null)
    {
        if ($artist == null) {
            $artist = create(Artist::class);
        }

        $this->actingAs($artist, 'web-artists');

        return $artist;
    }
}
