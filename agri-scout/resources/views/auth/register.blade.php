<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - AgriScout</title>
    <meta name="description" content="Create your AgriScout account to access the Field & Farm Management Portal.">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary:       #10b981;
            --primary-dark:  #059669;
            --primary-light: #34d399;
            --bg-dark:       #0a0f1e;
            --card-bg:       rgba(18, 28, 52, 0.82);
            --border-color:  rgba(255, 255, 255, 0.10);
            --input-bg:      rgba(8, 14, 32, 0.65);
            --text-muted:    #94a3b8;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f1f5f9;
            margin: 0;
            padding: 30px 16px;
            overflow-x: hidden;
            position: relative;
        }

        /* ── Animated background ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 900px 700px at 15% -10%,  rgba(16,185,129,.18) 0%, transparent 60%),
                radial-gradient(ellipse 600px 500px at 90%  110%, rgba(5, 150, 105,.14) 0%, transparent 55%),
                radial-gradient(ellipse 400px 400px at 50%  50%,  rgba(30, 58, 138,.25) 0%, transparent 70%);
            z-index: 0;
            pointer-events: none;
        }

        /* Floating orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .35;
            pointer-events: none;
            animation: floatOrb 12s ease-in-out infinite;
        }
        .orb-1 { width:320px; height:320px; background:#10b981; top:-80px; left:-80px; animation-delay:0s; }
        .orb-2 { width:260px; height:260px; background:#1e3a8a; bottom:-60px; right:-60px; animation-delay:-5s; }
        .orb-3 { width:180px; height:180px; background:#059669; top:50%; right:8%; animation-delay:-9s; }

        @keyframes floatOrb {
            0%,100% { transform: translate(0,0) scale(1); }
            50%      { transform: translate(20px,-30px) scale(1.08); }
        }

        /* ── Card ── */
        .register-card {
            position: relative;
            z-index: 1;
            background: var(--card-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-color);
            border-radius: 28px;
            box-shadow:
                0 30px 60px -15px rgba(0,0,0,.55),
                0 0 0 1px rgba(255,255,255,.05) inset,
                0 0 40px rgba(16,185,129,.12);
            width: 100%;
            max-width: 520px;
            padding: 44px 48px;
            animation: cardIn .5s cubic-bezier(.22,.68,0,1.2) both;
        }

        @keyframes cardIn {
            from { opacity:0; transform:translateY(24px) scale(.97); }
            to   { opacity:1; transform:translateY(0)    scale(1); }
        }

        /* ── Brand ── */
        .brand-header { text-align: center; margin-bottom: 28px; }

        .brand-icon {
            width: 68px;
            height: 68px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            color: #fff;
            box-shadow: 0 12px 30px rgba(16,185,129,.4), 0 0 0 8px rgba(16,185,129,.08);
            margin-bottom: 16px;
            animation: iconPulse 3s ease-in-out infinite;
        }
        @keyframes iconPulse {
            0%,100% { box-shadow: 0 12px 30px rgba(16,185,129,.4), 0 0 0 8px rgba(16,185,129,.08); }
            50%      { box-shadow: 0 12px 30px rgba(16,185,129,.55), 0 0 0 14px rgba(16,185,129,.05); }
        }

        .brand-title {
            font-size: 1.7rem;
            font-weight: 800;
            background: linear-gradient(90deg, #f1f5f9 0%, #a3e8cb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0 0 4px;
        }

        .brand-subtitle { color: var(--text-muted); font-size: .88rem; margin: 0 0 16px; }

        .page-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #e2e8f0;
            margin: 0 0 2px;
        }
        .page-desc { color: var(--text-muted); font-size: .82rem; }

        /* ── Divider ── */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0 18px;
            color: rgba(255,255,255,.25);
            font-size: .75rem;
            font-weight: 500;
            letter-spacing: .06em;
            text-transform: uppercase;
        }
        .section-divider::before,
        .section-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }

        /* ── Form labels ── */
        .form-label {
            color: var(--text-muted);
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        /* ── Inputs ── */
        .input-wrapper {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1rem;
            pointer-events: none;
            transition: color .2s;
            z-index: 2;
        }
        .form-control, .form-select {
            background: var(--input-bg);
            border: 1px solid rgba(255,255,255,.12);
            color: #f1f5f9;
            border-radius: 12px;
            padding: 12px 14px 12px 42px;
            font-family: 'Outfit', sans-serif;
            font-size: .95rem;
            transition: all .25s ease;
            width: 100%;
        }
        .form-control::placeholder { color: rgba(148,163,184,.5); }
        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(8,14,32,.85);
            color: #fff;
            box-shadow: 0 0 0 4px rgba(16,185,129,.18);
        }
        .form-control:focus + .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: var(--primary-light);
        }

        /* password toggle */
        .pw-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1rem;
            z-index: 2;
            transition: color .2s;
            background: none;
            border: none;
            padding: 0;
        }
        .pw-toggle:hover { color: var(--primary-light); }
        .pw-toggle-field { padding-right: 44px !important; }

        /* select fix */
        .form-select {
            -webkit-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2394a3b8' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 38px;
        }
        .form-select option { background: #1e293b; color: #f1f5f9; }

        /* ── Role cards ── */
        .role-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        .role-card {
            position: relative;
            cursor: pointer;
        }
        .role-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        .role-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 14px 8px;
            background: var(--input-bg);
            border: 1.5px solid rgba(255,255,255,.1);
            border-radius: 14px;
            cursor: pointer;
            transition: all .2s ease;
            text-align: center;
            user-select: none;
        }
        .role-label .role-emoji { font-size: 1.5rem; line-height: 1; }
        .role-label .role-name  { font-size: .78rem; font-weight: 600; color: var(--text-muted); transition: color .2s; }

        .role-card input:checked + .role-label {
            border-color: var(--primary);
            background: rgba(16,185,129,.12);
            box-shadow: 0 0 0 3px rgba(16,185,129,.2);
        }
        .role-card input:checked + .role-label .role-name { color: var(--primary-light); }
        .role-label:hover {
            border-color: rgba(16,185,129,.4);
            background: rgba(16,185,129,.06);
        }

        /* ── Password strength ── */
        .strength-bar-track {
            height: 4px;
            background: rgba(255,255,255,.08);
            border-radius: 4px;
            margin-top: 8px;
            overflow: hidden;
        }
        .strength-bar-fill {
            height: 100%;
            border-radius: 4px;
            width: 0%;
            transition: width .4s ease, background .4s ease;
        }
        .strength-text { font-size: .73rem; margin-top: 4px; color: var(--text-muted); }

        /* ── Submit button ── */
        .btn-register {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            padding: 14px;
            border-radius: 14px;
            width: 100%;
            transition: all .3s ease;
            box-shadow: 0 10px 25px rgba(16,185,129,.3);
            position: relative;
            overflow: hidden;
            letter-spacing: .02em;
        }
        .btn-register::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,.15) 0%, transparent 60%);
            opacity: 0;
            transition: opacity .3s;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 35px rgba(16,185,129,.45);
            background: linear-gradient(135deg, #34d399 0%, #059669 100%);
            color: #fff;
        }
        .btn-register:hover::after { opacity: 1; }
        .btn-register:active { transform: translateY(0); }

        /* ── Alert ── */
        .alert-custom {
            background: rgba(239,68,68,.18);
            border: 1px solid rgba(239,68,68,.35);
            border-left: 4px solid #ef4444;
            color: #fca5a5;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: .85rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ── Validation errors ── */
        .field-error {
            color: #f87171;
            font-size: .76rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── Footer link ── */
        .footer-link {
            text-align: center;
            margin-top: 22px;
            font-size: .87rem;
            color: var(--text-muted);
        }
        .footer-link a {
            color: var(--primary-light);
            text-decoration: none;
            font-weight: 600;
            transition: color .2s;
        }
        .footer-link a:hover { color: #fff; }

        /* ── Status badge ── */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(16,185,129,.10);
            border: 1px solid rgba(16,185,129,.28);
            color: #34d399;
            padding: 5px 13px;
            border-radius: 20px;
            font-size: .78rem;
            font-weight: 500;
        }
        .status-dot {
            width: 7px;
            height: 7px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 6px #10b981;
            animation: blink 2s infinite;
        }
        @keyframes blink {
            0%,100% { transform:scale(.95); box-shadow: 0 0 0 0 rgba(16,185,129,.7); }
            70%      { transform:scale(1);   box-shadow: 0 0 0 5px rgba(16,185,129,0); }
        }

        /* ── Step progress ── */
        .step-progress {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-bottom: 24px;
        }
        .step-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: rgba(255,255,255,.15);
            transition: all .3s;
        }
        .step-dot.active {
            background: var(--primary);
            width: 24px;
            border-radius: 4px;
            box-shadow: 0 0 8px rgba(16,185,129,.6);
        }

        /* Responsive */
        @media (max-width: 575px) {
            .register-card { padding: 32px 24px; }
            .role-grid { grid-template-columns: repeat(3, 1fr); }
        }
    </style>
</head>
<body>

    <!-- Animated background orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="register-card">

        <!-- Brand header -->
        <div class="brand-header">
            <div class="brand-icon">
                <i class="bi bi-leaf-fill"></i>
            </div>
            <h1 class="brand-title">AgriScout</h1>
            <p class="brand-subtitle">Field &amp; Farm Management Portal</p>
            <div class="status-badge">
                <span class="status-dot"></span>
                Oracle 21c (XE) — Live
            </div>
        </div>

        <!-- Step indicator -->
        <div class="step-progress">
            <div class="step-dot active" id="step1"></div>
            <div class="step-dot" id="step2"></div>
            <div class="step-dot" id="step3"></div>
        </div>

        <div style="text-align:center; margin-bottom:22px;">
            <p class="page-title">Create your account</p>
            <p class="page-desc">Join thousands of farmers &amp; field officers</p>
        </div>

        <!-- Error alert -->
        @if(session('error'))
            <div class="alert-custom">
                <i class="bi bi-exclamation-triangle-fill" style="flex-shrink:0;"></i>
                {{ session('error') }}
            </div>
        @endif

        <form id="registerForm" method="POST" action="{{ route('register.submit') }}" novalidate>
            @csrf

            <!-- Full Name -->
            <div class="mb-3">
                <label class="form-label" for="name">Full Name</label>
                <div class="input-wrapper">
                    <i class="bi bi-person-fill input-icon"></i>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="John Kamau"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                    >
                </div>
                @error('name')
                    <div class="field-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label" for="email">Email Address</label>
                <div class="input-wrapper">
                    <i class="bi bi-envelope-fill input-icon"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="john@agriscout.com"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                    >
                </div>
                @error('email')
                    <div class="field-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
                @enderror
            </div>

            <!-- Role -->
            <div class="mb-3">
                <label class="form-label">Select Your Role</label>
                <div class="role-grid">

                    <label class="role-card">
                        <input type="radio" name="role" id="role_farmer" value="farmer" {{ old('role') === 'farmer' ? 'checked' : '' }} required>
                        <div class="role-label">
                            <span class="role-emoji">🌾</span>
                            <span class="role-name">Farmer</span>
                        </div>
                    </label>

                    <label class="role-card">
                        <input type="radio" name="role" id="role_officer" value="field_officer" {{ old('role') === 'field_officer' ? 'checked' : '' }}>
                        <div class="role-label">
                            <span class="role-emoji">📋</span>
                            <span class="role-name">Field Officer</span>
                        </div>
                    </label>

                    <label class="role-card">
                        <input type="radio" name="role" id="role_customer" value="customer" {{ old('role') === 'customer' ? 'checked' : '' }}>
                        <div class="role-label">
                            <span class="role-emoji">🛒</span>
                            <span class="role-name">Customer</span>
                        </div>
                    </label>

                </div>
                @error('role')
                    <div class="field-error mt-2"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="section-divider">Security</div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrapper">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control pw-toggle-field @error('password') is-invalid @enderror"
                        placeholder="Min. 6 characters"
                        required
                        autocomplete="new-password"
                        oninput="updateStrength(this.value)"
                    >
                    <button type="button" class="pw-toggle" id="togglePw1" onclick="togglePw('password','togglePw1')">
                        <i class="bi bi-eye-fill" id="eyeIcon1"></i>
                    </button>
                </div>
                <!-- Strength meter -->
                <div class="strength-bar-track">
                    <div class="strength-bar-fill" id="strengthFill"></div>
                </div>
                <div class="strength-text" id="strengthText">Enter a password</div>
                @error('password')
                    <div class="field-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <div class="input-wrapper">
                    <i class="bi bi-shield-lock-fill input-icon"></i>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control pw-toggle-field"
                        placeholder="Re-enter password"
                        required
                        autocomplete="new-password"
                    >
                    <button type="button" class="pw-toggle" id="togglePw2" onclick="togglePw('password_confirmation','togglePw2')">
                        <i class="bi bi-eye-fill" id="eyeIcon2"></i>
                    </button>
                </div>
                <div class="field-error" id="matchError" style="display:none;">
                    <i class="bi bi-exclamation-circle-fill"></i>Passwords do not match
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-register" id="submitBtn">
                <i class="bi bi-person-plus-fill me-2"></i>Create Account
            </button>

        </form>

        <!-- Footer -->
        <div class="footer-link">
            Already have an account?
            <a href="{{ route('login') }}">Sign in here <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('admin.login') }}" style="color: rgba(148,163,184,.5); text-decoration:none; font-size:.78rem;">
                <i class="bi bi-shield-lock-fill me-1"></i>Administrator Access
            </a>
        </div>

    </div>

