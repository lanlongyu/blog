<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function posts()
    {
        return $this->hasMany(\App\Post::class, 'user_id', 'id');
    }

    public function fans()
    {
        return $this->hasMany(\App\Fan::class, 'star_id', 'id');
    }

    public function stars()
    {
        return $this->hasMany(\App\Fan::class, 'fan_id', 'id');
    }

    public function doFan($uid)
    {
        $fan = new Fan();
        $fan->star_id = $uid;
        return $this->stars()->save($fan);
    }

    public function doUnFan($uid)
    {
        $fan = new Fan();
        $fan->star_id = $uid;
        return $this->stars()->delete($fan);
    }

    public function hasFan($uid)
    {
        return $this->fans()->where('fan_id', $uid)->count();
    }

    public function hasStar($uid)
    {
        return $this->stars()->where('star_id', $uid)->count();
    }

    public function notices()
    {
        return $this->belongsToMany(Notice::class, 'user_notices', 'user_id', 'notice_id')->withPivot([
                'user_id', 'notice_id'
            ]
        );
    }

    public function addNotice($notice)
    {
        return $this->notices()->save($notice);
    }


}
