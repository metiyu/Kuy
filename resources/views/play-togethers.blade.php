@extends('layouts.app')

@section('content')
    <div class="flex flex-col justify-center items-center w-screen p-24 bg-gray-100">
        <form action="{{ route('main-bareng') }}" method="GET" class="w-11/12 flex justify-center">
            <div class="flex w-11/12 pl-[6px] justify-between">
                <div class="flex items-center rounded-lg border border-gray-300 w-8/12 bg-white pl-2">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M3.14811 9.80524C3.14811 6.12861 6.12861 3.14811 9.80524 3.14811C13.4819 3.14811 16.4624 6.12861 16.4624 9.80524C16.4624 13.4819 13.4819 16.4624 9.80524 16.4624C6.12861 16.4624 3.14811 13.4819 3.14811 9.80524ZM9.80524 1.48145C5.20814 1.48145 1.48145 5.20814 1.48145 9.80524C1.48145 14.4024 5.20814 18.129 9.80524 18.129C11.7045 18.129 13.4551 17.493 14.8558 16.4222L17.3632 18.9231C17.689 19.2481 18.2167 19.2474 18.5417 18.9216C18.8667 18.5957 18.866 18.0681 18.5402 17.7431L16.0732 15.2825C17.3533 13.8188 18.129 11.9026 18.129 9.80524C18.129 5.20814 14.4024 1.48145 9.80524 1.48145Z"
                            fill="#A0A4A8"></path>
                    </svg>
                    <input type="text" name="search"
                        class="border-none w-full focus:outline-none ring-0 rounded-r-lg ml-1" placeholder="Cari Main Bareng"
                        value="{{ request('search') }}">
                </div>
                <button class="flex justify-end" type="submit">
                    <div class="bg-red-800 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200">
                        Cari Main Bareng</div>
                </button>
                <div class="flex justify-end">
                    <a href="/daftarkan-main-bareng"
                        class="bg-red-800 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200">Buat
                        Main Bareng</a>
                </div>
            </div>
        </form>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-10/12 pt-5">
            @foreach ($playTogethers as $pt)
                <a href="/main-bareng-detail/{{ $pt->id }}">
                    <div class="card bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition duration-200">
                        <span
                            class="border-4 border-red-800 rounded-lg bg-red-100 text-black py-[2px] px-3 inline-flex items-center font-semibold"
                            style="font-size: 11px">
                            <span class="mt-[3px] inline-flex items-center">
                                <img src="{{ $pt->sport->icon }}" alt="{{ $pt->sport->name }}" class="h-4 pb-1 mr-1">
                            </span>
                            {{ $pt->sport->name }}
                        </span>
                        <div class="text-black px-4 py-1 font-semibold">{{ $pt->name }}</div>
                        <div class="px-4 py-1">
                            <p class="text-gray-700 text-sm">{{ $pt->getFormattedDateAttribute() }} •
                                {{ $pt->getFormattedPriceAttribute() }}</p>
                            <p class="text-gray-700 text-sm">
                                {{ $pt->play_together_schedules->first()->schedule->field->venue->location }}</p>
                            <div class="flex items-center mt-2">
                                <!-- Avatar icons -->
                            </div>
                            <div
                                class="flex text-center {{ $pt->play_together_details->count('user_count') === $pt->player_slot ? 'bg-[#dc3327]' : 'bg-gray-600' }} text-white rounded-md p-1 mb-2">
                                <img src="https://ayo.co.id/assets/icon/new-user.png" class="w-4 mr-1 ml-2 mb-0"
                                    alt="New user icon">
                                <div class="text-xs text-center">
                                    <span>
                                        {{ $pt->play_together_details->count('user_count') }}/{{ $pt->player_slot }}
                                        Bergabung
                                        {{ $pt->play_together_details->count('user_count') === $pt->player_slot ? '(Full)' : '' }}
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="flex justify-center pt-14">
            {{ $playTogethers->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