<script>
    /* ── Password visibility toggle ── */
    function togglePw(fieldId, btnId) {
        const field = document.getElementById(fieldId);
        const icon  = document.getElementById(btnId).querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.className = 'bi bi-eye-slash-fill';
        } else {
            field.type = 'password';
            icon.className = 'bi bi-eye-fill';
        }
    }

    /* ── Password strength meter ── */
    function updateStrength(pw) {
        const fill = document.getElementById('strengthFill');
        const text = document.getElementById('strengthText');
        let score = 0;
        if (pw.length >= 6)  score++;
        if (pw.length >= 10) score++;
        if (/[A-Z]/.test(pw)) score++;
        if (/[0-9]/.test(pw)) score++;
        if (/[^A-Za-z0-9]/.test(pw)) score++;

        const levels = [
            { pct: '0%',   color: 'transparent',                                label: 'Enter a password', col: '#94a3b8' },
            { pct: '25%',  color: 'linear-gradient(90deg,#ef4444,#f97316)',      label: 'Weak',             col: '#f87171' },
            { pct: '50%',  color: 'linear-gradient(90deg,#f97316,#eab308)',      label: 'Fair',             col: '#fbbf24' },
            { pct: '75%',  color: 'linear-gradient(90deg,#eab308,#22c55e)',      label: 'Good',             col: '#86efac' },
            { pct: '90%',  color: 'linear-gradient(90deg,#22c55e,#10b981)',      label: 'Strong',           col: '#34d399' },
            { pct: '100%', color: 'linear-gradient(90deg,#10b981,#06d6a0)',      label: '💪 Very Strong',   col: '#6ee7b7' },
        ];

        const lvl = pw.length === 0 ? levels[0] : levels[Math.min(score, 5)];
        fill.style.width      = lvl.pct;
        fill.style.background = lvl.color;
        text.textContent      = lvl.label;
        text.style.color      = lvl.col;
    }

    /* ── Confirm match check ── */
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const pw   = document.getElementById('password').value;
        const err  = document.getElementById('matchError');
        err.style.display = (this.value && this.value !== pw) ? 'flex' : 'none';
    });

    /* ── Step indicator animation on focus flow ── */
    const steps = ['name','email','role_farmer','password','password_confirmation'];
    const stepMap = { name:0, email:0, role_farmer:1, role_officer:1, role_customer:1, password:2, password_confirmation:2 };
    const dots = document.querySelectorAll('.step-dot');

    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', () => {
            const s = stepMap[input.id];
            if (s === undefined) return;
            dots.forEach((d,i) => d.classList.toggle('active', i <= s));
        });
    });

    /* ── Prevent submit if passwords mismatch ── */
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const pw  = document.getElementById('password').value;
        const pw2 = document.getElementById('password_confirmation').value;
        if (pw !== pw2) {
            e.preventDefault();
            document.getElementById('matchError').style.display = 'flex';
            document.getElementById('password_confirmation').focus();
        }
    });
</script>

</body>
</html>
