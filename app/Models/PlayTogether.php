<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayTogether extends Model
{
    use HasFactory;
    public function sport()
    {
        return $this->belongsTo(Sport::class, 'sport_id');
    }

    public function play_together_details()
    {
        return $this->hasMany(PlayTogetherDetail::class, 'play_together_id');
    }

    public function play_together_schedules()
    {
        return $this->hasMany(PlayTogetherSchedule::class, 'play_together_id');
    }
}
