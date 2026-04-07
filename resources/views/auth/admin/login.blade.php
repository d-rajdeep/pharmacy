<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Management System - Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            /* Applying your custom gradient */
            background: linear-gradient(to right, #8971ea, #7f72ea, #7574ea, #6a75e9, #5f76e8) !important;
        }

        /* Modern card styling matching dashboard cards */
        .login-box {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f5f9;
            transition: transform 0.3s ease-in-out;
        }

        /* Submit Button Styling */
        .btn-gradient {
            background: linear-gradient(to right, #8971ea, #5f76e8);
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(95, 118, 232, 0.3);
        }

        .btn-gradient:hover {
            box-shadow: 0 6px 18px rgba(95, 118, 232, 0.45);
            transform: translateY(-1px);
        }

        /* Input field modernization */
        .modern-input {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.2s;
        }

        .modern-input:focus {
            background-color: #ffffff;
            border-color: #7f72ea;
            box-shadow: 0 0 0 3px rgba(127, 114, 234, 0.15);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">

    <div class="max-w-[450px] w-full relative z-10 p-2 md:p-0">
        <div class="login-box p-8 md:p-10 fade-in">

            <div class="text-center mb-10">
                <img src="{{ asset('assets/images/drugs.png') }}" alt="Pharmacy Logo" class="mx-auto h-14 w-auto mb-4"
                    style="object-fit: contain;">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Admin Login</h2>
                <p class="mt-2 text-sm text-gray-500 font-medium">Pharmacy Management System</p>
            </div>

            @if ($errors->any())
                <div class="rounded-xl bg-red-50 p-4 border border-red-100 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 fa-lg mt-1"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-red-800">Authentication Failed</h3>
                            <div class="mt-1 text-xs text-red-700">
                                <p>Please check your credentials and try again.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form class="space-y-6" method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Email
                        Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i
                                class="fas fa-envelope text-gray-400 group-focus-within:text-purple-600 transition-colors duration-200"></i>
                        </div>
                        <input id="email" name="email" type="email" required
                            class="modern-input block w-full px-4 py-3 pl-11 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-200 focus:border-purple-500 transition duration-200 @error('email') border-red-500 bg-red-50/50 @enderror"
                            placeholder="admin@pharmacy.com" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-600 font-medium flex items-center ml-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i
                                class="fas fa-lock text-gray-400 group-focus-within:text-purple-600 transition-colors duration-200"></i>
                        </div>
                        <input id="password" name="password" type="password" required
                            class="modern-input block w-full px-4 py-3 pl-11 pr-11 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-200 focus:border-purple-500 transition duration-200 @error('password') border-red-500 bg-red-50/50 @enderror"
                            placeholder="Enter your password">

                        <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center"
                            onclick="togglePassword()">
                            <i id="password-icon"
                                class="fas fa-eye text-gray-400 hover:text-purple-600 cursor-pointer"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-600 font-medium flex items-center ml-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded cursor-pointer">
                        <label for="remember" class="ml-2 block text-sm text-gray-600 cursor-pointer select-none">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#"
                            class="font-semibold text-purple-600 hover:text-purple-800 transition duration-200">
                            Forgot password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-base font-semibold rounded-xl btn-gradient focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-4">
                            <i class="fas fa-sign-in-alt text-white/70 group-hover:text-white"></i>
                        </span>
                        Sign In to Dashboard
                    </button>
                </div>

            </form>
        </div>

        <div class="text-center mt-8 text-xs text-gray-100 font-medium">
            <p>&copy; 2026 Pharmacy Management. All rights reserved.</p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
