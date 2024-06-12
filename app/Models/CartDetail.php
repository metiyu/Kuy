<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'schedule_id'
    ];

    public function getFormattedPriceAttribute()
    {
        return 'Rp' . number_format($this->attributes['field_price'], 0, ',', '.');
    }

    public function getFormattedDateAttribute()
    {
        $days = [
            'Sun' => 'Min',
            'Mon' => 'Sen',
            'Tue' => 'Sel',
            'Wed' => 'Rab',
            'Thu' => 'Kam',
            'Fri' => 'Jum',
            'Sat' => 'Sab',
        ];

        $englishDay = date('D', strtotime($this->attributes['date'])); // Get the English abbreviation of the day
        $indonesianDay = $days[$englishDay]; // Get the Indonesian abbreviation from the translation array
        $formattedDate = $indonesianDay . ', ' . date('d M Y', strtotime($this->attributes['date'])); // Combine with the rest of the date format
        return $formattedDate;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
