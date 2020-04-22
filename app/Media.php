<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    protected $appends = ['url'];
    protected $table = 'media';


    //
    public function getUrlAttribute()
    {
        return $this->getFullUrl();
    }

}
