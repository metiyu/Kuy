@php
    // Get the selected date from the request or session
    $selectedDate = request()->input('date') ?? session()->get('selected_date');
@endphp
@foreach ($field->schedules as $schedule)
    @if ($schedule->date == $selectedDate)
        <form method="POST" class="schedule-form">
            @csrf
            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
            <input type="text" hidden name="in_cart" value="{{ in_array($schedule->id, $scheduleIds) ? true : false }}">
            <div class="schedule-item bg-gray-100 p-2 rounded flex justify-between items-center
                    {{ in_array($schedule->id, $scheduleIds)
                        ? 'bg-yellow-100'
                        : ($schedule->transaction_details->count() == 0
                            ? 'bg-green-100'
                            : 'bg-red-100') }}"
                data-date="{{ $schedule->date }}">
                <div class="flex flex-col">
                    <span class="text-sm font-medium">{{ substr($schedule->start_hour, 0, 5) }}
                        - {{ substr($schedule->end_hour, 0, 5) }}</span>
                    <span class="text-sm font-medium">Rp
                        {{ number_format($field->price, 0, ',', '.') }}</span>
                </div>
                <button type="submit"
                    class="text-sm font-semibold py-1 px-2 rounded
                        {{ in_array($schedule->id, $scheduleIds)
                            ? 'bg-yellow-500 text-white'
                            : ($schedule->transaction_details->count() == 0
                                ? 'bg-green-600 text-white hover:bg-green-700'
                                : 'bg-red-600 text-white cursor-not-allowed') }}"
                    {{ $schedule->transaction_details->count() > 0 ? 'disabled' : '' }}>
                    {{ in_array($schedule->id, $scheduleIds)
                        ? 'In Cart'
                        : ($schedule->transaction_details->count() == 0
                            ? 'Booking'
                            : 'Booked') }}
                </button>
            </div>
        </form>
    @endif
@endforeach
