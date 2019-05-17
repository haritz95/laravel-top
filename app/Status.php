<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = "status";

    protected $fillable = [
        'name',
    ];

    public function sites()
    {
        return $this->hasMany(Sites::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
