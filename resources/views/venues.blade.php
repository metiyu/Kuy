@extends('layouts.app')

@section('content')
    <div class="flex place-content-center w-screen">
        <div class="grid grid-cols-3 p-32 max-w-screen-xl">
            @foreach ($venues as $v)
                <div class="p-2 mt-3">
                    <a href="/venue/{{ $v->id }}" class="text-black">
                        <div
                            class="card w-full border-none rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-200">
                            <img src="{{ $v->fields[0]->picture }}"
                                class="w-full h-60 object-cover" alt="Lapangan Generasi Baru">
                            <div class="p-4 border">
                                <div>
                                    <p class="text-sm font-medium tracking-wider text-gray-400">Venue</p>
                                </div>
                                <p class="text-xl text-left font-medium truncate">{{ $v->name }}</p>
                                <div class="flex items-center py-2">
                                    {{-- <span class="flex pb-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                            class="w-4 h-4 fill-yellow-500">
                                            <path fill-rule="evenodd"
                                                d="M8 1.75a.75.75 0 0 1 .692.462l1.41 3.393 3.664.293a.75.75 0 0 1 .428 1.317l-2.791 2.39.853 3.575a.75.75 0 0 1-1.12.814L7.998 12.08l-3.135 1.915a.75.75 0 0 1-1.12-.814l.852-3.574-2.79-2.39a.75.75 0 0 1 .427-1.318l3.663-.293 1.41-3.393A.75.75 0 0 1 8 1.75Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span> --}}
                                    <p class="text-sm tracking-wider text-gray-500 pl-1">📍</p>
                                    <p class="text-sm tracking-wider text-gray-500">{{ $v->location }}</p>
                                </div>
                                <div class="inline-flex items-center text-sm font-normal text-gray-400">
                                    @foreach ($v->sports as $s)
                                        <div class="flex items-center">
                                            <img src="{{ $s->icon }}" alt="{{ $s->name }}" class="h-5 pb-1 mr-1">
                                            <p class="text-xs tracking-wider text-gray-500 pb-0.5">{{ $s->name }}</p>
                                        </div>
                                        <p class="text-sm tracking-wider text-gray-500 px-1">·</p>
                                    @endforeach
                                </div>
                                <p class="text-sm font-normal text-gray-500 mt-3 mb-0"></p>
                                <p class="text-sm font-normal mb-0">
                                    <span>Mulai </span>
                                    <span class="text-xl font-medium text-gray-800">{{ $v->getMinimumPriceField()->formatted_price }}</span>
                                    <span class="text-gray-500">/ sesi</span>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
