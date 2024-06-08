<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'open_hour',
        'close_hour',
    ];

    public function fields()
    {
        return $this->hasMany(Field::class, 'venue_id');
    }
    public function sports()
    {
        return $this->belongsToMany(Sport::class, 'fields', 'venue_id', 'sport_id')
            ->withCount('fields')
            ->distinct();
    }
    public function getMinimumPriceField()
    {
        return $this->fields()
            ->where('price', function ($query) {
                $query->select(DB::raw('MIN(price)'))
                    ->from('fields')
                    ->where('venue_id', $this->id);
            })
            ->orderBy('id')
            ->limit(1)
            ->first();
    }
}
