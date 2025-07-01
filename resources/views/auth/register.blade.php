@extends('layouts.app')
@section('title', 'Register')
@section('content')
    @push('style')
        <style>
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
                background-size: 400% 400%;
                animation: gradientShift 15s ease infinite;
            }

            @keyframes gradientShift {

                0%,
                100% {
                    background-position: 0% 50%;
                }

                25% {
                    background-position: 100% 50%;
                }

                50% {
                    background-position: 0% 100%;
                }

                75% {
                    background-position: 100% 0%;
                }
            }

            .floating-shapes {
                position: absolute;
                width: 100%;
                height: 100%;
                overflow: hidden;
                pointer-events: none;
            }

            .shape {
                position: absolute;
                opacity: 0.1;
                animation: float 8s ease-in-out infinite;
            }

            .shape:nth-child(1) {
                top: 15%;
                left: 10%;
                animation-delay: 0s;
            }

            .shape:nth-child(2) {
                top: 70%;
                right: 15%;
                animation-delay: 3s;
            }

            .shape:nth-child(3) {
                bottom: 25%;
                left: 25%;
                animation-delay: 6s;
            }

            .shape:nth-child(4) {
                top: 45%;
                right: 35%;
                animation-delay: 2s;
            }

            .shape:nth-child(5) {
                top: 80%;
                left: 60%;
                animation-delay: 4s;
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px) rotate(0deg);
                }

                50% {
                    transform: translateY(-30px) rotate(180deg);
                }
            }

            .register-card {
                backdrop-filter: blur(20px);
                background: rgba(255, 255, 255, 0.95);
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }

            .input-group {
                position: relative;
            }

            .input-field {
                transition: all 0.3s ease;
            }

            .input-field:focus {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.25);
            }

            .input-field.valid {
                border-color: #10b981;
                background-color: #f0fdf4;
            }

            .input-field.invalid {
                border-color: #ef4444;
                background-color: #fef2f2;
            }

            .input-icon {
                transition: all 0.3s ease;
            }

            .input-field:focus+.input-icon {
                color: #667eea;
                transform: scale(1.1);
            }

            .social-btn {
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .social-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.5s;
            }

            .social-btn:hover::before {
                left: 100%;
            }

            .social-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.25);
            }

            .google-btn:hover {
                background: #ea4335;
                color: white;
            }

            .github-btn:hover {
                background: #333;
                color: white;
            }

            .twitter-btn:hover {
                background: #1da1f2;
                color: white;
            }

            .password-strength {
                height: 4px;
                background: #e5e7eb;
                border-radius: 2px;
                overflow: hidden;
                margin-top: 8px;
            }

            .password-strength-bar {
                height: 100%;
                transition: all 0.3s ease;
                border-radius: 2px;
            }

            .strength-weak {
                background: #ef4444;
                width: 25%;
            }

            .strength-fair {
                background: #f59e0b;
                width: 50%;
            }

            .strength-good {
                background: #10b981;
                width: 75%;
            }

            .strength-strong {
                background: #059669;
                width: 100%;
            }

            .password-requirements {
                margin-top: 8px;
                font-size: 12px;
            }

            .requirement {
                display: flex;
                align-items: center;
                margin-bottom: 4px;
                transition: all 0.3s ease;
            }

            .requirement.met {
                color: #10b981;
            }

            .requirement.unmet {
                color: #6b7280;
            }

            .requirement i {
                width: 16px;
                margin-right: 8px;
            }

            .fade-in {
                animation: fadeIn 0.8s ease-out;
            }

            .fade-in-up {
                animation: fadeInUp 0.8s ease-out;
            }

            .fade-in-delay {
                animation: fadeInUp 0.8s ease-out 0.2s both;
            }

            .fade-in-delay-2 {
                animation: fadeInUp 0.8s ease-out 0.4s both;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .password-toggle {
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .password-toggle:hover {
                color: #667eea;
                transform: scale(1.1);
            }

            .checkbox-custom {
                appearance: none;
                width: 20px;
                height: 20px;
                border: 2px solid #d1d5db;
                border-radius: 4px;
                position: relative;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .checkbox-custom:checked {
                background: #667eea;
                border-color: #667eea;
            }

            .checkbox-custom:checked::after {
                content: '✓';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: white;
                font-size: 12px;
                font-weight: bold;
            }

            .register-btn {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .register-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.5s;
            }

            .register-btn:hover::before {
                left: 100%;
            }

            .register-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 15px 35px -5px rgba(102, 126, 234, 0.4);
            }

            .register-btn:active {
                transform: translateY(0);
            }

            .register-btn:disabled {
                opacity: 0.6;
                cursor: not-allowed;
                transform: none;
            }

            .loading-spinner {
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            .error-message {
                animation: shake 0.5s ease-in-out;
            }

            @keyframes shake {

                0%,
                100% {
                    transform: translateX(0);
                }

                25% {
                    transform: translateX(-5px);
                }

                75% {
                    transform: translateX(5px);
                }
            }

            .success-message {
                animation: slideDown 0.5s ease-out;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .divider {
                position: relative;
            }

            .divider::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                height: 1px;
                background: #e5e7eb;
            }

            .divider span {
                background: rgba(255, 255, 255, 0.95);
                padding: 0 1rem;
            }

            .feature-highlight {
                background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
                border: 1px solid rgba(102, 126, 234, 0.2);
            }

            .step-indicator {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 2rem;
            }

            .step {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                transition: all 0.3s ease;
                position: relative;
            }

            .step.active {
                background: #667eea;
                color: white;
            }

            .step.completed {
                background: #10b981;
                color: white;
            }

            .step.inactive {
                background: #e5e7eb;
                color: #6b7280;
            }

            .step-connector {
                width: 60px;
                height: 2px;
                background: #e5e7eb;
                margin: 0 8px;
            }

            .step-connector.completed {
                background: #10b981;
            }

            .verification-modal {
                backdrop-filter: blur(20px);
                background: rgba(0, 0, 0, 0.8);
            }

            .pulse-animation {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.7;
                }
            }

            @media (max-width: 768px) {
                .register-card {
                    margin: 1rem;
                    backdrop-filter: blur(15px);
                }

                .floating-shapes {
                    display: none;
                }

                .step-indicator {
                    margin-bottom: 1rem;
                }

                .step {
                    width: 32px;
                    height: 32px;
                    font-size: 14px;
                }

                .step-connector {
                    width: 40px;
                }
            }

            .breadcrumb-arrow::after {
                content: '>';
                margin: 0 8px;
                color: #9CA3AF;
            }

            .breadcrumb-arrow:last-child::after {
                display: none;
            }

            .avatar-upload {
                position: relative;
                width: 100px;
                height: 100px;
                margin: 0 auto 1rem;
                border-radius: 50%;
                border: 4px solid #e5e7eb;
                overflow: hidden;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .avatar-upload:hover {
                border-color: #667eea;
                transform: scale(1.05);
            }

            .avatar-upload img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .avatar-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .avatar-upload:hover .avatar-overlay {
                opacity: 1;
            }
        </style>
    @endpush


    <div class="relative z-10 min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-lg w-full space-y-8">
            <!-- Registration Card -->
            <div class="register-card rounded-2xl p-8 fade-in">
                <!-- Step Indicator -->
                {{-- <div class="step-indicator fade-in-up">
                    <div class="step active" id="step1">1</div>
                    <div class="step-connector" id="connector1"></div>
                    <div class="step inactive" id="step2">2</div>
                    <div class="step-connector" id="connector2"></div>
                    <div class="step inactive" id="step3">3</div>
                </div> --}}

                <!-- Header -->
                <div class="text-center mb-8 fade-in-up">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-purple-600 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-2xl text-white"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Join BlogSite</h2>
                    <p class="text-gray-600">Create your account and start your journey</p>
                </div>

                <!-- Alert Messages -->
                <div id="alertContainer" class="mb-6"></div>

                <!-- Social Registration Buttons -->
                <div class="space-y-3 mb-6 fade-in-delay">
                    <button
                        class="social-btn google-btn w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i class="fab fa-google text-xl mr-3"></i>
                        Sign up with Google
                    </button>
                    <button
                        class="social-btn github-btn w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i class="fab fa-github text-xl mr-3"></i>
                        Sign up with GitHub
                    </button>
                    <button
                        class="social-btn twitter-btn w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i class="fab fa-twitter text-xl mr-3"></i>
                        Sign up with Twitter
                    </button>
                </div>

                <!-- Divider -->
                <div class="divider text-center text-gray-500 text-sm mb-6 fade-in-delay">
                    <span>or create account with email</span>
                </div>

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Step 1: Basic Information -->
                    <div id="step1Content">
                        <!-- Full Name -->
                        <div class="input-group">
                            <label for="fullName" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name *
                            </label>
                            <div class="relative">
                                <input type="text" id="fullName" name="name" :value="old('name')" required
                                    class="input-field w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="Enter your full name" autocomplete="name">
                                <i
                                    class="input-icon fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="input-group">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address *
                            </label>
                            <div class="relative">
                                <input type="email" id="email" name="email" :value="old('email')" required
                                    class="input-field w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="Enter your email" autocomplete="email">
                                <i
                                    class="input-icon fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            <div id="emailFeedback" class="mt-2 text-sm"></div>
                        </div>

                        <!-- Username -->
                        {{-- <div class="input-group">
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                Username *
                            </label>
                            <div class="relative">
                                <input type="text" id="username" name="username" required
                                    class="input-field w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="Choose a username" autocomplete="username">
                                <i
                                    class="input-icon fas fa-at absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            <div id="usernameFeedback" class="mt-2 text-sm"></div>
                        </div> --}}

                        <!-- Password -->
                        <div class="input-group">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password *
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required
                                    class="input-field w-full pl-12 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="Create a strong password" autocomplete="new-password">
                                <i
                                    class="input-icon fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <i class="password-toggle fas fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"
                                    id="passwordToggle"></i>
                            </div>

                            <!-- Password Strength Indicator -->
                            <div class="password-strength">
                                <div class="password-strength-bar" id="strengthBar"></div>
                            </div>
                            <div id="strengthText" class="text-sm mt-1 text-gray-600"></div>

                            <!-- Password Requirements -->
                            {{-- <div class="password-requirements">
                                <div class="requirement unmet" id="lengthReq">
                                    <i class="fas fa-times"></i>
                                    <span>At least 8 characters</span>
                                </div>
                                <div class="requirement unmet" id="uppercaseReq">
                                    <i class="fas fa-times"></i>
                                    <span>One uppercase letter</span>
                                </div>
                                <div class="requirement unmet" id="lowercaseReq">
                                    <i class="fas fa-times"></i>
                                    <span>One lowercase letter</span>
                                </div>
                                <div class="requirement unmet" id="numberReq">
                                    <i class="fas fa-times"></i>
                                    <span>One number</span>
                                </div>
                                <div class="requirement unmet" id="specialReq">
                                    <i class="fas fa-times"></i>
                                    <span>One special character</span>
                                </div>
                            </div> --}}
                        </div>

                        <!-- Confirm Password -->
                        <div class="input-group">
                            <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm Password *
                            </label>
                            <div class="relative">
                                <input type="password" id="confirmPassword" name="password_confirmation" required
                                    class="input-field w-full pl-12 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="Confirm your password" autocomplete="new-password">
                                <i
                                    class="input-icon fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <i class="password-toggle fas fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"
                                    id="confirmPasswordToggle"></i>
                            </div>
                            <div id="confirmPasswordFeedback" class="mt-2 text-sm"></div>
                        </div>
                        <div>
                            <button type="submit"
                                class="ml-auto px-6 py-3 register-btn text-white font-semibold rounded-lg">
                                Register
                            </button>
                        </div>
                    </div>

                    {{-- <!-- Step 2: Profile Information -->
                    <div id="step2Content" class="hidden">
                        <!-- Avatar Upload -->
                        <div class="text-center mb-6">
                            <div class="avatar-upload" id="avatarUpload">
                                <img src="/placeholder.svg?height=100&width=100" alt="Avatar" id="avatarPreview">
                                <div class="avatar-overlay">
                                    <i class="fas fa-camera text-white text-xl"></i>
                                </div>
                            </div>
                            <input type="file" id="avatarInput" accept="image/*" class="hidden">
                            <p class="text-sm text-gray-600">Click to upload profile picture (optional)</p>
                        </div>

                        <!-- Bio -->
                        <div class="input-group">
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                                Bio (Optional)
                            </label>
                            <textarea id="bio" name="bio" rows="3"
                                class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                                placeholder="Tell us about yourself..." maxlength="160"></textarea>
                            <div class="text-right text-sm text-gray-500 mt-1">
                                <span id="bioCount">0</span>/160 characters
                            </div>
                        </div>

                        <!-- Interests -->
                        <div class="input-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Interests (Select up to 5)
                            </label>
                            <div class="grid grid-cols-2 gap-2" id="interestsGrid">
                                <label
                                    class="flex items-center p-2 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input type="checkbox" name="interests" value="javascript" class="mr-2">
                                    <span class="text-sm">JavaScript</span>
                                </label>
                                <label
                                    class="flex items-center p-2 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input type="checkbox" name="interests" value="react" class="mr-2">
                                    <span class="text-sm">React</span>
                                </label>
                                <label
                                    class="flex items-center p-2 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input type="checkbox" name="interests" value="nodejs" class="mr-2">
                                    <span class="text-sm">Node.js</span>
                                </label>
                                <label
                                    class="flex items-center p-2 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input type="checkbox" name="interests" value="python" class="mr-2">
                                    <span class="text-sm">Python</span>
                                </label>
                                <label
                                    class="flex items-center p-2 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input type="checkbox" name="interests" value="css" class="mr-2">
                                    <span class="text-sm">CSS</span>
                                </label>
                                <label
                                    class="flex items-center p-2 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input type="checkbox" name="interests" value="ai" class="mr-2">
                                    <span class="text-sm">AI/ML</span>
                                </label>
                            </div>
                            <div id="interestsFeedback" class="mt-2 text-sm"></div>
                        </div>

                        <!-- Experience Level -->
                        <div class="input-group">
                            <label for="experience" class="block text-sm font-medium text-gray-700 mb-2">
                                Experience Level
                            </label>
                            <select id="experience" name="experience"
                                class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Select your level</option>
                                <option value="beginner">Beginner (0-1 years)</option>
                                <option value="intermediate">Intermediate (1-3 years)</option>
                                <option value="advanced">Advanced (3-5 years)</option>
                                <option value="expert">Expert (5+ years)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Step 3: Terms and Preferences -->
                    <div id="step3Content" class="hidden">
                        <!-- Newsletter Subscription -->
                        <div class="feature-highlight p-4 rounded-lg mb-6">
                            <div class="flex items-start">
                                <input type="checkbox" id="newsletter" name="newsletter"
                                    class="checkbox-custom mt-1 mr-3" checked>
                                <div>
                                    <label for="newsletter" class="font-medium text-gray-900 cursor-pointer">
                                        Subscribe to our newsletter
                                    </label>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Get weekly updates on new articles, tutorials, and tech insights.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Email Preferences -->
                        <div class="space-y-3 mb-6">
                            <h4 class="font-medium text-gray-900">Email Preferences</h4>
                            <label class="flex items-center">
                                <input type="checkbox" name="emailPrefs" value="articles" class="checkbox-custom mr-3"
                                    checked>
                                <span class="text-sm text-gray-700">New article notifications</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="emailPrefs" value="comments" class="checkbox-custom mr-3">
                                <span class="text-sm text-gray-700">Comment replies</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="emailPrefs" value="follows" class="checkbox-custom mr-3">
                                <span class="text-sm text-gray-700">New followers</span>
                            </label>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="space-y-4">
                            <label class="flex items-start">
                                <input type="checkbox" id="terms" name="terms" required
                                    class="checkbox-custom mt-1 mr-3">
                                <span class="text-sm text-gray-700">
                                    I agree to the
                                    <a href="#" class="text-purple-600 hover:text-purple-700 underline">Terms of
                                        Service</a>
                                    and
                                    <a href="#" class="text-purple-600 hover:text-purple-700 underline">Privacy
                                        Policy</a>
                                </span>
                            </label>

                            <label class="flex items-start">
                                <input type="checkbox" id="age" name="age" required
                                    class="checkbox-custom mt-1 mr-3">
                                <span class="text-sm text-gray-700">
                                    I confirm that I am at least 13 years old
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between pt-6">
                        <button type="button" id="prevBtn"
                            class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors hidden">
                            Previous
                        </button>



                        {{-- <button type="submit" id="submitBtn"
                            class="ml-auto register-btn px-6 py-3 text-white font-semibold rounded-lg hidden">
                            <span class="register-text">Create Account</span>
                            <span class="loading-text hidden">
                                <i class="loading-spinner fas fa-spinner mr-2"></i>
                                Creating Account...
                            </span>
                        </button> --}}
                    {{-- </div>  --}}
                </form>

                <!-- Login Link -->
                {{-- <div class="text-center mt-6 fade-in-delay-2">
                    <p class="text-gray-600">
                        Already have an account?
                        <a href="#" class="text-purple-600 hover:text-purple-700 font-medium transition-colors">
                            Sign in here
                        </a>
                    </p>
                </div>

                <!-- Security Features -->
                <div class="mt-8 pt-6 border-t border-gray-200 fade-in-delay-2">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="feature-highlight p-3 rounded-lg">
                            <i class="fas fa-shield-alt text-purple-600 text-lg mb-2"></i>
                            <p class="text-xs text-gray-600">SSL Encrypted</p>
                        </div>
                        <div class="feature-highlight p-3 rounded-lg">
                            <i class="fas fa-lock text-purple-600 text-lg mb-2"></i>
                            <p class="text-xs text-gray-600">Secure Signup</p>
                        </div>
                        <div class="feature-highlight p-3 rounded-lg">
                            <i class="fas fa-envelope-check text-purple-600 text-lg mb-2"></i>
                            <p class="text-xs text-gray-600">Email Verified</p>
                        </div>
                    </div>
                </div> --}}
            </div>

            <!-- Additional Info -->
            {{-- <div class="text-center text-white text-sm fade-in-delay-2">
                <p class="mb-2">
                    <i class="fas fa-users mr-1"></i>
                    Join 150,000+ developers worldwide
                </p>
                <p class="text-purple-200">
                    Free forever • No spam • Unsubscribe anytime
                </p>
            </div> --}}
        </div>
    </div>

    @push('script')
        <script>
            // Global variables
            let currentStep = 1;
            const totalSteps = 3;
            let passwordStrength = 0;

            // DOM Elements
            const registerForm = document.getElementById('registerForm');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const submitBtn = document.getElementById('submitBtn');
            const alertContainer = document.getElementById('alertContainer');
            const verificationModal = document.getElementById('verificationModal');

            // Initialize
            document.addEventListener('DOMContentLoaded', function() {
                setupEventListeners();
                updateStepIndicator();
                document.getElementById('fullName').focus();
            });

            function setupEventListeners() {
                // Form navigation
                nextBtn.addEventListener('click', nextStep);
                prevBtn.addEventListener('click', prevStep);
                registerForm.addEventListener('submit', handleSubmit);

                // Password toggles
                document.getElementById('passwordToggle').addEventListener('click', () => togglePassword('password'));
                document.getElementById('confirmPasswordToggle').addEventListener('click', () => togglePassword(
                    'confirmPassword'));

                // Real-time validation
                document.getElementById('email').addEventListener('input', validateEmail);
                document.getElementById('username').addEventListener('input', validateUsername);
                document.getElementById('password').addEventListener('input', validatePassword);
                document.getElementById('confirmPassword').addEventListener('input', validateConfirmPassword);

                // Bio character counter
                document.getElementById('bio').addEventListener('input', updateBioCounter);

                // Interests validation
                document.querySelectorAll('input[name="interests"]').forEach(checkbox => {
                    checkbox.addEventListener('change', validateInterests);
                });

                // Avatar upload
                document.getElementById('avatarUpload').addEventListener('click', () => {
                    document.getElementById('avatarInput').click();
                });
                document.getElementById('avatarInput').addEventListener('change', handleAvatarUpload);

                // Social registration
                document.querySelectorAll('.social-btn').forEach(btn => {
                    btn.addEventListener('click', handleSocialRegistration);
                });

                // Verification modal
                document.getElementById('resendVerification').addEventListener('click', resendVerification);
                document.getElementById('changeEmail').addEventListener('click', changeEmail);
            }

            function nextStep() {
                if (validateCurrentStep()) {
                    if (currentStep < totalSteps) {
                        currentStep++;
                        updateStepDisplay();
                        updateStepIndicator();
                    }
                }
            }

            function prevStep() {
                if (currentStep > 1) {
                    currentStep--;
                    updateStepDisplay();
                    updateStepIndicator();
                }
            }

            function updateStepDisplay() {
                // Hide all step contents
                for (let i = 1; i <= totalSteps; i++) {
                    document.getElementById(`step${i}Content`).classList.add('hidden');
                }

                // Show current step content
                document.getElementById(`step${currentStep}Content`).classList.remove('hidden');

                // Update navigation buttons
                prevBtn.classList.toggle('hidden', currentStep === 1);
                nextBtn.classList.toggle('hidden', currentStep === totalSteps);
                submitBtn.classList.toggle('hidden', currentStep !== totalSteps);
            }

            function updateStepIndicator() {
                for (let i = 1; i <= totalSteps; i++) {
                    const step = document.getElementById(`step${i}`);
                    const connector = document.getElementById(`connector${i}`);

                    if (i < currentStep) {
                        step.className = 'step completed';
                        step.innerHTML = '<i class="fas fa-check"></i>';
                        if (connector) connector.classList.add('completed');
                    } else if (i === currentStep) {
                        step.className = 'step active';
                        step.textContent = i;
                    } else {
                        step.className = 'step inactive';
                        step.textContent = i;
                        if (connector) connector.classList.remove('completed');
                    }
                }
            }

            function validateCurrentStep() {
                switch (currentStep) {
                    case 1:
                        return validateStep1();
                    case 2:
                        return validateStep2();
                    case 3:
                        return validateStep3();
                    default:
                        return true;
                }
            }

            function validateStep1() {
                const fullName = document.getElementById('fullName').value.trim();
                const email = document.getElementById('email').value.trim();
                const username = document.getElementById('username').value.trim();
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;

                if (!fullName || !email || !username || !password || !confirmPassword) {
                    showAlert('Please fill in all required fields.');
                    return false;
                }

                if (!isValidEmail(email)) {
                    showAlert('Please enter a valid email address.');
                    return false;
                }

                if (username.length < 3) {
                    showAlert('Username must be at least 3 characters long.');
                    return false;
                }

                if (passwordStrength < 3) {
                    showAlert('Please choose a stronger password.');
                    return false;
                }

                if (password !== confirmPassword) {
                    showAlert('Passwords do not match.');
                    return false;
                }

                return true;
            }

            function validateStep2() {
                // Step 2 is optional, so always return true
                return true;
            }

            function validateStep3() {
                const terms = document.getElementById('terms').checked;
                const age = document.getElementById('age').checked;

                if (!terms || !age) {
                    showAlert('Please accept the terms and confirm your age.');
                    return false;
                }

                return true;
            }

            function validateEmail() {
                const email = this.value.trim();
                const feedback = document.getElementById('emailFeedback');

                if (!email) {
                    this.classList.remove('valid', 'invalid');
                    feedback.textContent = '';
                    return;
                }

                if (isValidEmail(email)) {
                    this.classList.add('valid');
                    this.classList.remove('invalid');
                    feedback.innerHTML =
                        '<span class="text-green-600"><i class="fas fa-check mr-1"></i>Valid email address</span>';

                    // Simulate email availability check
                    setTimeout(() => {
                        if (email === 'taken@example.com') {
                            this.classList.add('invalid');
                            this.classList.remove('valid');
                            feedback.innerHTML =
                                '<span class="text-red-600"><i class="fas fa-times mr-1"></i>Email already registered</span>';
                        }
                    }, 500);
                } else {
                    this.classList.add('invalid');
                    this.classList.remove('valid');
                    feedback.innerHTML =
                        '<span class="text-red-600"><i class="fas fa-times mr-1"></i>Invalid email format</span>';
                }
            }

            function validateUsername() {
                const username = this.value.trim();
                const feedback = document.getElementById('usernameFeedback');

                if (!username) {
                    this.classList.remove('valid', 'invalid');
                    feedback.textContent = '';
                    return;
                }

                if (username.length < 3) {
                    this.classList.add('invalid');
                    this.classList.remove('valid');
                    feedback.innerHTML =
                        '<span class="text-red-600"><i class="fas fa-times mr-1"></i>Username too short</span>';
                } else if (!/^[a-zA-Z0-9_]+$/.test(username)) {
                    this.classList.add('invalid');
                    this.classList.remove('valid');
                    feedback.innerHTML =
                        '<span class="text-red-600"><i class="fas fa-times mr-1"></i>Only letters, numbers, and underscores allowed</span>';
                } else {
                    this.classList.add('valid');
                    this.classList.remove('invalid');
                    feedback.innerHTML =
                        '<span class="text-green-600"><i class="fas fa-check mr-1"></i>Username available</span>';

                    // Simulate username availability check
                    setTimeout(() => {
                        if (username === 'admin' || username === 'test') {
                            this.classList.add('invalid');
                            this.classList.remove('valid');
                            feedback.innerHTML =
                                '<span class="text-red-600"><i class="fas fa-times mr-1"></i>Username not available</span>';
                        }
                    }, 500);
                }
            }

            function validatePassword() {
                const password = this.value;
                updatePasswordStrength(password);

                // Update requirements
                const requirements = {
                    length: password.length >= 8,
                    uppercase: /[A-Z]/.test(password),
                    lowercase: /[a-z]/.test(password),
                    number: /\d/.test(password),
                    special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
                };

                Object.keys(requirements).forEach(req => {
                    const element = document.getElementById(`${req}Req`);
                    if (requirements[req]) {
                        element.classList.add('met');
                        element.classList.remove('unmet');
                        element.querySelector('i').className = 'fas fa-check';
                    } else {
                        element.classList.add('unmet');
                        element.classList.remove('met');
                        element.querySelector('i').className = 'fas fa-times';
                    }
                });

                // Validate confirm password if it has a value
                const confirmPassword = document.getElementById('confirmPassword');
                if (confirmPassword.value) {
                    validateConfirmPassword.call(confirmPassword);
                }
            }

            function validateConfirmPassword() {
                const password = document.getElementById('password').value;
                const confirmPassword = this.value;
                const feedback = document.getElementById('confirmPasswordFeedback');

                if (!confirmPassword) {
                    this.classList.remove('valid', 'invalid');
                    feedback.textContent = '';
                    return;
                }

                if (password === confirmPassword) {
                    this.classList.add('valid');
                    this.classList.remove('invalid');
                    feedback.innerHTML = '<span class="text-green-600"><i class="fas fa-check mr-1"></i>Passwords match</span>';
                } else {
                    this.classList.add('invalid');
                    this.classList.remove('valid');
                    feedback.innerHTML =
                        '<span class="text-red-600"><i class="fas fa-times mr-1"></i>Passwords do not match</span>';
                }
            }

            function updatePasswordStrength(password) {
                const strengthBar = document.getElementById('strengthBar');
                const strengthText = document.getElementById('strengthText');

                let strength = 0;
                const checks = [
                    password.length >= 8,
                    /[A-Z]/.test(password),
                    /[a-z]/.test(password),
                    /\d/.test(password),
                    /[!@#$%^&*(),.?":{}|<>]/.test(password)
                ];

                strength = checks.filter(Boolean).length;
                passwordStrength = strength;

                // Update visual indicator
                strengthBar.className = 'password-strength-bar';

                if (strength === 0) {
                    strengthBar.classList.add('strength-weak');
                    strengthText.textContent = '';
                } else if (strength <= 2) {
                    strengthBar.classList.add('strength-weak');
                    strengthText.textContent = 'Weak password';
                    strengthText.className = 'text-sm mt-1 text-red-600';
                } else if (strength === 3) {
                    strengthBar.classList.add('strength-fair');
                    strengthText.textContent = 'Fair password';
                    strengthText.className = 'text-sm mt-1 text-yellow-600';
                } else if (strength === 4) {
                    strengthBar.classList.add('strength-good');
                    strengthText.textContent = 'Good password';
                    strengthText.className = 'text-sm mt-1 text-green-600';
                } else {
                    strengthBar.classList.add('strength-strong');
                    strengthText.textContent = 'Strong password';
                    strengthText.className = 'text-sm mt-1 text-green-600';
                }
            }

            function updateBioCounter() {
                const bio = this.value;
                const counter = document.getElementById('bioCount');
                counter.textContent = bio.length;

                if (bio.length > 160) {
                    counter.parentElement.classList.add('text-red-600');
                    counter.parentElement.classList.remove('text-gray-500');
                } else {
                    counter.parentElement.classList.add('text-gray-500');
                    counter.parentElement.classList.remove('text-red-600');
                }
            }

            function validateInterests() {
                const checked = document.querySelectorAll('input[name="interests"]:checked');
                const feedback = document.getElementById('interestsFeedback');

                if (checked.length > 5) {
                    this.checked = false;
                    feedback.innerHTML = '<span class="text-red-600">Maximum 5 interests allowed</span>';
                } else {
                    feedback.textContent = '';
                }
            }

            function handleAvatarUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    if (file.size > 5 * 1024 * 1024) { // 5MB limit
                        showAlert('Image size must be less than 5MB.');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('avatarPreview').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }

            function togglePassword(fieldId) {
                const field = document.getElementById(fieldId);
                const toggle = document.getElementById(fieldId + 'Toggle');

                if (field.type === 'password') {
                    field.type = 'text';
                    toggle.classList.remove('fa-eye');
                    toggle.classList.add('fa-eye-slash');
                } else {
                    field.type = 'password';
                    toggle.classList.remove('fa-eye-slash');
                    toggle.classList.add('fa-eye');
                }
            }

            function handleSocialRegistration(event) {
                const provider = this.classList.contains('google-btn') ? 'Google' :
                    this.classList.contains('github-btn') ? 'GitHub' : 'Twitter';

                showAlert(`Redirecting to ${provider} registration...`, 'success');

                // Simulate social registration redirect
                setTimeout(() => {
                    console.log(`${provider} registration initiated`);
                }, 1000);
            }

            async function handleSubmit(event) {
                event.preventDefault();

                if (!validateCurrentStep()) {
                    return;
                }

                setLoadingState(true);

                try {
                    // Collect form data
                    const formData = new FormData(registerForm);
                    const userData = Object.fromEntries(formData.entries());

                    // Add interests array
                    userData.interests = Array.from(document.querySelectorAll('input[name="interests"]:checked'))
                        .map(cb => cb.value);

                    // Add email preferences
                    userData.emailPreferences = Array.from(document.querySelectorAll('input[name="emailPrefs"]:checked'))
                        .map(cb => cb.value);

                    // Simulate registration API call
                    await simulateRegistration(userData);

                    showVerificationModal(userData.email);

                } catch (error) {
                    showAlert(error.message);
                    setLoadingState(false);
                }
            }

            function showVerificationModal(email) {
                document.getElementById('verificationEmail').textContent = email;
                verificationModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function resendVerification() {
                const email = document.getElementById('verificationEmail').textContent;
                showAlert('Verification email sent!', 'success');
                console.log('Resending verification to:', email);
            }

            function changeEmail() {
                verificationModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                currentStep = 1;
                updateStepDisplay();
                updateStepIndicator();
                document.getElementById('email').focus();
            }

            function setLoadingState(loading) {
                const registerText = submitBtn.querySelector('.register-text');
                const loadingText = submitBtn.querySelector('.loading-text');

                if (loading) {
                    registerText.classList.add('hidden');
                    loadingText.classList.remove('hidden');
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-75');
                } else {
                    registerText.classList.remove('hidden');
                    loadingText.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-75');
                }
            }

            function showAlert(message, type = 'error') {
                const alertClass = type === 'error' ? 'error-message bg-red-50 border border-red-200 text-red-700' :
                    'success-message bg-green-50 border border-green-200 text-green-700';
                const iconClass = type === 'error' ? 'fa-exclamation-circle text-red-500' : 'fa-check-circle text-green-500';

                alertContainer.innerHTML = `
                <div class="${alertClass} p-4 rounded-lg flex items-center">
                    <i class="fas ${iconClass} mr-3"></i>
                    <span>${message}</span>
                </div>
            `;

                // Auto-hide after 5 seconds
                setTimeout(() => {
                    alertContainer.innerHTML = '';
                }, 5000);
            }

            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            async function simulateRegistration(userData) {
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        // Simulate different scenarios
                        if (userData.email === 'taken@example.com') {
                            reject(new Error('Email address is already registered.'));
                        } else if (userData.username === 'admin') {
                            reject(new Error('Username is not available.'));
                        } else if (!userData.terms) {
                            reject(new Error('Please accept the terms and conditions.'));
                        } else {
                            resolve({
                                success: true,
                                userId: 'user_' + Date.now()
                            });
                        }
                    }, 2000);
                });
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && e.ctrlKey) {
                    if (currentStep < totalSteps) {
                        nextStep();
                    } else {
                        handleSubmit(e);
                    }
                }
            });

            // Auto-save form data to localStorage
            function saveFormData() {
                const formData = new FormData(registerForm);
                const data = Object.fromEntries(formData.entries());
                localStorage.setItem('registrationData', JSON.stringify(data));
            }

            function loadFormData() {
                const saved = localStorage.getItem('registrationData');
                if (saved) {
                    const data = JSON.parse(saved);
                    Object.keys(data).forEach(key => {
                        const field = document.querySelector(`[name="${key}"]`);
                        if (field) {
                            field.value = data[key];
                        }
                    });
                }
            }

            // Save form data on input
            registerForm.addEventListener('input', saveFormData);

            // Load saved data on page load
            window.addEventListener('load', loadFormData);

            // Clear saved data on successful registration
            function clearSavedData() {
                localStorage.removeItem('registrationData');
            }
        </script>
    @endpush


@endsection
