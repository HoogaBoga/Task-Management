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
            background-color: #fbfcff; /* Tailwind bg-white on body might override this */
        }
        /* Ensure smooth transition for main content margin */
        #main-content {
            transition: margin-right 0.3s ease-in-out;
        }
        /* For making dark monochrome icons white (used for the + icon on blue background) */
        .icon-filter-to-white {
            filter: brightness(0) invert(1);
        }

        /* --- IMPORTANT NOTE ON ICON COLORS ---
           For IMG SVGs to change color with CSS (like with Tailwind text color classes),
           the SVG file itself MUST be designed to use "currentColor" for its fill/stroke.
           If your SVGs have hardcoded colors, these CSS methods won't work effectively.
        */
    </style>
</head>
<body class="bg-white min-h-screen overflow-x-hidden">

    <aside id="icon-sidebar"
           class="hidden md:flex fixed top-16 right-0 w-20 bg-[#F1F2F6] shadow-xl z-30
                  flex-col items-center justify-between py-6 rounded-l-2xl transform transition-transform duration-300 ease-in-out translate-x-full">

        <div class="flex flex-col items-center space-y-2">
            <a href="{{ route('dashboard') }}" title="Home" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95">
                <img src="{{ asset('images/home2.svg') }}" alt="home" class="w-8 h-8 text-slate-700 group-hover:text-blue-600">
            </a>

<!-- Notification popup functio -->
<div class="relative">
  <button title="Notifications" id="bell-icon" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95 cursor-pointer">
    <img src="{{ asset('images/bell.svg') }}" alt="bell" class="w-8 h-8">
  </button>

 <div id="notification-popup" class="absolute right-20 -mt-40 w-80 bg-white rounded-xl shadow-lg border border-gray-200 hidden z-40">
    <div class="p-4 border-b border-gray-300">
      <h3 class="text-lg font-bold">Notifications</h3>
    </div>
    <div class="flex items-center justify-between px-4 py-2">
      <div class="flex gap-2">
        <button id="notif-all" class="text-sm font-medium px-3 py-1 rounded-full bg-blue-100 text-blue-700">All</button>
        <button id="notif-unread" class="text-sm font-medium px-3 py-1 rounded-full hover:bg-gray-200">Unread</button>
      </div>
      <button id="mark-read" class="text-sm text-blue-600 underline hover:text-blue-800">Mark all as Read</button>
    </div>
    <div class="p-4 text-sm text-gray-500">No new notifications.</div>
  </div>
