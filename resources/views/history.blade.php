@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center py-24 w-full bg-gray-100">
        <div class="grid grid-cols-3 gap-8 w-10/12">
            <div class="flex flex-col rounded-xl bg-white p-10 shadow-lg w-full h-min col-span-2">
                <p class="text-xl font-medium mb-8">Transaksi</p>
                @foreach ($transactions as $transaction)
                    <div
                        class="border-l-8 border-red-800 bg-white rounded-lg shadow-md py-4 px-2 mb-4 flex flex-col items-start justify-between min-w-full">
                        <button class="" type="button" onclick="toggleAccordion({{ $transaction->id }})"
                            class="accordion-button">
                            <div class="flex flex-col items-start">
                                <span class="text-base font-medium mb-1">Transaksi No.{{ $transaction->id }}</span>
                                <span class="text-sm">{{ $transaction->getFormattedDateAttribute() }}</span>
                                <span class="text-sm">Payment Method: {{ $transaction->payment_method }}</span>
                            </div>
                        </button>
                        <div id="accordion-content-{{ $transaction->id }}" class="accordion-content hidden">
                            <div class="grid grid-cols-2 gap-5">
                                @foreach ($transaction->transaction_details as $detail)
                                    <div
                                        class="border-l-8 border-red-800 bg-white rounded-lg shadow-md py-1 px-2 ml-5 mt-3 items-center justify-between min-w-full">
                                        <div class="flex items-center">
                                            <img src="{{ $detail->schedule->field->sport->icon }}"
                                                alt="{{ $detail->schedule->field->sport->name }}" class="h-5 pb-1 mr-1">
                                            <p class="text-xs tracking-wider text-gray-500 pb-0.5">
                                                {{ $detail->schedule->field->sport->name }}</p>
                                        </div>
                                        <p class="text-base font-medium mb-1">{{ $detail->schedule->field->venue->name }}
                                        </p>
                                        <span class="text-sm">{{ $detail->schedule->field->name }}</span>
                                        <span class="text-sm mx-1">·</span>
                                        <span class="text-sm">{{ $detail->schedule->getFormattedDateAttribute() }}</span>
                                        <p class="text-sm">{{ substr($detail->schedule->start_hour, 0, 5) }} -
                                            {{ substr($detail->schedule->end_hour, 0, 5) }}</p>
                                        <p class="text-sm">{{ $detail->schedule->field->formatted_price }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex flex-col rounded-xl bg-white p-10 shadow-lg w-full h-min">
                <p class="text-xl font-medium mb-8">Main Bareng</p>
                @foreach ($playTogethers as $playTogether)
                    <div
                        class="border-l-8 border-red-800 bg-white rounded-lg shadow-md py-4 px-2 mb-4 flex flex-col items-start justify-between min-w-full">
                        <button class="" type="button"
                            class="accordion-button">
                            <div class="flex flex-col items-start">
                                @if ($playTogether->user_id == $playTogether->play_together->owner_id)
                                    <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded mb-1">Owner</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded mb-1">Member</span>
                                @endif
                                <div class="flex items-center">
                                    <img src="{{ $playTogether->play_together->sport->icon }}"
                                        alt="{{ $playTogether->play_together->sport->name }}" class="h-5 pb-1 mr-1">
                                    <p class="text-xs tracking-wider text-gray-500 pb-0.5">
                                        {{ $playTogether->play_together->sport->name }}</p>
                                </div>
                                <span class="text-sm">Main Bareng No.{{ $playTogether->play_together->id }}</span>
                                <span class="text-base font-medium mb-1">{{ $playTogether->play_together->name }}</span>
                                <span class="text-sm">{{ $playTogether->play_together->getFormattedDateAttribute() }}</span>
                            </div>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        function toggleAccordion(id) {
            let content = document.getElementById('accordion-content-' + id);
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
            } else {
                content.classList.add('hidden');
            }
        }
    </script>
@endsection
