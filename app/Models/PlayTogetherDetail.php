<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayTogetherDetail extends Model
{
    use HasFactory;
    public function play_together()
    {
        return $this->belongsTo(PlayTogether::class, 'play_together_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
