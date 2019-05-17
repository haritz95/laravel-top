<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Spots;
use App\Period;

class Ad extends Model
{
    protected $table = "ads";

    protected $fillable = [
        'id_spot', 'id_period', 'tittle', 'website', 'banner_link', 'banner_upload', 'active'
    ];

    public function spots()
    {
        return $this->belongsTo(Spots::class,'id_spot','id');
    }

    public function period()
    {
        return $this->belongsTo(Period::class,'id_period','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
