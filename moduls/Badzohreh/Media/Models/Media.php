<?php

namespace Badzohreh\Media\Models;

use Badzohreh\Media\Services\MediaService;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $casts=[
        'files'=>"json"
    ];

    public function getThumbAttribute()
    {
        return "/storage/".$this->files[300];
    }

protected static function booted()
{
    static::deleting(function ($media){
        MediaService::delete($media);

    });
}

}
