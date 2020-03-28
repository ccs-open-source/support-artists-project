<?php

namespace Tests\Feature;

use App\Models\Stream;
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
         $this->withoutExceptionHandling();
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
}
