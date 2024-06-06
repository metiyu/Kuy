@extends('layouts.app')

@section('content')
    <div class="flex flex-col place-content-center w-screen pt-60">
        <p>{{ $venue->name }}</p>
        <div class="flex items-center py-2">
            <p class="text-sm tracking-wider text-gray-500 pl-1">📍</p>
            <p class="text-sm tracking-wider text-gray-500">{{ $venue->location }}</p>
        </div>
        <div class="inline-flex items-center text-sm font-normal text-gray-400">
            @foreach ($venue->sports as $s)
                <div class="flex items-center">
                    <img src="{{ $s->icon }}" alt="{{ $s->name }}" class="h-5 pb-1 mr-1">
                    <p class="text-xs tracking-wider text-gray-500 pb-0.5">{{ $s->name }}</p>
                </div>
                <p class="text-sm tracking-wider text-gray-500 px-1">·</p>
            @endforeach
        </div>
        <p>{{ $venue->description }}</p>
        <p>Pilih lapangan</p>
        <input type="date" name="date" id="date">
        <button id="changeDateBtn">Change date</button>
        @foreach ($venue->fields as $f)
            <p>{{ $f->name }}</p>
            <p>{{ $f->sport->name }}</p>
            <p>{{ $f->isIndoor == 0 ? 'indoor' : 'outdoor' }}</p>
            <img src="{{ $f->picture }}" alt="" class="max-w-sm">
            <div class="field-schedules" data-field-id="{{ $f->id }}">
                @foreach ($f->schedules as $s)
                    <p>{{ $s->date }}: {{ $s->start_hour }} - {{ $s->end_hour }} - {{ $s->transaction_details->count() == 0 ? 'Available' : 'Not Available' }} - {{ $f->getFormattedPriceAttribute() }}</p>
                @endforeach
            </div>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0];
            document.getElementById('date').value = formattedDate;

            const changeDateBtn = document.getElementById('changeDateBtn');

            changeDateBtn.addEventListener('click', () => {
                const dateInput = document.getElementById('date');
                const selectedDate = dateInput.value;

                // Update schedule data in the DOM based on the selected date
                const scheduleContainers = document.querySelectorAll('.field-schedules');
                scheduleContainers.forEach(scheduleContainer => {
                    const fieldId = scheduleContainer.dataset.fieldId;
                    const scheduleItems = scheduleContainer.querySelectorAll('p');
                    scheduleItems.forEach(scheduleItem => {
                        const scheduleDate = scheduleItem.innerText.split(':')[0];
                        if (scheduleDate === selectedDate) {
                            scheduleItem.style.display = 'block';
                        } else {
                            scheduleItem.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
@endsection
