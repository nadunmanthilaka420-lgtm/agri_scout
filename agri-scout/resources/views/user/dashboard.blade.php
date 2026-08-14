<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - AgriScout</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #0f172a;
            color: #f8fafc;
            min-height: 100vh;
        }
        .navbar-custom {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .dashboard-card {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 24px;
            transition: all 0.3s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-color: rgba(16, 185, 129, 0.3);
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .oracle-badge {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="#">
            <i class="bi bi-sprout-fill text-success fs-4"></i> AgriScout Portal
        </a>
        <div class="d-flex align-items-center gap-3">
            <span class="oracle-badge">
                <i class="bi bi-database-check me-1"></i> Oracle XE Connected
            </span>
            <div class="dropdown">
                <button class="btn btn-outline-light btn-sm dropdown-toggle rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1"></i> {{ session('user_name', 'User') }}
                </button>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow">
                    <li><span class="dropdown-item-text small text-secondary">Role: {{ strtoupper(session('user_role', 'USER')) }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-1"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card bg-gradient">
                <div class="d-md-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="fw-bold mb-1">Welcome back, {{ session('user_name', 'User') }}! 👋</h2>
                        <p class="text-secondary mb-0">AgriScout Field & Agricultural Operations Dashboard</p>
                    </div>
                    <span class="badge bg-success bg-opacity-20 text-success border border-success px-3 py-2 rounded-pill mt-3 mt-md-0 fs-6">
                        <i class="bi bi-shield-check me-1"></i> Authenticated via Oracle DB
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="dashboard-card">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="stat-icon bg-success bg-opacity-20 text-success">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-secondary mb-0">Active Fields</h6>
                        <h3 class="fw-bold mb-0">12 Farms</h3>
                    </div>
                </div>
                <p class="small text-secondary mb-0">Monitored via Oracle spatial mapping schema.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-card">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="stat-icon bg-warning bg-opacity-20 text-warning">
                        <i class="bi bi-clipboard-pulse"></i>
                    </div>
                    <div>
                        <h6 class="text-secondary mb-0">Officer Visits</h6>
                        <h3 class="fw-bold mb-0">5 Scheduled</h3>
                    </div>
                </div>
                <p class="small text-secondary mb-0">Upcoming field inspections by assigned officer.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-card">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="stat-icon bg-info bg-opacity-20 text-info">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-secondary mb-0">Current Role</h6>
                        <h3 class="fw-bold mb-0 text-capitalize">{{ session('user_role', 'Member') }}</h3>
                    </div>
                </div>
                <p class="small text-secondary mb-0">User ID #{{ session('user_id', 'N/A') }} in Oracle database.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
