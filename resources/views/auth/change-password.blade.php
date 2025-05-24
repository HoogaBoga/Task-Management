<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Passsword</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Styles / Scripts -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-[#293241]">
    <div class="container w-full max-w-[400px] p-6 bg-[#293241] rounded-lg text-center">


        <!-- Back Arrow Button -->
        <div class="flex justify-start mb-6">
            <a href="{{ route('login') }}" class="flex items-center text-white hover:text-gray-200 transition-colors">
                <img src="{{ asset('images/back-arrow.svg') }}" alt="Back" class="w-6 h-6 mr-2 filter brightness-0 invert">
            </a>
        </div>

        <div class="Change_password mb-12">
            <span class="text-4xl font-bold text-[#FFFFFF]">Change <br> Password</span>
        </div>
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        <!-- Error Messages -->
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-none">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('change-password') }}">
            @csrf

            <div class="form-group mb-12">
                <input type="password"
                       id="old_password"
                       name="old_password"

                       class="w-full px-3 py-1 border-2 border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#FFFFFF]"

                       required>
                <label for="old_password" class="font-extrabold text-xl text-[#FFFFFF]"><br>Enter Old Password</label>
            </div>

            <div class="form-group mb-12">
                <input type="password"
                       id="new_password"
                       name="new_password"

                       class="w-full px-3 py-1 border-2 border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#FFFFFF]"

                       required>
                <label for="new_password" class="font-extrabold text-xl text-[#FFFFFF]"><br>Enter New Password</label>
            </div>

            <div class="form-group mb-12">
                <input type="password"
                       id="new_password_confirmation"
                       name="new_password_confirmation"

                       class="w-full px-3 py-1 border-2 border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#FFFFFF]"

                       required>
                <label for="new_password_confirmation" class="font-extrabold text-xl text-[#FFFFFF]"><br>Confirm New Password</label>
            </div>

            <button type="submit" class="w-2/4 bg-[#336699] text-white py-2 px-3 border border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold text-lg">
                CONFIRM
            </button>
        </form>
    </div>
</body>
</html>
