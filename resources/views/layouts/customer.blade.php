<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Athara Villas')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #0f172a; /* Deep slate */
            --accent: #c9a84c; /* Gold */
            --accent-light: #fef9e8;
            --bg-body: #f8fafc;
            --surface: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --nav-height: 65px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
            padding-bottom: calc(var(--nav-height) + 15px); /* Space for bottom nav */
            -webkit-tap-highlight-color: transparent;
        }

        /* Top Header */
        .app-header {
            background: var(--surface);
            padding: 1rem 1.25rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }

        .header-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary);
            margin: 0;
        }

        /* Bottom Navigation Bar */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: var(--nav-height);
            background: var(--surface);
            display: flex;
            justify-content: space-around;
            align-items: center;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.06);
            z-index: 1000;
            padding: 0 10px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.5rem;
            min-width: 65px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .nav-item i {
            font-size: 1.3rem;
            margin-bottom: 3px;
            transition: transform 0.3s;
        }

        .nav-item.active {
            color: var(--accent);
        }

        .nav-item.active i {
            transform: translateY(-3px);
        }

        .nav-item.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--accent);
        }

        /* Utilities */
        .content-area {
            padding: 1.25rem;
        }
        
        .card-custom {
            background: var(--surface);
            border-radius: 16px;
            padding: 1.25rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            border: none;
            margin-bottom: 1rem;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @yield('styles')
</head>
<body>

    @hasSection('header')
        <div class="app-header">
            @yield('header')
        </div>
    @endif

    <div class="content-area fade-in">
        @yield('content')
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="{{ route('villa.index') }}" class="nav-item {{ request()->routeIs('villa.index') ? 'active' : '' }}">
            <i class="bi bi-house-door{{ request()->routeIs('villa.index') ? '-fill' : '' }}"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('customer.history') }}" class="nav-item {{ request()->routeIs('customer.history') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span>History</span>
        </a>
        <a href="{{ route('customer.account') }}" class="nav-item {{ request()->routeIs('customer.account') ? 'active' : '' }}">
            <i class="bi bi-person{{ request()->routeIs('customer.account') ? '-fill' : '' }}"></i>
            <span>Akun</span>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
