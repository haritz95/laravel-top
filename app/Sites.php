<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Sites;
use App\Category;

class Sites extends Model
{
    //

    protected $table = "sites";

    protected $fillable = [
        'title', 'description', 'category_id', 'url', 'url_file', 'p_description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
