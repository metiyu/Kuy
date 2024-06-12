@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen pt-16">
        <div class="container mx-auto py-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-start m-4">
                    <div class="flex flex-col">
                        <div class="flex items-center mb-4">
                            <div class="flex justify-center items-center bg-red-100 border-4 border-red-800 rounded-lg py-[2px] px-3 font-medium"
                                style="font-size: 12px">
                                <span class="mt-[3px] inline-flex items-center">
                                    <img src="{{ $playTogether->sport->icon }}" alt="{{ $playTogether->sport->name }}"
                                        class="h-6 pb-1 mr-1">
                                </span>
                                {{ $playTogether->sport->name }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <h1 class="text-3xl font-bold">{{ $playTogether->name }}</h1>
                        </div>
                        <div class="flex items-center mb-4">
                            <div class="mr-4">
                                <div class="bg-red-100 border-4 border-red-800 text-black py-1 pl-3 rounded-lg inline-flex justify-between items-center font-medium w-full cursor-pointer"
                                    onclick="toggleAccordion(event)">
                                    <div class="flex items-center">
                                        {{ $playTogether->play_together_details->count('user_count') }}/{{ $playTogether->player_slot }}
                                        Bergabung
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="mt-[2px] transition-transform arrow-icon" width="25" height="25"
                                            viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.5 4L6.89645 5.39645C7.09171 5.59171 7.09171 5.90829 6.89645 6.10355L5.5 7.5"
                                                stroke="#9E0620" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="accordion-content hidden">
                                    <div id="players">
                                        @foreach ($players as $p)
                                            <div
                                                class="flex justify-between items-center border-x-4 pl-1 pr-1 bg-red-100 border-red-800 {{ !next($players) ? 'border-b-4 rounded-b-lg' : '' }}">
                                                <p>
                                                    {{ $p->full_name }}
                                                </p>
                                                @if (auth()->check())
                                                    @if ($playTogether->owner_id !== $p->id)
                                                        <form action="{{ route('remove-player') }}" method="POST">
                                                            @csrf
                                                            <input type="text" name="play_together_id" value="{{ $playTogether->id }}" hidden>
                                                            <input type="text" name="user_id" value="{{ $p->id }}" hidden>
                                                            <button type="submit" class="pt-1">
                                                                <svg height="16px" id="Layer_1"
                                                                    style="enable-background:new 0 0 512 512;"
                                                                    version="1.1" viewBox="0 0 512 512" width="16px"
                                                                    xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                    <g>
                                                                        <path
                                                                            d="M256,32C132.3,32,32,132.3,32,256s100.3,224,224,224s224-100.3,224-224S379.7,32,256,32z M384,272H128v-32h256V272z" />
                                                                    </g>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-lg font-medium">Tentang Mabar</h3>
                            <p>{{ $playTogether->description }}</p>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-lg font-medium">Lokasi</h3>
                            @foreach ($playTogether->getLocations() as $loc)
                                <p>📍 {{ $loc }}</p>
                            @endforeach
                        </div>
                        <div class="mt-2">
                            <h3 class="text-lg font-medium mb-2">Dibuat oleh:</h3>
                            <p>{{ $playTogether->owner->full_name }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col mr-10">
                        <div id="countdown" class="mb-3 hidden"></div>
                        <div class="flex items-end">
                            <p class="text-xl font-bold">{{ $playTogether->getFormattedPriceAttribute() }}</p>
                            <p class="text-xs font-normal text-gray-500 pb-[4px]"> /peserta</p>
                        </div>
                        <div class="mb-4">
                            <form action="{{ route('ikut-main-bareng') }}" method="POST">
                                @csrf
                                <input type="text" class="hidden" name="play_together_id"
                                    value="{{ $playTogether->id }}">
                                <button type="submit"
                                    class="w-full mt-4 bg-red-800 text-white py-2 px-4 rounded-lg font-semibold hover:bg-red-700 transition duration-300">
                                    Daftar Sekarang
                                </button>
                            </form>
                        </div>
                        <div class="flex items-center mb-4">
                            <img class="w-6 h-6" src="https://ayo.co.id/assets/Event_Details/calendar.png"
                                alt="Calendar icon" class="match-icon">
                            <div class="flex flex-col ml-2">
                                <p class="font-bold text-sm">Waktu & Tanggal</p>
                                <p class="text-sm">{{ $playTogether->getFormattedDateAttribute() }}</p>
                                <p class="text-sm">{{ substr($playTogether->start_hour, 0, 5) }} -
                                    {{ substr($playTogether->end_hour, 0, 5) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center mb-4">
                            <img class="w-6 h-6" src="https://ayo.co.id/assets/Event_Details/location.png"
                                alt="Location icon" class="match-icon">
                            <div class="flex flex-col ml-2">
                                <p class="font-bold text-sm">Lapangan</p>
                                @foreach ($playTogether->getFieldVenueDetails() as $f)
                                    <p class="text-sm">{{ $f->field_name }}</p>
                                    <p class="text-sm">{{ $f->venue_name }}</p>
                                    <p class="text-sm">{{ $f->venue_location }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleAccordion(event) {
            const accordionBtn = event.currentTarget;
            const accordionContent = event.currentTarget.nextElementSibling;
            const arrowIcon = event.currentTarget.querySelector('.arrow-icon');

            if (accordionBtn.classList.contains('rounded-lg')) {
                accordionBtn.classList.remove('rounded-lg');
                accordionBtn.classList.add('rounded-t-lg');
            } else {
                accordionBtn.classList.remove('rounded-t-lg');
                accordionBtn.classList.add('rounded-lg');
            }

            if (accordionBtn.classList.contains('border-4')) {
                accordionBtn.classList.remove('border-4');
                accordionBtn.classList.add('border-x-4');
                accordionBtn.classList.add('border-t-4');
                accordionBtn.classList.add('border-b-2');
            } else {
                accordionBtn.classList.remove('border-x-4');
                accordionBtn.classList.remove('border-t-4');
                accordionBtn.classList.remove('border-b-2');
                accordionBtn.classList.add('border-4');
            }
            accordionContent.classList.toggle('hidden');
            arrowIcon.classList.toggle('rotate-90');
        }

        // Get the scheduled date and time
        // const eventDate = new Date('2024-06-12T08:00:00');
        const date = '{{ $playTogether->date }}';
        const startHour = '{{ $playTogether->start_hour }}';
        const eventDate = new Date(`${date} ${startHour}`);

        // Function to update the countdown timer
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = eventDate - now;

            // Calculate days, hours, minutes, and seconds
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the countdown
            const countdownElement = document.getElementById('countdown');
            countdownElement.innerHTML = `
                <p>Main Bareng akan dimulai dalam:</p>
                <p class="border-2 rounded-lg border-red-600 text-center font-semibold">${days}d ${hours}h ${minutes}m ${seconds}s</p>
            `;

            // Update the countdown every second
            if (distance > 0) {
                countdownElement.style.display = 'block';
                setTimeout(updateCountdown, 1000);
            } else {
                console.log('hidde');
                countdownElement.style.display = 'hidden';
            }
        }

        // Call the updateCountdown function initially
        updateCountdown();
    </script>
@endsection
