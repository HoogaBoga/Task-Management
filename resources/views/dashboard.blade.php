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

    <div class="flex flex-col md:flex-row">
        <div class="flex-1 p-6 md:p-8 mb-24 md:mb-0">
            <div class="flex flex-wrap justify-between items-center gap-4 mb-10">
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
                    <!--logout shiz-->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-500 p-2 rounded-full hover:bg-gray-100">
                            <img src="{{ asset('images/logout-light.svg') }}" alt="Logout" class="w-8 h-8">
                        </button>
                    </form>
                    <button class="text-gray-500 p-2 rounded-full hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L16 11.414V16a1 1 0 01-.293.707l-2 2A1 1 0 0112 18v-1.586l-3.707-3.707A1 1 0 018 12V6.414L3.293 4.707A1 1 0 013 4z" />
                        </svg>
                    </button>
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
                <a href="#" class="p-3 text-gray-500 hover:text-blue-500 -mt-8">
                    <div class="bg-blue-600 text-white p-4 rounded-full shadow-lg">
                         <i class="fas fa-plus text-2xl"></i>
                    </div>
                </a>
                <a href="#" class="p-3 text-gray-500 hover:text-blue-500"><i class="fas fa-clipboard-list text-xl"></i></a>
                <a href="#" class="p-3 text-gray-500 hover:text-blue-500"><i class="fas fa-users text-xl"></i></a>
            </div>
        </div>

         <!-- Sidebar -->
    <div class="fixed right-0 top-0 h-3/4 w-[80px] flex flex-col items-center z-10">
        <!--background-->
        <div class="w-full h-full bg-[#F1F2F6] rounded-b-[60px] pt-4 pb-4 flex flex-col items-center justify-between">
            <!--top icons-->
            <div class="flex flex-col items-center gap-4 w-full px-2">
                <!--home-->
                <button class="p-2 rounded-lg hover:bg-gray-200 transition-all">
                    <img src="{{ asset('images/home2.svg') }}" alt="home" class="w-10 h-10">
                </button>

                <!--notifs-->
                <button class="p-2 rounded-lg hover:bg-gray-200 transition-all text-blue-800">
                    <img src="{{ asset('images/bell.svg') }}?v=2" alt="bell" class="w-10 h-10">
                </button>

                <!--tasks-->
                <button class="p-2 rounded-lg hover:bg-gray-200 transition-all">
                    <img src="{{ asset('images/calendarclock.svg') }}" alt="task" class="w-10 h-10">
                </button>

                <!--users-->
                <button class="p-2 rounded-lg hover:bg-gray-200 transition-all">
                    <img src="{{ asset('images/users.svg') }}" alt="users" class="w-10 h-10">
                </button>

                <!--add-->
                <button class="p-2 rounded-lg hover:bg-gray-200 transition-all">
                    <img src="{{ asset('images/add.svg') }}?v=2" alt="add" class="w-10 h-10">
                </button>

                <!--theme-->
                <button class="p-2 rounded-lg hover:bg-gray-200 transition-all">
                    <img src="{{ asset('images/moon.svg') }}" alt="theme" class="w-10 h-10">
                </button>
            </div>
        </div>
    </div>

    </div>

</body>
</html>
