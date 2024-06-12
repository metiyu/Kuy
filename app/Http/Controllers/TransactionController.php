<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\CartDetail;
use App\Models\PlayTogether;
use App\Models\PlayTogetherDetail;
use App\Models\Schedule;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with([
            'transaction_details.schedule.field.venue',
            'transaction_details.schedule.field.sport',
        ])
        ->where('user_id', Auth::user()->id)
        ->orderBy('date', 'desc')
        ->get();

        $playTogethers = PlayTogetherDetail::with([
            'play_together',
            'user'
        ])
        ->where('user_id', Auth::user()->id)
        ->join('play_togethers', 'play_together_details.play_together_id', '=', 'play_togethers.id')
        ->join('sports', 'sports.id', '=', 'play_togethers.sport_id')
        ->orderBy('play_togethers.date', 'desc')
        ->select('play_together_details.*') // Ensure you select the proper fields
        ->get();

        // dd($playTogethers->toArray());

        return view('history', compact('transactions', 'playTogethers'));
    }

    public function getTransactions(Request $request)
    {
        $user = Auth::user();
        $date = $request->input('date');

        if ($date) {
            $transactions = DB::table('transactions as t')
            ->join('transaction_details as td', 'td.transaction_id', '=', 't.id')
            ->join('schedules as s', 'td.schedule_id', '=', 's.id')
            ->join('fields as f', 's.field_id', '=', 'f.id')
            ->join('venues as v', 'f.venue_id', '=', 'v.id')
            ->join('sports as sp', 'f.sport_id', '=', 'sp.id')
            ->select(
                't.id as transaction_id',
                't.date as transaction_date',
                't.payment_method as transaction_payment_method',
                't.user_id as transaction_user_id',
                'td.transaction_id as transaction_detail_transaction_id',
                'td.schedule_id as transaction_detail_schedule_id',
                's.id as schedule_id',
                's.date as schedule_date',
                's.start_hour as schedule_start_hour',
                's.end_hour as schedule_end_hour',
                's.field_id as schedule_field_id',
                'f.id as field_id',
                'f.name as field_name',
                'f.is_indoor as field_is_indoor',
                'f.price as field_price',
                'f.picture as field_picture',
                'f.venue_id as field_venue_id',
                'f.sport_id as field_sport_id',
                'v.id as venue_id',
                'v.name as venue_name',
                'sp.id as sport_id',
                'sp.name as sport_name'
            )
            ->where('t.user_id', $user->id)
            ->where('s.date', $date)
            ->get();

        } else {
            $transactions = collect();
        }

        return response()->json($transactions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Get the JSON data from the request
        $cartData = $request->input('cart_data');

        // Decode the JSON data into an array
        $cartDataArray = array_map(function($item) {
            return json_decode($item, true);
        }, $cartData);

        return view('checkout', compact('cartDataArray'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        try {
            $user = Auth::user();

            $transaction = Transaction::create([
                'date' => Carbon::now()->format('Y-m-d'),
                'payment_method' => $request->input('payment-method'),
                'user_id' => $user->id,
            ]);

            foreach ($request->input('schedule_ids') as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'schedule_id' => $item,
                ]);
                $cart = CartDetail::where('user_id', $user->id)->where('schedule_id', $item)->delete();
            }

            Alert::success('Sukses', 'Berhasil booking jadwal!');

            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/')->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
