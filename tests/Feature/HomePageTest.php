<?php

namespace Tests\Feature;

use App\Models\Stream;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomePageTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function i_can_access_to_homepage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(config('app.name'));
        $response->assertSee(config('app.description'));
        $response->assertSee('/register/facebook');
        $response->assertSee('/register/twitter');
    }

    /**
     * @test
     */
    public function can_list_stream()
    {
        $this->withoutExceptionHandling();

        $stream = create(Stream::class);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee($stream->title);
        if ($stream->isLive) {
            $response->assertSee(trans('stream.is-live'));
        } else {
            $response->assertDontSee(trans('stream.is-live'));
        }
        foreach ($stream->tags as $tag) {
            $response->assertSee($tag);
        }
        $response->assertSee(trans('stream.clicked', ['click' => $stream->clicks]));
        $this->assertNotEmpty($stream->postTimeAgo, "Unable to post time a ago");
        $response->assertSee($stream->postTimeAgo);
        $this->assertNotEmpty($stream->artist->name, "Unable to get Artist Name");
        $response->assertSee($stream->artist->name);
        $response->assertSee($stream->artist->isValid ? 'badge-valid' : '');
        $response->assertSee('/stream/' . $stream->slug);

    }
}
