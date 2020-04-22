<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signedurl extends Model
{
    protected $table = 'signed_url';
    protected $fillable = [
        'files_id','temp_url','hash_key','expiry_time','isEnable'
    ];

    public function Files()
    {
        return $this->belongsTo('App\File','files_id');
    }

}
