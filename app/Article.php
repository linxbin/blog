<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $fillable = ['title', 'body', 'pv'];

    public function topics()
    {
        return $this->belongsToMany( Topic::class )->withTimestamps();
    }
}
