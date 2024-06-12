<?php

namespace App\Http\Controllers;

use App\Models\CartDetail;
use App\Http\Requests\StoreCartDetailRequest;
use App\Http\Requests\UpdateCartDetailRequest;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CartDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartDetailRequest $request)
    {
        $user = Auth::user();
        $scheduleId = $request->input('schedule_id');
        $schedule = Schedule::findOrFail($scheduleId);
        $field = $schedule->field;
        $selectedDate = $request->input('date');

        try {
            if ($request->input('in_cart') == 0) {
                // Add the schedule to the cart
                $cart = CartDetail::create([
                    'user_id' => $user->id,
                    'schedule_id' => $scheduleId,
                ]);

                $carts = CartDetail::where('user_id', Auth::user()->id)->get();
                $scheduleIds = $carts->pluck('schedule_id')->toArray();

                // Render the updated schedules for the field
                $updatedSchedulesHtml = view('components.field-schedules', compact('field', 'carts', 'scheduleIds', 'selectedDate'))->render();

                return response()->json([
                    'success' => true,
                    'message' => 'Jadwal berhasil ditambahkan ke keranjang',
                    'html' => $updatedSchedulesHtml,
                ]);
            } elseif ($request->input('in_cart') == 1) {
                $deleted = CartDetail::where('user_id', $user->id)
                    ->where('schedule_id', $scheduleId)
                    ->delete();

                if ($deleted) {
                    $carts = CartDetail::where('user_id', Auth::user()->id)->get();
                    $scheduleIds = $carts->pluck('schedule_id')->toArray();

                    // Render the updated schedules for the field
                    $updatedSchedulesHtml = view('components.field-schedules', compact('field', 'carts', 'scheduleIds', 'selectedDate'))->render();

                    return response()->json([
                        'success' => true,
                        'message' => 'Berhasil dihapus dari keranjang',
                        'html' => $updatedSchedulesHtml,
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'error' => 'Jadwal tidak ditemukan di keranjang'
                    ], 404);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CartDetail $cartDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartDetail $cartDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartDetailRequest $request, CartDetail $cartDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartDetail $cartDetail)
    {
        //
    }
}
