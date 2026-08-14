<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Farmer Dashboard') - AgriScout</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --bg-dark: #0f172a;
            --sidebar-bg: #1e293b;
            --card-bg: rgba(30, 41, 59, 0.7);
            --border-color: rgba(255, 255, 255, 0.1);
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: #0b1329;
            color: #09915f;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }
        .nav-link {
            color: #94a3b8;
            padding: 12px 20px;
            border-radius: 12px;
            margin: 4px 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: #169730;
            background: rgba(16, 185, 129, 0.15);
            border-left: 4px solid var(--primary);
        }
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .badge-role {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
    @yield('styles')
</head>
<body>

<aside class="sidebar" id="sidebar">
    <div class="p-4 border-bottom border-secondary border-opacity-25 d-flex align-items-center gap-3">
        <div class="bg-success text-white rounded-3 p-2 fs-4 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: linear-gradient(135deg, #10b981, #047857) !important;">
            <i class="bi bi-sprout-fill"></i>
        </div>
        <div>
            <h5 class="fw-bold mb-0 text-white">AgriScout</h5>
            <span class="badge badge-role px-2 py-1 rounded-pill small">🌾 Farmer Portal</span>
        </div>
    </div>

    <nav class="mt-3">
        <a href="{{ route('farmer.dashboard') }}" class="nav-link {{ request()->routeIs('farmer.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill text-success fs-5"></i> Dashboard
        </a>
        <a href="{{ route('farmer.farms.index') }}" class="nav-link {{ request()->routeIs('farmer.farms.*') ? 'active' : '' }}">
            <i class="bi bi-tree-fill text-emerald fs-5"></i> My Farms
        </a>
        <a href="{{ route('farmer.crops.index') }}" class="nav-link {{ request()->routeIs('farmer.crops.*') ? 'active' : '' }}">
            <i class="bi bi-flower2 text-warning fs-5"></i> My Crops
        </a>
        <a href="{{ route('farmer.diseases.index') }}" class="nav-link {{ request()->routeIs('farmer.diseases.*') ? 'active' : '' }}">
            <i class="bi bi-bug-fill text-danger fs-5"></i> Disease Reports
        </a>
        <a href="{{ route('farmer.visits.index') }}" class="nav-link {{ request()->routeIs('farmer.visits.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check-fill text-info fs-5"></i> Visits
        </a>
        <a href="{{ route('farmer.orders.index') }}" class="nav-link {{ request()->routeIs('farmer.orders.*') ? 'active' : '' }}">
            <i class="bi bi-cart-check-fill text-primary fs-5"></i> Orders
        </a>
        <a href="{{ route('farmer.profile.index') }}" class="nav-link {{ request()->routeIs('farmer.profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle text-secondary fs-5"></i> Profile
        </a>

        <div class="px-3 mt-4 pt-3 border-top border-secondary border-opacity-25">
            <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm w-100 rounded-3 py-2">
                <i class="bi bi-box-arrow-right me-1"></i> Sign Out
            </a>
        </div>
    </nav>
</aside>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-secondary border-opacity-25">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-dark d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list fs-4"></i>
            </button>
            <h4 class="fw-bold mb-0 text-white">@yield('page_title', 'Farmer Dashboard')</h4>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-secondary small d-none d-md-inline"><i class="bi bi-database-check text-success me-1"></i> Oracle + MongoDB Integrated</span>
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle rounded-pill px-3 py-1 border-secondary" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-fill text-success me-1"></i> {{ Session::get('user_name', 'Farmer') }}
                </button>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                    <li><a class="dropdown-menu-item dropdown-item" href="{{ route('farmer.profile.index') }}"><i class="bi bi-person me-2"></i> Profile Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i> Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 text-white rounded-3 py-2 px-3 mb-4" style="background: rgba(16, 185, 129, 0.25); border-left: 4px solid #10b981 !important;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 text-white rounded-3 py-2 px-3 mb-4" style="background: rgba(239, 68, 68, 0.25); border-left: 4px solid #ef4444 !important;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
