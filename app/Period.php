<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ad;

class Period extends Model
{
	protected $table = "table_ads_period";

    protected $fillable = [
        'id', 'display_name'
    ];

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}
