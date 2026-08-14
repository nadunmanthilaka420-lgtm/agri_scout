<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - AgriScout</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --bg-dark: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.75);
            --border-color: rgba(255, 255, 255, 0.12);
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 50% -20%, #1e8a4d 0%, #0f172a 60%, #020617 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f8fafc;
            margin: 0;
            padding: 20px 0;
        }
        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 30px rgba(16, 185, 129, 0.15);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .brand-header {
            text-align: center;
            padding-bottom: 1.5rem;
        }
        .brand-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #ffffff;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
            margin-bottom: 12px;
        }
        .form-control {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #f8fafc;
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            background: rgba(15, 23, 42, 0.85);
            border-color: var(--primary);
            color: #ffffff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
        }
        .btn-custom {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: #ffffff;
            font-weight: 600;
            padding: 12px;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(16, 185, 129, 0.45);
            background: linear-gradient(135deg, #34d399 0%, #059669 100%);
            color: #ffffff;
        }
        .oracle-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #34d399;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 500;
        }
        .status-dot {
            width: 8px;
            height: 8px;
            background-color: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 8px #10b981;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
        .demo-chip {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 0.78rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .demo-chip:hover {
            background: rgba(16, 185, 129, 0.2);
            border-color: rgba(16, 185, 129, 0.4);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">

            <div class="login-card p-4 p-md-5">

                <div class="brand-header">
                    <div class="brand-icon">
                        <i class="bi bi-sprout-fill"></i>
                    </div>
                    <h3 class="fw-bold mb-1">AgriScout</h3>
                    <p class="text-secondary small mb-3">Field & Farm Management Portal</p>

                    <div class="oracle-status-badge">
                        <span class="status-dot"></span>
                        Connected to Oracle 21c (XE)
                    </div>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger border-0 text-white rounded-3 small py-2 px-3 mb-4" style="background: rgba(239, 68, 68, 0.25); border-left: 4px solid #ef4444 !important;">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-medium">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-secondary" style="border-radius: 12px 0 0 12px; border-color: rgba(255, 255, 255, 0.15) !important;">
                                <i class="bi bi-envelope-fill"></i>
                            </span>
                            <input type="email" id="email" name="email" class="form-control" placeholder="name@agriscout.com" required style="border-radius: 0 12px 12px 0;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary small fw-medium">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-secondary" style="border-radius: 12px 0 0 12px; border-color: rgba(255, 255, 255, 0.15) !important;">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required style="border-radius: 0 12px 12px 0;">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-custom w-100 mb-3">
                        Sign In <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </form>

                <div class="mt-3 pt-3 border-top border-secondary border-opacity-25">
                    <p class="text-secondary small mb-2"><i class="bi bi-lightning-charge-fill text-warning me-1"></i> Quick Demo Accounts (Click to Fill):</p>
                    <div class="d-flex flex-wrap gap-1">
                        <span class="demo-chip" onclick="fillCredentials('farmer@agriscout.com', 'Farmer@123')">
                            🌾 Farmer
                        </span>
                        <span class="demo-chip" onclick="fillCredentials('officer@agriscout.com', 'Officer@123')">
                            📋 Officer
                        </span>
                        <span class="demo-chip" onclick="fillCredentials('customer@agriscout.com', 'Customer@123')">
                            🛒 Customer
                        </span>
                    </div>
                </div>

                <div class="text-center mt-4 pt-3 border-top border-secondary border-opacity-25">
                    <p class="text-secondary small mb-2">Don't have an account yet?</p>
                    <a href="{{ route('register') }}" class="btn btn-outline-success btn-sm w-100 rounded-3 py-2 fw-medium text-white" style="border-color: rgba(16, 185, 129, 0.5); background: rgba(16, 185, 129, 0.1);">
                        <i class="bi bi-person-plus-fill me-1 text-success"></i> Create New Account
                    </a>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('admin.login') }}" class="text-decoration-none small text-secondary">
                        <i class="bi bi-shield-lock-fill me-1 text-primary"></i> Administrator Access
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
    function fillCredentials(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>

</body>
</html>
