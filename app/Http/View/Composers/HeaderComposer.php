<?php

namespace App\Http\View\Composers;

use App\Models\CartDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HeaderComposer
{
    /**
     * Create a new class instance.
     */
    protected $carts;
    public function __construct()
    {
        if (Auth::check()) {
            $this->carts =  CartDetail::where('user_id', Auth::user()->id)->get();
        }
    }

    public function compose(View $view)
    {
        if (Auth::check()) {
            // Get the current authenticated user
            $user = Auth::user();

            // Fetch the cart details for the user
            $carts = DB::table('cart_details as cd')
                ->join('schedules as s', 'cd.schedule_id', '=', 's.id')
                ->join('fields as f', 's.field_id', '=', 'f.id')
                ->join('venues as v', 'f.venue_id', '=', 'v.id')
                ->select(
                    'cd.user_id as cart_user_id',
                    'cd.schedule_id as cart_schedule_id',
                    's.id as schedule_id',
                    's.date as schedule_date',
                    's.start_hour as schedule_start_hour',
                    's.end_hour as schedule_end_hour',
                    'f.id as field_id',
                    'f.name as field_name',
                    'f.is_indoor as field_is_indoor',
                    'f.price as field_price',
                    'f.picture as field_picture',
                    'v.id as venue_id',
                    'v.name as venue_name',
                    'v.description as venue_description',
                    'v.location as venue_location',
                    'v.open_hour as venue_open_hour',
                    'v.close_hour as venue_close_hour',
                    'v.owner_id as venue_owner_id'
                )
                ->where('cd.user_id', $user->id)
                ->orderBy('s.date')
                ->orderBy('s.start_hour')
                ->get();

            // Format the data
            $carts->transform(function ($cart) {
                $cart->formatted_price = 'Rp' . number_format($cart->field_price, 0, ',', '.');
                $days = [
                    'Sun' => 'Min',
                    'Mon' => 'Sen',
                    'Tue' => 'Sel',
                    'Wed' => 'Rab',
                    'Thu' => 'Kam',
                    'Fri' => 'Jum',
                    'Sat' => 'Sab',
                ];
                $englishDay = date('D', strtotime($cart->schedule_date));
                $indonesianDay = $days[$englishDay];
                $cart->formatted_date = $indonesianDay . ', ' . date('d M Y', strtotime($cart->schedule_date));
                return $cart;
            });

            // Pass the cart details to the view
            $view->with('carts', $carts);
        } else {
            // Pass an empty collection or null for guest users
            $view->with('carts', collect());
        }
    }
}
