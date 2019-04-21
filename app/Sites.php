<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Sites;

class Sites extends Model
{
    //

    protected $fillable = [
        'title', 'description', 'category', 'url', 'url_file'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
