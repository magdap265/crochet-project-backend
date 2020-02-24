<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public function pattern()
    {
        return $this->hasOne('App\Patterns');
    }

    public function comment()
    {
        return $this->hasMany('App\Comments');
    }

    public function delete()   // czy to jest potrzebne?
    {
        // delete all related fields
        $this->pattern()->delete();
        $this->comment()->delete();
        return parent::delete();
    }

    protected $fillable = [
        'name',
        'product_type',
        'color',
        'rope_size',
        'description',
        'image_path'
    ];
}
