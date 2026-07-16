<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Presbusy Assurance</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: #0B1F3A;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .login-card h3 {
            color: #0B1F3A;
            font-weight: 700;
        }
        .login-card .gold-text {
            color: #D4AF37;
        }
        .btn-gold {
            background: #D4AF37;
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            transition: background 0.3s;
        }
        .btn-gold:hover {
            background: #b89224;
            color: #fff;
        }
        .form-control:focus {
            border-color: #D4AF37;
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <h3 class="mb-1"><span class="gold-text">Presbusy</span> Assurance</h3>
            <p class="text-muted small">Admin Login</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="admin@presbusy.com" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-gold">Login</button>
        </form>
        <p class="text-center text-muted small mt-3">
            Default: admin@presbusy.com / password123
        </p>
    </div>
</body>
</html>