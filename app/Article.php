<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function authorsToDisplay()
    {
        return $this->belongsToMany(Author::class)->wherePivot('display', true);
    }
}
