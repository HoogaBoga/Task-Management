<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Register</title>
</head>
<body class="min-h-screen flex items-center justify-center bg-[url('/images/Background.svg')] w-screen bg-fixed bg-cover bg-center bg-no-repeat">
    <div class="p-4">
        <div class="bg-white w-full p-6 md:p-8 rounded-[50px] shadow-xl mx-auto
            max-w-md             md:max-w-lg          lg:max-w-2xl         xl:w-[1190px]        xl:max-w-none        xl:h-[700px]         ">
            <h2 class="font-krona">Register New Account</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Username</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
