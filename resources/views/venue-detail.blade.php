@extends('layouts.app')

@section('content')

    <div>
    <div class="carousel relative w-full max-w-lg mx-auto mt-10">
        <div class="carousel-inner relative w-full">
            <div class="carousel-item active absolute w-full">
                <img src="https://asset.ayo.co.id/image/venue/170902029479080.image_cropper_9F999465-83E5-49C2-97BB-3BA533CF9915-1905-000000DD24536E28_large.jpg" class="block w-full h-auto" alt="Slide 1">
            </div>
            <div class="carousel-item absolute w-full hidden">
                <img src="hhttps://asset.ayo.co.id/image/venue/170902029479080.image_cropper_9F999465-83E5-49C2-97BB-3BA533CF9915-1905-000000DD24536E28_large.jpg" class="block w-full h-auto" alt="Slide 2">
            </div>
            <div class="carousel-item absolute w-full hidden">
                <img src="hhttps://asset.ayo.co.id/image/venue/170902029479080.image_cropper_9F999465-83E5-49C2-97BB-3BA533CF9915-1905-000000DD24536E28_large.jpg" class="block w-full h-auto" alt="Slide 3">
            </div>
        </div>
        <button class="prev absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-2">
            Prev
        </button>
        <button class="next absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-2">
            Next
        </button>
    </div>
    </div>

@endsection

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const items = document.querySelectorAll('.carousel-item');
            let currentItem = 0;

            function showSlide(index) {
                items.forEach((item, i) => {
                    item.classList.remove('active');
                    item.classList.add('hidden');
                    if (i === index) {
                        item.classList.add('active');
                        item.classList.remove('hidden');
                    }
                });
            }

            document.querySelector('.next').addEventListener('click', () => {
                currentItem = (currentItem + 1) % items.length;
                showSlide(currentItem);
            });

            document.querySelector('.prev').addEventListener('click', () => {
                currentItem = (currentItem - 1 + items.length) % items.length;
                showSlide(currentItem);
            });

            showSlide(currentItem);
        });
    </script>
</body>

</html> --}}
