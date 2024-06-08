<?php

namespace App\Http\Controllers;

use App\Models\PlayTogether;
use App\Http\Requests\StorePlayTogetherRequest;
use App\Http\Requests\UpdatePlayTogetherRequest;

class PlayTogetherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $playTogethers = PlayTogether::paginate(15);
        return view('play-togethers', compact('playTogethers'));
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
    public function store(StorePlayTogetherRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $playTogether = PlayTogether::find($id);
        return view('play-together-detail', compact('playTogether'));
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
