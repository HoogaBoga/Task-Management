<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Dashboard</title>
    <style>
        .scroll-container::-webkit-scrollbar { display: none; }
        .scroll-container { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-white w-screen min-h-screen">

    <div class="flex p-4 justify-between items-center">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/user-profile.jpg') }}" alt="User" class="w-12 h-12 rounded-full">
            <div>
                <h1 class="text-xl font-bold">Hello, {{ Auth::user()->name ?? 'User' }}!</h1>
                <p class="text-sm text-gray-500">Welcome Back!</p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search Task" class="border border-gray-300 rounded-full px-4 py-1">
            <button class="p-2 rounded-full bg-gray-200">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M..." /></svg>
            </button>
        </div>
    </div>

    <div class="space-y-8 p-4">

        <div>
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-semibold">To Do</h2>
                <span class="text-sm text-blue-600 cursor-pointer">See All</span>
            </div>
            <div class="flex overflow-x-auto space-x-4 scroll-container">
                @foreach($tasksTodo as $task)
                    <div class="bg-blue-700 rounded-lg w-48 h-32 p-4 flex-shrink-0 text-white">
                        <h3 class="font-bold">{{ $task->title }}</h3>
                        <p class="text-sm">{{ $task->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-semibold">In Progress</h2>
                <span class="text-sm text-blue-600 cursor-pointer">See All</span>
            </div>
            <div class="flex overflow-x-auto space-x-4 scroll-container">
                @foreach($tasksInProgress as $task)
                    <div class="bg-blue-500 rounded-lg w-48 h-32 p-4 flex-shrink-0 text-white">
                        <h3 class="font-bold">{{ $task->title }}</h3>
                        <p class="text-sm">{{ $task->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-semibold">Completed</h2>
                <span class="text-sm text-blue-600 cursor-pointer">See All</span>
            </div>
            <div class="flex overflow-x-auto space-x-4 scroll-container">
                @foreach($tasksCompleted as $task)
                    <div class="bg-blue-300 rounded-lg w-48 h-32 p-4 flex-shrink-0 text-black">
                        <h3 class="font-bold">{{ $task->title }}</h3>
                        <p class="text-sm">{{ $task->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <div class="fixed right-4 top-1/2 transform -translate-y-1/2 flex flex-col space-y-4 items-center">
        <button class="bg-white p-2 rounded-full shadow">
            <img src="{{ asset('images/home-icon.png') }}" alt="Home" class="w-6 h-6">
        </button>
        <button class="bg-white p-2 rounded-full shadow">
            <img src="{{ asset('images/notification-icon.png') }}" alt="Notifications" class="w-6 h-6">
        </button>
        <button class="bg-white p-2 rounded-full shadow">
            <img src="{{ asset('images/tasks-icon.png') }}" alt="Tasks" class="w-6 h-6">
        </button>
        <button class="bg-white p-2 rounded-full shadow">
            <img src="{{ asset('images/team-icon.png') }}" alt="Team" class="w-6 h-6">
        </button>
        <button class="bg-[#336699] text-white p-3 rounded-full shadow">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/></svg>
        </button>
        <button class="bg-white p-2 rounded-full shadow">
            <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path d="M..." /></svg>
        </button>
    </div>

</body>
</html>
