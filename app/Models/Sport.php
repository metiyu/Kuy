<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;
    public function fields()
    {
        return $this->hasMany(Field::class, 'sport_id');
    }

    public function play_togethers()
    {
        return $this->hasMany(PlayTogether::class, 'sport_id');
    }
}
