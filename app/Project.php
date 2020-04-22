<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Project extends Model implements HasMedia
{
    use HasMediaTrait;

    public $with = ['media'];

    protected $fillable = [
        'user_id', 'name', 'URL','description'
    ];


    public function Files()
    {
        return $this->morphMany('App\File','privatable');
    }

}
