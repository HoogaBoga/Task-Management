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
        #main-content {
            transition: margin-right 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
        .icon-filter-to-white {
            filter: brightness(0) invert(1);
        }
        .hide-scrollbar-on-idle { scrollbar-width: none; }
        .hide-scrollbar-on-idle::-webkit-scrollbar { height: 8px; }
        .hide-scrollbar-on-idle::-webkit-scrollbar-track { background: transparent; }
        .hide-scrollbar-on-idle::-webkit-scrollbar-thumb {
            background: transparent;
            border-radius: 4px;
            transition: background-color 0.3s ease-in-out;
        }
        .hide-scrollbar-on-idle:hover {
            scrollbar-width: thin;
            scrollbar-color: #D1D5DB #F3F4F6;
        }
        .hide-scrollbar-on-idle:hover::-webkit-scrollbar-thumb { background: #D1D5DB; }
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
            <div class="relative">
              <button title="Notifications" id="desktop-bell-icon" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95 cursor-pointer">
                <img src="{{ asset('images/bell.svg') }}" alt="bell" class="w-8 h-8">
                <span id="desktop-notif-badge" class="absolute top-2 right-2 w-5 h-5 bg-red-500 text-white text-xs font-semibold rounded-full flex items-center justify-center border-2 border-[#F1F2F6] hidden"></span>
              </button>
            </div>
            <a href="{{ route('user.profile') }}" title="Profile" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95">
                <img src="{{ asset('images/users.svg') }}" alt="users" class="w-8 h-8 text-slate-700 group-hover:text-blue-600">
            </a>
        </div>
        <div class="flex flex-col items-center w-full space-y-4">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" title="Logout" class="w-full p-3 flex justify-center rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95">
                    <img src="{{ asset('images/logout-light.svg') }}" alt="Logout" class="w-8 h-8 text-slate-700 group-hover:text-red-500">
                </button>
            </form>
            <a href="{{ route('tasks.create') }}" title="Add New Task"
               class="w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 active:bg-blue-800 transition-all duration-150 ease-in-out hover:scale-105 active:scale-95 hover:shadow-xl">
                <img src="{{ asset('images/add.svg') }}?v=2" alt="add" class="w-7 h-7 icon-filter-to-white">
            </a>
        </div>
    </aside>

    <div id="main-content" class="p-6 md:p-8 pb-24 md:pb-8">
        <div id="notification-popup" class="fixed bottom-20 right-4 md:top-16 md:right-24 md:bottom-auto w-80 bg-white rounded-xl shadow-lg border border-gray-200 hidden z-50 flex flex-col">
            <div class="p-4 border-b border-gray-300">
              <h3 class="text-lg font-bold">Notifications</h3>
            </div>
            <div class="flex items-center justify-between px-4 py-2 border-b">
              <div class="flex gap-2">
                <button id="notif-all" class="text-sm font-medium px-3 py-1 rounded-full bg-blue-100 text-blue-700">All</button>
                <button id="notif-unread" class="text-sm font-medium px-3 py-1 rounded-full hover:bg-gray-200">Unread</button>
              </div>
              <button id="mark-read" class="text-sm text-blue-600 hover:text-blue-800 disabled:text-gray-400 disabled:cursor-not-allowed" disabled>Mark all as read</button>
            </div>
            <div id="notification-list" class="flex-grow overflow-y-auto" style="max-height: 400px;">
                <div class="p-4 text-sm text-gray-500 text-center">Loading...</div>
            </div>
        </div>

        <div class="md:hidden mb-6">
             <div class="flex justify-between items-center mb-4">
                <div class="flex items-center space-x-4">
                    @if (Auth::user()->avatar_url)
                        <img src="{{ Auth::user()->avatar_url }}" alt="User Avatar" class="w-12 h-12 rounded-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="User Initials" class="w-12 h-12 rounded-full object-cover">
                    @endif
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Hello, {{ optional(Auth::user())->name ?? 'Guest'}}!</h1>
                        <p class="text-sm text-gray-500">Welcome Back!</p>
                    </div>
                </div>
            </div>
            <div class="relative w-full">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <i class="fas fa-search text-lg"></i>
                </span>
                <input type="text" id="mobile-search-input" placeholder="Search Task" class="bg-gray-100 outline-none w-full h-12 rounded-full pl-12 pr-4">
            </div>
        </div>

       <div class="hidden md:flex flex-wrap justify-between items-center gap-4 mb-10">
            <div class="flex items-center space-x-4">
                @if (Auth::user()->avatar_url)
                    <img src="{{ Auth::user()->avatar_url }}" alt="User Avatar" class="w-14 h-14 rounded-full object-cover">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="User Initials" class="w-14 h-14 rounded-full object-cover">
                @endif
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
                    <input type="text" id="search-input" placeholder="Search Task" class="bg-gray-100 outline-none w-full h-12 rounded-full pl-12 pr-4 min-w-[250px]">
                </div>
                <div class="relative">
                    <select id="category-filter" class="bg-gray-100 outline-none h-12 rounded-full px-4 appearance-none cursor-pointer">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="hidden md:block">
                    <button id="sidebar-toggle-button" class="p-2 rounded-full hover:bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" title="Toggle Sidebar">
                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="space-y-10">
             @foreach (['todo' => 'To Do', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $status => $title)
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $title }}</h2>
                </div>
                <div class="relative">
                    <div id="{{ $status }}-container" class="flex space-x-4 pb-4 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 hide-scrollbar-on-idle">
                        @forelse ($tasksByStatus[$status] ?? [] as $task)
                            @php
                                $statusColors = [
                                    'todo' => '#336699',
                                    'in_progress' => '#5B84AE',
                                    'completed' => '#86BBD8'
                                ];
                                $taskJson = json_encode($task);
                            @endphp
                            <div class="w-72 h-80 flex-shrink-0 rounded-2xl p-4 shadow-lg cursor-pointer transition-all hover:shadow-xl flex flex-col text-white"
                                style="background-color: {{ $statusColors[$status] }};"
                                data-task='{{ $taskJson }}'
                                onclick="showTaskDetails(this)">
                                @if($task->image_url)
                                    <div class="h-36 w-full mb-3 overflow-hidden rounded-lg">
                                        <img src="{{ $task->image_url }}" alt="Task Image" class="h-full w-full object-cover" />
                                    </div>
                                @endif
                                <div class="flex-grow flex flex-col">
                                    <h3 class="font-bold text-lg line-clamp-2">{{ $task->task_name }}</h3>
                                    <div class="mt-auto">
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="flex items-center"><i class="far fa-calendar-alt mr-1"></i> {{ $task->task_deadline ? \Carbon\Carbon::parse($task->task_deadline)->format('M d, Y') : 'No deadline' }}</span>
                                            <span class="px-2 py-1 rounded-full text-xs {{ $task->priority === 'high' ? 'bg-red-400' : 'bg-green-400' }}">{{ ucfirst($task->priority) }}</span>
                                        </div>
                                        @if(!empty($task->category))
                                            <div class="mt-2 flex flex-wrap gap-1">
                                                  @foreach($task->category as $category)
                                                    <span class="bg-opacity-1 px-2 py-1 rounded-full text-xs font-semibold " style="background-color: #ee6c4d;">{{ $category }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="w-72 h-80 flex-shrink-0 rounded-2xl border-2 border-dashed border-gray-300 flex items-center justify-center"><p class="text-gray-400">No tasks in this section.</p></div>
                        @endforelse
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white shadow-lg z-40">
           <div class="flex justify-around items-center p-2">
                <a href="{{ route('dashboard') }}" title="Dashboard" class="p-3 {{ request()->routeIs('dashboard') ? 'text-blue-500' : 'text-gray-500' }} hover:text-blue-500">
                    <i class="fas fa-home text-xl"></i>
                </a>
                <a href="#" id="mobile-bell-icon" title="Notifications" class="p-3 text-gray-500 hover:text-blue-500 relative">
                    <i class="fas fa-bell text-xl"></i>
                    <span id="mobile-notif-badge" class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white text-xs font-semibold rounded-full flex items-center justify-center border-2 border-white hidden"></span>
                </a>
                <a href="{{ route('tasks.create') }}" title="Add Task" class="p-3 text-gray-500 hover:text-blue-500 -mt-8">
                    <div class="bg-blue-600 text-white p-4 rounded-full shadow-lg">
                         <i class="fas fa-plus text-2xl"></i>
                    </div>
                </a>
                <a href="{{ route('user.profile') }}" title="Profile" class="p-3 {{ request()->routeIs('user.profile') ? 'text-blue-500' : 'text-gray-500' }} hover:text-blue-500">
                    <i class="fas fa-user text-xl"></i>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" title="Logout" class="p-3 text-gray-500 hover:text-blue-500">
                        <i class="fas fa-sign-out-alt text-xl"></i>
                    </button>
                </form>
            </div>
        </div>

        <div id="taskModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 overflow-y-auto" onclick="closeModal()">
             <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-auto transform transition-all" onclick="event.stopPropagation()">
                <form id="edit-task-form" method="POST" action="" enctype="multipart/form-data"
                    data-update-url-template="{{ route('tasks.update', ['task' => 'TASK_ID_PLACEHOLDER']) }}"
                    data-destroy-url-template="{{ route('tasks.destroy', ['task' => 'TASK_ID_PLACEHOLDER']) }}">
                    @csrf
                    @method('PATCH')
                    <div class="p-6 space-y-4">
                        <input id="modalTaskNameInput" name="task_name" type="text" class="text-2xl font-bold w-full outline-none p-0 border-0 bg-transparent focus:ring-0" placeholder="Task Name" disabled>

                        <div id="modalTaskImage" class="mb-4"></div>
                        <input type="file" name="image" id="modalTaskImageInput" class="hidden" disabled>

                        <textarea id="modalTaskDescriptionInput" name="task_description" class="w-full h-24 text-gray-600 outline-none resize-none border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Add a description..." disabled></textarea>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="modalTaskDeadlineInput" class="text-sm font-medium text-gray-500">Deadline</label>
                                <input id="modalTaskDeadlineInput" name="task_deadline" type="date" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" disabled>
                            </div>
                            <div>
                                <label for="modalTaskPriorityInput" class="text-sm font-medium text-gray-500">Priority</label>
                                <select id="modalTaskPriorityInput" name="priority" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" disabled>
                                    <option value="low">Low</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div>
                                <label for="modalTaskStatusInput" class="text-sm font-medium text-gray-500">Status</label>
                                <select id="modalTaskStatusInput" name="status" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" disabled>
                                    <option value="todo">To Do</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Categories</label>
                            <div class="tags-container mt-2 flex flex-wrap items-center gap-2">
                                <button type="button" id="add-category-btn" onclick="showTagDropdown()" class="hidden flex-shrink-0 text-blue-600 border border-dashed border-blue-600 rounded-lg px-3 py-1 text-sm hover:bg-blue-50">
                                    + Add
                                </button>
                                <div id="tag-dropdown" class="absolute mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden">
                                    <input type="text" placeholder="New category..." onkeydown="handleCustomTagInput(event)" class="block w-full px-4 py-2 text-gray-800 border-b focus:outline-none">
                                    <div id="existing-tags-list">
                                        @foreach($categories as $category)
                                            <a href="#" onclick="addTagFromDropdown('{{$category}}')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{$category}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="categories" id="modalTaskCategories">
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex justify-between items-center rounded-b-2xl">
                        <button type="button" onclick="deleteTask()" class="text-red-600 hover:text-red-800 font-semibold">Delete Task</button>
                        <div>
                            <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 font-semibold rounded-lg hover:bg-gray-200">Close</button>
                            <button type="button" id="edit-task-btn" onclick="toggleEditMode(true)" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">Edit</button>
                            <button type="button" id="cancel-edit-btn" onclick="toggleEditMode(false)" class="hidden px-4 py-2 text-gray-600 font-semibold rounded-lg hover:bg-gray-200">Cancel</button>
                            <button type="submit" id="save-task-btn" class="hidden px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // SCRIPT FOR SIDEBAR AND NOTIFICATION POPUP
        document.addEventListener('DOMContentLoaded', () => {
            // Sidebar Toggle
            const toggleButton = document.getElementById('sidebar-toggle-button');
            const iconSidebar = document.getElementById('icon-sidebar');
            const mainContent = document.getElementById('main-content');
            if (toggleButton && iconSidebar && mainContent) {
                toggleButton.addEventListener('click', (event) => {
                    event.stopPropagation();
                    iconSidebar.classList.toggle('translate-x-full');
                    mainContent.classList.toggle('md:mr-20', !iconSidebar.classList.contains('translate-x-full'));
                });
            }

            // Notification Popup
            const desktopBell = document.getElementById('desktop-bell-icon');
            const mobileBell = document.getElementById('mobile-bell-icon');
            const notificationPopup = document.getElementById('notification-popup');

            const togglePopup = (e) => {
                e.preventDefault();
                e.stopPropagation();
                notificationPopup.classList.toggle('hidden');
                if (!notificationPopup.classList.contains('hidden')) {
                    fetchNotifications();
                }
            };

            if (desktopBell) desktopBell.addEventListener('click', togglePopup);
            if (mobileBell) mobileBell.addEventListener('click', togglePopup);

            if (notificationPopup) {
                document.addEventListener('click', (e) => {
                    if (notificationPopup.classList.contains('hidden')) return;
                    const isClickInsidePopup = notificationPopup.contains(e.target);
                    const isClickOnDesktopBell = desktopBell ? desktopBell.contains(e.target) : false;
                    const isClickOnMobileBell = mobileBell ? mobileBell.contains(e.target) : false;
                    if (!isClickInsidePopup && !isClickOnDesktopBell && !isClickOnMobileBell) {
                        notificationPopup.classList.add('hidden');
                    }
                });
            }
        });
    </script>

    <script>
        // SCRIPT FOR NOTIFICATION LOGIC
        document.addEventListener('DOMContentLoaded', function() {
            let allNotifications = [];
            let currentFilter = 'all';

            const notificationList = document.getElementById('notification-list');
            const markReadBtn = document.getElementById('mark-read');
            const notifAllBtn = document.getElementById('notif-all');
            const notifUnreadBtn = document.getElementById('notif-unread');

            window.fetchNotifications = async function() {
                @if (Route::has('notifications.index'))
                    try {
                        const response = await fetch("{{ route('notifications.index') }}");
                        if (!response.ok) throw new Error(`Server responded with ${response.status}`);
                        const data = await response.json();
                        allNotifications = data.notifications || [];
                        updateNotificationBadge(data.unread_count || 0);
                        renderNotifications();
                    } catch (error) {
                        console.error('Error fetching notifications:', error);
                        if(notificationList) notificationList.innerHTML = `<div class="p-4 text-sm text-gray-500 text-center">Failed to load notifications.</div>`;
                    }
                @else
                    if(notificationList) notificationList.innerHTML = `<div class="p-4 text-sm text-gray-500 text-center">Notification route not found.</div>`;
                @endif
            };

            function renderNotifications() {
                if (!notificationList) return;
                const filtered = currentFilter === 'unread'
                    ? allNotifications.filter(n => !n.read_at)
                    : allNotifications;
                notificationList.innerHTML = '';
                if (filtered.length === 0) {
                    const message = currentFilter === 'unread' ? 'No unread notifications.' : 'You have no notifications.';
                    notificationList.innerHTML = `<div class="p-4 text-sm text-gray-500 text-center">${message}</div>`;
                } else {
                    filtered.forEach(notif => {
                        const isUnread = !notif.read_at;
                        const notifElement = `
                            <div class="p-3 border-b border-gray-200 hover:bg-gray-50 flex items-start gap-3 ${isUnread ? 'font-semibold cursor-pointer' : ''}"
                                 data-id="${notif.id}"
                                 onclick="markNotificationAsRead(this)">
                                ${isUnread ? '<div class="w-2 h-2 bg-blue-500 rounded-full mt-1.5 flex-shrink-0"></div>' : '<div class="w-2 h-2"></div>'}
                                <div class="flex-grow">
                                    <p class="text-sm text-gray-800">${notif.data.message || 'New notification'}</p>
                                    <p class="text-xs text-gray-500 mt-1 font-normal">${new Date(notif.created_at).toLocaleString()}</p>
                                </div>
                            </div>
                        `;
                        notificationList.insertAdjacentHTML('beforeend', notifElement);
                    });
                }
                const hasUnread = allNotifications.some(n => !n.read_at);
                if(markReadBtn) markReadBtn.disabled = !hasUnread;
            }

            function updateNotificationBadge(unreadCount) {
                const badges = [document.getElementById('desktop-notif-badge'), document.getElementById('mobile-notif-badge')];
                badges.forEach(badge => {
                    if (badge) {
                        if (unreadCount > 0) {
                            badge.textContent = unreadCount > 9 ? '9+' : unreadCount;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    }
                });
            }

            window.markNotificationAsRead = async function(element) {
                const notifId = element.dataset.id;
                if (!element.classList.contains('font-semibold')) return;

                @if (Route::has('notifications.markAsRead'))
                    try {
                        let url = "{{ route('notifications.markAsRead', ['notification' => 'NOTIF_ID']) }}";
                        url = url.replace('NOTIF_ID', notifId);

                        await fetch(url, {
                            method: 'PATCH',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                        });
                        fetchNotifications();
                    } catch (error) {
                        console.error('Error marking notification as read:', error);
                    }
                @endif
            }

            async function markAllAsRead() {
                if(markReadBtn) markReadBtn.disabled = true;
                 @if (Route::has('notifications.markAllAsRead'))
                    try {
                        await fetch("{{ route('notifications.markAllAsRead') }}", {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                        });
                        fetchNotifications();
                    } catch (error) {
                        console.error('Error marking notifications as read:', error);
                        if(markReadBtn) markReadBtn.disabled = false;
                    }
                @endif
            }

            if(notifAllBtn) notifAllBtn.addEventListener('click', () => {
                currentFilter = 'all';
                notifAllBtn.classList.add('bg-blue-100', 'text-blue-700');
                notifUnreadBtn.classList.remove('bg-blue-100', 'text-blue-700');
                renderNotifications();
            });

            if(notifUnreadBtn) notifUnreadBtn.addEventListener('click', () => {
                currentFilter = 'unread';
                notifUnreadBtn.classList.add('bg-blue-100', 'text-blue-700');
                notifAllBtn.classList.remove('bg-blue-100', 'text-blue-700');
                renderNotifications();
            });

            if(markReadBtn) markReadBtn.addEventListener('click', markAllAsRead);

            fetchNotifications();
        });
    </script>

    <script>
        // SCRIPT FOR TASK MODAL (VIEW/EDIT/DELETE)
        let modalSelectedCategories = [];
        let currentTask = null;

        function showTaskDetails(element) {
            currentTask = JSON.parse(element.dataset.task);
            const taskModal = document.getElementById('taskModal');
            const form = document.getElementById('edit-task-form');

            if (form && taskModal && currentTask) {
                const urlTemplate = form.dataset.updateUrlTemplate;
                form.action = urlTemplate.replace('TASK_ID_PLACEHOLDER', currentTask.id);

                document.getElementById('modalTaskNameInput').value = currentTask.task_name || '';
                document.getElementById('modalTaskDescriptionInput').value = currentTask.task_description || '';

                if (currentTask.task_deadline) {
                    document.getElementById('modalTaskDeadlineInput').value = new Date(currentTask.task_deadline).toISOString().split('T')[0];
                } else {
                    document.getElementById('modalTaskDeadlineInput').value = '';
                }

                document.getElementById('modalTaskPriorityInput').value = currentTask.priority || 'low';
                document.getElementById('modalTaskStatusInput').value = currentTask.status || 'todo';

                const imageContainer = document.getElementById('modalTaskImage');
                imageContainer.innerHTML = '';
                if (currentTask.image_url) {
                    imageContainer.innerHTML = `<img src="${currentTask.image_url}" alt="Task image" class="w-full h-48 object-cover rounded-lg">`;
                }

                renderModalCategories(currentTask.category || []);
                taskModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                toggleEditMode(false);
            }
        }

        function renderModalCategories(categories) {
            const container = document.querySelector('.tags-container');
            const addButton = document.getElementById('add-category-btn');
            if (container && addButton) {
                const tagsToRemove = container.querySelectorAll('.tag-toggle');
                tagsToRemove.forEach(tag => tag.remove());

                modalSelectedCategories = [];
                if (categories && Array.isArray(categories)) {
                    categories.forEach(category => addTagToModal(category, false));
                }
                updateModalCategoriesInput();
            }
        }

        function closeModal() {
            const taskModal = document.getElementById('taskModal');
            if (taskModal) {
                taskModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        function toggleEditMode(isEditing) {
            const form = document.getElementById('edit-task-form');
            if(form) {
                const inputs = form.querySelectorAll('input:not([type=hidden]), select, textarea');
                const addCategoryBtn = document.getElementById('add-category-btn');

                inputs.forEach(input => {
                    input.disabled = !isEditing;
                });

                document.getElementById('edit-task-btn').classList.toggle('hidden', isEditing);
                document.getElementById('save-task-btn').classList.toggle('hidden', !isEditing);
                document.getElementById('cancel-edit-btn').classList.toggle('hidden', !isEditing);
                if(addCategoryBtn) addCategoryBtn.classList.toggle('hidden', !isEditing);

                document.querySelectorAll('.delete-tag').forEach(btn => {
                    btn.classList.toggle('hidden', !isEditing);
                });
            }
        }

        function deleteTask() {
            if (confirm('Are you sure you want to delete this task? This cannot be undone.')) {
                const form = document.getElementById('edit-task-form');
                if (form && currentTask) {
                    const urlTemplate = form.dataset.destroyUrlTemplate;
                    const deleteUrl = urlTemplate.replace('TASK_ID_PLACEHOLDER', currentTask.id);

                    const deleteForm = document.createElement('form');
                    deleteForm.method = 'POST';
                    deleteForm.action = deleteUrl;
                    deleteForm.innerHTML = `@csrf @method('DELETE')`;
                    document.body.appendChild(deleteForm);
                    deleteForm.submit();
                }
            }
        }

        function updateModalCategoriesInput() {
            const categoryInput = document.getElementById('modalTaskCategories');
            if(categoryInput) {
                categoryInput.value = modalSelectedCategories.join(',') || '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const editTaskForm = document.getElementById('edit-task-form');
            if (editTaskForm) {
                editTaskForm.addEventListener('submit', function(event) {
                    updateModalCategoriesInput();
                });
            }
        });

        function addTagToModal(category, updateInput = true) {
            if (!category || modalSelectedCategories.includes(category)) return;

            const container = document.querySelector('.tags-container');
            const addButton = document.getElementById('add-category-btn');

            if (container && addButton) {
                const newButton = document.createElement('button');
                newButton.type = 'button';
                newButton.className = 'tag-toggle flex-shrink-0 flex items-center justify-center px-3 py-1 rounded-lg gap-2 border border-blue-600 bg-blue-600 text-white relative group';
                newButton.dataset.value = category;
                newButton.textContent = category;

                const deleteSpan = document.createElement('span');
                deleteSpan.className = 'delete-tag hidden absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs group-hover:flex hover:bg-red-600';
                deleteSpan.innerHTML = '&times;';
                deleteSpan.onclick = (e) => removeModalTag(e, newButton);

                newButton.appendChild(deleteSpan);
                container.insertBefore(newButton, addButton);
                modalSelectedCategories.push(category);

                if (updateInput) updateModalCategoriesInput();
                const isEditing = !document.getElementById('save-task-btn').classList.contains('hidden');
                if (isEditing) {
                    deleteSpan.classList.remove('hidden');
                }
            }
        }

        function removeModalTag(event, tagButton) {
            event.stopPropagation();
            const value = tagButton.dataset.value;
            modalSelectedCategories = modalSelectedCategories.filter(cat => cat !== value);
            updateModalCategoriesInput();
            tagButton.remove();
        }

        function showTagDropdown() {
            const dropdown = document.getElementById('tag-dropdown');
            if(dropdown) dropdown.classList.toggle('hidden');
        }

        function addTagFromDropdown(category) {
            addTagToModal(category);
            showTagDropdown();
        }

        function handleCustomTagInput(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                const input = event.target;
                if (input.value.trim()) {
                    addTagFromDropdown(input.value.trim());
                    input.value = '';
                }
            }
        }
    </script>

    <script>
        // SCRIPT FOR DYNAMIC SEARCH AND FILTER
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const mobileSearchInput = document.getElementById('mobile-search-input');
            const categoryFilter = document.getElementById('category-filter');
            const mainContent = document.getElementById('main-content');

            function debounce(func, delay = 300) {
                let timeout;
                return (...args) => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
                };
            }

            async function fetchAndRenderTasks() {
                const searchTerm = (searchInput ? searchInput.value : '') || (mobileSearchInput ? mobileSearchInput.value : '');
                const category = categoryFilter ? categoryFilter.value : '';
                const params = new URLSearchParams({ search: searchTerm, category: category });

                if(mainContent) mainContent.style.opacity = '0.5';
                try {
                    const response = await fetch(`{{ route('dashboard') }}?${params.toString()}`, {
                        method: 'GET',
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                    });
                    if (!response.ok) throw new Error('Network response was not ok');
                    const tasksByStatus = await response.json();
                    renderTasks(tasksByStatus);
                } catch (error) {
                    console.error('Failed to fetch tasks:', error);
                } finally {
                    if(mainContent) mainContent.style.opacity = '1';
                }
            }

            function renderTasks(tasksByStatus) {
                const containerIds = {
                    todo: 'todo-container',
                    in_progress: 'in_progress-container',
                    completed: 'completed-container'
                };

                const searchTerm = (searchInput && searchInput.value) || (mobileSearchInput && mobileSearchInput.value);
                const category = categoryFilter && categoryFilter.value;

                for (const status in containerIds) {
                    const container = document.getElementById(containerIds[status]);
                    if (!container) continue;

                    container.innerHTML = '';
                    const tasks = tasksByStatus[status] || [];

                    if (tasks.length > 0) {
                        tasks.forEach(task => container.insertAdjacentHTML('beforeend', createTaskCard(task)));
                    } else {
                        let message = "No tasks in this section.";
                        if (searchTerm || category) {
                            message = "No tasks match your filter.";
                        }
                        container.innerHTML = `<div class="w-72 h-80 flex-shrink-0 rounded-2xl border-2 border-dashed border-gray-300 flex items-center justify-center"><p class="text-gray-400">${message}</p></div>`;
                    }
                }
            }

            function createTaskCard(task) {
                const deadline = task.task_deadline ? new Date(task.task_deadline).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : 'No deadline';
                const priorityClass = task.priority === 'high' ? 'bg-red-400' : 'bg-green-400';
                const priorityText = task.priority.charAt(0).toUpperCase() + task.priority.slice(1);
                const statusColors = { todo: '#336699', in_progress: '#5B84AE', completed: '#86BBD8' };

                let categoriesHtml = '';
                if(task.category && Array.isArray(task.category)) {
                    categoriesHtml = task.category.map(cat => `<span class="bg-opacity-1 px-2 py-1 rounded-full text-xs font-semibold" style="background-color: #ee6c4d;">${cat}</span>`).join('');
                }

                let imageHtml = task.image_url ? `<div class="h-36 w-full mb-3 overflow-hidden rounded-lg"><img src="${task.image_url}" alt="Task Image" class="h-full w-full object-cover" /></div>` : '';

                const taskJsonString = JSON.stringify(task).replace(/'/g, '&apos;');

                return `
                    <div class="w-72 h-80 flex-shrink-0 rounded-2xl p-4 shadow-lg cursor-pointer transition-all hover:shadow-xl flex flex-col text-white"
                         style="background-color: ${statusColors[task.status]};"
                         data-task='${taskJsonString}'
                         onclick="showTaskDetails(this)">
                        ${imageHtml}
                        <div class="flex-grow flex flex-col">
                            <h3 class="font-bold text-lg line-clamp-2">${task.task_name}</h3>
                            <div class="mt-auto">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="flex items-center"><i class="far fa-calendar-alt mr-1"></i> ${deadline}</span>
                                    <span class="px-2 py-1 rounded-full text-xs ${priorityClass}">${priorityText}</span>
                                </div>
                                <div class="mt-2 flex flex-wrap gap-1">${categoriesHtml}</div>
                            </div>
                        </div>
                    </div>
                `;
            }

            const debouncedFetch = debounce(fetchAndRenderTasks);
            if (searchInput) searchInput.addEventListener('input', debouncedFetch);
            if (mobileSearchInput) mobileSearchInput.addEventListener('input', debouncedFetch);
            if (categoryFilter) categoryFilter.addEventListener('change', fetchAndRenderTasks);
        });
    </script>
</body>
</html>
