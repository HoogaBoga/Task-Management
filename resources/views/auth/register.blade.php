<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Register</title>
</head>
<body class="bg-[url('/images/background.svg')] w-screen bg-fixed bg-cover bg-center bg-no-repeat">

    <div id="main-content" class="min-h-screen w-full flex items-center justify-center p-2">

        <div class="bg-white w-full p-1 rounded-[50px] shadow-xl mx-auto
                max-w-md md:max-w-4xl lg:max-w-5xl xl:max-w-6xl flex flex-col md:flex-row overflow-hidden">

            <div class="w-full md:w-1/2 p-8 md:p-12 lg:p-16">
                <div class="mb-8">
                    <img src="{{ asset('images/logo-krud.png') }}" alt="Logo Krud" class="h-8 w-auto">
                </div>

                <h1 class="text-3xl md:text-4xl font-bold mb-2 text-black font-krona">Welcome!!</h1>
                <h2 class="text-xl md:text-2xl font-semibold mb-8 text-black font-krona">Create your account</h2>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 boreder border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-black mb-1 font-inter">Username</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-1 border border-black rounded-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required autofocus>
                        @error('name')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-black mb-1 font-inter">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-1 border border-black rounded-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        @error('email')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-black mb-1 font-inter">Password</label>
                        <input id="password" type="password" name="password" class="w-full px-4 py-1 border border-black rounded-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        @error('password')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input id="agree_terms" name="agree_terms" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="agree_terms" class="ml-2 block text-sm text-gray-900 text-inter">
                            I agree to the <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Terms of Service</a> and <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                        </label>
                    </div>

                    @error('agree_terms')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-[#336699] hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            SIGN UP
                        </button>
                    </div>
                </form>

                <div class="my-6 flex items-center">
                    <div class="flex-grow border-t-2 border-[#86BBD8]"></div>
                    <span class="mx-4 text-sm text-black font-inter">OR</span>
                    <div class="flex-grow border-t-2 border-[#86BBD8]"></div>
                </div>

                <div>
                    <button type="button" class="w-full flex items-center justify-center py-3 px-4 border border-black rounded-full shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-offset-2 focus:ring-indigo-500">
                        <img src="{{ asset('images/social.png') }}" alt="Google" class="h-5 w-5 mr-2">
                        Sign up with Google
                    </button>
                </div>

                <p class="mt-4 text-center text-sm text-gray-600 font-inter"> Already have an account? <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Log In</a>
                </p>
            </div>

            <div class="hidden md:flex md:w-1/2 items-center justify-center p-8 lg:p-12 bg-[#E0FBFC] rounded-r-[45px]">
                <div class="bg-white p-6 rounded-3xl shadow-lg">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="w-32 h-32 bg-[#336699] rounded-xl"></div>
                        <div class="w-32 h-32 bg-[#D8DCFF] rounded-xl"></div>
                        <div class="w-32 h-32 bg-[#5B84AE] rounded-xl"></div>
                        <div class="w-32 h-32 bg-[#F2BAE1] rounded-xl"></div>
                        <div class="w-32 h-32 bg-[#86BBD8] rounded-xl"></div>
                        <div class="w-32 h-32 bg-[#FF9494] rounded-xl"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="creationSuccessModal" class="fixed inset-0 bg-black/75 items-center justify-center p-4 hidden z-50">
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl text-center max-w-md w-full relative">
            <button onclick="closeSuccessModal()" class="absolute top-2 right-3 text-gray-500 hover:text-gray-800 text-3xl font-light" aria-label="Close Modal">
                &times;
            </button>
            <img src="{{ asset('images/logo-krud.png') }}" alt="Logo KRUD" class="h-16 md:h-20 w-auto mx-auto mb-4 md:mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-black mb-2 md:mb-3 font-krona">Success!</h2>
            <p class="text-black mb-6 md:mb-8">Your account has been successfully created.</p>
            <a href="{{ route('login') }}" class="inline-block bg-[#336699] text-white font-inter px-10 py-3 rounded-full font-semibold hover:bg-blue-700">
                LOG IN
            </a>
        </div>
    </div>


    @if(session('show_creation_success_modal'))
    <script>
         function closeSuccessModal() {
            document.getElementById('creationSuccessModal').classList.add('hidden');
            document.getElementById('creationSuccessModal').classList.remove('flex');
            document.querySelector('body').classList.remove('modal-open');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('creationSuccessModal');
            const body = document.querySelector('body');

            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                body.classList.add('modal-open');
            }
        });
    </script>
    @endif

</body>
</html>