</div>

            <a href="{{ route('tasks.create') }}" title="Tasks" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95">
                <img src="{{ asset('images/calendarclock.svg') }}" alt="task" class="w-8 h-8 text-slate-700 group-hover:text-blue-600">
            </a>
            <a href="{{ route('user.profile') }}" title="Users" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95">
                <img src="{{ asset('images/users.svg') }}" alt="users" class="w-8 h-8 text-slate-700 group-hover:text-blue-600">
            </a>
        </div>

        <div class="flex flex-col items-center"> <a href="{{ route('tasks.create') }}" title="Add New Task"
               class="w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 active:bg-blue-800 transition-all duration-150 ease-in-out hover:scale-105 active:scale-95 hover:shadow-xl">
                <img src="{{ asset('images/add.svg') }}?v=2" alt="add" class="w-7 h-7 icon-filter-to-white">
            </a>
            </div>
    </aside>

    <div id="main-content" class="p-6 md:p-8 pb-24 md:pb-8">
        <div class="md:hidden mb-6">
             <div class="flex justify-between items-center mb-4">
                <div class="flex items-center space-x-4">
                    <img src="https://i.imgur.com/OzA0f2a.jpeg" alt="User" class="w-12 h-12 rounded-full">
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Hello, $user!</h1>
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
                    <h1 class="text-2xl font-bold text-gray-800">Hello, {{ optional(Auth::user())->name ?? 'Guest'}}!</h1>
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
                <div class="hidden md:block">
                    <button id="sidebar-toggle-button" class="p-2 rounded-full hover:bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="space-y-10">
            {{-- To Do Section --}}
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">To Do</h2>
                </div>
                <div class="relative">
                    <div class="flex space-x-4 pb-4 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                        @if(isset($tasksByStatus['todo']) && $tasksByStatus['todo']->count())
                            @foreach ($tasksByStatus['todo'] as $task)
                                <div class="w-72 h-80 flex-shrink-0 rounded-2xl p-4 shadow-lg cursor-pointer transition-all hover:shadow-xl flex flex-col text-white"
                                    style="background-color: #336699; transition: background-color 0.3s ease;"
                                    onmouseover="this.style.backgroundColor='#2a5780'"
                                    onmouseout="this.style.backgroundColor='#336699'"
                                    onclick="showTaskDetails({{ json_encode($task, JSON_HEX_APOS) }})">

                                    <!-- Image (fixed height) -->
                                    @if($task->image_url)
                                        <div class="h-36 w-full mb-3 overflow-hidden rounded-lg">
                                            <img src="{{ $task->image_url }}" alt="Task Image"
                                                class="h-full w-full object-cover" />
                                        </div>
                                    @endif

                                    <!-- Content (flexible space) -->
                                    <div class="flex-grow flex flex-col">
                                        <h3 class="font-bold text-lg line-clamp-2">{{ $task->task_name }}</h3>

                                        <div class="mt-auto">
                                            <div class="flex justify-between items-center text-sm">
                                                <span class="flex items-center">
                                                    <i class="far fa-calendar-alt mr-1"></i>
                                                    {{ $task->task_deadline ? \Carbon\Carbon::parse($task->task_deadline)->format('M d, Y') : 'No deadline' }}
                                                </span>
                                                <span class="px-2 py-1 rounded-full text-xs {{
                                                    $task->priority === 'high' ? 'bg-red-400' :
                                                    ($task->priority === 'medium' ? 'bg-yellow-400' : 'bg-green-400')
                                                }}">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </div>

                                            @if($task->category)
                                                <div class="mt-2 flex flex-wrap gap-1">
                                                    @foreach(explode(',', $task->category) as $category)
                                                        <span class="bg-opacity-1 px-2 py-1 rounded-full text-xs font-semibold " style="background-color: #ee6c4d;">
                                                            {{ trim($category) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="w-72 h-80 flex-shrink-0 rounded-2xl border-2 border-dashed border-gray-300 flex items-center justify-center">
                                <p class="text-gray-400">No tasks to do.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- In Progress Section --}}
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">In Progress</h2>
                </div>
                <div class="relative">
                    <div class="flex space-x-4 pb-4 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                        @if(isset($tasksByStatus['in_progress']) && $tasksByStatus['in_progress']->count())
                            @foreach ($tasksByStatus['in_progress'] as $task)
                                <div class="w-72 h-80 flex-shrink-0 rounded-2xl p-4 shadow-lg cursor-pointer transition-all hover:shadow-xl flex flex-col text-white"
                                    style="background-color: #5B84AE; transition: background-color 0.3s ease;"
                                    onmouseover="this.style.backgroundColor='#4a6d8d'"
                                    onmouseout="this.style.backgroundColor='#5B84AE'"
                                    onclick="showTaskDetails({{ json_encode($task, JSON_HEX_APOS) }})">

                                    @if($task->image_url)
                                        <div class="h-36 w-full mb-3 overflow-hidden rounded-lg">
                                            <img src="{{ $task->image_url }}" alt="Task Image"
                                                class="h-full w-full object-cover" />
                                        </div>
                                    @endif

                                    <div class="flex-grow flex flex-col">
                                        <h3 class="font-bold text-lg line-clamp-2">{{ $task->task_name }}</h3>

                                        <div class="mt-auto">
                                            <div class="flex justify-between items-center text-sm">
                                                <span class="flex items-center">
                                                    <i class="far fa-calendar-alt mr-1"></i>
                                                    {{ $task->task_deadline ? \Carbon\Carbon::parse($task->task_deadline)->format('M d, Y') : 'No deadline' }}
                                                </span>
                                                <span class="px-2 py-1 rounded-full text-xs {{
                                                    $task->priority === 'high' ? 'bg-red-400' :
                                                    ($task->priority === 'medium' ? 'bg-yellow-400' : 'bg-green-400')
                                                }}">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </div>

                                            @if($task->category)
                                                <div class="mt-2 flex flex-wrap gap-1">
                                                    @foreach(explode(',', $task->category) as $category)
                                                        <span class="bg-opacity-1 px-2 py-1 rounded-full text-xs font-semibold " style="background-color: #ee6c4d;">
                                                            {{ trim($category) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="w-72 h-80 flex-shrink-0 rounded-2xl border-2 border-dashed border-gray-300 flex items-center justify-center">
                                <p class="text-gray-400">No tasks in progress.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Completed Section --}}
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Completed</h2>
                </div>
                <div class="relative">
                    <div class="flex space-x-4 pb-4 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                        @if(isset($tasksByStatus['completed']) && $tasksByStatus['completed']->count())
                            @foreach ($tasksByStatus['completed'] as $task)
                                <div class="w-72 h-80 flex-shrink-0 rounded-2xl p-4 shadow-lg cursor-pointer transition-all hover:shadow-xl flex flex-col text-white"
                                    style="background-color: #86BBD8; transition: background-color 0.3s ease;"
                                    onmouseover="this.style.backgroundColor='#75a7c2'"
                                    onmouseout="this.style.backgroundColor='#86BBD8'"
                                    onclick="showTaskDetails({{ json_encode($task, JSON_HEX_APOS) }})">

                                    @if($task->image_url)
                                        <div class="h-36 w-full mb-3 overflow-hidden rounded-lg">
                                            <img src="{{ $task->image_url }}" alt="Task Image"
                                                class="h-full w-full object-cover" />
                                        </div>
                                    @endif

                                    <div class="flex-grow flex flex-col">
                                        <h3 class="font-bold text-lg line-clamp-2">{{ $task->task_name }}</h3>

                                        <div class="mt-auto">
                                            <div class="flex justify-between items-center text-sm">
                                                <span class="flex items-center">
                                                    <i class="far fa-calendar-alt mr-1"></i>
                                                    {{ $task->task_deadline ? \Carbon\Carbon::parse($task->task_deadline)->format('M d, Y') : 'No deadline' }}
                                                </span>
                                                <span class="px-2 py-1 rounded-full text-xs {{
                                                    $task->priority === 'high' ? 'bg-red-400' :
                                                    ($task->priority === 'medium' ? 'bg-yellow-400' : 'bg-green-400')
                                                }}">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </div>

                                            @if($task->category)
                                                <div class="mt-2 flex flex-wrap gap-1">
                                                    @foreach(explode(',', $task->category) as $category)
                                                        <span class="bg-opacity-1 px-2 py-1 rounded-full text-xs font-semibold " style="background-color: #ee6c4d;">
                                                            {{ trim($category) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="w-72 h-80 flex-shrink-0 rounded-2xl border-2 border-dashed border-gray-300 flex items-center justify-center">
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

        <!-- taskmodal aka popup ig click sa task card sa dashboard -->
    <div id="taskModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-xl">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <h3 class="text-2xl font-bold text-gray-800" id="modalTaskName"></h3>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="mt-4">
                    <div id="modalTaskImage" class="mb-4">
                        <!--image if exists -->
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-gray-600 font-medium">Deadline</p>
                            <p id="modalTaskDeadline" class="text-gray-800"></p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-gray-600 font-medium">Priority</p>
                            <p id="modalTaskPriority" class="text-gray-800"></p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-gray-600 font-medium">Status</p>
                            <p id="modalTaskStatus" class="text-gray-800"></p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-gray-600 font-medium">Category</p>
                            <div id="modalTaskCategory" class="text-gray-800 flex flex-wrap gap-1"></div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg mb-4">
                        <p class="text-gray-600 font-medium">Description</p>
                        <p id="modalTaskDescription" class="text-gray-800 whitespace-pre-line"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

//Notification popup js
document.addEventListener('DOMContentLoaded', () => {
const bellIcon = document.getElementById('bell-icon');
const notificationPopup = document.getElementById('notification-popup');

  if (bellIcon && notificationPopup) {
    let isVisible = false;

    bellIcon.addEventListener('click', (e) => {
      e.stopPropagation();
      isVisible = !isVisible;
      if (isVisible) {
        notificationPopup.classList.remove('hidden');
        requestAnimationFrame(() => {
          notificationPopup.classList.remove('opacity-0', 'scale-95');
          notificationPopup.classList.add('opacity-100', 'scale-100');
        });
      } else {
        notificationPopup.classList.remove('opacity-100', 'scale-100');
        notificationPopup.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
          if (!isVisible) notificationPopup.classList.add('hidden');
        }, 300);
      }
    });

    document.addEventListener('click', (e) => {
      if (!notificationPopup.contains(e.target) && !bellIcon.contains(e.target)) {
        if (isVisible) {
          isVisible = false;
          notificationPopup.classList.remove('opacity-100', 'scale-100');
          notificationPopup.classList.add('opacity-0', 'scale-95');
          setTimeout(() => {
            notificationPopup.classList.add('hidden');
          }, 300);
        }
      }
    });
  }
});

