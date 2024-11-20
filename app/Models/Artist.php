<?php

namespace App\Models;

use App\Models\Album;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $fillable = [
        'name',
    ];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }
}
