<?php

namespace Tests\Feature;

use Carbon\Carbon;
use App\Models\Stream;
use App\Models\Artist;
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

        $stream = create(Stream::class, [
            'artist_id' => create(Artist::class, [
                'name' => 'Artist Name',
                'realName' => 'Jonathan Fontes',
                'isVerified' => 1
            ])->id,
            'isLive' => 1
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee($stream->title);
        $response->assertSee(trans('stream.is-live'));
        foreach ($stream->tags as $tag) {
            $response->assertSee($tag);
        }
        $response->assertSee(trans('stream.clicked', ['click' => $stream->clicks]));
        $this->assertNotEmpty($stream->postTimeAgo, "Unable to post time a ago");
        $response->assertSee($stream->postTimeAgo);
        $this->assertNotEmpty($stream->artist->name, "Unable to get Artist Name");
        $response->assertSee($stream->artist->name);
        if ($stream->artist->isVerified) {
            $response->assertSee('fas fa-check-circle', 'Artist is Verified but don\'t exists badge on response');
        }
        $response->assertSee('/stream/' . $stream->slug);
    }

    /**
     * @test
     */
    public function if_stream_is_cancel_cannot_be_listed()
    {
        $this->withoutExceptionHandling();

        $stream = create(Stream::class, [
            'cancel_at' => Carbon::now()
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee($stream->title);
    }

    /**
     * @test
     */
    public function stream_is_order_by_creation_data()
    {
        create(Stream::class, ['title' => 'Stream TWO', 'created_at' => Carbon::now()->sub('2 hour')]);
        create(Stream::class, ['title' => 'Stream ONE', 'created_at' => Carbon::now()->sub('1 hour')]);
        create(Stream::class, ['title' => 'Stream THREE', 'created_at' => Carbon::now()->sub('3 hour')]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'Stream ONE',
            'Stream TWO',
            'Stream THREE'
        ]);
    }

    /**
     * @test
     */
    public function deleted_stream_isnt_listed()
    {
        create(Stream::class, ['title' => 'Stream it will deleted', 'created_at' => Carbon::now()->sub('2 hour')])->delete();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Stream it will deleted');
    }
}
