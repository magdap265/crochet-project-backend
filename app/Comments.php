<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    public function products() {
        return $this->belongsTo('App\Products');
    }

    protected $fillable = [  //vo tu się dzieje i po co to? :P
        'user_name',
        'rating',
        'opinion',
        'products_id'
    ];
}
