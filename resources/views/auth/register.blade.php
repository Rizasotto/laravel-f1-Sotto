<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            padding: 50px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .register-header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .register-header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s, box-shadow 0.3s;
            font-family: inherit;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .error-message {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .form-group.has-error input,
        .form-group.has-error select {
            border-color: #dc2626;
        }

        .register-btn {
            width: 100%;
            padding: 12px;
            background: #6366f1;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .register-btn:hover {
            background: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.4);
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #eee;
            padding-top: 25px;
        }

        .login-link a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .login-link a:hover {
            color: #4f46e5;
        }

        .back-home {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .back-home a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: opacity 0.3s;
        }

        .back-home a:hover {
            opacity: 0.8;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 25px;
            font-size: 13px;
        }

        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fca5a5;
        }

        .role-description {
            background: #f9fafb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 12px;
            color: #666;
            line-height: 1.6;
        }

        .role-option {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .role-option strong {
            color: #333;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 30px 20px;
            }

            .register-header h1 {
                font-size: 24px;
            }

            .logo {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>
    <div class="back-home">
        <a href="{{ route('home') }}">← Back to Home</a>
    </div>

    <div class="register-container">
        <div class="register-header">
            <div class="logo">🎨</div>
            <h1>Join Us</h1>
            <p>Create your account to get started</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Registration Failed!</strong>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="form-group @error('name') has-error @enderror">
                <label for="name">Full Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    placeholder="John Doe"
                    required
                    autofocus
                >
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group @error('email') has-error @enderror">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="you@example.com"
                    required
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group @error('password') has-error @enderror">
                <label for="password">Password</label>
                <div style="position: relative;">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••"
                        required
                        style="padding-right: 70px;"
                    >
                    <button type="button" onclick="togglePasswordVisibility('password')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 12px; font-weight: 600; color: #6366f1; padding: 5px 8px; text-decoration: underline;">Show</button>
                </div>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group @error('password_confirmation') has-error @enderror">
                <label for="password_confirmation">Confirm Password</label>
                <div style="position: relative;">
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="••••••••"
                        required
                        style="padding-right: 70px;"
                    >
                    <button type="button" onclick="togglePasswordVisibility('password_confirmation')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 12px; font-weight: 600; color: #6366f1; padding: 5px 8px; text-decoration: underline;">Show</button>
                </div>
                @error('password_confirmation')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group @error('role') has-error @enderror">
                <label for="role">I am a...</label>
                <select id="role" name="role" required>
                    <option value="">-- Select your role --</option>
                    <option value="artist" {{ old('role') === 'artist' ? 'selected' : '' }}>Artist</option>
                    <option value="buyer" {{ old('role') === 'buyer' ? 'selected' : '' }}>Client (Buyer)</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }} disabled>Admin (Not available)</option>
                </select>
                @error('role')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="role-description">
                <strong>Choose Your Role:</strong><br>
                <span style="display: block; margin-top: 8px;">
                    <strong>🎨 Artist:</strong> Showcase your artwork, manage portfolio, and receive commissions
                </span>
                <span style="display: block; margin-top: 8px;">
                    <strong>🛒 Client:</strong> Browse artworks, commission artists, and build your collection
                </span>
            </div>

            <button type="submit" class="register-btn">Create Account</button>
        </form>

    <script>
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const button = event.target.closest('button');
            if (field.type === 'password') {
                field.type = 'text';
                button.textContent = 'Hide';
            } else {
                field.type = 'password';
                button.textContent = 'Show';
            }
        }
    </script>        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Sign in here</a>
        </div>
    </div>
</body>
</html>
