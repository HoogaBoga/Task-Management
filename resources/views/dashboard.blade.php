<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fbfcff;
        }
    </style>
</head>
<body class="bg-white min-h-screen">

    <div class="p-6 md:p-8 pb-24 md:pb-8">
        <div class="md:hidden mb-6">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center space-x-4">
                    <img src="https://i.imgur.com/OzA0f2a.jpeg" alt="User" class="w-12 h-12 rounded-full">
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Hello, Jarod!</h1>
                        <p class="text-sm text-gray-500">Welcome Back!</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="text-gray-600 p-2 rounded-full hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L16 11.414V16a1 1 0 01-.293.707l-2 2A1 1 0 0112 18v-1.586l-3.707-3.707A1 1 0 018 12V6.414L3.293 4.707A1 1 0 013 4z" />
                        </svg>
                    </button>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-500 p-2 rounded-full hover:bg-gray-100 transition-colors">
                            <img src="{{ asset('images/logout-light.svg') }}" alt="Logout" class="w-7 h-7">
                        </button>
                    </form>
                </div>
            </div>
            <div class="relative w-full">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <i class="fas fa-search text-lg"></i>
                </span>
                <input type="text" placeholder="Search Task" class="bg-gray-100 outline-none w-full h-12 rounded-full pl-12 pr-4">
            </div>
        </div>

        <div class="hidden md:flex flex-wrap justify-between items-center gap-4 mb-10">
            <div class="flex items-center space-x-4">
                <img src="https://i.imgur.com/OzA0f2a.jpeg" alt="User" class="w-14 h-14 rounded-full">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Hello, Jarod!</h1>
                    <p class="text-md text-gray-500">Welcome Back!</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <div class="relative flex-grow min-w-0">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" placeholder="Search Task" class="bg-gray-100 outline-none w-full h-12 rounded-full pl-12 pr-4 min-w-[250px]">
                </div>
                <button class="text-gray-500 p-2 rounded-full hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L16 11.414V16a1 1 0 01-.293.707l-2 2A1 1 0 0112 18v-1.586l-3.707-3.707A1 1 0 018 12V6.414L3.293 4.707A1 1 0 013 4z" />
                    </svg>
                </button>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-500 p-2 rounded-full hover:bg-gray-200 transition-colors">
                        <img src="{{ asset('images/logout-light.svg') }}" alt="Logout" class="w-8 h-8">
                    </button>
                </form>
                <div class="relative hidden md:block">
                    <button id="sidebar-toggle-button" class="p-2 rounded-full hover:bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                    <div id="sidebar-dropdown-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-20">
                         <div class="py-2">
                            <a href="#" class="flex items-center gap-4 px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <img src="{{ asset('images/home2.svg') }}" alt="home" class="w-8 h-8">
                                <span>Home</span>
                            </a>
                            <a href="#" class="flex items-center gap-4 px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <img src="{{ asset('images/bell.svg') }}?v=2" alt="bell" class="w-8 h-8">
                                <span>Notifications</span>
                            </a>
                            <a href="#" class="flex items-center gap-4 px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <img src="{{ asset('images/calendarclock.svg') }}" alt="task" class="w-8 h-8">
                                <span>Tasks</span>
                            </a>
                            <a href="#" class="flex items-center gap-4 px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <img src="{{ asset('images/users.svg') }}" alt="users" class="w-8 h-8">
                                <span>Users</span>
                            </a>
                            <a href="#" class="flex items-center gap-4 px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <img src="{{ asset('images/add.svg') }}?v=2" alt="add" class="w-8 h-8">
                                <span>Add Task</span>
                            </a>
                            <div class="border-t border-gray-200 my-2"></div>
                            <a href="#" class="flex items-center gap-4 px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <img src="{{ asset('images/moon.svg') }}" alt="theme" class="w-8 h-8">
                                <span>Theme</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-10">
            {{-- To Do Section --}}
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">To Do</h2>
                    <a href="#" class="text-blue-500 font-semibold">See All</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @if(isset($tasksByStatus['todo']) && $tasksByStatus['todo']->count())
                        @foreach ($tasksByStatus['todo'] as $task)
                            <div class="rounded-2xl p-4 shadow-lg text-white" style="background-color: #336699;">
                                @if($task->image_url)
                                    <img src="{{ $task->image_url }}" alt="Task Image" class="w-full h-28 object-cover rounded-lg mb-3" />
                                @endif
                                <h3 class="font-bold text-lg">{{ $task->task_name }}</h3>
                                <p class="mt-1 text-sm opacity-90">{{ Str::limit($task->task_description, 80) }}</p>
                            </div>
                        @endforeach
                    @else
                         <div class="rounded-2xl border-2 border-dashed border-gray-300 flex items-center justify-center h-48">
                            <p class="text-gray-400">No tasks to do.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- In Progress Section --}}
            <div>
                <div class="flex justify-between items-center mb-4">
                     <h2 class="text-2xl font-bold text-gray-800">In Progress</h2>
                     <a href="#" class="text-blue-500 font-semibold">See All</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @if(isset($tasksByStatus['in_progress']) && $tasksByStatus['in_progress']->count())
                        @foreach ($tasksByStatus['in_progress'] as $task)
                            <div class="rounded-2xl p-4 shadow-lg text-white" style="background-color: #5B84AE;">
                                @if($task->image_url)
                                    <img src="{{ $task->image_url }}" alt="Task Image" class="w-full h-28 object-cover rounded-lg mb-3" />
                                @endif
                                <h3 class="font-bold text-lg">{{ $task->task_name }}</h3>
                                <p class="mt-1 text-sm opacity-90">{{ Str::limit($task->task_description, 80) }}</p>
                            </div>
                        @endforeach
                    @else
                        <div class="rounded-2xl border-2 border-dashed border-gray-300 flex items-center justify-center h-48">
                            <p class="text-gray-400">No tasks in progress.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Completed Section --}}
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Completed</h2>
                    <a href="#" class="text-blue-500 font-semibold">See All</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @if(isset($tasksByStatus['completed']) && $tasksByStatus['completed']->count())
                        @foreach ($tasksByStatus['completed'] as $task)
                            <div class="rounded-2xl p-4 shadow-lg text-white" style="background-color: #86BBD8;">
                                @if($task->image_url)
                                    <img src="{{ $task->image_url }}" alt="Task Image" class="w-full h-28 object-cover rounded-lg mb-3" />
                                @endif
                                <h3 class="font-bold text-lg">{{ $task->task_name }}</h3>
                                <p class="mt-1 text-sm opacity-90">{{ Str::limit($task->task_description, 80) }}</p>
                            </div>
                        @endforeach
                    @else
                        <div class="rounded-2xl border-2 border-dashed border-gray-300 flex items-center justify-center h-48">
                            <p class="text-gray-400">No completed tasks.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white shadow-lg z-10">
       <div class="flex justify-around items-center p-2">
            <a href="#" class="p-3 text-blue-500"><i class="fas fa-home text-xl"></i></a>
            <a href="#" class="p-3 text-gray-500 hover:text-blue-500"><i class="fas fa-bell text-xl"></i></a>
            <a href="{{ route('tasks.create') }}" class="p-3 text-gray-500 hover:text-blue-500 -mt-8">
                <div class="bg-blue-600 text-white p-4 rounded-full shadow-lg">
                     <i class="fas fa-plus text-2xl"></i>
                </div>
            </a>
            <a href="#" class="p-3 text-gray-500 hover:text-blue-500"><i class="fas fa-clipboard-list text-xl"></i></a>
            <a href="#" class="p-3 text-gray-500 hover:text-blue-500"><i class="fas fa-users text-xl"></i></a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButton = document.getElementById('sidebar-toggle-button');
            const dropdownMenu = document.getElementById('sidebar-dropdown-menu');
            if (toggleButton) {
                toggleButton.addEventListener('click', (event) => {
                    event.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });
            }
            window.addEventListener('click', () => {
                if (dropdownMenu && !dropdownMenu.classList.contains('hidden')) {
                    dropdownMenu.classList.add('hidden');
                }
            });
            if (dropdownMenu) {
                dropdownMenu.addEventListener('click', (event) => {
                    event.stopPropagation();
                });
            }
        });
    </script>
</body>
</html>
