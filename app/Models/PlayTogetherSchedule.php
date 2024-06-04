<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayTogetherSchedule extends Model
{
    use HasFactory;
    public function play_together()
    {
        return $this->belongsTo(PlayTogether::class, 'play_together_id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}
