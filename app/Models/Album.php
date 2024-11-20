<?php

namespace App\Models;

use App\Models\Song;
use App\Models\Artist;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class)->withPivot('track_number');
    }

}
