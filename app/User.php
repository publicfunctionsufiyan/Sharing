<?php

namespace App;

use App\Notifications\resetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;





class User extends Authenticatable implements HasMedia
{
    use Notifiable;
    use HasApiTokens, Notifiable;
    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $with = ['media'];
    protected $fillable = [
        'fname','lname', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Files()
    {
        return $this->morphMany('App\File','privatable');
    }


public function sendPasswordResetNotification($token)
{
    $this->notify(new resetPasswordNotification($token));
}

}
