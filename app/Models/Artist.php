<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Artist extends Authenticatable
{
    public function getSlugAttribute()
    {
        return \Str::slug($this->name, '-');
    }

    public function getAvatarAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($this->email)));
    }
}
