<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BudgetRack - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a237e 0%, #283593 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .brand-title {
            color: #1a237e;
            font-weight: 800;
            font-size: 1.8rem;
        }
        .btn-login {
            background: linear-gradient(135deg, #1a237e, #283593);
            border: none;
            color: #fff;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #283593, #1a237e);
            color: #fff;
        }
        .form-control:focus {
            border-color: #1a237e;
            box-shadow: 0 0 0 0.2rem rgba(26,35,126,0.15);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <i class="bi bi-wallet2 text-primary" style="font-size: 2.5rem;"></i>
            <h1 class="brand-title mt-2">BudgetRack</h1>
            <p class="text-muted">Manajemen Keuangan Mahasiswa</p>
        </div>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                        id="email" name="email" value="{{ old('email') }}"
                        placeholder="email@example.com" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                        id="password" name="password" placeholder="••••••••" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label class="form-check-label text-muted" for="remember_me">Ingat saya</label>
            </div>

            <button type="submit" class="btn btn-login w-100 mb-3">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login
            </button>

            <div class="text-center">
                <span class="text-muted">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold ms-1"
                    style="color: #1a237e;">Daftar Sekarang</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>