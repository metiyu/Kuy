@extends('layouts.app')

@section('content')
    <div class="flex flex-col justify-center items-center w-screen p-24 bg-gray-100">
        <div class="container mx-auto p-8 bg-white rounded-lg shadow-lg">
            <div class="container mx-auto px-4 py-8">
                <h1 class="text-3xl font-bold mb-6">Kuy daftarkan venue-mu!</h1>
                <p class="text-gray-700 mb-6">
                    Terima kasih sudah mengunjungi website KUY. Daftarkan venue-mu dan nikmati kemudahannya!
                </p>
                <p class="text-gray-700 mb-6">
                    Sampaikan pertanyaan Anda disini. Tim kami akan menghubungi Anda secepatnya.
                </p>
                <form action="{{ route('simpan-venue') }}" method="POST" enctype="multipart/form-data" class="max-w-xl">
                    @csrf
                    <div class="mb-4">
                        <input required type="text" name="nama" placeholder="Nama Venue" value="{{ old('nama') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    <div class="mb-4">
                        <input required type="text" name="desc" placeholder="Deskripsi Venue"
                            value="{{ old('desc') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    <div class="mb-4">
                        <input required type="tel" name="location" placeholder="Lokasi Venue"
                            value="{{ old('location') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    <div class="flex flex-row mb-4 justify-evenly min-w-full gap-8">
                        <div class="flex flex-col w-full">
                            <label for="open_hour">Jam Buka</label>
                            <input required type="time" name="open_hour" value="{{ old('open_hour') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        <div class="flex flex-col w-full">
                            <label for="close_hour">Jam Tutup</label>
                            <input required type="time" name="close_hour" value="{{ old('close_hour') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold mb-4">Lapangan</h2>
                        <div id="fields-container"></div>
                        <button type="button" onclick="addField()"
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">Tambahkan</button>
                    </div>

                    <div>
                        <button type="submit"
                            class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition duration-300">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <template id="field-template">
        <div class="field-item border shadow-lg p-4 rounded-md mb-4">
            <h3 class="text-xl font-semibold mb-3">Detail Lapangan</h3>
            <div class="mb-4">
                <input required type="text" name="field-name[]" placeholder="Nama Lapangan"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>
            <label class="mb-2" for="">Tipe Lapangan</label>
            <div class="mb-4">
                <select required name="field-type[]" class="focus:outline-none focus:ring-red-500 focus:ring-2">
                    <option selected hidden disabled value="">Pilih disini</option>
                    @foreach ($sports as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <label class="mb-2" for="">Jenis Lapangan</label>
            <div class="flex flex-row mb-4 min-w-full gap-8 ml-4">
                <div class="flex items-center">
                    <input required type="radio" value="0" name="field-radio-[]"
                        class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label class="ms-2 text-sm font-medium">Indoor</label>
                </div>
                <div class="flex items-center">
                    <input required type="radio" value="1" name="field-radio-[]"
                        class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label class="ms-2 text-sm font-medium">Outdoor</label>
                </div>
            </div>
            <div class="mb-4">
                <input required type="text" name="field-price[]" placeholder="Harga Lapangan per jam"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                    onkeyup="formatRupiah(this)">
            </div>
            <div class="mb-4">
                <label class="block mb-2">Upload Field Pictures</label>
                <input type="file" name="field-picture[]" accept="image/*" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>
            <button type="button" onclick="removeField(this)"
                class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition duration-300">Hapus</button>
        </div>
    </template>

    <script>
        let fieldCounter = 0;

        function addField() {
            const template = document.getElementById('field-template').content.cloneNode(true);
            const radioButtons = template.querySelectorAll('input[type=radio]');
            radioButtons.forEach((radio, index) => {
                radio.name = `field-radio-${fieldCounter}`;
                radio.id = `field-radio-${fieldCounter}-${index}`;
            });

            const container = document.getElementById('fields-container');
            container.appendChild(template);
            fieldCounter++;
        }

        function removeField(button) {
            button.closest('.field-item').remove();
            fieldCounter--;
        }

        function formatRupiah(input) {
            let value = input.value.replace(/\D/g, '');
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            value = 'Rp ' + value;
            input.value = value;
        }
    </script>
@endsection
