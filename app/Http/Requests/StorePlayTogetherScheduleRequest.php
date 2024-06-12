<?php

namespace App\Http\Requests;

use App\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StorePlayTogetherScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string',
            'desc' => 'required|string',
            'price' => 'required',
            'slot' => 'required|integer|min:3',
            'sport' => 'required|integer|exists:sports,id',
            'date' => 'required|date',
            'schedule' => 'required|array|min:1',
            'schedule.*' => 'integer|exists:schedules,id'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $price = convertCurrencyToInteger($this->input('price'));
            if ($price < 10000) {
                $validator->errors()->add('schedule', 'Biaya registrasi minimal Rp10.000');
            }

            $scheduleIds = $this->input('schedule');

            // Validate that all schedules are in the same venue
            if ($scheduleIds) {
                $schedules = Schedule::whereIn('id', $scheduleIds)->get();

                // Validate that all schedules are in the same venue
                $venueIds = $schedules->pluck('field.venue_id')->unique();
                if ($venueIds->count() > 1) {
                    $validator->errors()->add('schedule', 'Semua jadwal harus di venue yang sama');
                }

                // Validate that the sport is the same as the field sport id
                $sportId = $this->input('sport');
                $fieldSportIds = $schedules->pluck('field.sport_id')->unique();
                if ($fieldSportIds->count() > 1 || $fieldSportIds->first() != $sportId) {
                    $validator->errors()->add('sport', 'Olahraga yang dipilih tidak sesuai dengan tipe lapangan');
                }

                // Validate that schedules are adjacent in time
                $scheduleData = $schedules->map(function ($schedule) {
                    return [
                        'start_hour' => $schedule->start_hour,
                        'end_hour' => $schedule->end_hour,
                    ];
                })->sortBy('start_hour')->values();

                for ($i = 0; $i < $scheduleData->count() - 1; ++$i) {
                    if ($scheduleData[$i]['end_hour'] != $scheduleData[$i + 1]['start_hour']) {
                        $validator->errors()->add('schedule', 'Jadwal yang dipilih harus berurutan dalam waktu.');
                        break;
                    }
                }
            }
        });
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama harus diisi',
            'desc.required' => 'Deskripsi harus diisi',
            'price.required' => 'Biaya registrasi harus diisi',
            'slot.required' => 'Slot peserta harus minimal 3',
            'slot.min' => 'Slot peserta harus minimal 3',
            'sport.required' => 'Olahraga harus dipilih',
            'sport.exists' => 'Olahraga yang dipilih tidak valid',
            'date.required' => 'Tanggal harus diisi',
            'schedule.required' => 'Setidaknya satu jadwal harus dipilih',
            'schedule.min' => 'Setidaknya satu jadwal harus dipilih',
            'schedule.*.exists' => 'Jadwal yang dipilih tidak valid',
        ];
    }
}
