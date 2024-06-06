<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $appends = ['formatted_price'];

    public function getFormattedPriceAttribute()
    {
        return 'Rp' . number_format($this->attributes['price'], 0, ',', '.');
    }
    public function sport()
    {
        return $this->belongsTo(Sport::class, 'sport_id');
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'field_id');
    }
}
