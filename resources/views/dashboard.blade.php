<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fbfcff;
        }
    </style>
</head>
<body class="bg-white min-h-screen">

    <div class="flex">
        <div class="flex-1 p-8">
            <div class="flex justify-between items-center mb-10">
                <div class="flex items-center space-x-4">
                    <img src="https://i.imgur.com/OzA0f2a.jpeg" alt="User" class="w-14 h-14 rounded-full">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Hello, Jarod!</h1>
                        <p class="text-md text-gray-500">Welcome Back!</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative w-96">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" placeholder="Search Task" class="bg-gray-100 outline-none w-full h-12 rounded-full pl-12 pr-4">
                    </div>
                    <button class="text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L16 11.414V16a1 1 0 01-.293.707l-2 2A1 1 0 0112 18v-1.586l-3.707-3.707A1 1 0 018 12V6.414L3.293 4.707A1 1 0 013 4z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="space-y-10">

                {{-- To Do Section --}}
<div class="mb-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">To Do</h2>
    <div class="flex space-x-6 overflow-x-auto pb-4 no-scrollbar">
        @if(isset($tasksByStatus['todo']) && $tasksByStatus['todo']->count())
            @foreach ($tasksByStatus['todo'] as $task)
                <div class="flex-shrink-0 rounded-2xl w-52 h-auto p-4" style="background-color: #336699; color: white;">
                    @if($task->image_url)
                        <img src="{{ $task->image_url }}" alt="Task Image" class="w-full h-24 object-cover rounded-lg mb-2" />
                    @endif
                    <h3 class="font-bold text-lg">{{ $task->task_name }}</h3>
                    <p class="mt-2 text-sm">{{ Str::limit($task->task_description, 80) }}</p>
                </div>
            @endforeach
        @else
            <p class="text-gray-400">No tasks in this category.</p>
        @endif
    </div>
</div>

{{-- In Progress Section --}}
<div class="mb-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">In Progress</h2>
    <div class="flex space-x-6 overflow-x-auto pb-4 no-scrollbar">
        @if(isset($tasksByStatus['in_progress']) && $tasksByStatus['in_progress']->count())
            @foreach ($tasksByStatus['in_progress'] as $task)
                <div class="flex-shrink-0 rounded-2xl w-52 h-auto p-4" style="background-color: #5B84AE; color: white;">
                    @if($task->image_url)
                        <img src="{{ $task->image_url }}" alt="Task Image" class="w-full h-24 object-cover rounded-lg mb-2" />
                    @endif
                    <h3 class="font-bold text-lg">{{ $task->task_name }}</h3>
                    <p class="mt-2 text-sm">{{ Str::limit($task->task_description, 80) }}</p>
                </div>
            @endforeach
        @else
            <p class="text-gray-400">No tasks in this category.</p>
        @endif
    </div>
</div>

{{-- Completed Section --}}
<div class="mb-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Completed</h2>
    <div class="flex space-x-6 overflow-x-auto pb-4 no-scrollbar">
        @if(isset($tasksByStatus['completed']) && $tasksByStatus['completed']->count())
            @foreach ($tasksByStatus['completed'] as $task)
                <div class="flex-shrink-0 rounded-2xl w-52 h-auto p-4" style="background-color: #86BBD8; color: white;">
                    @if($task->image_url)
                        <img src="{{ $task->image_url }}" alt="Task Image" class="w-full h-24 object-cover rounded-lg mb-2" />
                    @endif
                    <h3 class="font-bold text-lg">{{ $task->task_name }}</h3>
                    <p class="mt-2 text-sm">{{ Str::limit($task->task_description, 80) }}</p>
                </div>
            @endforeach
        @else
            <p class="text-gray-400">No tasks in this category.</p>
        @endif
    </div>
</div>


        </div>

        <div class="fixed right-0 top-0 h-full flex items-center justify-center px-5">
            <div class="flex flex-col space-y-3 bg-white p-2 rounded-full shadow-lg border">
                <button class="p-3 text-gray-700 hover:text-blue-500 rounded-full">
                    <i class="fas fa-home text-xl"></i>
                </button>
                <button class="p-3 text-gray-700 hover:text-blue-500 rounded-full">
                     <i class="fas fa-bell text-xl"></i>
                </button>
                <button class="p-3 text-gray-700 hover:text-blue-500 rounded-full">
                    <i class="fas fa-clipboard-list text-xl"></i>
                </button>
                <button class="p-3 text-gray-700 hover:text-blue-500 rounded-full">
                    <i class="fas fa-users text-xl"></i>
                </button>
                <div class="py-2">
                    <button class="bg-[#3b5998] text-white p-4 rounded-full shadow-md hover:bg-blue-700">
                        <i class="fas fa-plus text-2xl"></i>
                    </button>
                </div>
                <button class="p-3 text-gray-700 hover:text-blue-500 rounded-full">
                    <i class="fas fa-moon text-xl"></i>
                </button>
            </div>
        </div>
    </div>

</body>
</html>
