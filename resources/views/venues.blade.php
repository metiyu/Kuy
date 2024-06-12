@extends('layouts.app')

@section('content')
    <div class="flex flex-col justify-center items-center w-screen p-24 bg-gray-100">
        <form action="{{ route('venues') }}" method="GET" class="w-full flex justify-center">
            <div class="flex w-11/12 pl-[6px] justify-between">
                <div class="flex items-center rounded-lg border border-gray-300 w-10/12 bg-white pl-2">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M3.14811 9.80524C3.14811 6.12861 6.12861 3.14811 9.80524 3.14811C13.4819 3.14811 16.4624 6.12861 16.4624 9.80524C16.4624 13.4819 13.4819 16.4624 9.80524 16.4624C6.12861 16.4624 3.14811 13.4819 3.14811 9.80524ZM9.80524 1.48145C5.20814 1.48145 1.48145 5.20814 1.48145 9.80524C1.48145 14.4024 5.20814 18.129 9.80524 18.129C11.7045 18.129 13.4551 17.493 14.8558 16.4222L17.3632 18.9231C17.689 19.2481 18.2167 19.2474 18.5417 18.9216C18.8667 18.5957 18.866 18.0681 18.5402 17.7431L16.0732 15.2825C17.3533 13.8188 18.129 11.9026 18.129 9.80524C18.129 5.20814 14.4024 1.48145 9.80524 1.48145Z"
                            fill="#A0A4A8"></path>
                    </svg>
                    <input type="text" name="search" class="border-none w-full focus:outline-none ring-0 rounded-r-lg ml-1"
                        placeholder="Cari Venue" value="{{ request('search') }}">
                </div>
                <button class="flex justify-end" type="submit">
                    <div class="bg-red-800 text-white px-12 mr-2 py-2 rounded-lg hover:bg-red-700 transition duration-200">Cari
                        venue</div>
                </button>
            </div>
        </form>
        <div class="grid grid-cols-3 w-11/12">
            @foreach ($venues as $v)
                <div class="p-2 mt-3">
                    <a href="/venue/{{ $v->id }}" class="text-black">
                        <div
                            class="card w-full border-none rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-200">
                            <img src="{{ $v->fields[0]->picture }}" class="w-full h-60 object-cover"
                                alt="Lapangan Generasi Baru">
                            <div class="p-4 border">
                                <div>
                                    <p class="text-sm font-medium tracking-wider text-gray-400">Venue</p>
                                </div>
                                <p class="text-xl text-left font-medium truncate">{{ $v->name }}</p>
                                <div class="flex items-center py-2">
                                    <p class="text-sm tracking-wider text-gray-500 pl-1">📍</p>
                                    <p class="text-sm tracking-wider text-gray-500">{{ $v->location }}</p>
                                </div>
                                <div class="inline-flex items-center text-sm font-normal text-gray-400">
                                    @foreach ($v->sports as $s)
                                        @if (!$loop->first)
                                            <p class="text-sm tracking-wider text-gray-500 px-1">·</p>
                                        @endif
                                        <div class="flex items-center">
                                            <img src="{{ $s->icon }}" alt="{{ $s->name }}" class="h-5 pb-1 mr-1">
                                            <p class="text-xs tracking-wider text-gray-500 pb-0.5">{{ $s->name }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-sm font-normal text-gray-500 mt-3 mb-0"></p>
                                <p class="text-sm font-normal mb-0">
                                    <span>Mulai </span>
                                    <span
                                        class="text-xl font-medium text-gray-800">{{ $v->getMinimumPriceField()->formatted_price }}</span>
                                    <span class="text-gray-500">/ jam</span>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="flex justify-center pt-14">
            {{ $venues->links('vendor.pagination.tailwind') }}
            {{-- {{ $venues->appends(request()->search())->links('vendor.pagination.tailwind') }} --}}
        </div>
    </div>
@endsection
