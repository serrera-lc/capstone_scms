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
            background: linear-gradient(135deg, #fce4ec, #f8bbd0); /* soft pink gradient */
        }

        .login-card {
            width: 100%;
            max-width: 380px;
            padding: 2.5rem;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 6px 22px rgba(0, 0, 0, 0.15);
            text-align: center;
            transition: all 0.3s ease-in-out;
        }

        .login-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .login-card img {
            width: 90px;
            margin-bottom: 12px;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .login-card h4 {
            font-weight: 600;
            margin-bottom: 8px;
            color: #ad1457; /* darker pink */
        }

        .login-subtitle {
            font-size: 14px;
            color: #6d6d6d;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 500;
            font-size: 14px;
            color: #ad1457;
        }

        .form-control {
            border-radius: 8px;
            height: 42px;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #f48fb1;
        }

        .form-control:focus {
            border-color: #ec407a;
            box-shadow: 0 0 0 2px rgba(236, 64, 122, 0.2);
        }

        .input-group-text {
            background: transparent;
            border-left: none;
            cursor: pointer;
            color: #ad1457;
        }

        .btn-login {
            font-weight: 600;
            border-radius: 8px;
            background-color: #ec407a; /* main pink button */
            color: white;
            height: 45px;
            transition: background-color 0.3s;
            border: none;
        }

        .btn-login:hover {
            background-color: #d81b60; /* darker hover */
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
            color: #ec407a;
            font-weight: 500;
        }

        .bi {
            transition: all 0.2s ease-in-out;
        }
    </style>
</head>
<body>

  <div class="login-card">
    <!-- School Logo -->
    <img src="{{ asset('images/lcguidancelogo.jpg') }}" alt="LCSHS Logo">

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
