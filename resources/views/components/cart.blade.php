<button id="closeButton" class="absolute top-2 right-2">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6">
        <path
            d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
    </svg>
</button>
<div class="m-6">
    <h5 class="text-center mb-4 font-semibold text-xl">Jadwal Dipilih</h5>
    @if ($carts->isEmpty())
        <p class="text-center mb-4 font-normal text-md">Belum ada jadwal di keranjang</p>
    @else
        <form action="{{ route('review-checkout') }}" method="POST">
            @csrf
            @foreach ($carts as $c)
                <div
                    class="border-l-8 border-red-800 bg-white rounded-lg shadow-md py-4 px-2 mb-4 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span>{{ $c->venue_name }}</span>
                        <span>{{ $c->field_name }}</span>
                        <span class="text-black font-normal text-sm">{{ $c->formatted_date }} •
                            {{ substr($c->schedule_start_hour, 0, 5) }} -
                            {{ substr($c->schedule_end_hour, 0, 5) }}</span>
                        <span class="text-gray-800 font-normal text-sm">{{ $c->formatted_price }}</span>
                        <input type="hidden" name="cart_data[]"
                            value="{{ json_encode([
                                'venue_name' => $c->venue_name,
                                'field_name' => $c->field_name,
                                'date' =>
                                    $c->formatted_date .
                                    ' • ' .
                                    substr($c->schedule_start_hour, 0, 5) .
                                    ' - ' .
                                    substr($c->schedule_end_hour, 0, 5),
                                'formatted_price' => $c->formatted_price,
                                'price' => $c->field_price,
                                'location' => $c->venue_location,
                                'schedule_id' => $c->schedule_id
                            ]) }}">
                    </div>
                </div>
            @endforeach
            <button type="submit" id="checkout"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-800 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Selanjutnya
            </button>
        </form>
    @endif
</div>
