<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Preview</title>
    <style>
        .scroll-container::-webkit-scrollbar { display: none; }
        .scroll-container { -ms-overflow-style: none; scrollbar-width: none; }
        body { font-family: Arial, sans-serif; }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-white w-screen min-h-screen">

    <!-- Top bar with profile and search combined -->
    <div class="flex p-4 justify-between items-center">
        <div class="flex items-center space-x-6 w-full">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/user-profile.jpg') }}" alt="User" class="w-12 h-12 rounded-full">
                <div>
                    <h1 class="text-xl font-bold">Hello, {{ Auth::user()->name ?? 'Jarod' }}!</h1>
                    <p class="text-sm text-gray-500">Welcome Back!</p>
                </div>
            </div>
            <div class="flex items-center bg-gray-200 rounded-full px-4 py-2 w-1/2">
                <span class="mr-2">🔍</span>
                <input type="text" placeholder="Search Task" class="bg-gray-200 outline-none w-full h-10">
            </div>
            <button class="ml-4 bg-blue-500 text-white px-4 py-2 rounded">Filters Button</button>
        </div>
    </div>

    <div class="space-y-8 p-4">

        <!-- To Do Section -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-2xl font-bold">To Do</h2>
                <span class="text-lg text-gray-500 cursor-pointer mr-10">See All</span>
            </div>
            <div class="flex flex-wrap gap-4">
                @for ($i = 1; $i <= 7; $i++)
                    <div class="rounded-lg w-60 h-48" style="background-color:#336699;"></div>
                @endfor
            </div>
        </div>

        <!-- In Progress Section -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-2xl font-bold">In Progress</h2>
                <span class="text-lg text-gray-500 cursor-pointer mr-10">See All</span>
            </div>
            <div class="flex flex-wrap gap-4">
                @for ($i = 1; $i <= 7; $i++)
                    <div class="rounded-lg w-60 h-48" style="background-color:#5B84AE;"></div>
                @endfor
            </div>
        </div>

        <!-- Completed Section -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-2xl font-bold">Completed</h2>
                <span class="text-lg text-gray-500 cursor-pointer mr-10">See All</span>
            </div>
            <div class="flex flex-wrap gap-4">
                @for ($i = 1; $i <= 7; $i++)
                    <div class="rounded-lg w-60 h-48" style="background-color:#86BBD8;"></div>
                @endfor
            </div>
        </div>

    </div>

    <!-- Right Side Navbar -->
    <div class="fixed right-4 top-1/2 transform -translate-y-1/2 flex flex-col space-y-4 items-center">
        <button class="bg-white p-2 rounded-full shadow">🏠</button>
        <button class="bg-white p-2 rounded-full shadow">🔔</button>
        <button class="bg-white p-2 rounded-full shadow">📋</button>
        <button class="bg-white p-2 rounded-full shadow">👥</button>
        <button class="bg-[#336699] text-white p-3 rounded-full shadow">＋</button>
        <button class="bg-white p-2 rounded-full shadow">🌙</button>
    </div>

</body>
</html>
