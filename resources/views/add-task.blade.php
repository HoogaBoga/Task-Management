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
            font-family: 'Inter', sans-serif;
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
        <div class="container bg-white p-8 rounded-lg shadow-lg w-3/4">
            <!-- header -->
            <div class="header flex items-center">
                <h1 class="header text-[28px] font-bold">Add Task</h1>
                <button class="ml-4">
                    <img src="{{ asset('images/add.svg') }}" alt="add" class="w-10 h-10 mr-2">
                </button>
            </div>

            <!-- actual shiz -->
             <div>
                <form method="POST" action="">
                    @csrf
                    <div class="flex flex-row gap-8">
                        <!-- Task Name Column -->
                        <div class="flex-1">
                            <div class="input1 flex flex-col gap-1">
                                <label for="task-name" class="input1label font-extrabold text-[16px] text-[#000000]">Task Name</label>
                                <input type="text" id="task-name" name="task-name" class="w-full px-3 py-1 border-2 border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#F1F2F6]">
                            </div>
                        </div>

                        <!-- Team Members Column -->
                        <div class="flex-1">
                            <div class="input4 flex flex-col gap-1">
                                <label for="team-members" class="input4label font-extrabold text-[16px] text-[#000000]">Team Members</label>
                                <div class="users flex gap-3 mt-2">
                                    <!-- 1 -->
                                    <button type="button" class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center hover:bg-blue-200 transition-colors">
                                        <img src="{{ asset('images/user.svg') }}" alt="User 1" class="w-6 h-6">
                                    </button>

                                    <!-- 2 -->
                                    <button type="button" class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center hover:bg-green-200 transition-colors">
                                        <img src="{{ asset('images/user.svg') }}" alt="User 2" class="w-6 h-6">
                                    </button>

                                    <!-- 3 -->
                                    <button type="button" class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center hover:bg-purple-200 transition-colors">
                                        <img src="{{ asset('images/user.svg') }}" alt="User 3" class="w-6 h-6">
                                    </button>

                                    <!-- 4 -->
                                    <button type="button" class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center hover:bg-yellow-200 transition-colors">
                                        <img src="{{ asset('images/user.svg') }}" alt="User 4" class="w-6 h-6">
                                    </button>

                                    <!-- Add Member -->
                                    <button type="button" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors">
                                        <img src="{{ asset('images/add.svg') }}" alt="Add Member" class="w-6 h-6">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input2 flex flex-col gap-1 mt-4">
                        <label for="task-deadline" class="input2label font-extrabold text-[16px] text-[#000000]">Task Deadline</label>
                        <input type="date" id="task-deadline" name="task-deadline" class="w-1/2 px-3 py-1 border-2 border-[#000000] rounded-[2rem] focus:outline-none focus:ring-2 focus:ring-blue-500 bg-[#F1F2F6]">
                    </div>

                    <div class="input3 flex flex-col gap-1 mt-4">
                        <label class="font-extrabold text-[16px] text-black">Task Description</label>
                        <textarea id="task-description" name="task-description" class="w-1/2 min-h-[theme(spacing.40)] px-3 py-2 border-2 border-black rounded-[2rem] bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y" rows="3" ></textarea>
                    </div>

                </form>
            </div>

        </div>
</body>
</html>
