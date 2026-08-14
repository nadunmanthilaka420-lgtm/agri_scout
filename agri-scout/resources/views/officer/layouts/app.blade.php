<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Field Officer Portal') - AgriScout</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary: #3b82f6;
            --sidebar-bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --border-color: rgba(255, 255, 255, 0.1);
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: #09101f;
            color: #f8fafc;
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
            color: #ffffff;
            background: rgba(59, 130, 246, 0.15);
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
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.3);
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
        <div class="bg-primary text-white rounded-3 p-2 fs-4 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: linear-gradient(135deg, #3b82f6, #1d4ed8) !important;">
            <i class="bi bi-shield-check"></i>
        </div>
        <div>
            <h5 class="fw-bold mb-0 text-white">AgriScout</h5>
            <span class="badge badge-role px-2 py-1 rounded-pill small">📋 Field Officer</span>
        </div>
    </div>

    <nav class="mt-3">
        <a href="{{ route('officer.dashboard') }}" class="nav-link {{ request()->routeIs('officer.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill text-primary fs-5"></i> Dashboard
        </a>
        <a href="{{ route('officer.farms.index') }}" class="nav-link {{ request()->routeIs('officer.farms.*') ? 'active' : '' }}">
            <i class="bi bi-tree-fill text-success fs-5"></i> Assigned Farms
        </a>
        <a href="{{ route('officer.visits.index') }}" class="nav-link {{ request()->routeIs('officer.visits.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check-fill text-info fs-5"></i> Visits
        </a>
        <a href="{{ route('officer.visit-reports.create') }}" class="nav-link {{ request()->routeIs('officer.visit-reports.*') ? 'active' : '' }}">
            <i class="bi bi-journal-plus text-warning fs-5"></i> Submit Report
        </a>
        <a href="{{ route('officer.crops.index') }}" class="nav-link {{ request()->routeIs('officer.crops.*') ? 'active' : '' }}">
            <i class="bi bi-flower2 text-emerald fs-5"></i> Farm Crops
        </a>
        <a href="{{ route('officer.diseases.index') }}" class="nav-link {{ request()->routeIs('officer.diseases.*') ? 'active' : '' }}">
            <i class="bi bi-bug-fill text-danger fs-5"></i> Disease Reports
        </a>
        <a href="{{ route('officer.profile.index') }}" class="nav-link {{ request()->routeIs('officer.profile.*') ? 'active' : '' }}">
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
            <h4 class="fw-bold mb-0 text-white">@yield('page_title', 'Field Officer Dashboard')</h4>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-secondary small d-none d-md-inline"><i class="bi bi-database-check text-info me-1"></i> Oracle + MongoDB Field Operations</span>
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle rounded-pill px-3 py-1 border-secondary" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-badge-fill text-primary me-1"></i> {{ Session::get('user_name', 'Officer') }}
                </button>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('officer.profile.index') }}"><i class="bi bi-person me-2"></i> Officer Profile</a></li>
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
