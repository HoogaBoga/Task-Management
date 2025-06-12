<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', 'sans-serif';
        }
        body {
            background-image: url("{{ asset('images/background.svg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .icon-filter-to-white {
            filter: brightness(0) invert(1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center w-screen py-8 pb-24 md:pb-8">

    <aside id="icon-sidebar"
           class="hidden md:flex fixed top-16 right-0 w-20 bg-slate-100 shadow-xl z-30
                  flex-col items-center justify-between py-6 rounded-l-2xl">
        <div class="flex flex-col items-center space-y-2">
            <a href="{{ route('dashboard') }}" title="Home" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95">
                <img src="{{ asset('images/home2.svg') }}" alt="home" class="w-8 h-8 text-slate-700 group-hover:text-blue-600">
            </a>
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
        <div class="flex flex-col items-center">
            <a href="{{ route('tasks.create') }}" title="Add New Task"
               class="w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 active:bg-blue-800 transition-all duration-150 ease-in-out hover:scale-105 active:scale-95 hover:shadow-xl">
                <img src="{{ asset('images/add.svg') }}?v=2" alt="add" class="w-7 h-7 icon-filter-to-white">
            </a>
        </div>
    </aside>

    <div class="container w-11/12 md:w-3/4 bg-white p-4 sm:p-6 md:p-8 rounded-2xl shadow-lg md:mr-[80px]">
        <div class="header flex items-center mb-6">
            <h1 class="header text-2xl md:text-3xl font-bold">Add Task</h1>
        </div>

        <div class="shiz">
            <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="form-container flex flex-col md:flex-row gap-4 md:gap-8 mb-4">
                    <div class="flex-1">
                        <div class="input1 flex flex-col gap-1">
                            <label for="task-name" class="text-base font-bold text-[#000000]">Task Name</label>
                            <input type="text" id="task-name" name="task_name" value="{{ old('task_name') }}" class="rounded-full w-full px-4 py-2 border-2 border-[#000000] focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#F1F2F6]">
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-bold text-[#000000]">Task Priority</label>
                            <div class="flex items-center gap-4 md:gap-8 h-full pt-2">
                                <div class="flex items-center gap-2">
                                    <input type="radio" id="priority-high" name="priority" value="high" class="w-5 h-5 text-red-600 focus:ring-red-500 border-gray-300">
                                    <label for="priority-high" class="text-md font-medium text-gray-900">High</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="radio" id="priority-low" name="priority" value="low" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                                    <label for="priority-low" class="text-md font-medium text-gray-900">Low</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-container flex flex-col md:flex-row gap-4 md:gap-8 mb-4">
                    <div class="flex-1">
                        <div class="input2 flex flex-col gap-1">
                            <label for="task-deadline" class="font-bold text-base text-[#000000]">Task Deadline</label>
                            <input type="date" id="task-deadline" name="task_deadline" value="{{ old('task_deadline') }}" class="w-full px-4 py-2 border-2 border-[#000000] rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#F1F2F6]">
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex flex-col gap-1">
                            <label for="Category" class="text-base font-bold text-[#000000]">Category</label>
                            <input type="hidden" id="selected-categories" name="categories">
                            <div class="tags-container flex flex-row gap-2 w-full h-[3.25rem] px-3 py-2 border-2 border-black rounded-full bg-gray-50 overflow-x-auto">
                                <button type="button" class="tag-toggle flex-shrink-0 flex items-center justify-center px-3 py-1 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition relative group" data-value="social" onclick="toggleCategory(this)">Social</button>
                                <button type="button" class="tag-toggle flex-shrink-0 flex items-center justify-center px-3 py-1 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition relative group" data-value="life" onclick="toggleCategory(this)">Life</button>
                                <button type="button" class="tag-toggle flex-shrink-0 flex items-center justify-center px-3 py-1 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition relative group" data-value="sports" onclick="toggleCategory(this)">Sports</button>
                                <button type="button" class="tag-toggle flex-shrink-0 flex items-center justify-center px-3 py-1 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition relative group" data-value="school" onclick="toggleCategory(this)">School</button>
                                <button type="button" class="tag-toggle flex-shrink-0 flex items-center justify-center px-3 py-1 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition" onclick="addNewCategory()"><img src="{{ asset('images/add.svg') }}" alt="Add Tag" class="w-4 h-4"></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-1 mb-4">
                    <div class="input1 flex flex-col gap-1">
                        <label for="task-image" class="text-base font-bold text-[#000000]">Image</label>
                        <div class="relative">
                            <input type="file" id="task-image" name="task_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="border-2 border-[#000000] rounded-full bg-[#F1F2F6] px-4 py-2 text-center truncate">
                                <span id="file-name" class="text-sm text-gray-500">Choose file</span>
                            </div>
                        </div>
                        <div id="image-preview" class="mt-2 hidden">
                            <img id="preview" src="#" alt="Preview" class="max-h-20 rounded-lg border border-gray-300">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="status" class="block font-bold text-base text-[#000000] mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border-2 border-[#000000] rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#F1F2F6]">
                        <option value="todo">To Do</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="mb-6">
                    <div class="input1 flex flex-col gap-1 mb-4">
                        <label for="task-description" class="text-base font-bold text-[#000000]">Task Description</label>
                        <textarea id="task-description" name="task_description" class="w-full px-4 py-3 border-2 border-[#000000] rounded-2xl bg-[#F1F2F6] focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y placeholder-gray-400" rows="5" placeholder="Enter detailed task description...">{{ old('task_description') }}</textarea>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="w-full sm:w-auto bg-[#336699] text-white py-3 px-8 border border-[#000000] rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold text-lg hover:bg-[#29527a] transition-colors">
                            Create Task
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white shadow-lg z-40">
   <div class="flex justify-around items-center p-2">

        <a href="{{ route('dashboard') }}" title="Dashboard" class="p-3 {{ request()->routeIs('dashboard') ? 'text-blue-500' : 'text-gray-500' }} hover:text-blue-500">
            <i class="fas fa-home text-xl"></i>
        </a>

        <a href="#" title="Notifications" class="p-3 text-gray-500 hover:text-blue-500">
            <i class="fas fa-bell text-xl"></i>
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
    <script>
    // YOUR JAVASCRIPT IS UNAFFECTED AND REMAINS THE SAME
    document.addEventListener('DOMContentLoaded', () => {
      const bellIcon = document.getElementById('bell-icon');
      const notificationPopup = document.getElementById('notification-popup');
      if (bellIcon && notificationPopup) {
        let isVisible = false;
        bellIcon.addEventListener('click', (e) => {
          e.stopPropagation();
          isVisible = !isVisible;
          notificationPopup.classList.toggle('hidden', !isVisible);
        });
        document.addEventListener('click', (e) => {
          if (!notificationPopup.contains(e.target) && !bellIcon.contains(e.target)) {
            notificationPopup.classList.add('hidden');
          }
        });
      }
      document.getElementById('notif-all').addEventListener('click', () => {
        document.getElementById('notif-all').classList.add('bg-blue-100', 'text-blue-700');
        document.getElementById('notif-unread').classList.remove('bg-blue-100', 'text-blue-700');
      });
      document.getElementById('notif-unread').addEventListener('click', () => {
        document.getElementById('notif-unread').classList.add('bg-blue-100', 'text-blue-700');
        document.getElementById('notif-all').classList.remove('bg-blue-100', 'text-blue-700');
      });
    });
    let selectedCategories = [];
    function updateSelectedCategoriesInput() {
        document.getElementById('selected-categories').value = selectedCategories.join(',');
    }
    function toggleCategory(button) {
        const value = button.dataset.value;
        const isSelected = button.classList.contains('bg-blue-600');
        if (isSelected) {
            button.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
            button.classList.add('border-gray-400');
            selectedCategories = selectedCategories.filter(cat => cat !== value);
        } else {
            button.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
            button.classList.remove('border-gray-400');
            if (!selectedCategories.includes(value)) {
                selectedCategories.push(value);
            }
        }
        updateSelectedCategoriesInput();
    }
    function addNewCategory() {
        const newCategoryName = prompt("Enter new category name:");
        if (newCategoryName && newCategoryName.trim() !== '') {
            const normalizedCategory = newCategoryName.trim().toLowerCase();
            const existingTag = document.querySelector(`.tag-toggle[data-value="${normalizedCategory}"]`);
            if (!existingTag) {
                const container = document.querySelector('.tags-container');
                const addButton = container.querySelector('button:last-child');
                const newButton = document.createElement('button');
                newButton.type = 'button';
                newButton.className = 'tag-toggle flex-shrink-0 flex items-center justify-center px-3 py-1 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition relative group';
                newButton.dataset.value = normalizedCategory;
                newButton.textContent = newCategoryName.trim();
                newButton.onclick = function() { toggleCategory(this); };
                container.insertBefore(newButton, addButton);
            } else {
                alert('This category already exists!');
            }
        }
    }
    document.getElementById('task-image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileNameEl = document.getElementById('file-name');
        const previewContainer = document.getElementById('image-preview');
        const previewEl = document.getElementById('preview');
        if (file) {
            fileNameEl.textContent = file.name;
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewEl.src = event.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewEl.src = '#';
                previewContainer.classList.add('hidden');
            }
        } else {
            fileNameEl.textContent = 'Choose file';
            previewEl.src = '#';
            previewContainer.classList.add('hidden');
        }
    });
    document.querySelector('form').addEventListener('submit', function(e) {
        updateSelectedCategoriesInput();
    });
    </script>
</body>
</html>
