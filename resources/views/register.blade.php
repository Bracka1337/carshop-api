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
                       <div id="email-hint" class="hidden text-xs text-gray-500 mt-1">
                        Check your email adress
                    </div>
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
                       <div id="password-match" class="hidden text-xs text-gray-500 mt-1">
                        Your passwords do not match.
                    </div>
            </div>
            <div class="mb-4">
                <label for="phone_nr" class="block text-sm font-medium text-gray-700">Phone Number</label>
                
                <div class="mt-1 flex items-center">
                    <button id="dropdown-phone-button-3" data-dropdown-toggle="dropdownDivider"
                        class="az-10 inline-flex items-center rounded-s-lg border border-gray-300 bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100"
                        type="button">
                        <span class="inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="me-2 h-4 w-4"
                                fill="none" viewBox="0 0 200 100">
                                <rect width="200" height="40" fill="#CF142B" />
                                <rect y="40" width="200" height="20" fill="#FFFFFF" />
                                <rect y="60" width="200" height="40" fill="#CF142B" />
                            </svg>
                            +371
                        </span>
                        <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="dropdown-phone-3"
                        class="bg-gray-100 mt-40 absolute z-10 hidden w-56 divide-y divide-gray-100 rounded-lg bg-white shadow">
                        <ul class="p-2 text-sm font-medium text-gray-700"
                            aria-labelledby="dropdown-phone-button-3">
                            <li>
                                <button type="button"
                                    class="dropdown-item inline-flex w-full rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-indigo-100 hover:text-gray-900"
                                    role="menuitem">
                                    <span class="inline-flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="me-2 h-4 w-4"
                                            fill="none" viewBox="0 0 200 100">
                                            <rect width="200" height="40" fill="#CF142B" />
                                            <rect y="40" width="200" height="20"
                                                fill="#FFFFFF" />
                                            <rect y="60" width="200" height="40"
                                                fill="#CF142B" />
                                        </svg>
                                        +371
                                    </span>
                                </button>
                            </li>
                            <li>
                                <button type="button"
                                    class="dropdown-item inline-flex w-full rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-indigo-100 hover:text-gray-900 "
                                    role="menuitem">
                                    <span class="inline-flex items-center">
                                        <svg class="w-4 h-4 me-2" fill="none" viewBox="0 0 20 15">
                                            <rect width="19.6" height="14" y=".5" fill="#fff"
                                                rx="2" />
                                            <mask id="a" style="mask-type:luminance"
                                                width="20" height="15" x="0" y="0"
                                                maskUnits="userSpaceOnUse">
                                                <rect width="19.6" height="14" y=".5"
                                                    fill="#fff" rx="2" />
                                            </mask>
                                            <g mask="url(#a)">
                                                <path fill="#FFD700" fill-rule="evenodd"
                                                    d="M0 5.167h19.6V.5H0v4.667z"
                                                    clip-rule="evenodd" />
                                                <g filter="url(#filter0_d_374_135180)">
                                                    <path fill="#006A4E" fill-rule="evenodd"
                                                        d="M0 9.833h19.6V5.167H0v4.666z"
                                                        clip-rule="evenodd" />
                                                </g>
                                                <g filter="url(#filter1_d_374_135180)">
                                                    <path fill="#C1272D" fill-rule="evenodd"
                                                        d="M0 14.5h19.6V9.833H0V14.5z"
                                                        clip-rule="evenodd" />
                                                </g>
                                            </g>
                                            <defs>
                                                <filter id="filter0_d_374_135180" width="19.6"
                                                    height="4.667" x="0" y="5.167"
                                                    color-interpolation-filters="sRGB"
                                                    filterUnits="userSpaceOnUse">
                                                    <feFlood flood-opacity="0"
                                                        result="BackgroundImageFix" />
                                                    <feColorMatrix in="SourceAlpha" result="hardAlpha"
                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                                                    <feOffset />
                                                    <feColorMatrix
                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.06 0" />
                                                    <feBlend in2="BackgroundImageFix"
                                                        result="effect1_dropShadow_374_135180" />
                                                    <feBlend in="SourceGraphic"
                                                        in2="effect1_dropShadow_374_135180"
                                                        result="shape" />
                                                </filter>
                                                <filter id="filter1_d_374_135180" width="19.6"
                                                    height="4.667" x="0" y="9.833"
                                                    color-interpolation-filters="sRGB"
                                                    filterUnits="userSpaceOnUse">
                                                    <feFlood flood-opacity="0"
                                                        result="BackgroundImageFix" />
                                                    <feColorMatrix in="SourceAlpha" result="hardAlpha"
                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                                                    <feOffset />
                                                    <feColorMatrix
                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.06 0" />
                                                    <feBlend in2="BackgroundImageFix"
                                                        result="effect1_dropShadow_374_135180" />
                                                    <feBlend in="SourceGraphic"
                                                        in2="effect1_dropShadow_374_135180"
                                                        result="shape" />
                                                </filter>
                                            </defs>
                                        </svg>
                                        +370
                                    </span>
                                </button>
                            </li>
                            <li>
                                <button type="button"
                                    class="dropdown-item inline-flex w-full rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-indigo-100 hover:text-gray-900"
                                    role="menuitem">
                                    <span class="inline-flex items-center">
                                        <svg class="w-4 h-4 me-2" fill="none" viewBox="0 0 20 15">
                                            <rect width="19.6" height="14" y=".5" fill="#fff"
                                                rx="2" />
                                            <mask id="a" style="mask-type:luminance"
                                                width="20" height="15" x="0" y="0"
                                                maskUnits="userSpaceOnUse">
                                                <rect width="19.6" height="14" y=".5"
                                                    fill="#fff" rx="2" />
                                            </mask>
                                            <g mask="url(#a)">
                                                <path fill="#0072CE" fill-rule="evenodd"
                                                    d="M0 5.167h19.6V.5H0v4.667z"
                                                    clip-rule="evenodd" />
                                                <g filter="url(#filter0_d_374_135180)">
                                                    <path fill="#000000" fill-rule="evenodd"
                                                        d="M0 9.833h19.6V5.167H0v4.666z"
                                                        clip-rule="evenodd" />
                                                </g>
                                                <g filter="url(#filter1_d_374_135180)">
                                                    <path fill="#FFFFFF" fill-rule="evenodd"
                                                        d="M0 14.5h19.6V9.833H0V14.5z"
                                                        clip-rule="evenodd" />
                                                </g>
                                            </g>
                                            <defs>
                                                <filter id="filter0_d_374_135180" width="19.6"
                                                    height="4.667" x="0" y="5.167"
                                                    color-interpolation-filters="sRGB"
                                                    filterUnits="userSpaceOnUse">
                                                    <feFlood flood-opacity="0"
                                                        result="BackgroundImageFix" />
                                                    <feColorMatrix in="SourceAlpha" result="hardAlpha"
                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                                                    <feOffset />
                                                    <feColorMatrix
                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.06 0" />
                                                    <feBlend in2="BackgroundImageFix"
                                                        result="effect1_dropShadow_374_135180" />
                                                    <feBlend in="SourceGraphic"
                                                        in2="effect1_dropShadow_374_135180"
                                                        result="shape" />
                                                </filter>
                                                <filter id="filter1_d_374_135180" width="19.6"
                                                    height="4.667" x="0" y="9.833"
                                                    color-interpolation-filters="sRGB"
                                                    filterUnits="userSpaceOnUse">
                                                    <feFlood flood-opacity="0"
                                                        result="BackgroundImageFix" />
                                                    <feColorMatrix in="SourceAlpha" result="hardAlpha"
                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                                                    <feOffset />
                                                    <feColorMatrix
                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.06 0" />
                                                    <feBlend in2="BackgroundImageFix"
                                                        result="effect1 dropShadow_374_135180" />
                                                    <feBlend in="SourceGraphic"
                                                        in2="effect1_dropShadow_374_135180"
                                                        result="shape" />
                                                </filter>
                                            </defs>
                                        </svg>
                                        +372
                                    </span>
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="relative w-full">
                        <input type="hidden" id="full-phone-number" name="phone_nr" value="+371">
        <input type="tel" id="phone-input"
    class="z-20 block w-full border p-2.5 text-sm border border-gray-300 rounded-r-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
    inputmode="numeric" pattern="[0-9]{7,20}"
    title="Phone number should be numeric and between 7 to 20 digits."
    oninput="this.value = this.value.replace(/[^0-9]/g, ''); updateFullPhoneNumber();" />
    
                    </div>
                    
                </div>
                <div id="phone-length" class="hidden text-xs text-gray-500 mt-1">
                    Phone number too short.
                </div>
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
    const phoneLength = document.getElementById('phone-length');
    const passwordHint = document.getElementById('password-hint');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const passwordMatchHint = document.getElementById('password-match');
    const emailInput = document.getElementById('email');
    const emailHint = document.getElementById('email-hint');
    const phoneInput = document.getElementById('phone-input');
    const submitButton = document.querySelector('button[type="submit"]');
    
    let passwordHasBeenFocused = false;

    function validatePassword() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/;
        let passwordValid = true;

        if (regex.test(password)) {
            passwordHint.classList.remove('text-red-500');
            passwordHint.classList.add('text-green-500');
            passwordHint.textContent = 'Password meets all requirements.';
        } else {
            passwordHint.classList.remove('text-green-500');
            passwordHint.classList.add('text-red-500');
            passwordHint.textContent = 'Your password should be 8-16 characters long and include at least one uppercase letter, a number, and a special character.';
            passwordHint.classList.remove('hidden');
            passwordValid = false;
        }

        const passwordsMatch = (password === confirmPassword);
        if (passwordsMatch) {
            passwordMatchHint.classList.remove('text-red-500');
            passwordMatchHint.classList.add('text-green-500');
            passwordMatchHint.textContent = 'Passwords match.';
        } else {
            passwordMatchHint.classList.add('text-red-500');
            passwordMatchHint.textContent = 'Your passwords do not match.';
            passwordMatchHint.classList.remove('hidden');
        }

        return passwordValid && passwordsMatch;
    }

    function validateEmail() {
        const email = emailInput.value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailRegex.test(email)) {
            emailHint.classList.add('hidden');
            return true; // Email is valid
        } else {
            emailHint.classList.add('text-red-500');
            emailHint.classList.remove('hidden');
            return false; // Email is not valid
        }
    }

    function validatePhoneNumber() {
        const phoneNumber = phoneInput.value;
        if(phoneNumber.length>=8){
            phoneLength.classList.add('hidden');
            return true;
        }
        phoneLength.classList.add('text-red-500');
        phoneLength.classList.remove('hidden');
        return false;
    }

    function validateForm() {
        if (!passwordHasBeenFocused) {
            return; // Don't validate if password hasn't been focused yet
        }
        
        const isPasswordValid = validatePassword();
        const isEmailValid = validateEmail();
        const isPhoneValid = validatePhoneNumber();
        submitButton.disabled = !(isPasswordValid && isEmailValid && isPhoneValid);
    }

    passwordInput.addEventListener('focus', function() {
        passwordHasBeenFocused = true;
        passwordHint.classList.remove('hidden');
    });

    passwordInput.addEventListener('blur', function() {
        passwordHint.classList.add('hidden');
    });
    confirmPasswordInput.addEventListener('blur', function() {
        passwordMatchHint.classList.add('hidden');
    });
    confirmPasswordInput.addEventListener('focus', function() {
        passwordMatchHint.classList.remove('hidden');
    });

    passwordInput.addEventListener('input', validateForm);
    confirmPasswordInput.addEventListener('input', validateForm);
    emailInput.addEventListener('input', validateForm);
    phoneInput.addEventListener('input', validateForm);

    // Initial state: disable submit button
    submitButton.disabled = true;
});
document.addEventListener('DOMContentLoaded', function() {
    const dropdownButton = document.getElementById('dropdown-phone-button-3');
    const dropdownMenu = document.getElementById('dropdown-phone-3');
    const dropdownItems = dropdownMenu.querySelectorAll('.dropdown-item');
    const phoneInput = document.getElementById('phone-input');
    const fullPhoneNumberInput = document.getElementById('full-phone-number');

    function updateFullPhoneNumber() {
        const prefix = dropdownButton.querySelector('span').textContent.trim();
        const number = phoneInput.value;
        fullPhoneNumberInput.value = prefix + number;
    }

    dropdownButton.addEventListener('click', function() {
        dropdownMenu.classList.toggle('hidden');
    });

    dropdownItems.forEach(function(item) {
        item.addEventListener('click', function() {
            const buttonLabel = this.innerHTML.trim();
            dropdownButton.innerHTML = buttonLabel + ' <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" /></svg>';
            dropdownMenu.classList.add('hidden');
            updateFullPhoneNumber();
        });
    });

    document.addEventListener('click', function(event) {
        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });

    phoneInput.addEventListener('input', updateFullPhoneNumber);

    // Initial update
    updateFullPhoneNumber();
});
          
    </script>
    </body>
    </html>
