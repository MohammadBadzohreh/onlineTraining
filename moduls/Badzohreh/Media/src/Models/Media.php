<?php

namespace Badzohreh\Media\Models;

use Badzohreh\Media\Services\MediaService;
use Badzohreh\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $casts = [
        'files' => "json"
    ];

    public function getThumbAttribute()
    {
        return MediaService::thumb($this);
    }


    public function user()
    {
        return $this->hasOne(User::class, "user_id", "id");

    }

    protected static function booted()
    {
        static::deleting(function ($media) {
            MediaService::delete($media);
        });
    }

}
