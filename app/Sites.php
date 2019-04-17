<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Sites;

class Sites extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
