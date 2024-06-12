@extends('layouts.app')

@section('content')
    <div class="flex flex-col justify-center items-center w-screen p-24 bg-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-11/12">
            <div class="relative w-full">
                <img id="mainImage" src="{{ $venue->fields[0]->picture }}" alt="Main Image"
                    class="w-full h-96 object-cover rounded-lg">
                <div class="absolute top-2 right-2 space-x-2">
                    @foreach ($venue->fields->take(3) as $index => $field)
                        <img src="{{ $field->picture }}" alt="Thumbnail {{ $index + 1 }}"
                            class="inline-block w-20 h-20 object-cover rounded cursor-pointer hover:opacity-75 transition duration-300 ease-in-out"
                            onclick="changeMainImage('{{ $field->picture }}')">
                    @endforeach
                </div>
            </div>

            <div>
                <h1 class="text-3xl font-bold mb-2">{{ $venue->name }}</h1>
                <div class="flex items-center text-gray-600 mb-4">
                    <svg class="w-5 h-5 text-gray-500 mr-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ $venue->location }}</span>
                </div>

                <div class="flex items-center mb-6">
                    @foreach ($venue->sports as $s)
                        <div class="flex items-center mr-4">
                            <img src="{{ $s->icon }}" alt="{{ $s->name }}" class="w-6 h-6 mr-1">
                            <span class="text-sm text-gray-700">{{ $s->name }}</span>
                        </div>
                    @endforeach
                </div>

                <p class="text-gray-700 mb-6">{{ $venue->description }}</p>

                <div class="mb-32"></div>

                <div class="text-3xl font-bold text-red-800 mb-4">Rp
                    {{ number_format($venue->fields[0]->price, 0, ',', '.') }}<span
                        class="text-base font-normal text-gray-700">/jam</span></div>

                <button id="checkAvailabilityBtn"
                    class="w-full bg-red-800 text-white py-3 px-6 rounded-lg font-semibold hover:bg-red-700 transition duration-300">Cek
                    Ketersediaan</button>
            </div>
        </div>

        <div class="mt-16">
            <h2 id="fieldSelection" class="text-2xl font-bold mb-6">Pilih Lapangan</h2>

            <div class="flex items-center mb-6">
                <label for="date" class="mr-4 font-medium text-gray-700">Tanggal Main</label>
                <input type="date" id="date" name="date"
                    class="py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($venue->fields as $index => $field)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <img src="{{ $field->picture }}" alt="{{ $field->name }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-xl font-semibold mb-2">{{ $field->name }}</h3>
                            <div class="flex items-center mb-4">
                                <img src="{{ $field->sport->icon }}" alt="{{ $field->sport->name }}" class="w-5 h-5 mr-2">
                                <span class="text-sm text-gray-600">{{ $field->sport->name }}</span>
                                <span class="mx-2 text-gray-500">·</span>
                                <span
                                    class="text-sm text-gray-600">{{ $field->is_indoor == 0 ? 'Indoor' : 'Outdoor' }}</span>
                            </div>
                            <button
                                class="w-full mb-4 bg-red-800 text-white py-2 px-4 rounded font-semibold hover:bg-red-700 transition duration-300 toggle-schedules"
                                data-field-id="{{ $field->id }}">
                                <span class="available-schedule-count"></span>
                            </button>
                            <div class="field-schedules space-y-2 hidden" data-field-id="{{ $field->id }}">
                                @foreach ($field->schedules as $schedule)
                                    <form method="POST" class="schedule-form">
                                        @csrf
                                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                        <input type="text" hidden name="in_cart"
                                            value="{{ in_array($schedule->id, $scheduleIds) ? true : false }}">
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
                                @endforeach
                            </div>
                            <button
                                class="w-full mt-4 bg-red-800 text-white py-2 px-4 rounded font-semibold hover:bg-red-700 transition duration-300">
                                Booking Sekarang
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function changeMainImage(imageSrc) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = imageSrc;

            mainImage.style.opacity = 0;
            setTimeout(() => {
                mainImage.style.opacity = 1;
            }, 50);
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            const dateInput = document.getElementById('date');
            const today = new Date().toISOString().split('T')[0];
            dateInput.value = today;
            updateSchedules(today);

            dateInput.addEventListener('change', (e) => {
                updateSchedules(e.target.value);
            });

            function updateSchedules(selectedDate) {
                const schedules = document.querySelectorAll('.schedule-item');
                schedules.forEach(schedule => {
                    schedule.style.display = schedule.dataset.date === selectedDate ? 'flex' : 'none';
                });

                const fieldSchedules = Array.from(schedules).filter(schedule => schedule.dataset.date ===
                    selectedDate);
                const availableScheduleCounts = fieldSchedules.reduce((counts, schedule) => {
                    const fieldId = schedule.closest('.field-schedules').dataset.fieldId;
                    const isAvailable = schedule.querySelector('button:not(:disabled)');
                    counts[fieldId] = (counts[fieldId] || 0) + (isAvailable ? 1 : 0);
                    return counts;
                }, {});

                const availableScheduleCountSpans = document.querySelectorAll('.available-schedule-count');
                availableScheduleCountSpans.forEach(span => {
                    const fieldId = span.closest('.toggle-schedules').dataset.fieldId;
                    span.textContent = `${availableScheduleCounts[fieldId] || 0} Jadwal Tersedia`;
                });
            }

            const thumbnails = document.querySelectorAll('.absolute img');
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', (e) => {
                    changeMainImage(e.target.src);
                });
            });

            document.getElementById('checkAvailabilityBtn').addEventListener('click', function() {
                document.getElementById('fieldSelection').scrollIntoView({
                    behavior: 'smooth'
                });
            });

            function toggleSchedules() {
                const fieldId = this.dataset.fieldId;
                const scheduleContainer = document.querySelector(
                    `.field-schedules[data-field-id="${fieldId}"]`);
                scheduleContainer.classList.toggle('hidden');
            }

            function handleScheduleFormSubmit(event, form) {
                event.preventDefault(); // Prevent the default form submission

                let formData = new FormData(form);
                formData.append('date', dateInput.value);

                fetch('{{ route('manage-cart') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'success',
                                title: data.message,
                            });

                            let fieldId = form.closest('.field-schedules').getAttribute('data-field-id');
                            let schedulesContainer = document.querySelector(
                                `.field-schedules[data-field-id="${fieldId}"]`);
                            schedulesContainer.innerHTML = data.html;

                            initializeEventListeners(schedulesContainer);
                        } else if (data.error) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'error',
                                title: data.error,
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            function initializeEventListeners(container) {
                // Re-attach event listeners for .schedule-form
                container.querySelectorAll('.schedule-form').forEach(form => {
                    form.addEventListener('submit', (event) => handleScheduleFormSubmit(event, form));
                });

                // Re-attach event listeners for .toggle-schedules
                container.querySelectorAll('.toggle-schedules').forEach(button => {
                    button.addEventListener('click', toggleSchedules);
                });
            }

            initializeEventListeners(document);
        });
    </script>
@endsection
