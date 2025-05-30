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
    </style>
</head>
<body class="min-h-screen flex items-center justify-center w-screen">

    <!-- Sidebar -->
    <div class="fixed right-0 top-0 h-3/4 w-[80px] flex flex-col items-center z-10">
        <!--background-->
        <div class="w-full h-full bg-[#F1F2F6] rounded-b-[60px] pt-4 pb-4 flex flex-col items-center justify-between">
            <!--top icons-->
            <div class="flex flex-col items-center gap-4 w-full px-2">
                <!--home-->
                <button class="p-2 rounded-lg hover:bg-gray-200 transition-all">
                    <img src="{{ asset('images/home.svg') }}" alt="home" class="w-10 h-10">
                </button>

                <!--notifs-->
                <button class="p-2 rounded-lg hover:bg-gray-200 transition-all text-blue-800">
                    <img src="{{ asset('images/bell.svg') }}?v=2" alt="bell" class="w-10 h-10">
                </button>

                <!--tasks-->
                <button class="p-2 rounded-lg hover:bg-gray-200 transition-all">
                    <img src="{{ asset('images/calendar.svg') }}" alt="task" class="w-10 h-10">
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

    <!--container-->
    <div class="container w-3/4 bg-white p-8 rounded-lg mr-[80px]">
        <!-- header -->
        <div class="header flex items-center">
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
                <!-- row1 -->
                <div class="form-container flex flex-row gap-8 mb-2">
                    <div class="flex-1">
                        <div class="input1 flex flex-col gap-1">
                            <label for="task-name" class="text-[16px] font-extrabold text-[#000000]">Task Name</label>
                            <input type="text" id="task-name" name="task-name" class="rounded-[2rem] w-full px-3 py-1 border-2 border-[#000000] focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#F1F2F6]">
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

                <!-- row2 -->
                <div class="form-container flex flex-row gap-8 mb-2">
                    <div class="flex-1">
                        <div class="input2 flex flex-col gap-1">
                            <label for="task-deadline" class="font-extrabold text-[16px] text-[#000000]">Task Deadline</label>
                            <input type="date" id="task-deadline" name="task-deadline" class="w-full px-3 py-1 border-2 border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#F1F2F6]">
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="flex flex-col gap-1">
                            <label for="Category" class="text-[16px] font-extrabold text-[#000000]">Category</label>
                            <input type="hidden" id="selected-categories" name="categories">
                            <div class="tags-container flex flex-row gap-2 w-full h-[2.35rem] px-3 py-2 border-2 border-black rounded-[2rem] bg-gray-50">
                                <!-- tag1-->
                                <button type="button" class="tag-toggle flex items-center justify-center px-3 py-2 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition" data-value="social" onclick="toggleCategory(this)">
                                    Social
                                    <span class="delete-tag hidden absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs group-hover:block hover:bg-red-600" onclick="removeTag(event, this.parentNode)">×</span>
                                </button>
                                <!-- tag2-->
                                <button type="button" class="tag-toggle flex items-center justify-center px-3 py-2 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition" data-value="life" onclick="toggleCategory(this)">
                                    Life
                                    <span class="delete-tag hidden absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs group-hover:block hover:bg-red-600" onclick="removeTag(event, this.parentNode)">×</span>
                                </button>
                                <!-- tag3-->
                                <button type="button" class="tag-toggle flex items-center justify-center px-3 py-2 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition" data-value="sports" onclick="toggleCategory(this)">
                                    Sports
                                    <span class="delete-tag hidden absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs group-hover:block hover:bg-red-600" onclick="removeTag(event, this.parentNode)">×</span>
                                </button>
                                <!-- tag4-->
                                <button type="button" class="tag-toggle flex items-center justify-center px-3 py-2 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition" data-value="school" onclick="toggleCategory(this)">
                                    School
                                    <span class="delete-tag hidden absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs group-hover:block hover:bg-red-600" onclick="removeTag(event, this.parentNode)">×</span>
                                </button>
                                <!--add tag-->
                                <button type="button" class="tag-toggle flex items-center justify-center px-3 py-2 rounded-lg gap-2 border border-dashed border-gray-400 hover:bg-gray-200 transition" onclick="addNewCategory()">
                                    <img src="{{ asset('images/add.svg') }}" alt="Add Tag" class="w-4 h-4">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--row3-->
                <div class="flex-1">
                    <div class="input1 flex flex-col gap-1">
                        <label for="task-image" class="text-[16px] font-extrabold text-[#000000]">Image</label>
                            <div class="relative">
                                <input type="file" id="task-image" name="task-image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div class="border-2 border-[#000000] rounded-[2rem] bg-[#F1F2F6] px-3 py-1 text-center truncate">
                                    <span id="file-name" class="text-sm">Choose file</span>
                                </div>
                            </div>
                            <div id="image-preview" class="mt-2 hidden">
                                <img id="preview" src="#" alt="Preview" class="max-h-20 rounded-[1rem] border border-gray-300">
                            </div>
                    </div>
                </div>
                <!-- row 4 -->
                <div class="mb-6">
                    <div class="input1 flex flex-col gap-1 mb-4">
                        <label for="task-description" class="text-[16px] font-extrabold text-[#000000]">Task Description</label>
                        <textarea id="task-description" name="task-description" class="w-full px-4 py-3 border-2 border-[#000000] rounded-[2rem] bg-[#F1F2F6] focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y placeholder-gray-400" rows="5" placeholder="Enter detailed task description..."></textarea>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="w-auto bg-[#336699] text-white py-2 px-6 border border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold text-lg">
                            Create Task
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<script>

    let selectedCategories = [];

    function toggleCategory(button) {
        const value = button.dataset.value;
        const isSelected = button.classList.contains('bg-blue-100');

        if (isSelected) {
            // Remove from selected
            button.classList.remove('bg-blue-100', 'border-blue-400');
            selectedCategories = selectedCategories.filter(cat => cat !== value);
        } else {
            // Add to selected
            button.classList.add('bg-blue-100', 'border-blue-400');
            selectedCategories.push(value);
        }

        // Update hidden input value
        document.getElementById('selected-categories').value = selectedCategories.join(',');
    }

    function addNewCategory() {
        const newCategory = prompt("Enter new category name:");
        if (newCategory && newCategory.trim() !== '') {
            const normalizedCategory = newCategory.trim().toLowerCase();

            // Check if already exists
            const existingTags = Array.from(document.querySelectorAll('.tag-toggle')).map(btn => btn.dataset.value);
            if (!existingTags.includes(normalizedCategory)) {
                // Create new button
                const container = document.querySelector('.tags-container');
                const addButton = container.querySelector('button:last-child');

                const newButton = document.createElement('button');
                newButton.type = 'button';
                newButton.className = 'tag-toggle flex items-center justify-center px-3 py-1 rounded-lg gap-1 border border-dashed border-gray-400 hover:bg-gray-200 transition relative group';
                newButton.dataset.value = normalizedCategory;
                newButton.innerHTML = `
                    ${newCategory.trim()}
                    <span class="delete-tag hidden absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs group-hover:block hover:bg-red-600" onclick="removeTag(event, this.parentNode)">×</span>
                `;
                newButton.onclick = function() { toggleCategory(this); };

                // Insert before the add button
                container.insertBefore(newButton, addButton);
            } else {
                alert('This category already exists!');
            }
        }
    }

    function removeTag(event, tagButton) {
        // Prevent the tag click from triggering
        event.stopPropagation();

        // Remove from selected categories if it was selected
        const value = tagButton.dataset.value;
        selectedCategories = selectedCategories.filter(cat => cat !== value);
        document.getElementById('selected-categories').value = selectedCategories.join(',');

        // Remove the tag from DOM
        tagButton.remove();
    }

    document.getElementById('task-image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileName = document.getElementById('file-name');
        const previewContainer = document.getElementById('image-preview');
        const preview = document.getElementById('preview');

        if (file) {
            fileName.textContent = file.name;

            //show preview if image ang file
            if (file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
            }
        } else {
            fileName.textContent = 'Choose file';
            previewContainer.classList.add('hidden');
        }
    });
    document.querySelector('form').addEventListener('submit', function(e) {
    document.getElementById('selected-categories').name = 'categories';
    document.getElementById('selected-categories').value = selectedCategories.join(',');
    });
</script>
</html>
