<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmaCare | Admin Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --glass-bg: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .glass-effect {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
        }

        .neumorphic {
            border-radius: 20px;
            background: linear-gradient(145deg, #1a202c, #161b26);
            box-shadow: 12px 12px 24px #0d1117,
                -12px -12px 24px #2d3748;
        }

        .input-glass {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .pulse-ring {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 15px rgba(102, 126, 234, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
            }
        }

        .glow {
            filter: drop-shadow(0 0 15px rgba(102, 126, 234, 0.5));
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .slide-in {
            animation: slideIn 0.6s ease-out forwards;
            opacity: 0;
            transform: translateX(-30px);
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .btn-hover-effect {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-hover-effect::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-hover-effect:hover::after {
            width: 300px;
            height: 300px;
        }

        .input-focus-effect:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }
    </style>
</head>

<body class="relative overflow-hidden">
    <!-- Animated background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl floating"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl floating"
            style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-pink-500/10 rounded-full blur-3xl floating"
            style="animation-delay: 2s;"></div>

        <!-- Grid pattern -->
        <div class="absolute inset-0 opacity-5"
            style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 50px 50px;">
        </div>
    </div>

    <!-- Floating particles -->
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-white rounded-full opacity-30 floating"></div>
        <div class="absolute top-1/3 right-1/3 w-1 h-1 bg-blue-400 rounded-full opacity-40 floating"
            style="animation-delay: 0.5s;"></div>
        <div class="absolute bottom-1/4 left-1/3 w-3 h-3 bg-purple-400 rounded-full opacity-20 floating"
            style="animation-delay: 1.5s;"></div>
    </div>

    <!-- Main container -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="max-w-[480px] w-full slide-in" style="animation-delay: 0.2s;">
            <!-- Logo header -->
            <div class="text-center mb-10 slide-in" style="animation-delay: 0.4s;">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl glass-effect mb-6 glow">
                    <i class="fas fa-pills text-3xl gradient-text"></i>
                </div>
                <h1 class="text-4xl font-bold text-white mb-2">Pharma<span class="gradient-text">Care</span></h1>
                <p class="text-gray-400 font-medium">Secure Admin Portal</p>
            </div>

            <!-- Login card -->
            <div class="neumorphic rounded-3xl p-8 relative overflow-hidden">
                <!-- Decorative corner elements -->
                <div
                    class="absolute -top-10 -right-10 w-40 h-40 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-full blur-xl">
                </div>
                <div
                    class="absolute -bottom-10 -left-10 w-40 h-40 bg-gradient-to-tr from-blue-500/20 to-cyan-500/20 rounded-full blur-xl">
                </div>

                <!-- Form header -->
                <div class="mb-8 relative z-10 slide-in" style="animation-delay: 0.6s;">
                    <h2 class="text-2xl font-bold text-white mb-2">Welcome Back</h2>
                    <p class="text-gray-400">Enter your credentials to access the dashboard</p>
                </div>

                <!-- Login form -->
                <form class="space-y-6 relative z-10" method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <!-- Email field -->
                    <div class="space-y-3 slide-in" style="animation-delay: 0.8s;">
                        <div class="flex items-center">
                            <label for="email"
                                class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Email
                                Address</label>
                            <span class="ml-2 text-xs text-red-500">*</span>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i
                                    class="fas fa-envelope text-gray-500 group-focus-within:text-purple-500 transition-colors duration-300"></i>
                            </div>
                            <input id="email" name="email" type="email" required
                                class="w-full pl-12 pr-4 py-4 rounded-xl input-glass text-white placeholder-gray-500 focus:outline-none input-focus-effect transition-all duration-300 @error('email') border-red-500/50 bg-red-900/20 @enderror"
                                placeholder="admin@pharmacare.com" value="{{ old('email') }}">
                            <div
                                class="absolute inset-0 rounded-xl border border-transparent group-focus-within:border-purple-500/30 pointer-events-none transition-all duration-300">
                            </div>
                        </div>
                        @error('email')
                            <div class="flex items-center text-red-400 text-sm mt-2">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Password field -->
                    <div class="space-y-3 slide-in" style="animation-delay: 1s;">
                        <div class="flex items-center">
                            <label for="password"
                                class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Password</label>
                            <span class="ml-2 text-xs text-red-500">*</span>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i
                                    class="fas fa-lock text-gray-500 group-focus-within:text-purple-500 transition-colors duration-300"></i>
                            </div>
                            <input id="password" name="password" type="password" required
                                class="w-full pl-12 pr-12 py-4 rounded-xl input-glass text-white placeholder-gray-500 focus:outline-none input-focus-effect transition-all duration-300 @error('password') border-red-500/50 bg-red-900/20 @enderror"
                                placeholder="Enter your password">
                            <div
                                class="absolute inset-0 rounded-xl border border-transparent group-focus-within:border-purple-500/30 pointer-events-none transition-all duration-300">
                            </div>

                            <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center"
                                onclick="togglePassword()">
                                <i id="password-icon"
                                    class="fas fa-eye text-gray-500 hover:text-purple-400 cursor-pointer transition-colors duration-300"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="flex items-center text-red-400 text-sm mt-2">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between pt-2 slide-in" style="animation-delay: 1.2s;">
                        <div class="flex items-center">
                            <div class="relative">
                                <input id="remember" name="remember" type="checkbox" class="sr-only peer">
                                <div
                                    class="w-5 h-5 bg-gray-800 border border-gray-700 rounded-md peer-checked:bg-gradient-to-r peer-checked:from-purple-600 peer-checked:to-pink-600 peer-checked:border-transparent transition-all duration-300 flex items-center justify-center">
                                    <i
                                        class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100 transition-opacity duration-300"></i>
                                </div>
                            </div>
                            <label for="remember" class="ml-3 text-sm text-gray-400 cursor-pointer select-none">
                                Remember this device
                            </label>
                        </div>

                        <a href="#"
                            class="text-sm font-medium text-purple-400 hover:text-purple-300 transition-colors duration-300 group">
                            <span class="group-hover:underline">Forgot password?</span>
                            <i
                                class="fas fa-arrow-right ml-1 text-xs transform group-hover:translate-x-1 transition-transform duration-300"></i>
                        </a>
                    </div>

                    <!-- Submit button -->
                    <div class="pt-4 slide-in" style="animation-delay: 1.4s;">
                        <button type="submit"
                            class="btn-hover-effect relative w-full py-4 px-6 text-lg font-semibold rounded-xl text-white bg-gradient-to-r from-purple-600 via-pink-600 to-purple-600 bg-[length:200%] hover:bg-[length:100%] transition-all duration-500 shadow-lg shadow-purple-900/30 hover:shadow-purple-900/50 overflow-hidden group">
                            <span class="relative z-10 flex items-center justify-center">
                                <i
                                    class="fas fa-lock-open mr-3 group-hover:rotate-12 transition-transform duration-300"></i>
                                Authenticate & Continue
                                <i
                                    class="fas fa-arrow-right ml-3 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300"></i>
                            </span>
                        </button>
                    </div>

                    <!-- Error message -->
                    @if ($errors->any())
                        <div class="mt-6 p-4 rounded-xl bg-gradient-to-r from-red-900/30 to-pink-900/20 border border-red-800/30 slide-in"
                            style="animation-delay: 1.6s;">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-shield-exclamation text-red-400 text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-semibold text-red-300">Authentication Required</h3>
                                    <p class="mt-1 text-sm text-red-400/80">Invalid credentials. Please verify your
                                        email and password.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>

                <!-- Security note -->
                <div class="mt-8 pt-6 border-t border-gray-800 slide-in" style="animation-delay: 1.8s;">
                    <div class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-shield-alt mr-3 text-purple-500"></i>
                        <span>Your credentials are encrypted and secured with 256-bit SSL</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 slide-in" style="animation-delay: 2s;">
                <p class="text-xs text-gray-500 font-medium">
                    &copy; 2025 PharmaCare Management System v3.1
                    <span class="mx-2">•</span>
                    <span class="text-gray-600">Protected Environment</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Session timeout warning (hidden by default) -->
    <div id="sessionWarning"
        class="fixed bottom-6 left-1/2 transform -translate-x-1/2 glass-effect rounded-xl p-4 border border-yellow-500/30 max-w-md hidden">
        <div class="flex items-center">
            <i class="fas fa-clock text-yellow-500 text-xl mr-3"></i>
            <div>
                <h4 class="font-semibold text-white">Session Security</h4>
                <p class="text-sm text-gray-400">Your session will expire in 5 minutes for security</p>
            </div>
            <button class="ml-4 text-gray-500 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
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
                passwordIcon.classList.add('text-purple-400');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash', 'text-purple-400');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Add subtle hover effects to all inputs
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-purple-500/20');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-purple-500/20');
            });
        });

        // Simulate session warning after 30 seconds
        setTimeout(() => {
            const warning = document.getElementById('sessionWarning');
            warning.classList.remove('hidden');
            warning.classList.add('animate__animated', 'animate__fadeInUp');

            // Auto-hide after 10 seconds
            setTimeout(() => {
                warning.classList.add('animate__fadeOutDown');
                setTimeout(() => warning.classList.add('hidden'), 500);
            }, 10000);
        }, 30000);
    </script>

    <!-- Add animate.css for extra animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</body>

</html>
