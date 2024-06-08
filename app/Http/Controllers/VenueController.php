<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Sport;
use App\Http\Requests\StoreVenueRequest;
use App\Http\Requests\UpdateVenueRequest;
use Illuminate\Support\Facades\Log;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $venues = Venue::paginate(15);
        return view('venues', compact('venues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sports = Sport::all();
        return view('create-venue', compact('sports'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVenueRequest $request)
    {
        // Get the form data
        $validatedData = $request->validate([
            'nama' => 'required',
            'desc' => 'required',
            'location' => 'required',
            'open_hour' => 'required',
            'close_hour' => 'required',
            'field_name.*' => 'required',
            'field_type.*' => 'required',
            'field-radio.*' => 'required',
            'field_price.*' => 'required',
            'field_pictures.*' => 'required|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Process the validated data
        $venue = Venue::create([
            'name' => $validatedData['nama'],
            'description' => $validatedData['desc'],
            'location' => $validatedData['location'],
            'open_hour' => $validatedData['open_hour'],
            'close_hour' => $validatedData['close_hour'],
        ]);

        // Handle the field data
        foreach ($validatedData['field_name'] as $index => $fieldName) {
            $fieldPicture = $request->file('field_pictures')[$index] ?? null;

            $field = $venue->fields()->create([
                'name' => $fieldName,
                'is_indoor' => $validatedData['default-radio'][$index] === 'indoor',
                'price' => $validatedData['field_price'][$index],
                'sport_id' => 1, // Replace with the appropriate sport ID
            ]);

            if ($fieldPicture) {
                $filename = $fieldPicture->hashName(); // Generate a unique filename
                Storage::putFileAs('public/field_pictures', $fieldPicture, $filename); // Save the file to public/storage/field_pictures
                $field->picture = 'field_pictures/' . $filename; // Store the file path in the database
                $field->save();
            }
        }

        // Return a response or redirect
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $venue = Venue::find($id);
        return view('venue-detail', compact('venue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venue $venue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVenueRequest $request, Venue $venue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venue $venue)
    {
        //
    }
}
