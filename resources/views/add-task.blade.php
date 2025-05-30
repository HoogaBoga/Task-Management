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
        *{
            font-family: 'Inter', 'sans-serif';
        }
        body{
            background-image:url('/Task-Management/public/images/background.svg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center w-screen">
    <!--container-->
    <div class="container w-3/4 bg-white p-8 rounded-lg">
        <!-- header -->
        <div class="header flex items-center">
            <h1 class="header text-[28px] font-bold">Add Task</h1>
            <button class="ml-4">
                <img src="{{ asset('images/add.svg') }}" alt="add" class="w-10 h-10 mr-2">
            </button>
        </div>

        <div class="shiz">
            <form action="" method="POST">
                @csrf
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
                            <div class="tags-container flex flex-row gap-2 w-full h-[5rem] px-3 py-2 border-2 border-black rounded-[2rem] bg-gray-50">
                                <!-- tag1-->
                                <button class="tag-toggle flex items-center justify-center px-3 py-2 rounded-lg gap-2 border border-dashed border-gray-400">
                                    <label for="Social Tag">Social</label>
                                </button>
                                <!-- tag2-->
                                <button class="tag-toggle flex items-center justify-center px-3 py-2 rounded-lg gap-2 border border-dashed border-gray-400">
                                    <label for="Life Tag">life</label>
                                </button>
                                <!-- tag3-->
                                <button class="tag-toggle flex items-center justify-center px-3 py-2 rounded-lg gap-2 border border-dashed border-gray-400">
                                    <label for="Sports Tag">Sports</label>
                                </button>
                                <!-- tag4-->
                                <button class="tag-toggle flex items-center justify-center px-3 py-2 rounded-lg gap-2 border border-dashed border-gray-400">
                                    <label for="School Tag">School</label>
                                </button>
                                <!--add tag-->
                                <button class="tag-toggle flex items-center justify-center px-3 py-2 rounded-lg gap-2 border border-dashed border-gray-400">
                                    <img src="{{ asset('images/add.svg') }}" alt="Add Tag" class="w-4 h-4">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- row 3 -->
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
</html>
