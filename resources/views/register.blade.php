<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
         <title>Register</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        


    </head>
    <body class="antialiased bg-gray-100 flex items-center justify-center flex-col min-h-screen">
        <div class="area">
			<ul class="circles">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
		</div>
    
    <div class="register-container bg-white p-8  shadow-md  mt-10 mb-10 w-96">
        <div class="mb-4 flex justify-center ">
            <a href="/">
                <span class="sr-only ">East Squad</span>
                <img class="h-10 w-auto" src="{{ asset('images/logo2.svg') }}" alt="EastSquad logo">
            </a>
        </div>
        <h1 class="text-2xl font-bold  text-indigo-600 mb-4 ">Register</h1>
        <form action="{{ route('register.store') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="text" id="email" name="email" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="name" name="name" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            
            

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                       <div id="password-hint" class="hidden text-xs text-gray-500 mt-1">
                        Your password should be 8-16 characters long and include atleast one upper case letter, a number and special character.
                    </div>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="phone_nr" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="text" id="phone_nr" name="phone_nr" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 border border-red-500 bg-red-100 text-red-700 rounded" alert alert-danger>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <button type="submit" class="w-full bg-indigo-100 text-indigo-600 font-bold py-2 px-4 rounded hover:bg-indigo-200 focus:outline-none focus:bg-indigo-100">
                Register
            </button>
        </form>
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Already have an account?
                <a class="text-indigo-600 hover:underline" href="/login">
                Login
            </a>
        </p>
            
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const passwordHint = document.getElementById('password-hint');
            const submitButton = document.querySelector('button[type="submit"]');
        
            passwordInput.addEventListener('focus', function() {
                passwordHint.classList.remove('hidden');
            });
        
            passwordInput.addEventListener('blur', function() {
                passwordHint.classList.add('hidden');
            });
        
            passwordInput.addEventListener('input', function() {
                const password = passwordInput.value;
                const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/;
        
                if (regex.test(password)) {
                    passwordHint.classList.remove('text-red-500');
                    passwordHint.classList.add('text-green-500');
                    passwordHint.textContent = 'Password meets all requirements.';
                    submitButton.disabled = false;
                } else {
                    passwordHint.classList.remove('text-green-500');
                    passwordHint.classList.add('text-red-500');
                    passwordHint.textContent = 'Your password should be 8-16 characters long and include at least one uppercase letter, a number, and a special character.';
                    submitButton.disabled = true;
                }
            });
        });
        </script>
    </body>
    </html>
