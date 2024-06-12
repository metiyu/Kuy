<?php

namespace App\Http\Controllers;

use App\Models\PlayTogetherDetail;
use App\Http\Requests\StorePlayTogetherDetailRequest;
use App\Http\Requests\UpdatePlayTogetherDetailRequest;
use App\Models\PlayTogether;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PlayTogetherDetailController extends Controller
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
    public function store(StorePlayTogetherDetailRequest $request)
    {
        try {
            $user = Auth::user();

            // Check if the user ID already exists in the table
            $existingRecord = PlayTogetherDetail::where('user_id', $user->id)
                                ->where('play_together_id', $request->input('play_together_id'))
                                ->exists();

            if ($existingRecord) {
                // If the record already exists, return with an error message
                return redirect()->back()->withErrors('Kamu sudah ikut dalam main bareng ini');
            }

            // Create a new record if the user is not already participating
            $playTogetherDetail = PlayTogetherDetail::create([
                'user_id' => $user->id,
                'play_together_id' => $request->input('play_together_id'),
            ]);

            Alert::success('Sukses', 'Berhasil ikut main bareng!');

            return redirect('/main-bareng-detail/'.$request->input('play_together_id'))->with('success', 'Berhasil ikut main bareng!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PlayTogetherDetail $playTogetherDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlayTogetherDetail $playTogetherDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlayTogetherDetailRequest $request, PlayTogetherDetail $playTogetherDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // dd($request->all());
        try {
            $playTogetherDetail = PlayTogetherDetail::where('user_id', $request->input('user_id'))->where('play_together_id', $request->input('play_together_id'));
            $playTogetherDetail->delete();

            Alert::success('Sukses', 'Berhasil hapus member main bareng!');

            return redirect('/main-bareng-detail/'.$request->input('play_together_id'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
}
