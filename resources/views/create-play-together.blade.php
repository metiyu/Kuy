@extends('layouts.app')

@section('content')
    <style>
        /* Custom CSS to hide number input arrows */
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
            /* Firefox */
        }
    </style>

    <div class="flex pt-16">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-6">Kuy buat main bareng!</h1>
            <form action="{{ route('simpan-main-bareng') }}" method="POST" enctype="multipart/form-data" class="max-w-xl">
                @csrf
                <div class="mb-4">
                    <input required type="text" name="nama" placeholder="Nama Main Bareng" value="{{ old('nama') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
                <div class="mb-4">
                    <input required type="text" name="desc" placeholder="Deskripsi Main Bareng"
                        value="{{ old('desc') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
                <div class="mb-4">
                    <input required type="text" name="price" placeholder="Biaya Registrasi Main Bareng"
                        value="{{ old('price') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                        onkeyup="formatRupiah(this)">
                </div>
                <div class="mb-4 flex justify-between items-center">
                    <label for="slot">Slot Peserta</label>
                    <div class="flex items-center space-x-2">
                        <button type="button" onclick="decrement(event)"
                            class="bg-gray-300 text-gray-800 px-3 py-1 rounded focus:ring-red-500">
                            -
                        </button>
                        <input type="number" id="slot" name="slot" min="0" value="{{ old('slot') ? old('slot') : 0}}"
                            class="w-16 text-center border border-gray-300 rounded focus:ring-red-500">
                        <button type="button" onclick="increment(event)"
                            class="bg-gray-300 text-gray-800 px-3 py-1 rounded focus:ring-red-500">
                            +
                        </button>
                    </div>
                </div>
                <div class="mb-4 flex justify-between items-center">
                    <label for="sport">Kategori Olahraga</label>
                    <div>
                        <select required id="sport" name="sport" class="block w-full rounded-lg focus:ring-red-500">
                            <option selected hidden disabled value="">Pilih disini</option>
                            @foreach ($sports as $s)
                                <option value="{{ $s->id }}" {{ $s->id == old('sport') ? 'selected' : '' }}>
                                    {{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-4 flex justify-between items-center">
                    <label for="date">Tanggal Main Bareng</label>
                    <input required type="date" name="date" id="date" value="{{ old('date') }}"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
                <div class="mb-4">
                    <div class="flex items-center">
                        <label for="jadwal_booking">Pilih Jadwal Booking</label>
                        <div class="relative ml-2">
                            <div id="tooltip" class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white p-3 rounded shadow-lg w-64 hidden">
                                <p class="text-sm">
                                    Pastikan jadwal yang Anda pilih dari venue yang sama dan tipe lapangan sama dengan kategori olahraga
                                </p>
                            </div>
                            <button type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none" onclick="toggleBookingTooltip()">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="15" height="15" viewBox="0 0 30 30">
                                    <path d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M16,21h-2v-7h2V21z M15,11.5 c-0.828,0-1.5-0.672-1.5-1.5s0.672-1.5,1.5-1.5s1.5,0.672,1.5,1.5S15.828,11.5,15,11.5z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div id="info" class="bg-gray-300 px-4 py-3 mt-2 shadow-sm rounded-lg hidden">
                        <div class="flex">
                            <div class="py-[2px] mr-1">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="15" height="15" viewBox="0 0 30 30">
                                    <path d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M16,21h-2v-7h2V21z M15,11.5 c-0.828,0-1.5-0.672-1.5-1.5s0.672-1.5,1.5-1.5s1.5,0.672,1.5,1.5S15.828,11.5,15,11.5z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm">Pilih tanggal main bareng terlebih dahulu</p>
                            </div>
                        </div>
                    </div>

                    <div id="transactions-container" class="mt-2"></div>
                </div>
                <div>
                    <button type="submit"
                        class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition duration-300">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function increment(event) {
            event.preventDefault();
            var input = document.getElementById('slot');
            input.value = parseInt(input.value) + 1;
        }

        function decrement(event) {
            event.preventDefault();
            var input = document.getElementById('slot');
            if (input.value > 0) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function formatRupiah(input) {
            let value = input.value.replace(/\D/g, '');
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            value = 'Rp ' + value;
            input.value = value;
        }

        function toggleBookingTooltip() {
            const tooltip = document.getElementById('tooltip');
            tooltip.classList.toggle('hidden');
        }

        document.getElementById('date').addEventListener('change', fetchTransactions);

        function fetchTransactions() {
            const date = document.getElementById('date').value;
            const info = document.getElementById('info');
            info.classList.add('hidden');
            if (date) {
                fetch(`/get-transactions?date=${date}`, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        let transactionsContainer = document.getElementById('transactions-container');
                        transactionsContainer.innerHTML = ''; // Clear previous content

                        if (data.length > 0) {
                            // Group transactions by venue ID
                            let transactionsByVenue = {};
                            data.forEach(transaction => {
                                if (!transactionsByVenue[transaction.venue_id]) {
                                    transactionsByVenue[transaction.venue_id] = {
                                        venue_name: transaction.venue_name,
                                        schedules: []
                                    };
                                }
                                transactionsByVenue[transaction.venue_id].schedules.push(transaction);
                            });

                            // Create accordion for each venue
                            Object.keys(transactionsByVenue).forEach(venueId => {
                                let venueTransactions = transactionsByVenue[venueId];

                                // Create accordion wrapper
                                let accordionWrapper = document.createElement('div');
                                accordionWrapper.classList.add('border', 'border-gray-200', 'rounded', 'mb-4');

                                // Accordion button
                                let accordionButton = document.createElement('button');
                                accordionButton.setAttribute('type', 'button');
                                accordionButton.classList.add('flex', 'items-center', 'justify-between',
                                    'w-full', 'text-left', 'px-4', 'py-2', 'bg-gray-200', 'rounded-t',
                                    'hover:bg-gray-300', 'focus:outline-none');
                                accordionButton.addEventListener('click', (event) => {
                                    event.preventDefault();
                                    accordionContent.classList.toggle('hidden');
                                });

                                // Down arrow icon as img tag
                                let downArrowIcon = document.createElement('img');
                                downArrowIcon.setAttribute('src',
                                    'https://img.icons8.com/pastel-glyph/64/expand-arrow.png');
                                downArrowIcon.setAttribute('alt', 'expand-arrow');
                                downArrowIcon.setAttribute('width', '24');
                                downArrowIcon.setAttribute('height', '24');

                                // Text content
                                let buttonText = document.createElement('span');
                                console.log(venueTransactions);
                                buttonText.textContent = `Venue: ${venueTransactions.venue_name}`;

                                accordionButton.appendChild(buttonText);
                                accordionButton.appendChild(downArrowIcon);
                                accordionWrapper.appendChild(accordionButton);

                                // Accordion content
                                let accordionContent = document.createElement('div');
                                accordionContent.classList.add('hidden', 'px-4', 'py-2', 'bg-gray-100',
                                    'rounded-b');
                                venueTransactions.schedules.forEach(transaction => {
                                    let checkboxDiv = document.createElement('div');
                                    checkboxDiv.classList.add('flex', 'items-center', 'mb-2');
                                    console.log(transaction);
                                    let checkboxElement = document.createElement('input');
                                    checkboxElement.setAttribute('type', 'checkbox');
                                    checkboxElement.setAttribute('id',
                                        `schedule_${transaction.schedule_id}`);
                                    checkboxElement.setAttribute('name', 'schedule[]');
                                    checkboxElement.setAttribute('value', transaction.schedule_id);
                                    checkboxElement.classList.add('mr-2', 'h-4', 'w-4', 'text-red-600',
                                        'focus:ring-red-500', 'border-gray-300', 'rounded');

                                    let label = document.createElement('label');
                                    label.setAttribute('for', `schedule_${transaction.schedule_id}`);
                                    label.classList.add('text-sm', 'text-gray-700', 'px-2');
                                    label.textContent =
                                        `${formatDate(transaction.schedule_date)} • ${transaction.schedule_start_hour} - ${transaction.schedule_end_hour} (${transaction.field_name}: ${transaction.sport_name})`;

                                    checkboxDiv.appendChild(checkboxElement);
                                    checkboxDiv.appendChild(label);
                                    accordionContent.appendChild(checkboxDiv);
                                });
                                accordionWrapper.appendChild(accordionContent);

                                transactionsContainer.appendChild(accordionWrapper);
                            });
                        } else {
                            transactionsContainer.innerHTML = `
                            <div id="info" class="bg-red-200 px-4 py-3 shadow-sm rounded-lg">
                                <div class="flex">
                                    <div class="py-[2px] mr-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="15" height="15"
                                            viewBox="0 0 48 48">
                                            <path fill="#f44336"
                                                d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z">
                                            </path>
                                            <path fill="#fff"
                                                d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path>
                                            <path fill="#fff"
                                                d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm">Tidak ada jadwal booking di tanggal tersebut</p>
                                    </div>
                                </div>
                            </div>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching transactions:', error);
                    });
            }
        }

        function formatDate(dateString) {
            let date = new Date(dateString);
            let day = date.getDate();
            let month = date.toLocaleString('default', {
                month: 'short'
            });
            let year = date.getFullYear();
            return `${day} ${month} ${year}`;
        }
    </script>
@endsection
