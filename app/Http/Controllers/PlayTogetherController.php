<?php

namespace App\Http\Controllers;

use App\Models\PlayTogether;
use App\Http\Requests\StorePlayTogetherRequest;
use App\Http\Requests\StorePlayTogetherScheduleRequest;
use App\Http\Requests\UpdatePlayTogetherRequest;
use App\Models\PlayTogetherDetail;
use App\Models\PlayTogetherSchedule;
use App\Models\Schedule;
use App\Models\Sport;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PlayTogetherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $now = Carbon::now()->setTimezone('Asia/Jakarta'); // Adjust the timezone if needed

        if ($request->input('search')) {
            $search = $request->input('search');
            $playTogethers = PlayTogether::where(function ($query) use ($now, $search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->where(function ($query) use ($now) {
                        $query->where('date', '>', $now->toDateString())
                            ->orWhere(function ($query) use ($now) {
                                $query->where('date', '=', $now->toDateString())
                                    ->where('start_hour', '>', $now->toTimeString());
                            });
                    });
            })
            ->orderBy('date')
            ->orderBy('start_hour')
            ->paginate(15);
        } else {
            $playTogethers = PlayTogether::where(function ($query) use ($now) {
                $query->where('date', '>', $now->toDateString())
                    ->orWhere(function ($query) use ($now) {
                        $query->where('date', '=', $now->toDateString())
                            ->where('start_hour', '>', $now->toTimeString());
                    });
            })
            ->orderBy('date')
            ->orderBy('start_hour')
            ->paginate(15);
        }

        return view('play-togethers', compact('playTogethers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Retrieve sports for the select dropdown
        $sports = Sport::all();

        // Retrieve current user
        $user = Auth::user();

        // Check if request contains date and venue_id
        if ($request->has('date') && $request->has('venue_id')) {
            $date = $request->input('date');
            $venueId = $request->input('venue_id');

            // Retrieve transactions based on provided inputs
            $transactions = DB::table('transactions as t')
                ->join('transaction_details as td', 'td.transaction_id', '=', 't.id')
                ->join('schedules as s', 'td.schedule_id', '=', 's.id')
                ->join('fields as f', 's.field_id', '=', 'f.id')
                ->join('venues as v', 'f.venue_id', '=', 'v.id')
                ->select('t.*', 'td.*', 's.*', 'f.*', 'v.*')
                ->where('t.user_id', $user->id)
                ->where('v.id', $venueId)
                ->where('s.date', $date)
                ->get();
        } else {
            $transactions = collect(); // Empty collection if date or venue_id is not provided
        }

        return view('create-play-together', compact('sports', 'transactions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlayTogetherScheduleRequest  $request)
    {
        try {
            $scheduleIds = $request->input('schedule');
            $schedules = Schedule::whereIn('id', $scheduleIds)->get();
            $user = Auth::user();

            $startHour = $schedules->min('start_hour');
            $endHour = $schedules->max('end_hour');

            $playTogether = PlayTogether::create([
                'name' => $request->input('nama'),
                'description'=> $request->input('desc'),
                'player_slot'=> $request->input('slot'),
                'price'=> convertCurrencyToInteger($request->input('price')),
                'date'=> $request->input('date'),
                'start_hour'=> $startHour,
                'end_hour'=> $endHour,
                'sport_id' => $request->input('sport'),
                'owner_id' => $user->id,
            ]);

            PlayTogetherDetail::create([
                'play_together_id' => $playTogether->id,
                'user_id' => $user->id,
            ]);

            $numSchedules = count($request->input('schedule'));
            for ($i = 0; $i < $numSchedules; $i++) {
                PlayTogetherSchedule::create([
                    'play_together_id'=> $playTogether->id,
                    'schedule_id'=> $request->input('schedule')[$i],
                ]);
            }

            Alert::success('Sukses', 'Main Bareng berhasil dibuat!');

            return redirect('/main-bareng-detail/'.$playTogether->id)->with('success', 'Main Bareng berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $playTogether = PlayTogether::find($id);
        $playTogetherDetail = PlayTogetherDetail::where('play_together_id', $playTogether->id)->get();
        $users = $playTogetherDetail->pluck('user_id')->toArray();
        $players = [];
        foreach($users as $u){
            array_push($players, User::find($u));
        };
        return view('play-together-detail', compact('playTogether', 'players'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlayTogether $playTogether)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlayTogetherRequest $request, PlayTogether $playTogether)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlayTogether $playTogether)
    {
        //
    }
}
