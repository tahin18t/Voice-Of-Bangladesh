<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="api-base-url" content="{{ url('/api/v1') }}">
    <title>Login - VoBD</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Noto+Sans+Bengali:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="login-body">
    <div class="login-background">
        <div class="pattern-overlay"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
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
                <h1 class="login-title">Officer Portal</h1>
                <p class="login-subtitle">Sign in to access the VoBD dashboard.</p>
            </div>

            <div class="login-lang-toggle">
                <button class="lang-toggle" onclick="toggleLanguage()">
                    <span id="lang-flag">EN</span>
                    <span id="lang-text">বাংলা</span>
                </button>
            </div>

            <form id="login-form" class="login-form">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="form-input"
                            placeholder="you@example.com" required autocomplete="username">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-input"
                            placeholder="Enter your password" required autocomplete="current-password">
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="password-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" id="remember" name="remember">
                        <span class="checkbox-checkmark"></span>
                        <span class="checkbox-text">Remember me</span>
                    </label>
                    <a href="#forgot-password" class="forgot-link">Forgot password?</a>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Sign In</span>
                    <div class="btn-loader" id="login-loader" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </button>

                <div class="form-footer">
                    <p class="footer-text">Don't have an account?
                        <a href="{{ url('/signup') }}" class="footer-link">Sign up</a>
                    </p>
                </div>
            </form>

            <div class="login-footer">
                <p class="footer-text">For technical support, contact:</p>
                <a href="mailto:support@cfpip.gov.bd" class="support-link">support@cfpip.gov.bd</a>

                <div class="footer-links">
                    <a href="{{ url('/index') }}" class="footer-link">Back to Home</a>
                    <span class="divider">|</span>
                    <a href="#" class="footer-link">Privacy Policy</a>
                </div>
            </div>
        </div>

        <div class="security-notice">
            <div class="notice-content">
                <i class="fas fa-shield-alt notice-icon"></i>
                <div class="notice-text">
                    <h4>Secure Login</h4>
                    <p>This is a government system. All activities are monitored and logged for security purposes.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="error-modal" class="modal" style="display: none;">
        <div class="modal-content small">
            <div class="modal-header error">
                <div class="error-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h2 class="modal-title">Login Failed</h2>
            </div>
            <div class="modal-body">
                <p id="error-message" class="error-text">
                    Invalid email or password. Please try again.
                </p>
                <div class="error-tips">
                    <ul>
                        <li>Check your email address and password</li>
                        <li>Make sure Caps Lock is off</li>
                        <li>Contact admin if you continue to have issues</li>
                    </ul>
                </div>
            </div>
            <div class="modal-actions">
                <button onclick="closeErrorModal()" class="btn btn-primary">
                    Try Again
                </button>
            </div>
        </div>
    </div>

    <div id="success-modal" class="modal" style="display: none;">
        <div class="modal-content small">
            <div class="modal-header success">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2 class="modal-title">Login Successful</h2>
            </div>
            <div class="modal-body">
                <p class="success-text">
                    Welcome back! Redirecting to dashboard...
                </p>
                <div class="loading-bar">
                    <div class="loading-progress"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
