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
    <style>
        * {
            font-family: 'Inter', 'sans-serif';
        }
        body {
            background-image: url('/Task-Management/public/images/background.svg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
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
<body class="min-h-screen flex items-center justify-center w-screen">

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

<!-- Notification popup functio -->
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

    <div class="container w-3/4 bg-white p-8 rounded-lg mr-[80px]"> <div class="header flex items-center">
            <h1 class="header text-[28px] font-bold">Add Task</h1>
            <button class="ml-4">
                <img src="{{ asset('images/add.svg') }}" alt="add" class="w-10 h-10 mr-2">
            </button>
        </div>

        <div class="shiz">
            <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="form-container flex flex-row gap-8 mb-2">
                    <div class="flex-1">
                        <div class="input1 flex flex-col gap-1">
                            <label for="task-name" class="text-[16px] font-extrabold text-[#000000]">Task Name</label>
                            <input type="text" id="task-name" name="task_name"value="{{ old('task_name') }}" class="rounded-[2rem] w-full px-3 py-1 border-2 border-[#000000] focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#F1F2F6]">
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="flex flex-col gap-1">
                            <label class="text-[16px] font-extrabold text-[#000000]">Task Priority</label>
                            <div class="flex items-center gap-8 h-full pt-2">
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

                <div class="form-container flex flex-row gap-8 mb-2">
                    <div class="flex-1">
                        <div class="input2 flex flex-col gap-1">
                            <label for="task-deadline" class="font-extrabold text-[16px] text-[#000000]">Task Deadline</label>
                            <input type="date" id="task-deadline" name="task_deadline" value="{{ old('task_name') }}" class="w-full px-3 py-1 border-2 border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#F1F2F6]">
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="flex flex-col gap-1">
                            <label for="Category" class="text-[16px] font-extrabold text-[#000000]">Category</label>
                            <input type="hidden" id="selected-categories" name="categories"> <div class="tags-container flex flex-row gap-2 w-full h-[2.35rem] px-3 py-2 border-2 border-black rounded-[2rem] bg-gray-50 overflow-x-auto">
                                <button type="button" class="tag-toggle flex-shrink-0 flex items-center justify-center px-3 py-1 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition relative group" data-value="social" onclick="toggleCategory(this)">
                                    Social
                                    <span class="delete-tag hidden absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs group-hover:block hover:bg-red-600" onclick="removeTag(event, this.parentNode)">×</span>
                                </button>
                                <button type="button" class="tag-toggle flex-shrink-0 flex items-center justify-center px-3 py-1 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition relative group" data-value="life" onclick="toggleCategory(this)">
                                    Life
                                    <span class="delete-tag hidden absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs group-hover:block hover:bg-red-600" onclick="removeTag(event, this.parentNode)">×</span>
                                </button>
                                <button type="button" class="tag-toggle flex-shrink-0 flex items-center justify-center px-3 py-1 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition relative group" data-value="sports" onclick="toggleCategory(this)">
                                    Sports
                                    <span class="delete-tag hidden absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs group-hover:block hover:bg-red-600" onclick="removeTag(event, this.parentNode)">×</span>
                                </button>
                                <button type="button" class="tag-toggle flex-shrink-0 flex items-center justify-center px-3 py-1 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition relative group" data-value="school" onclick="toggleCategory(this)">
                                    School
                                    <span class="delete-tag hidden absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs group-hover:block hover:bg-red-600" onclick="removeTag(event, this.parentNode)">×</span>
                                </button>
                                <button type="button" class="tag-toggle flex-shrink-0 flex items-center justify-center px-3 py-1 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition" onclick="addNewCategory()">
                                    <img src="{{ asset('images/add.svg') }}" alt="Add Tag" class="w-4 h-4">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-1 mb-4"> <div class="input1 flex flex-col gap-1">
                        <label for="task-image" class="text-[16px] font-extrabold text-[#000000]">Image</label>
                            <div class="relative">
                                <input type="file" id="task-image" name="task_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div class="border-2 border-[#000000] rounded-[2rem] bg-[#F1F2F6] px-3 py-1 text-center truncate">
                                    <span id="file-name" class="text-sm text-gray-500">Choose file</span> </div>
                            </div>
                            <div id="image-preview" class="mt-2 hidden">
                                <img id="preview" src="#" alt="Preview" class="max-h-20 rounded-[1rem] border border-gray-300">
                            </div>
                    </div>
                </div>

                <div class="mb-4"> <label for="status" class="block font-extrabold text-[16px] text-[#000000] mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-1 border-2 border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#F1F2F6]">
                        <option value="todo">To Do</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>


                <div class="mb-6">
                    <div class="input1 flex flex-col gap-1 mb-4">
                        <label for="task-description" class="text-[16px] font-extrabold text-[#000000]">Task Description</label>
                        <textarea id="task-description" name="task_description" class="w-full px-4 py-3 border-2 border-[#000000] rounded-[2rem] bg-[#F1F2F6] focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y placeholder-gray-400" rows="5" placeholder="Enter detailed task description...">{{ old('task_description') }}</textarea> </div>

                    <div class="flex justify-center">
                        <button type="submit" class="w-auto bg-[#336699] text-white py-2 px-6 border border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold text-lg hover:bg-[#29527a] transition-colors"> Create Task
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
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

    // Close popup when clicking outside
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

    let selectedCategories = []; // Initialize as an empty array

    function updateSelectedCategoriesInput() {
        document.getElementById('selected-categories').value = selectedCategories.join(',');
    }

    function toggleCategory(button) {
        const value = button.dataset.value;
        const isSelected = button.classList.contains('bg-blue-600'); // Using a more distinct selected color

        if (isSelected) {
            button.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
            button.classList.add('border-gray-400'); // Revert to default border
            selectedCategories = selectedCategories.filter(cat => cat !== value);
        } else {
            button.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
            button.classList.remove('border-gray-400');
            if (!selectedCategories.includes(value)) { // Ensure no duplicates
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
                const addButton = container.querySelector('button:last-child'); // The "add new" button

                const newButton = document.createElement('button');
                newButton.type = 'button';
                // Added flex-shrink-0 to new tags as well
                newButton.className = 'tag-toggle flex-shrink-0 flex items-center justify-center px-3 py-1 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition relative group';
                newButton.dataset.value = normalizedCategory;
                newButton.textContent = newCategoryName.trim(); // Set text content directly

                // Create and append the delete span
                const deleteSpan = document.createElement('span');
                deleteSpan.className = 'delete-tag hidden absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs group-hover:block hover:bg-red-600';
                deleteSpan.innerHTML = '×';
                deleteSpan.onclick = function(event) { removeTag(event, newButton); };
                newButton.appendChild(deleteSpan);

                newButton.onclick = function() { toggleCategory(this); };

                container.insertBefore(newButton, addButton);
            } else {
                alert('This category already exists!');
            }
        }
    }

    function removeTag(event, tagButton) {
        event.stopPropagation();
        const value = tagButton.dataset.value;
        selectedCategories = selectedCategories.filter(cat => cat !== value);
        updateSelectedCategoriesInput();
        tagButton.remove();
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
                previewEl.src = '#'; // Clear previous preview
                previewContainer.classList.add('hidden');
            }
        } else {
            fileNameEl.textContent = 'Choose file';
            previewEl.src = '#';
            previewContainer.classList.add('hidden');
        }
    });

    // Ensure the hidden input for categories is correctly named on form submit
    // (This might be redundant if `name="categories"` is already on the hidden input,
    // but good for explicit control if it was initially different)
    document.querySelector('form').addEventListener('submit', function(e) {
        const categoriesInput = document.getElementById('selected-categories');
        if (categoriesInput.name !== 'categories') {
             categoriesInput.name = 'categories';
        }
        updateSelectedCategoriesInput(); // Ensure it's up-to-date before submit
    });
</script>
</html>
