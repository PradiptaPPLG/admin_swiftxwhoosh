<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Swift</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #E53935; /* Swift Red */
            --primary-dark: #B71C1C;
            --primary-light: #FFEBEE;
            --sidebar-bg: #0d1117;
            --surface: #ffffff;
            --surface-2: #F4F7FC;
            --text-primary: #0D1B2A;
            --text-secondary: #5A6B82;
            --text-muted: #8FA0B5;
            --border: #DDE5F0;
            --success: #0DAF7A;
            --danger: #EF4444;
            --shadow-lg: 0 10px 40px rgba(0,0,0,0.1);
            --radius: 12px;
            --radius-sm: 8px;
        }

        * { box-sizing: border-box; margin: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--sidebar-bg);
            color: var(--text-primary);
        }

        .login-left {
            width: 420px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
            background-color: #0d1117; 
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            z-index: 0;
            pointer-events: none;
        }

        .orb-1 { width: 350px; height: 350px; background: #E53935; top: -100px; left: -100px; animation: moveOrb1 18s ease-in-out infinite alternate; }
        .orb-2 { width: 400px; height: 400px; background: #FF5252; bottom: -150px; right: -150px; animation: moveOrb2 22s ease-in-out infinite alternate; }
        .orb-3 { width: 300px; height: 300px; background: #424242; top: 30%; left: -50px; animation: moveOrb3 20s ease-in-out infinite alternate; }

        @keyframes moveOrb1 { 0% { transform: translate(0, 0) scale(1); } 33% { transform: translate(200px, 250px) scale(1.2); } 66% { transform: translate(350px, 50px) scale(0.8); } 100% { transform: translate(150px, 350px) scale(1.1); } }
        @keyframes moveOrb2 { 0% { transform: translate(0, 0) scale(1); } 33% { transform: translate(-250px, -200px) scale(1.1); } 66% { transform: translate(-400px, 100px) scale(1.3); } 100% { transform: translate(-150px, -400px) scale(0.9); } }
        @keyframes moveOrb3 { 0% { transform: translate(0, 0) scale(1); } 33% { transform: translate(150px, -250px) scale(1.4); } 66% { transform: translate(250px, 150px) scale(0.7); } 100% { transform: translate(50px, -150px) scale(1.2); } }

        .brand-block { text-align: center; position: relative; z-index: 1; }

        .brand-icon-lg {
            width: 72px; height: 72px;
            background: white;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            overflow: hidden;
            padding: 8px;
        }

        .brand-block h1 { color: white; font-weight: 800; font-size: 28px; letter-spacing: 0.06em; margin-bottom: 6px; }
        .brand-block p { color: rgba(255,255,255,0.45); font-size: 12px; letter-spacing: 0.15em; text-transform: uppercase; }

        .brand-features { margin-top: 48px; display: flex; flex-direction: column; gap: 16px; position: relative; z-index: 1; }
        .brand-feature { display: flex; align-items: center; gap: 14px; color: rgba(255,255,255,0.6); font-size: 13px; font-weight: 500; }
        .brand-feature i { width: 36px; height: 36px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; color: rgba(255,255,255,0.8); flex-shrink: 0; }

        .login-right { flex: 1; display: flex; align-items: center; justify-content: center; background: var(--surface-2); padding: 48px; position: relative; }

        @keyframes cardEntrance3D { 0% { opacity: 0; transform: perspective(1000px) translateY(40px) rotateX(-10deg) scale(0.95); } 100% { opacity: 1; transform: perspective(1000px) translateY(0) rotateX(0deg) scale(1); } }
        @keyframes fadeUpStagger { 0% { opacity: 0; transform: translateY(15px); } 100% { opacity: 1; transform: translateY(0); } }

        .login-card { width: 100%; max-width: 420px; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow-lg); padding: 40px; opacity: 0; animation: cardEntrance3D 0.9s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; animation-delay: 0.1s; }
        .login-card h2, .login-card .subtitle, .login-card .alert, .login-card .mb-3, .login-card .mb-4, .login-card .btn-login, .login-card .login-footer { opacity: 0; animation: fadeUpStagger 0.7s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }

        .login-card h2 { animation-delay: 0.3s; font-size: 22px; font-weight: 800; color: var(--text-primary); margin-bottom: 6px; }
        .login-card .subtitle { animation-delay: 0.4s; font-size: 13.5px; color: var(--text-muted); margin-bottom: 32px; }
        .login-card .alert { animation-delay: 0.45s; }
        .login-card .mb-3 { animation-delay: 0.5s; }
        .login-card .mb-4 { animation-delay: 0.55s; }
        .login-card .btn-login { animation-delay: 0.6s; }
        .login-card .login-footer { animation-delay: 0.75s; text-align: center; margin-top: 24px; font-size: 12px; color: var(--text-muted); }

        .brand-icon-lg, .brand-block h1, .brand-block p, .brand-feature { opacity: 0; animation: fadeUpStagger 0.7s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        .brand-icon-lg { animation-delay: 0.2s; } .brand-block h1 { animation-delay: 0.3s; } .brand-block p { animation-delay: 0.4s; }
        .brand-feature:nth-child(1) { animation-delay: 0.5s; } .brand-feature:nth-child(2) { animation-delay: 0.6s; } .brand-feature:nth-child(3) { animation-delay: 0.7s; }

        .form-label { font-size: 12.5px; font-weight: 600; color: var(--text-secondary); letter-spacing: 0.02em; margin-bottom: 6px; }
        .form-control { font-size: 13.5px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); padding: 11px 14px; color: var(--text-primary); background: var(--surface); transition: all 0.2s; font-family: 'Plus Jakarta Sans', sans-serif; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(229,57,53,0.15); outline: none; }
        .form-control::placeholder { color: var(--text-muted); }

        .input-icon-wrap { position: relative; }
        .input-icon-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 15px; }
        .input-icon-wrap .form-control { padding-left: 42px; }

        .btn-login { width: 100%; background: var(--primary); border: none; color: white; padding: 12px; font-size: 14px; font-weight: 700; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer; transition: all 0.2s; }
        .btn-login:hover { background: var(--primary-dark); box-shadow: 0 4px 16px rgba(229,57,53,0.4); }

        .alert { border-radius: var(--radius-sm); border: none; font-size: 13px; font-weight: 500; padding: 12px 16px; margin-bottom: 20px; }
        .alert-danger { background: rgba(239,68,68,0.08); color: #991B1B; border-left: 3px solid var(--danger); }
        .error-text { font-size: 12px; color: var(--danger); margin-top: 5px; }

        @media (max-width: 768px) { body { flex-direction: column; } .login-left { width: 100%; padding: 32px 24px; } .brand-features { display: none; } .login-right { padding: 32px 24px; } }
    </style>
</head>
<body>

    <!-- LEFT BRAND PANEL -->
    <div class="login-left">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        <div class="brand-block">
            <div class="brand-icon-lg">
                <!-- User requested Photo 2 as icon -->
                <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            <h1>SWIFT</h1>
            <p>Admin Operations</p>
        </div>

        <div class="brand-features">
            <div class="brand-feature"><i class="bi bi-shield-lock"></i>Secure admin access</div>
            <div class="brand-feature"><i class="bi bi-speedometer2"></i>Real-time dashboard</div>
            <div class="brand-feature"><i class="bi bi-ticket-perforated"></i>Fleet & bookings management</div>
        </div>
    </div>

    <!-- RIGHT LOGIN FORM -->
    <div class="login-right">
        <div class="login-card">
            <h2>Welcome back</h2>
            <p class="subtitle">Sign in to access the Swift admin panel</p>

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-person"></i>
                        <input type="text" name="username" class="form-control" placeholder="admin" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label mb-0">Password</label>
                    </div>
                    <div class="input-icon-wrap">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </button>
            </form>

            <div class="login-footer">
                <i class="bi bi-shield-check me-1"></i> Protected admin area — Swift © {{ date('Y') }}
            </div>
        </div>
    </div>
    
    <!-- SECURITY GIMMICK POPUP -->
    <div id="gimmickPopup" style="display: none; position: fixed; inset: 0; background: rgba(13,17,23,0.95); z-index: 9999; flex-direction: column; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
        <!-- Scanning Phase -->
        <div id="scanPhase" style="text-align: center;">
            <div style="width: 100px; height: 100px; border: 4px solid var(--primary-dark); border-radius: 50%; border-top-color: var(--primary); animation: spin 1s linear infinite; margin: 0 auto 20px;"></div>
            <h3 style="color: white; font-family: 'JetBrains Mono', monospace; font-size: 20px; letter-spacing: 2px;">AUTHENTICATING...</h3>
            <p style="color: var(--primary); font-family: 'JetBrains Mono', monospace; font-size: 14px;" class="scan-text">Scanning credentials</p>
        </div>
        
        <!-- Welcome Phase -->
        <div id="welcomePhase" style="display: none; text-align: center; animation: cardEntrance3D 0.5s forwards;">
            <div style="width: 100px; height: 100px; background: var(--success); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 0 30px rgba(13,175,122,0.4);">
                <i class="bi bi-check-lg" style="font-size: 50px; color: white;"></i>
            </div>
            <h2 id="welcomeName" style="color: white; font-weight: 800; font-size: 32px; margin-bottom: 10px;">Howdy! 👋</h2>
            <p style="color: var(--text-muted); font-size: 16px;">Access Granted. Preparing dashboard...</p>
        </div>
    </div>

    <style>
        @keyframes spin { 100% { transform: rotate(360deg); } }
        .scan-text { animation: blink 1s step-end infinite; }
        @keyframes blink { 50% { opacity: 0; } }
        .spin-icon { animation: spin 1s linear infinite; display: inline-block; }
    </style>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = document.getElementById('loginBtn');
            btn.innerHTML = '<i class="bi bi-arrow-repeat spin-icon me-2"></i> Processing...';
            // We let the form submit normally in Laravel. 
            // If we want the gimmick before redirect, we do an ajax call.
            // For now, let it just show "Processing..." and submit.
        });

        // If session has 'success_login', show the gimmick on the dashboard page instead, 
        // or we handle it via ajax. Let's stick to standard form submission for Laravel to use its built-in auth logic.
    </script>
</body>
</html>
