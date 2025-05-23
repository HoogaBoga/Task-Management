<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
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
<body class="min-h-screen flex items-center justify-center bg-white">
    <div class="container w-full max-w-[400px] p-6 bg-white rounded-lg shadow-md text-center">

    {{-- ADD THESE BLOCKS TO DISPLAY SESSION MESSAGES --}}
        @if(session('success'))
            <div style="color: green; background-color: #e6fffa; padding: 10px; margin-bottom: 15px; border: 1px solid #38a169; border-radius: 5px; text-align: left;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="color: red; background-color: #ffe5e5; padding: 10px; margin-bottom: 15px; border: 1px solid #f56565; border-radius: 5px; text-align: left;">
                {{ session('error') }}
            </div>
        @endif
        {{-- END OF SESSION MESSAGE BLOCKS --}}

        <form method="POST" action="{{ route('login')}}" class="">
            @csrf
            <div class="form-group mb-8">
                <input type="text" id="username" name="email" class="w-full px-3 py-0.30 border-2 border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#D9D9D9]"
                value="{{ old('email') }}">
                @error('email')
                    <div style="color: red; font-size: 0.9em; text-align: left; margin-top: 5px;">{{ $message }}</div>
                @enderror
                <label for="username" class="font-extrabold text-xl"><br>Email</label>
            </div>

            <div class="form-group mb-12">
                <input type="password" id="password" name="password" class="w-full px-3 py-0.30 border-2 border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#D9D9D9]">
                @error('password')
                    <div style="color: red; font-size: 0.9em; text-align: left; margin-top: 5px;">{{ $message }}</div>
                @enderror
                <label for="password" class="font-extrabold text-xl"><br>Password</label>
            </div>

            <button type="submit" class="w-2/4 bg-[#336699] text-white py-2 px-3 border border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold text-lg">LOG IN</button>

        </form>

        <div class="sign-up mb-12">
            <span class="text-xs">Don't have an account yet?</span>
            <a href="{{ route('register') }}" class="font-bold text-black text-xs"><br>Sign Up</a>
        </div>


    </div>


</body>
</html>
