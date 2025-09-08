<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LCSHS-SCMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7f8fa;
        }

        .login-card {
            width: 100%;
            max-width: 380px;
            padding: 2.5rem;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .login-card img {
            width: 80px;
            margin-bottom: 10px;
        }

        .login-card h4 {
            font-weight: 600;
            margin-bottom: 8px;
            color: #202124;
        }

        .login-subtitle {
            font-size: 14px;
            color: #5f6368;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 500;
            font-size: 14px;
            color: #202124;
        }

        .form-control {
            border-radius: 6px;
            height: 42px;
            padding: 10px;
            font-size: 14px;
        }

        .input-group-text {
            background: transparent;
            border-left: none;
            cursor: pointer;
            color: #5f6368;
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 2px #1a73e8;
            border-radius: 6px;
        }

        .btn-login {
            font-weight: 600;
            border-radius: 6px;
            background-color: #1a73e8;
            color: white;
            height: 45px;
            transition: background-color 0.3s;
        }

        .btn-login:hover {
            background-color: #1669c1;
        }

        .alert {
            border-radius: 6px;
            font-size: 14px;
        }

        .footer-text {
            margin-top: 20px;
            font-size: 13px;
            color: #5f6368;
        }

        .footer-text a {
            text-decoration: none;
            color: #1a73e8;
            font-weight: 500;
        }

        /* Smooth icon transition */
        .bi {
            transition: all 0.2s ease-in-out;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Google-style Logo -->
        <img src="https://www.gstatic.com/images/branding/product/1x/avatar_circle_blue_120dp.png" alt="Logo">

        <h4>Sign in</h4>
        <p class="login-subtitle">Use your LCSHS-SCMS account</p>

        {{-- Validation / Login Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger text-start">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="mb-3 text-start">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    required autofocus autocomplete="email">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 text-start">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required autocomplete="current-password">
                    <span class="input-group-text" id="togglePassword">
                        <i class="bi bi-eye-slash"></i>
                    </span>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-login w-100">Login</button>
        </form>

        
    </div>

    <script>
        // Password visibility toggle
        document.getElementById("togglePassword").addEventListener("click", function() {
            const passwordInput = document.getElementById("password");
            const icon = this.querySelector("i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            }
        });
    </script>

</body>
</html>
