<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Management System - User Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .pharmacy-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-shadow {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
    </style>
</head>
<body class="pharmacy-bg min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Login Card -->
        <div class="bg-white rounded-2xl card-shadow overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6 text-center">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <div class="bg-white bg-opacity-20 p-3 rounded-full">
                        <i class="fas fa-user-injured text-white text-2xl"></i>
                    </div>
                    <div class="text-left">
                        <h1 class="text-2xl font-bold text-white">Pharmacist Portal</h1>
                        <p class="text-blue-100 text-sm">Access your pharmacy account</p>
                    </div>
                </div>
            </div>

            <!-- Login Form -->
            <form class="p-8 space-y-6" method="POST" action="{{ route('user.login') }}">
                @csrf
                
                <!-- Welcome Message -->
                <div class="text-center mb-2">
                    <h2 class="text-xl font-semibold text-gray-800">Welcome Back</h2>
                    <p class="text-gray-600 text-sm mt-1">Sign in to manage your prescriptions</p>
                </div>

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            required 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg input-focus focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('email') border-red-500 @enderror"
                            placeholder="patient@example.com"
                            value="{{ old('email') }}"
                            autocomplete="email"
                        >
                    </div>
                    @error('email')
                        <p class="text-red-600 text-xs flex items-center mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-500 transition duration-200">
                            Forgot password?
                        </a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required 
                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg input-focus focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('password') border-red-500 @enderror"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                        >
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword()">
                            <i id="password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-xs flex items-center mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input 
                        id="remember" 
                        name="remember" 
                        type="checkbox" 
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Keep me signed in
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 transform hover:scale-[1.02] flex items-center justify-center space-x-2">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Sign In to Account</span>
                </button>

                <!-- Error Message -->
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                            <span class="text-red-800 text-sm font-medium">Invalid credentials. Please try again.</span>
                        </div>
                    </div>
                @endif
            </form>

            <!-- Footer Links -->
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-200">
                <div class="text-center">
                    <p class="text-gray-600 text-sm">
                        Don't have an account?
                        <a href="#" class="text-blue-600 hover:text-blue-500 font-semibold ml-1 transition duration-200">
                            Sign up here
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Additional Features -->
        <div class="mt-6 grid grid-cols-3 gap-4 text-center">
            <div class="bg-white bg-opacity-20 rounded-lg p-3 backdrop-blur-sm">
                <i class="fas fa-prescription text-white text-lg mb-1"></i>
                <p class="text-white text-xs">Prescription History</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3 backdrop-blur-sm">
                <i class="fas fa-pills text-white text-lg mb-1"></i>
                <p class="text-white text-xs">Medicine Orders</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3 backdrop-blur-sm">
                <i class="fas fa-calendar-alt text-white text-lg mb-1"></i>
                <p class="text-white text-xs">Appointments</p>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center mt-6">
            <p class="text-white text-opacity-80 text-sm">
                &copy; 2025 Pharmacy Management System. Secure patient portal.
            </p>
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
                passwordIcon.classList.add('text-blue-500');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.remove('text-blue-500');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Add interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
            
            inputs.forEach(input => {
                // Add focus effects
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-blue-200', 'rounded-lg');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-blue-200');
                });

                // Add input validation styling
                input.addEventListener('input', function() {
                    if (this.value.length > 0) {
                        this.classList.add('border-green-300');
                    } else {
                        this.classList.remove('border-green-300');
                    }
                });
            });

            // Add loading state to form submission
            const form = document.querySelector('form');
            form.addEventListener('submit', function() {
                const button = this.querySelector('button[type="submit"]');
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span> Signing In...</span>';
                button.disabled = true;
            });
        });
    </script>
</body>
</html>