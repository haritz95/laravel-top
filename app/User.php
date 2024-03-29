<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function sites()
    {
        return $this->hasMany(Sites::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function role(){
        return $this->belongsTo(Roles::class);
    }

    public function admin(){
        return $this->role()->where('name', 'Admin')->exists();
    }
    
    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function banned(){
        return $this->status()->where('name', 'Banned')->exists();
    }
}
