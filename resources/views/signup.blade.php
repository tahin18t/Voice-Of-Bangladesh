<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - VoBD</title>
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
                <h1 class="login-title">Create Account</h1>
                <p class="login-subtitle">Officer/Admin onboarding for the VoBD portal.</p>
            </div>

            <div class="login-lang-toggle">
                <button class="lang-toggle" onclick="toggleLanguage()">
                    <span id="lang-flag">EN</span>
                    <span id="lang-text">বাংলা</span>
                </button>
            </div>

            @if(session('success'))
                <div class="alert success-alert">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert error-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Please fix the errors below.</span>
                </div>
            @endif

            <form id="signup-form" class="login-form" method="POST" action="{{ route('signup.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="name" name="name" class="form-input"
                               value="{{ old('name') }}" placeholder="Enter full name" required>
                    </div>
                    @error('name')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="form-input"
                               value="{{ old('email') }}" placeholder="officer@ministry.gov.bd" required>
                    </div>
                    @error('email')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="department" class="form-label">Department</label>
                    <div class="input-group">
                        <i class="fas fa-building input-icon"></i>
                        <select id="department" name="department" class="form-input" required>
                            <option value="">Select department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" {{ old('department') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('department')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role_id" class="form-label">Role</label>
                    <div class="input-group">
                        <i class="fas fa-user-shield input-icon"></i>
                        <select id="role_id" name="role_id" class="form-input" required>
                            <option value="">Select role</option>
                            @forelse($roles as $role)
                                <option value="{{ $role->id }}" {{ (string)old('role_id') === (string)$role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @empty
                                <option value="">No roles available</option>
                            @endforelse
                        </select>
                    </div>
                    @error('role_id')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="avatar" class="form-label">Avatar (optional)</label>
                    <div class="input-group">
                        <i class="fas fa-camera input-icon"></i>
                        <input type="file" id="avatar" name="avatar" class="form-input" accept="image/*">
                    </div>
                    @error('avatar')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-input"
                               placeholder="Enter password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="password-eye"></i>
                        </button>
                    </div>
                    <small class="helper-text">Stored as plain text for now to match your request.</small>
                    @error('password')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-user-plus"></i>
                    <span>Create Account</span>
                </button>
            </form>

            <div class="form-footer">
                <p class="footer-text">Already have an account?
                    <a href="{{ url('/login') }}" class="footer-link">Log in</a>
                </p>
                <p class="footer-text">
                    <a href="{{ url('/index') }}" class="footer-link">Back to Home</a>
                </p>
            </div>
        </div>

        <div class="security-notice">
            <div class="notice-content">
                <i class="fas fa-shield-alt notice-icon"></i>
                <div class="notice-text">
                    <h4>Secure Access</h4>
                    <p>Only authorized officers and admins should sign up. Activity may be monitored.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
