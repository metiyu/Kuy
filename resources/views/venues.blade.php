@extends('layouts.app')

@section('content')
    <div class="flex place-content-center w-screen">
        <div class="grid grid-cols-3 p-32 max-w-screen-xl">
            @for ($i = 0; $i < 5; $i++)
                <div class="p-2 mt-3">
                    <a href="https://ayo.co.id/v/lapangan-generasi-baru" class="text-black">
                        <div
                            class="card w-full border-none rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-200">
                            <img src="https://asset.ayo.co.id/image/venue/165528450821896.image_cropper_1655284384009_middle.jpg"
                                class="w-full h-60 object-cover" alt="Lapangan Generasi Baru">
                            <div class="p-4">
                                <div>
                                    <p class="text-sm font-medium tracking-wider text-gray-400">Venue</p>
                                </div>
                                <p class="text-xl text-left font-medium truncate">Lapangan Generasi Baru</p>
                                <div class="flex items-center py-2">
                                    <span class="flex pb-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                            class="w-4 h-4 fill-yellow-500">
                                            <path fill-rule="evenodd"
                                                d="M8 1.75a.75.75 0 0 1 .692.462l1.41 3.393 3.664.293a.75.75 0 0 1 .428 1.317l-2.791 2.39.853 3.575a.75.75 0 0 1-1.12.814L7.998 12.08l-3.135 1.915a.75.75 0 0 1-1.12-.814l.852-3.574-2.79-2.39a.75.75 0 0 1 .427-1.318l3.663-.293 1.41-3.393A.75.75 0 0 1 8 1.75Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <p class="text-sm tracking-wider text-gray-500 pl-1">4.73</p>
                                    <p class="text-sm tracking-wider text-gray-500 px-1">·</p>
                                    <p class="text-sm tracking-wider text-gray-500">Kota Jakarta Pusat</p>
                                </div>
                                <div class="inline-flex items-center text-sm font-normal text-gray-400">
                                    <div class="flex items-center">
                                        <img src="/assets/football.png" alt="Futsal" class="h-5 pb-1 mr-1">
                                        <p class="text-xs tracking-wider text-gray-500 pb-0.5">Futsal</p>
                                    </div>
                                    <p class="text-sm tracking-wider text-gray-500 px-1">·</p>
                                    <div class="flex items-center">
                                        <img src="/assets/basketball.png" alt="Basketball" class="h-5 pb-1 mr-1">
                                        <p class="text-xs tracking-wider text-gray-500 pb-0.5">Basketball</p>
                                    </div>
                                </div>
                                <p class="text-sm font-normal text-gray-500 mt-3 mb-0"></p>
                                <p class="text-sm font-normal mb-0">
                                    <span>Mulai </span>
                                    <span class="text-xl font-medium text-gray-800">Rp240,000</span>
                                    <span class="text-gray-500">/ sesi</span>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endfor
        </div>
    </div>
@endsection
