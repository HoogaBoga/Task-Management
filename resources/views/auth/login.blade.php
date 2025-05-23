<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        <form action="" class="">
            <div class="form-group mb-8">
                <input type="text" id="username" class="w-full px-3 py-0.30 border-2 border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#D9D9D9]">
                <label for="username" class="font-extrabold text-xl"><br>Username or email</label>
            </div>

            <div class="form-group mb-12">
                <input type="password" id="password" class="w-full px-3 py-0.30 border-2 border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#D9D9D9]">
                <label for="password" class="font-extrabold text-xl"><br>Password</label>
            </div>

        </form>

        <div class="sign-up mb-12">
            <span class="text-xs">Don't have an account yet?</span>
            <a href="{{ route('register') }}" class="font-bold text-black text-xs"><br>Sign Up</a>
        </div>

        <button class="w-2/4 bg-[#336699] text-white py-2 px-3 border border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold text-lg">LOG IN</button>

    </div>


</body>
</html>
