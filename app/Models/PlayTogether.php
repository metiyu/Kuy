<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayTogether extends Model
{
    use HasFactory;

    protected $appends = ['formatted_price'];

    protected $fillable = [
        'name',
        'description',
        'player_slot',
        'price',
        'date',
        'start_hour',
        'end_hour',
        'owner_id',
        'sport_id',
    ];
    public function getFormattedPriceAttribute()
    {
        return 'Rp' . number_format($this->attributes['price'], 0, ',', '.');
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

    public function owner()
    {
    return $this->belongsTo(User::class, 'owner_id');
    }

    public function loadParticipantsCount()
    {
        return $this->load([
            'play_together_details' => function ($query) {
                $query->withCount([
                    'user' => function ($query) {
                        $query->select('user_id');
                    }
                ])->groupBy('play_together_id');
            }
        ]);
    }

    public function getLocations()
    {
        return $this->play_together_schedules()
            ->with('schedule.field.venue')
            ->get()
            ->map(function ($schedule) {
                return $schedule->schedule->field->venue->location;
            });
    }

    public function getFields()
    {
        return $this->play_together_schedules()
            ->with('schedule.field')
            ->get()
            ->map(function ($field){
                return $field;
            });
    }

    public function getFieldVenueDetails()
    {
        return $this->play_together_schedules()
                    ->join('schedules', 'play_together_schedules.schedule_id', '=', 'schedules.id')
                    ->join('fields', 'schedules.field_id', '=', 'fields.id')
                    ->join('venues', 'fields.venue_id', '=', 'venues.id')
                    ->select('fields.name as field_name', 'venues.name as venue_name', 'venues.location as venue_location')
                    ->get();
    }
}
