<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VoBD</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Noto+Sans+Bengali:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="login-body">
    <!-- Background Pattern -->
    <div class="login-background">
        <div class="pattern-overlay"></div>
    </div>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="login-logo">
                    <div class="login-logo-container">
                        <div class="login-logo-icon">
                            <i class="fas fa-landmark"></i>
                        </div>
                        <div class="login-logo-badge">BD</div>
                        <div class="login-logo-glow"></div>
                    </div>
                </div>
                <h1 class="login-title" data-en="Officer Portal" data-bn="কর্মকর্তা পোর্টাল">Officer Portal</h1>
                <p class="login-subtitle" data-en="Citizen Feedback & Policy Insight Portal"
                    data-bn="নাগরিক মতামত ও নীতি অন্তর্দৃষ্টি পোর্টাল">
                    Citizen Feedback & Policy Insight Portal
                </p>
            </div>

            <!-- Language Toggle -->
            <div class="login-lang-toggle">
                <button class="lang-toggle" onclick="toggleLanguage()">
                    <span id="lang-flag">🇧🇩</span>
                    <span id="lang-text">বাং</span>
                </button>
            </div>

            <!-- Login Form -->
            <form id="login-form" class="login-form">
                <div class="form-group">
                    <label for="email" class="form-label" data-en="Email Address" data-bn="ইমেইল ঠিকানা">Email
                        Address</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="form-input"
                            placeholder="officer@ministry.gov.bd" data-placeholder-en="officer@ministry.gov.bd"
                            data-placeholder-bn="কর্মকর্তা@মন্ত্রণালয়.gov.bd" required autocomplete="username">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label" data-en="Password" data-bn="পাসওয়ার্ড">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-input"
                            placeholder="Enter your password" data-placeholder-en="Enter your password"
                            data-placeholder-bn="আপনার পাসওয়ার্ড লিখুন" required autocomplete="current-password">
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="password-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" id="remember" name="remember">
                        <span class="checkbox-checkmark"></span>
                        <span class="checkbox-text" data-en="Remember me" data-bn="আমাকে মনে রাখুন">Remember me</span>
                    </label>
                    <a href="#forgot-password" class="forgot-link" data-en="Forgot password?"
                        data-bn="পাসওয়ার্ড ভুলে গেছেন?">
                        Forgot password?
                    </a>
                </div>

                <button type="button" class="login-btn" data-en="Sign In" data-bn="সাইন ইন"
                    onclick="window.location.href='officer-dashboard.html'">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Sign In</span>
                    <div class="btn-loader" id="login-loader" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </button>

            </form>

            <!-- Demo Credentials -->
            <div class="demo-credentials">
                <h4 class="demo-title" data-en="Demo Credentials" data-bn="ডেমো তথ্য">Demo Credentials</h4>
                <div class="demo-accounts">
                    <div class="demo-account" onclick="fillDemoCredentials('officer')">
                        <div class="demo-role">
                            <i class="fas fa-user"></i>
                            <span data-en="Officer Account" data-bn="কর্মকর্তা অ্যাকাউন্ট">Officer Account</span>
                        </div>
                        <div class="demo-details">
                            <small>officer@cfpip.gov.bd</small>
                            <small>password123</small>
                        </div>
                    </div>
                    <div class="demo-account" onclick="fillDemoCredentials('admin')">
                        <div class="demo-role">
                            <i class="fas fa-user-shield"></i>
                            <span data-en="Admin Account" data-bn="অ্যাডমিন অ্যাকাউন্ট">Admin Account</span>
                        </div>
                        <div class="demo-details">
                            <small>admin@cfpip.gov.bd</small>
                            <small>admin456</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Links -->
            <div class="login-footer">
                <p class="footer-text" data-en="For technical support, contact:"
                    data-bn="প্রযুক্তিগত সহায়তার জন্য যোগাযোগ:">
                    For technical support, contact:
                </p>
                <a href="mailto:support@cfpip.gov.bd" class="support-link">support@cfpip.gov.bd</a>

                <div class="footer-links">
                    <a href="index.html" class="footer-link" data-en="← Back to Home" data-bn="← হোমে ফিরুন">← Back to
                        Home</a>
                    <span class="divider">|</span>
                    <a href="#" class="footer-link" data-en="Privacy Policy" data-bn="গোপনীয়তা নীতি">Privacy Policy</a>
                </div>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="security-notice">
            <div class="notice-content">
                <i class="fas fa-shield-alt notice-icon"></i>
                <div class="notice-text">
                    <h4 data-en="Secure Login" data-bn="নিরাপদ লগইন">Secure Login</h4>
                    <p data-en="This is a government system. All activities are monitored and logged for security purposes."
                        data-bn="এটি একটি সরকারি সিস্টেম। সিকিউরিটির জন্য সব কার্যক্রম পর্যবেক্ষিত ও লগ করা হয়।">
                        This is a government system. All activities are monitored and logged for security purposes.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="error-modal" class="modal" style="display: none;">
        <div class="modal-content small">
            <div class="modal-header error">
                <div class="error-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h2 class="modal-title" data-en="Login Failed" data-bn="লগইন ব্যর্থ">Login Failed</h2>
            </div>
            <div class="modal-body">
                <p id="error-message" class="error-text" data-en="Invalid email or password. Please try again."
                    data-bn="ভুল ইমেইল বা পাসওয়ার্ড। দয়া করে আবার চেষ্টা করুন।">
                    Invalid email or password. Please try again.
                </p>
                <div class="error-tips">
                    <ul>
                        <li data-en="Check your email address and password"
                            data-bn="আপনার ইমেইল এবং পাসওয়ার্ড চেক করুন">Check your email address and password</li>
                        <li data-en="Make sure Caps Lock is off" data-bn="নিশ্চিত করুন Caps Lock বন্ধ আছে">Make sure
                            Caps Lock is off</li>
                        <li data-en="Contact admin if you continue to have issues"
                            data-bn="সমস্যা অব্যাহত থাকলে অ্যাডমিনের সাথে যোগাযোগ করুন">Contact admin if you continue to
                            have issues</li>
                    </ul>
                </div>
            </div>
            <div class="modal-actions">
                <button onclick="closeErrorModal()" class="btn btn-primary" data-en="Try Again"
                    data-bn="আবার চেষ্টা করুন">
                    Try Again
                </button>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="modal" style="display: none;">
        <div class="modal-content small">
            <div class="modal-header success">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2 class="modal-title" data-en="Login Successful" data-bn="লগইন সফল">Login Successful</h2>
            </div>
            <div class="modal-body">
                <p class="success-text" data-en="Welcome back! Redirecting to dashboard..."
                    data-bn="স্বাগতম! ড্যাশবোর্ডে রিডাইরেক্ট করা হচ্ছে...">
                    Welcome back! Redirecting to dashboard...
                </p>
                <div class="loading-bar">
                    <div class="loading-progress"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>