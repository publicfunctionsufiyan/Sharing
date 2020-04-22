<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'shared_files';
    protected $fillable = [
        'privatable_type', 'privatable_id', 'path'
    ];

    public function privatable()
    {
        return $this->morphTo();
    }

    public function Signedurls()
    {
        return $this->hasMany('App\Signedurl', 'files_id');
    }
}
