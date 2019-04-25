<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ad;

class Spots extends Model
{

	protected $table = "table_ad_spots";

    protected $fillable = [
        'id', 'name'
    ];

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}
