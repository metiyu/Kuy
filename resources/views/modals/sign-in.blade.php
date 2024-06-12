<div id="signInModal"
    class="modal w-1/4 fixed z-[9999] top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-5 rounded-lg shadow-md">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <div class="pb-8">
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Masuk
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Belum punya akun KUY?
                    <button id="changeToSignUpOpenModalBtn" class="font-medium text-red-600 hover:text-red-500">
                        Daftar
                    </button>
                </p>
            </div>
            <form class="space-y-6" action="{{ route('masuk') }}" method="POST">
                @csrf
                <div>
                    <div class="mt-1">
                        <input id="emailSignIn" name="emailSignIn" type="email" autocomplete="emailSignIn"
                            placeholder="Email" required value="{{ old('emailSignIn') }}"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                </div>
                <div>
                    <div class="mt-1">
                        <input id="passwordSignIn" name="passwordSignIn" type="password" autocomplete="current-password"
                            placeholder="Password" required value="{{ old('passwordSignIn') }}"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember_me" type="checkbox"
                            class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Selanjutnya
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
