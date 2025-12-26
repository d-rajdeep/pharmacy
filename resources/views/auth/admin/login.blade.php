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
        }

        /* Smooth fade-in animation */
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Subtle medical cross pattern background */
        .medical-pattern {
            background-color: #f0f9ff;
            background-image: radial-gradient(#bae6fd 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>

<body class="medical-pattern min-h-screen flex items-center justify-center p-4">

    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div
            class="absolute -top-24 -left-24 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40">
        </div>
        <div
            class="absolute -bottom-24 -right-24 w-96 h-96 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40">
        </div>
    </div>

    <div class="max-w-[450px] w-full fade-in relative z-10">
        <div
            class="bg-white/80 backdrop-blur-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl border border-white/60 overflow-hidden">

            <div class="px-8 pt-10 pb-6 text-center">
                <div
                    class="mx-auto h-20 w-20 bg-gradient-to-tr from-blue-600 to-teal-400 rounded-2xl shadow-lg shadow-blue-500/20 flex items-center justify-center mb-6 transform rotate-3 hover:rotate-6 transition-transform duration-300">
                    <i class="fas fa-capsules text-white text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Welcome Back</h2>
                <p class="mt-2 text-sm text-gray-500 font-medium">Pharmacy Admin Portal</p>
            </div>

            <form class="px-8 pb-10 space-y-6" method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="text-xs font-bold text-gray-500 uppercase tracking-wide ml-1">Email
                        Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i
                                class="fas fa-envelope text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200"></i>
                        </div>
                        <input id="email" name="email" type="email" required
                            class="block w-full pl-11 pr-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 @error('email') border-red-500 bg-red-50/50 @enderror"
                            placeholder="admin@pharmacy.com" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <p class="text-xs text-red-600 font-medium flex items-center mt-1 ml-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password"
                        class="text-xs font-bold text-gray-500 uppercase tracking-wide ml-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i
                                class="fas fa-lock text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200"></i>
                        </div>
                        <input id="password" name="password" type="password" required
                            class="block w-full pl-11 pr-12 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 @error('password') border-red-500 bg-red-50/50 @enderror"
                            placeholder="••••••••">

                        <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center"
                            onclick="togglePassword()">
                            <i id="password-icon"
                                class="fas fa-eye text-gray-400 hover:text-blue-600 cursor-pointer transition-colors"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-600 font-medium flex items-center mt-1 ml-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                        <label for="remember" class="ml-2 block text-sm text-gray-600 cursor-pointer select-none">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500 transition duration-200">
                            Forgot password?
                        </a>
                    </div>
                </div>

                <button type="submit"
                    class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-blue-600 to-teal-500 hover:from-blue-700 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-500/30 transition-all duration-200 transform hover:-translate-y-0.5">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-4">
                        <i class="fas fa-sign-in-alt text-white/90 group-hover:text-white transition-colors"></i>
                    </span>
                    Sign In
                </button>

                @if ($errors->any())
                    <div class="rounded-xl bg-red-50 p-4 border border-red-100 animate-pulse mt-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-circle-exclamation text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Authentication Failed</h3>
                                <div class="mt-1 text-xs text-red-700">
                                    <p>Please check your credentials and try again.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>

        <div class="text-center mt-8">
            <p class="text-xs text-gray-400 font-medium">&copy; 2025 Pharmacy Management System</p>
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
