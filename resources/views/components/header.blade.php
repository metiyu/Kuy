<div class="fixed top-0 bg-white shadow-md z-50 w-full">
    <div class="relative z-20">
        <div
            class="max-w-7xl mx-auto flex justify-between items-center px-4 py-5 sm:px-6 sm:py-4 lg:px-8 md:justify-start md:space-x-10">
            <div>
                <a href="/" class="flex">
                    <span class="sr-only">Workflow</span>
                    <img class="h-8 w-auto sm:h-10" src="/assets/logotype.png" alt="">
                </a>
            </div>
            <div class="-mr-2 -my-2 md:hidden">
                <button type="button"
                    class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-800"
                    aria-expanded="false" id="open-btn">
                    <span class="sr-only">Open menu</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <div class="hidden md:flex-1 md:flex md:items-center md:justify-between">
                <nav class="flex space-x-10">
                    <a href="/venues" class="text-base font-medium text-gray-500 hover:text-gray-900">
                        Sewa Lapangan
                    </a>
                    <a href="/main-bareng" class="text-base font-medium text-gray-500 hover:text-gray-900">
                        Main Bareng
                    </a>
                </nav>
                <div class="flex items-center md:ml-12">
                    @if (auth()->check())
                        <button type="button"
                            class="bg-white rounded-md p-2 inline-flex items-center justify-center text-black hover:text-black hover:bg-gray-100"
                            aria-expanded="false">
                            <button type="button" id="cartButton"
                                class="bg-white rounded-md p-2 inline-flex items-center justify-center text-black hover:text-black hover:bg-gray-100">
                                <span class="sr-only">Cart</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </button>
                        </button>
                        <div class="relative pl-1" style="box-shadow: 0.3px 0 #888888 inset;">
                            <button type="button"
                                class="bg-white rounded-md p-2 inline-flex items-center justify-center text-black hover:text-black hover:bg-gray-100"
                                aria-expanded="false" id="profile-btn">
                                <span class="sr-only">Profile</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </button>
                            <div class="hidden absolute w-48 z-30 top-11 right-0 bg-white rounded-lg"
                                id="profile-modal">
                                <div class="rounded-lg shadow-lg  bg-white divide-y-2 divide-gray-50">
                                    <div class="py-3 px-2 rounded-lg">
                                        <div class="grid grid-cols-1">
                                            <a href="{{ route('transaksi') }}"
                                                class="flex p-3 rounded-lg text-base font-medium text-gray-900 hover:text-gray-700 hover:bg-gray-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                                </svg>
                                                Transaksi
                                            </a>
                                            <form action="{{ route('keluar') }}" method="POST">
                                                @csrf
                                                <button
                                                    class="flex p-3 rounded-lg text-base font-medium text-gray-900 hover:text-gray-700 hover:bg-gray-100 w-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                                    </svg>
                                                    Keluar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center md:pl-4">
                            <button id="signInOpenModalBtn"
                                class="text-base font-medium text-gray-500 hover:text-gray-900">
                                Sign in
                            </button>
                            <button id="signUpOpenModalBtn"
                                class="ml-4 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-red-800 hover:bg-red-700">
                                Sign up
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hidden">
    <a href="#" class="flex rounded-md text-base font-medium text-gray-900 hover:text-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
        </svg>
        Profile
    </a>
    <a href="#" class="flex rounded-md text-base font-medium text-gray-900 hover:text-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
        </svg>
        History
    </a>
    <a href="#" class="flex rounded-md text-base font-medium text-gray-900 hover:text-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
        </svg>
        Sign Out
    </a>
</div>

<div id="modalOverlay" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-[9998]"></div>

<!-- Side Component -->
<div id="sideComponent"
    class="hidden fixed top-0 right-0 h-screen bg-white transform transition-transform duration-300 ease-in-out z-[9999] w-96 overflow-auto">
    @include('components.cart')
</div>

<div id="signInModal" class="hidden">
    @include('modals.sign-in')
</div>

<div id="signUpModal" class="hidden">
    @include('modals.sign-up')
</div>

<script>
    const signInModal = document.getElementById('signInModal');
    const signUpModal = document.getElementById('signUpModal');
    const signUpOpenModalBtn = document.getElementById('signUpOpenModalBtn');
    const signInOpenModalBtn = document.getElementById('signInOpenModalBtn');
    const changeToSignUpOpenModalBtn = document.getElementById('changeToSignUpOpenModalBtn');
    const changeToSignInOpenModalBtn = document.getElementById('changeToSignInOpenModalBtn');
    const overlay = document.getElementById('modalOverlay');
    const cartButton = document.getElementById('cartButton');
    const sideComponent = document.getElementById('sideComponent');
    const closeButton = document.getElementById('closeButton');
    const profileModal = document.getElementById('profile-modal');
    const profileButton = document.getElementById('profile-btn');
    const body = document.body;

    if (signUpOpenModalBtn) {
        signUpOpenModalBtn.addEventListener('click', () => {
            signInModal.classList.add('hidden');
            signUpModal.classList.remove('hidden');
            overlay.classList.remove('hidden');
        });
    }

    if (signInOpenModalBtn) {
        signInOpenModalBtn.addEventListener('click', () => {
            signUpModal.classList.add('hidden');
            signInModal.classList.remove('hidden');
            overlay.classList.remove('hidden');
        });
    }

    if (changeToSignUpOpenModalBtn) {
        changeToSignUpOpenModalBtn.addEventListener('click', () => {
            signInModal.classList.add('hidden');
            signUpModal.classList.remove('hidden');
            overlay.classList.remove('hidden');
        });
    }

    if (changeToSignInOpenModalBtn) {
        changeToSignInOpenModalBtn.addEventListener('click', () => {
            signUpModal.classList.add('hidden');
            signInModal.classList.remove('hidden');
            overlay.classList.remove('hidden');
        });
    }

    if (cartButton) {
        cartButton.addEventListener('click', () => {
            sideComponent.classList.remove('hidden');
            overlay.classList.remove('hidden');
            body.classList.remove('overflow-hidden');
        });
    }

    if (closeButton) {
        closeButton.addEventListener('click', () => {
            sideComponent.classList.add('hidden');
            overlay.classList.add('hidden');
            body.classList.add('overflow-hidden');
        });
    }

    if (profileButton) {
        profileButton.addEventListener('click', function() {
            profileModal.classList.toggle('hidden');
        })
    }

    overlay.addEventListener('click', () => {
        signUpModal.classList.add('hidden');
        signInModal.classList.add('hidden');
        overlay.classList.add('hidden');
        if (sideComponent) {
            sideComponent.classList.add('hidden');
            body.classList.add('overflow-hidden');
        }
    });
</script>

{{-- <script src="{{ asset('scripts/header.js') }}"></script> --}}

<style>
    .swal2-custom-zindex {
        z-index: 9999 !important;
    }
</style>


@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($errors->all() as $error)
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'error',
                    title: '{{ $error }}',
                    customClass: {
                        container: 'swal2-custom-zindex'
                    }
                });
            @endforeach

            @if (session()->has('openSignUpModal'))
                @if (session('openSignUpModal') === true)
                    signUpModal.classList.remove('hidden');
                    overlay.classList.remove('hidden');
                @endif
            @endif

            @if (session()->has('openSignInModal'))
                @if (session('openSignInModal') === true)
                    signInModal.classList.remove('hidden');
                    overlay.classList.remove('hidden');
                @endif
            @endif
        });
    </script>
@endif
