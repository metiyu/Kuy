@extends('layouts.app')

@section('content')
    <div class="bg-white pt-18">
        <!-- Hero Section -->
        <div class="bg-red-800 pb-24 pt-40 border-b-4">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2">
                        <h1 class="text-6xl font-bold text-white mb-4">Super Sport Community App</h1>
                        <p class="text-white text-xl my-8">Platform all-in-one untuk sewa lapangan, cari lawan sparring, atau
                            cari
                            kawan main bareng. Olahraga makin mudah dan menyenangkan!</p>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <img src="{{ asset('assets/banner.png') }}" alt="Hero Image" class="max-w-lg">
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="flex flex-col justify-center">
                    <h2 class="text-3xl font-bold mb-4">Kelola venue lebih praktis dan menguntungkan.</h2>
                    <p class="mb-8">Jangan lewatkan peluang bagus untuk memaksimalkan potensi venue milikmu. Kuy
                        hadir untuk membantumu memasarkan venue lebih luas lagi.</p>
                    <a href="/daftarkan-venue" class="text-red-800 font-bold">Pelajari Lebih Lanjut &rarr;</a>
                </div>
                <img src="https://ayo.co.id/assets/img/venue-preview.png" alt="Feature Image 1" class="rounded-lg max-w-md">
            </div>
        </div>

        <!-- App Features Section -->
        <div class="px-4 py-16 border-t-4">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold mb-8 text-center">Cari teman main bareng hanya dalam ketukan jari.</h2>
                <div class="flex justify-center mb-8 gap-4">
                    <img src="https://img.antaranews.com/cache/1200x800/2024/01/06/abd68e34-bb87-4733-9af8-9b72b6325eae.jpg.webp" alt="App Feature Image" class="max-w-xs rounded-lg">
                    <img src="https://garuda.tv/wp-content/uploads/2023/12/gibran-bulu-tangkis-2048x1152.jpg" alt="App Feature Image" class="max-w-sm rounded-lg">
                    <img src="https://imgcdn.solopos.com/@space/2022/11/gibran-main-basket.jpg" alt="App Feature Image" class="max-w-xs rounded-lg">
                </div>
                <div class="flex justify-center items-center">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <a href="/main-bareng" class="bg-white p-6 rounded-lg shadow-lg">
                            <h3 class="text-xl font-bold mb-4">Temukan Teman Main</h3>
                            <p>Cari teman main bareng yang sesuai dengan preferensi Anda.</p>
                        </a>
                        <a href="/venues" class="bg-white p-6 rounded-lg shadow-lg">
                            <h3 class="text-xl font-bold mb-4">Sewa Lapangan Terdekat</h3>
                            <p>Akses ribuan lapangan olahraga di sekitar Anda dengan mudah.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
