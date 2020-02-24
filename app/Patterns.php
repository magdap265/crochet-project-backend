<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patterns extends Model
{
    public function products() {
        return $this->belongsTo('App\Products');
    }

    protected $fillable = [
        'video_path',
        'products_id'
    ];
}
