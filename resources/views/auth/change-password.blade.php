<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      /* Using Laravel's asset() helper for robust pathing */
      background: url("{{ asset('images/background.svg') }}") no-repeat center center fixed;
      background-size: cover;
    }

    .font-krona-one {
        font-family: 'Krona One', sans-serif;
    }

    .icon-filter-to-white {
        filter: brightness(0) invert(1);
    }
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-[#FFFFFF] px-4">
    <div class="w-full max-w-md p-8 rounded-2xl bg-[#FFFFFF] shadow-xl">

<div class="bg-[#E0FBFC] rounded-2xl p-6 md:p-8">
  <header class="flex items-center mb-8">
    <img src="{{ asset('images/logo-placeholder.svg') }}" alt="Logo" class="w-12 h-12 md:w-14 md:h-14" />
    <span class="ml-4 text-xl md:text-2xl font-krona-one">Change Password</span>
  </header>




        <!-- Back Arrow Button -->
        <div class="flex justify-start mb-6">
            <a href="{{ route('user.profile') }}" class="flex items-center text-black hover:text-gray-300 transition-colors">
                <img src="{{ asset('images/back-arrow.svg') }}" alt="Back" class="w-6 h-6 mr-2">
            </a>
        </div>

        <!-- Heading -->
        <div class="mb-10 text-center">
            <h2 class="text-3xl font-bold text-black">Change Password</h2>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside text-left">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('change-password') }}">
            @csrf

            <div class="mb-6">
                <label for="old_password" class="block text-black font-semibold mb-1">Old Password</label>
                <input type="password" id="old_password" name="old_password" class="w-full px-4 py-2 rounded-lg border border-gray-500 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-6">
                <label for="new_password" class="block text-black font-semibold mb-1">New Password</label>
                <input type="password" id="new_password" name="new_password" class="w-full px-4 py-2 rounded-lg border border-gray-500 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-10">
                <label for="new_password_confirmation" class="block text-black font-semibold mb-1">Confirm New Password</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full px-4 py-2 rounded-lg border border-gray-500 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="text-center">
                <button type="submit" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full transition duration-200">
                    CONFIRM
                </button>
            </div>
        </form>
    </div>
</body>
</html>
