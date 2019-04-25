<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Spots;

class Ad extends Model
{
    protected $table = "ads";

    protected $fillable = [
        'id_spot', 'title', 'website', 'banner'
    ];

    public function spots()
    {
        return $this->belongsTo(Spots::class,'id_spot','id');
    }
}
