<?php

namespace Tests\Unit;


use Carbon\Carbon;
use App\Models\Stream;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StreamModelTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_get_artist_name()
    {
        $stream = create(Stream::class);

        $this->assertNotEmpty($stream->artist->name);
    }

    /**
     * @test
     */
    public function can_get_slug_from_name_stream()
    {
        $stream = create(Stream::class, ['title' => 'my vision of world']);

        $this->assertNotEmpty($stream->slug);
        $this->assertEquals('my-vision-of-world', $stream->slug);
    }

    /**
     * @dataProvider dataProviderPostTimeAgo
     * @test
     * @param $hour
     * @param $interval
     * @param $text
     */
    public function calculate_time_ago($hour, $interval, $text)
    {
        $knownDate = Carbon::create(2020, 3, 1, 2);
        Carbon::setTestNow($knownDate);

        $stream = make(Stream::class);
        $stream->created_at = Carbon::now()->sub($hour, $interval);

        $this->assertEquals($text, $stream->postTimeAgo);
    }

    public function dataProviderPostTimeAgo()
    {
        return [
            'just-now' => [
                0, 'hour', 'agora mesmo'
            ],
            '1 day' => [
                1, 'days', "1 dia atrás"
            ],
            '1 hour' => [
                1, 'hour', "1 hora atrás"
            ],
            '1 week' => [
                1, 'week', '1 semana atrás'
            ]
        ];
    }
}