const bellIcon = document.getElementById('bell-icon');
const notificationPopup = document.getElementById('notification-popup');

document.addEventListener('click', (e) => {
  if (bellIcon.contains(e.target)) {
    notificationPopup.classList.toggle('hidden');
  } else if (!notificationPopup.contains(e.target)) {
    notificationPopup.classList.add('hidden');
  }
});

document.getElementById('notif-all').addEventListener('click', () => {
  document.getElementById('notif-all').classList.add('bg-blue-100', 'text-blue-700');
  document.getElementById('notif-unread').classList.remove('bg-blue-100', 'text-blue-700');
});

document.getElementById('notif-unread').addEventListener('click', () => {
  document.getElementById('notif-unread').classList.add('bg-blue-100', 'text-blue-700');
  document.getElementById('notif-all').classList.remove('bg-blue-100', 'text-blue-700');
});

        document.addEventListener('DOMContentLoaded', () => {
            const toggleButton = document.getElementById('sidebar-toggle-button');
            const iconSidebar = document.getElementById('icon-sidebar');
            const mainContent = document.getElementById('main-content');

            const mainContentMarginClass = 'md:mr-20';

            if (toggleButton && iconSidebar && mainContent) {
                toggleButton.addEventListener('click', (event) => {
                    event.stopPropagation();
                    iconSidebar.classList.toggle('translate-x-full');

                    if (!iconSidebar.classList.contains('translate-x-full')) {
                        mainContent.classList.add(mainContentMarginClass);
                    } else {
                        mainContent.classList.remove(mainContentMarginClass);
                    }
                });
            }

            //fix mobile user
            const mobileUserName = document.querySelector('.md\\:hidden.mb-6 h1');
            if (mobileUserName) {
                mobileUserName.textContent = 'Hello, {{ optional(Auth::user())->name ?? "Guest" }}!';
            }
        });

        //show taskmodal
        function showTaskDetails(task) {
            //get task name
            document.getElementById('modalTaskName').textContent = task.task_name || 'No name';

            //format sa deadline
            const deadline = task.task_deadline ? new Date(task.task_deadline).toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            }) : 'No deadline';
            document.getElementById('modalTaskDeadline').textContent = deadline;

            //priority with style red for high prio green for low
            const priorityElement = document.getElementById('modalTaskPriority');
            priorityElement.textContent = task.priority ?
                task.priority.charAt(0).toUpperCase() + task.priority.slice(1) :
                'Not set';
            priorityElement.className = 'inline-block px-2 py-1 rounded-full text-xs ' +
                (task.priority === 'high' ? 'bg-red-100 text-red-800' :
                task.priority === 'medium' ? 'bg-yellow-100 text-yellow-800' :
                'bg-green-100 text-green-800');

            //status
            document.getElementById('modalTaskStatus').textContent = task.status ?
                task.status.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') :
                'Not set';

            //category
            const categoryContainer = document.getElementById('modalTaskCategory');
            categoryContainer.innerHTML = '';
            if (task.category) {
                const categoryElement = document.createElement('span');
                categoryElement.className = 'px-2 py-1 rounded-full text-xs text-white';
                categoryElement.style = "background-color: #ee6c4d;"
                categoryElement.textContent = task.category;
                categoryContainer.appendChild(categoryElement);
            }

            //description
            document.getElementById('modalTaskDescription').textContent =
                task.task_description || 'No description provided';

            //task image
            const imageContainer = document.getElementById('modalTaskImage');
            imageContainer.innerHTML = '';
            if (task.image_url) {
                const img = document.createElement('img');
                img.src = task.image_url;
                img.alt = 'Task image';
                img.className = 'w-full h-48 object-cover rounded-lg';
                imageContainer.appendChild(img);
            }

            //show ang modal
            document.getElementById('taskModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal() {
            document.getElementById('taskModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        //x mugana(exit modal back to dashboard)
        document.getElementById('taskModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
