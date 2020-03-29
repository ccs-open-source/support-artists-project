<?php

namespace Tests\Feature;

use App\Models\Stream;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StreamWorkflowTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
     public function can_accesse_stream_detail_page()
     {
        $stream = create(Stream::class);

        $response = $this->get('/stream/' . $stream->slug);

        $response->assertOk();
        $response->assertViewIs('pages.stream.index');
        $response->assertViewHas('stream');
        $response->assertViewHas('stream', $stream);
        $response->assertSeeText($stream->title);
        $response->assertSee($stream->cover);
        $response->assertSee($stream->artist->name);
        // $response->assertSee($stream->donation->total);
     }

    /**
    * @test
    */
    public function can_create_stream()
    {
        $artist = $this->logIn();
        $stream = make(Stream::class, ['artist_id' => $artist->id, 'published_at' => '2020-01-01 00:00:00']);

        $response = $this->post('/profile/stream', $stream->toArray())
            ->assertRedirect('/profile/stream');

        $response->assertSessionHas('message');
        $this->assertDatabaseHas('streams', [
            'artist_id' => 1,
            'slug' => $stream->slug,
            'provider_id' => $stream->provider_id,
            'provider' => $stream->provider,
            'title' => $stream->title,
            'isLive' => $stream->isLive,
            'tags' => json_encode($stream->tags),
            'clicks' => 0,
            'published_at' => $stream->published_at,
            'description' => $stream->description
        ]);
    }

    /**
    * @test
    */
    public function can_access_create_form()
    {
        $this->withoutExceptionHandling();
        $artist = $this->logIn();

        $response = $this->get('/profile/stream/create');

        $response->assertOk();
        $response->assertViewIs('pages.profiles.stream-create');
        $response->assertViewHas('record');
        $response->assertSeeText(trans('profile.stream-title'));
        $response->assertSeeText(trans('profile.stream-provider'));
        $response->assertSeeText(trans('profile.stream-provider-id'));
        $response->assertSeeText(trans('profile.stream-tags'));
        $response->assertSeeText(trans('profile.stream-is-live'));
        $response->assertSeeText(trans('profile.stream-tags'));
    }

    /**
    * @test
    */
    public function some_fields_are_required()
    {
        $artist = $this->logIn();

        $response = $this->post('/profile/stream', [])
            ->assertRedirect('/profile/stream/create');

        $response->assertSessionHasErrors(['title', 'provider', 'provider_id']);
        $this->assertEquals(0, Stream::all()->count());
    }

    /**
    * @test
    */
    public function can_list_my_own_stream_on_my_profile_page()
    {
         $this->withoutExceptionHandling();
         $artist = $this->logIn();
         create(Stream::class, ['artist_id' => $artist->id], 10);

         $response = $this->get('/profile/stream');

         $response->assertOk();
         $response->assertViewIs('pages.profiles.stream');
         $response->assertViewHas('record');
         $response->assertViewHas('streams');
         $response->assertSee('/profile/stream/edit/');
         $response->assertSee('/profile/stream/delete/');
    }
}
