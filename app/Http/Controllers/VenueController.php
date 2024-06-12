<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Sport;
use App\Models\Field;
use App\Http\Requests\StoreVenueRequest;
use App\Http\Requests\UpdateVenueRequest;
use App\Models\CartDetail;
use App\Models\Schedule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->input('search')) {
            $search = $request->input('search');
            $venues = Venue::where('name', 'LIKE', "%{$search}%")
                ->orWhere('location', 'LIKE', "%{$search}%")
                ->paginate(15);
        } else {
            $venues = Venue::paginate(15);
        }

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
        try {
            // Validate the basic form data
            $validatedData = $request->validate([
                'nama' => 'required|min:3|max:255',
                'desc' => 'required|min:3|max:255',
                'location' => 'required|min:3|max:255',
                'open_hour' => 'required',
                'close_hour' => 'required',
            ]);

            // Convert open_hour and close_hour to Carbon instances
            $openHour = Carbon::createFromFormat('H:i', $validatedData['open_hour']);
            $closeHour = Carbon::createFromFormat('H:i', $validatedData['close_hour']);

            // Calculate the difference in hours
            $hoursDifference = $openHour->diffInHours($closeHour);
            $minutesDifference = $openHour->diffInMinutes($closeHour) % 60;

            if ($hoursDifference <= 2) {
                return redirect()->back()->withErrors(['error' => 'Jam buka harus lebih awal minimal 3 jam dari jam tutup'])->withInput();
            }

            if ($minutesDifference != 0) {
                return redirect()->back()->withErrors(['error' => 'Perbedaan jam buka dan jam tutup harus dalam satuan jam'])->withInput();
            }

            // Get the authenticated user
            $user = Auth::user();

            // Process the validated data and create the venue
            if ($user && $user->id) {
                $venue = Venue::create([
                    'name' => $validatedData['nama'],
                    'description' => $validatedData['desc'],
                    'location' => $validatedData['location'],
                    'open_hour' => $validatedData['open_hour'],
                    'close_hour' => $validatedData['close_hour'],
                    'owner_id' => $user->id,
                ]);

                // Handle the dynamic fields if present
                if ($request->has('field-name')) {
                    $validatedFields = $request->validate([
                        'field-name.*' => 'required|min:3|max:255',
                        'field-type.*' => 'required',
                        'field-radio-.*' => 'required',
                        'field-price.*' => 'required',
                        'field-picture.*' => 'required|file|mimes:jpeg,png,jpg|max:2048',
                    ]);

                    // Get the number of fields
                    $numFields = count($validatedFields['field-name']);
                    for ($i = 0; $i < $numFields; $i++) {

                        $fieldRadioKey = 'field-radio-' . ($i);
                        if (!$request->has($fieldRadioKey)) {
                            return redirect()->back()->withErrors(['error' => 'Harap pilih jenis lapangan untuk semua lapangan'])->withInput(); //Please select field type for all fields
                        }

                        $picture = $request->file('field-picture')[$i];
                        $filename = $picture->store('field-picture', 'public');

                        $price = convertCurrencyToInteger($validatedFields['field-price'][$i]);

                        $field = Field::create([
                            'name' => $validatedFields['field-name'][$i],
                            'is_indoor' => intval($request->input($fieldRadioKey)),
                            'price' => $price,
                            'picture' => 'http://127.0.0.1:8000/storage/'.$filename,
                            'venue_id' => $venue->id,
                            'sport_id' => $validatedFields['field-type'][$i],
                        ]);

                        $startDate = Carbon::create(2024, 6, 1);
                        $endDate = Carbon::create(2024, 7, 1);

                        for ($date = $startDate->copy(); $date->lessThan($endDate); $date->addDay()) {
                            $openHour = Carbon::createFromFormat('H:i', $venue->open_hour);
                            $closeHour = Carbon::createFromFormat('H:i', $venue->close_hour);

                            while ($openHour < $closeHour) {
                                $startHour = $openHour->copy();
                                $endHour = $openHour->addHour();

                                if ($endHour > $closeHour) {
                                    break;
                                }

                                Schedule::create([
                                    'date' => $date->format('Y-m-d'),
                                    'start_hour' => $startHour->format('H:i:s'),
                                    'end_hour' => $endHour->format('H:i:s'),
                                    'field_id' => $field->id,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);

                                $openHour = $endHour;
                            }
                        }
                    }
                } else {
                    return redirect()->back()->withErrors(['error' => 'Harap tambahkan setidaknya satu lapangan'])->withInput(); //Please add at least one field
                }
            }
            // Return a response or redirect
            Alert::success('Sukses', 'Venue-mu berhasil ditambahkan!');
            return redirect('/venue/'.$venue->id);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $venue = Venue::find($id);
        // Check if the user is authenticated
        if (Auth::check()) {
            $carts = CartDetail::where('user_id', Auth::user()->id)->get();
            $scheduleIds = $carts->pluck('schedule_id')->toArray();
        } else {
            // Handle the case when the user is not authenticated
            $carts = collect(); // or null, or any default value you want
            $scheduleIds = collect();
        }
        return view('venue-detail', compact('venue', 'carts', 'scheduleIds'));
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

    private function convertCurrencyStringToNumber($currencyString)
    {
        // Remove non-numeric characters except for the decimal point
        $numberString = preg_replace('/[^0-9.]/', '', $currencyString);
        // Convert to float or integer as needed
        return floatval($numberString);
    }
}
