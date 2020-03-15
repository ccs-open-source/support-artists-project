<?php

namespace App\Models;

use DateTime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
    ];

    public function getPostTimeAgoAttribute()
    {
        return $this->timeElapsedString($this->created_at);
    }

    /**
     * Get Slug from Title
     */
    public function getSlugAttribute()
    {
        return \Str::slug($this->title, '-');
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id', 'id');
    }

    /**
     * @param $datetime
     * @param bool $full
     * @return string
     * @throws \Exception
     */
    protected function timeElapsedString($datetime, $full = false) {
        $now = Carbon::now();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => trans('date.year'),
            'm' => trans('date.month'),
            'w' => trans('date.week'),
            'd' => trans('date.day'), //'day',
            'h' => trans('date.hour'), // 'hour',
            'i' => trans('date.minute'),
            's' => trans('date.second'),
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' '.trans('date.ago') : trans('date.just-now');
    }
}
