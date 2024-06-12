@extends('layouts.app')

@section('content')
    @php
        $totalPrice = 0;
    @endphp
    <div class="flex justify-center items-center">
        <div class="grid grid-cols-2 pt-28 gap-8 w-4/5">
            <div class="border shadow-lg p-10 rounded-lg min-w-full">
                <p class="text-xl font-medium">{{ $cartDataArray[0]['venue_name'] }}</p>
                <p class="text-sm">{{ $cartDataArray[0]['location'] }}</p>
                <div class="border-b-2 border-dashed my-8"></div>
                @foreach ($cartDataArray as $c)
                    @php
                        $totalPrice += $c['price'];
                    @endphp
                    <div
                        class="border-l-8 border-red-600 bg-white rounded-lg shadow-md py-4 px-2 mb-4 flex items-center justify-between">
                        <div class="flex flex-col">
                            <span>{{ $c['venue_name'] }}</span>
                            <span>{{ $c['field_name'] }}</span>
                            <span class="text-black font-normal text-sm">{{ $c['date'] }}</span>
                            <span class="text-gray-800 font-normal text-sm">{{ $c['formatted_price'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="grid grid-cols-1 grid-rows-6 gap-8">
                <div class="border shadow-lg p-10 rounded-lg row-span-5">
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <p class="text-xl font-medium">Rincian Biaya</p>
                        <div class="border-b-2 border-dashed my-8"></div>
                        <div class="flex justify-between mb-4">
                            <span>Biaya Sewa</span>
                            <span>{{ 'Rp' . number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <label class="mb-2" for="">Metode Pembayaran</label>
                            <div class="mb-4">
                                <select required name="payment-method"
                                    class="rounded-lg focus:outline-none focus:ring-red-500 focus:ring-2">
                                    <option selected hidden disabled value="">Pilih disini</option>
                                    <option value="QRIS">QRIS</option>
                                    <option value="Mobile Banking">Mobile Banking</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Credit Card">Credit Card</option>
                                </select>
                            </div>
                        </div>
                        <div class="border-b-2 border-dashed my-8"></div>
                        <div class="flex justify-between">
                            <span class="font-bold">Total Bayar</span>
                            <span>{{ 'Rp' . number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                        @foreach ($cartDataArray as $c)
                            <input type="hidden" name="schedule_ids[]" value="{{ $c['schedule_id'] }}">
                        @endforeach
                        <button type="submit"
                            class="bg-red-800 text-white px-6 py-2 rounded-md hover:bg-red-700 transition duration-300">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
