<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    @PwaHead
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Dashboard</title>

    <!-- Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('css')

    <style>
        :root {
            /* Brand (landing theme) */
            --brand-primary:       #1B3D2F;
            --brand-primary-light: #2D6148;
            --brand-accent:        #C9A84C;
            --brand-accent-light:  #E8C97D;

            /* Semantic accents (modern SaaS) */
            --success: #10B981;
            --success-light: #34D399;
            --warning: #F97316;
            --warning-light: #FB923C;
            --danger:  #EF4444;
            --danger-light: #F87171;
            --info:    #3B82F6;
            --info-light: #60A5FA;

            /* Surfaces & text */
            --bg-app:     #F6F7F9;
            --surface:    #FFFFFF;
            --text-primary:   #0F172A;
            --text-secondary: #64748B;
            --text-tertiary:  #94A3B8;
            --border-subtle: rgba(15, 23, 42, 0.06);

            /* Legacy aliases kept for existing views */
            --fi-color-primary: var(--brand-accent);
            --fi-color-primary-hover: #B8933E;
            --fi-brand: var(--brand-primary);
            --fi-bg-body: var(--bg-app);
            --fi-border-color: var(--border-subtle);
            --fi-text-primary: var(--text-primary);
            --fi-text-muted: var(--text-secondary);
            --fi-bg-card: var(--surface);

            /* Scale */
            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-pill: 999px;
            --fi-radius: var(--radius-lg);

            /* Shadows (soft, layered — used instead of borders) */
            --shadow-xs: 0 1px 2px rgba(15, 23, 42, 0.04);
            --shadow-sm: 0 2px 10px rgba(15, 23, 42, 0.06);
            --shadow-md: 0 10px 28px rgba(15, 23, 42, 0.09);
            --shadow-lg: 0 20px 48px rgba(15, 23, 42, 0.12);
            --shadow-glow-primary: 0 10px 24px rgba(27, 61, 47, 0.28);
            --shadow-glow-accent: 0 10px 24px rgba(201, 168, 76, 0.35);
            --fi-shadow: var(--shadow-sm);

            /* Gradients */
            --gradient-primary: linear-gradient(135deg, #1B3D2F 0%, #2D6148 100%);
            --gradient-accent:  linear-gradient(135deg, #C9A84C 0%, #E8C97D 100%);
            --gradient-success: linear-gradient(135deg, #10B981 0%, #34D399 100%);
            --gradient-warning: linear-gradient(135deg, #F97316 0%, #FB923C 100%);
            --gradient-danger:  linear-gradient(135deg, #EF4444 0%, #F87171 100%);
            --gradient-info:    linear-gradient(135deg, #3B82F6 0%, #60A5FA 100%);
        }

        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

        body {
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            background-color: var(--bg-app);
            color: var(--text-primary);
            letter-spacing: -0.01em;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both; }

        /* ===== Top Navbar ===== */
        .navbar-top {
            background-color: var(--surface);
            border-bottom: none;
            box-shadow: var(--shadow-xs);
            height: 72px;
            z-index: 1030;
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--text-primary) !important;
            font-size: 1.15rem;
            letter-spacing: -0.03em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-badge {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            background: var(--gradient-primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            box-shadow: var(--shadow-glow-primary);
            flex-shrink: 0;
        }

        .avatar-badge {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-pill);
            background: var(--gradient-accent);
            color: var(--brand-primary);
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            position: fixed;
            top: 72px;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 0;
            background-color: var(--surface) !important;
            border-right: none;
            box-shadow: var(--shadow-xs);
            transition: all 0.3s;
        }

        .sidebar-sticky {
            position: relative;
            height: calc(100vh - 72px);
            padding: 16px 0;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-secondary);
            padding: 10px 14px;
            margin: 2px 12px;
            border-radius: var(--radius-md);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
        }

        .nav-icon-chip {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 1rem;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }
        .nav-icon-chip.chip-primary { background: rgba(27, 61, 47, 0.08); color: var(--brand-primary); }
        .nav-icon-chip.chip-accent  { background: rgba(201, 168, 76, 0.14); color: #A9862F; }
        .nav-icon-chip.chip-info    { background: rgba(59, 130, 246, 0.1); color: var(--info); }
        .nav-icon-chip.chip-success { background: rgba(16, 185, 129, 0.1); color: var(--success); }
        .nav-icon-chip.chip-warning { background: rgba(249, 115, 22, 0.1); color: var(--warning); }

        .sidebar .nav-link:hover {
            color: var(--text-primary);
            background-color: #F1F5F9;
            transform: translateX(2px);
        }

        .sidebar .nav-link.active {
            color: #fff;
            background: var(--gradient-primary);
            font-weight: 700;
            box-shadow: var(--shadow-glow-primary);
        }
        .sidebar .nav-link.active .nav-icon-chip {
            background: rgba(255, 255, 255, 0.18);
            color: #fff;
        }
        .sidebar .nav-link.active .bi.float-end { color: rgba(255,255,255,0.7); }

        .sidebar-heading {
            font-size: 0.7rem;
            font-weight: 800;
            color: var(--text-tertiary) !important;
            letter-spacing: 0.08em;
        }

        /* ===== Cards ===== */
        .card {
            background-color: var(--surface);
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--border-subtle);
            padding: 20px 24px;
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-primary);
        }

        .card-body {
            padding: 24px;
        }

        /* ===== Tables ===== */
        .table {
            color: var(--text-primary);
            margin-bottom: 0;
        }

        .table th {
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.06em;
            border-bottom: 1px solid var(--border-subtle);
            padding: 14px 24px;
            background-color: #FAFBFC;
        }

        .table td {
            padding: 16px 24px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-subtle);
        }

        /* ===== Buttons ===== */
        .btn {
            border-radius: var(--radius-md);
            font-weight: 600;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-primary {
            background: var(--gradient-accent);
            border: none;
            color: var(--brand-primary);
            box-shadow: var(--shadow-xs);
        }

        .btn-primary:hover, .btn-primary:focus {
            background: var(--gradient-accent);
            color: var(--brand-primary);
            box-shadow: var(--shadow-glow-accent);
            transform: translateY(-2px);
        }

        .btn-brand {
            background: var(--gradient-primary);
            border: none;
            color: #fff;
            box-shadow: var(--shadow-xs);
        }
        .btn-brand:hover {
            color: #fff;
            box-shadow: var(--shadow-glow-primary);
            transform: translateY(-2px);
        }

        .btn-light {
            box-shadow: var(--shadow-xs);
        }
        .btn-light:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .btn-success, .btn-danger, .btn-outline-primary {
            border: none;
            box-shadow: var(--shadow-xs);
        }
        .btn-success:hover, .btn-danger:hover, .btn-outline-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        /* ===== Customizing Main Area ===== */
        main {
            padding-top: 72px;
            min-height: 100vh;
        }

        h1.page-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.03em;
        }

        @media (max-width: 767.98px) {
            .sidebar {
                top: 72px;
            }
        }

        /* ===== Shared Design System ===== */

        .card-fi {
            background-color: var(--surface);
            border: none !important;
            border-radius: var(--radius-lg) !important;
            box-shadow: var(--shadow-sm);
        }

        .card-fi .card-header {
            background-color: transparent;
            border: none;
            padding: 24px 24px 12px;
        }

        /* Card hover animation */
        .card-hover {
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md) !important;
        }

        /* Stat cards (colorful gradient accents) */
        .stat-card {
            position: relative;
            overflow: hidden;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            top: -48px;
            right: -48px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            opacity: 0.08;
            background: var(--stat-color, var(--brand-primary));
            pointer-events: none;
        }
        .stat-card.stat-primary { --stat-color: #1B3D2F; }
        .stat-card.stat-accent  { --stat-color: #C9A84C; }
        .stat-card.stat-success { --stat-color: #10B981; }
        .stat-card.stat-danger  { --stat-color: #EF4444; }
        .stat-card.stat-info    { --stat-color: #3B82F6; }
        .stat-card.stat-warning { --stat-color: #F97316; }

        .icon-circle,
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon {
            color: #fff;
        }
        .stat-icon.icon-primary { background: var(--gradient-primary); box-shadow: 0 8px 18px rgba(27, 61, 47, 0.28); }
        .stat-icon.icon-accent  { background: var(--gradient-accent); box-shadow: 0 8px 18px rgba(201, 168, 76, 0.32); color: var(--brand-primary); }
        .stat-icon.icon-success { background: var(--gradient-success); box-shadow: 0 8px 18px rgba(16, 185, 129, 0.3); }
        .stat-icon.icon-danger  { background: var(--gradient-danger); box-shadow: 0 8px 18px rgba(239, 68, 68, 0.3); }
        .stat-icon.icon-info    { background: var(--gradient-info); box-shadow: 0 8px 18px rgba(59, 130, 246, 0.3); }
        .stat-icon.icon-warning { background: var(--gradient-warning); box-shadow: 0 8px 18px rgba(249, 115, 22, 0.3); }

        /* Table consistency */
        .table-fi thead th {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.06em;
            color: var(--text-secondary);
            background-color: #FAFBFC;
            border-bottom: 1px solid var(--border-subtle);
            padding: 14px 24px;
        }
        .table-fi tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--border-subtle);
        }
        .table-fi tbody tr:last-child {
            border-bottom: none;
        }
        .table-fi tbody tr:hover {
            background-color: #FAFBFC;
        }
        .table-fi tbody tr:hover .fw-bold {
            color: var(--brand-primary);
        }

        /* Amount badge */
        .amount-badge {
            padding: 7px 14px;
            border-radius: var(--radius-pill);
            font-weight: 700;
            font-size: 0.85rem;
            display: inline-block;
        }

        /* Tab styling */
        .nav-tabs-fi .nav-link.active {
            color: var(--brand-primary) !important;
            border-bottom: 2px solid var(--brand-accent) !important;
            background: transparent;
        }
        .nav-tabs-fi .nav-link:hover {
            color: var(--brand-primary) !important;
        }

        /* Pagination wrapper */
        .pagination-fi {
            padding: 16px 24px;
            border-top: 1px solid var(--border-subtle);
            background-color: transparent;
        }

        /* Pagination theme */
        .pagination {
            gap: 4px;
            flex-wrap: wrap;
            margin-bottom: 0;
        }
        .pagination .page-link {
            border: none;
            border-radius: var(--radius-sm) !important;
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 8px 14px;
            transition: all 0.2s ease;
            background-color: #F6F7F9;
            min-width: 36px;
            text-align: center;
        }
        .pagination .page-link:hover {
            background-color: rgba(201, 168, 76, 0.14);
            color: var(--brand-primary);
            transform: translateY(-1px);
        }
        .pagination .page-link:focus {
            box-shadow: 0 0 0 0.2rem rgba(201, 168, 76, 0.25);
        }
        .pagination .page-item.active .page-link {
            background: var(--gradient-primary);
            color: #fff;
            font-weight: 700;
            box-shadow: var(--shadow-glow-primary);
        }
        .pagination .page-item.disabled .page-link {
            background-color: #F6F7F9;
            color: var(--text-tertiary);
        }
        .pagination-fi .d-flex.justify-content-between {
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }
        @media (min-width: 576px) {
            .pagination-fi .d-flex.justify-content-between {
                flex-direction: row;
            }
        }
        .pagination-fi p.small {
            color: var(--text-secondary);
            font-size: 0.8rem;
        }

        /* Alert consistency */
        .alert-fi {
            border: none;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            margin-bottom: 1rem;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 40px 16px;
            color: var(--text-tertiary);
        }
        .empty-state i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            opacity: 0.5;
        }

        /* Transition utilities */
        .transition-all { transition: all 0.3s ease; }
        .hover-shadow-sm:hover { box-shadow: var(--shadow-sm); }
        .shadow-xs { box-shadow: var(--shadow-xs) !important; }

        /* Page header */
        .page-header-fi h4 {
            font-weight: 800;
            font-size: 1.4rem;
            letter-spacing: -0.02em;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }
        .page-header-fi p {
            color: var(--text-secondary);
            margin-bottom: 0;
            font-size: 0.875rem;
        }

        /* Quick action pills */
        .quick-action {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            border-radius: var(--radius-pill);
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid var(--border-subtle);
            background: var(--surface);
            color: var(--text-primary);
            box-shadow: var(--shadow-xs);
        }
        .quick-action:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
            color: var(--text-primary);
        }
        .quick-action .qa-icon {
            width: 28px;
            height: 28px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
    </style>
</head>
<body>

<header class="navbar navbar-expand-md navbar-top sticky-top px-3">
  <div class="d-flex align-items-center col-md-3 col-lg-2">
      <button class="navbar-toggler d-md-none collapsed border-0 me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-list fs-4 text-dark"></i>
      </button>
      <a class="navbar-brand me-0" href="{{ url('/') }}">
          <span class="brand-badge"><i class="bi bi-buildings-fill"></i></span>
          Villa Finance
      </a>
  </div>

  <div class="navbar-nav ms-auto my-auto d-none d-md-flex align-items-center">
    <div class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-dark fw-medium d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="avatar-badge">{{ substr(Auth::user()->name ?? 'G', 0, 1) }}</span>
            {{ Auth::user()->name ?? 'Guest' }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" aria-labelledby="userDropdown" style="border-radius: var(--radius-md); overflow: hidden; padding: 8px;">
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item py-2 text-danger fw-medium" style="border-radius: var(--radius-sm);">
                        <i class="bi bi-box-arrow-right me-2"></i>Sign out
                    </button>
                </form>
            </li>
        </ul>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
      <div class="position-sticky sidebar-sticky">
        <ul class="nav flex-column gap-1">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
              <span class="nav-icon-chip chip-primary"><i class="bi bi-speedometer2"></i></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('transactions.index') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
              <span class="nav-icon-chip chip-accent"><i class="bi bi-wallet2"></i></span>
              Laporan Transaksi
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('recurring-transactions.index') ? 'active' : '' }}" href="{{ route('recurring-transactions.index') }}">
              <span class="nav-icon-chip chip-info"><i class="bi bi-arrow-repeat"></i></span>
              Pengeluaran Rutin
            </a>
          </li>

          @role('pengelola')
          <li class="nav-item mt-3">
            <h6 class="sidebar-heading px-3 mb-2 text-uppercase">
              Administration
            </h6>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('villas.*') || request()->routeIs('fasilitas.*') || request()->is('vouchers*') || request()->routeIs('vouchers.*') ? '' : 'collapsed' }} {{ request()->routeIs('villas.*') || request()->routeIs('fasilitas.*') || request()->is('vouchers*') || request()->routeIs('vouchers.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#villaMenu" role="button" aria-expanded="{{ request()->routeIs('villas.*') || request()->routeIs('fasilitas.*') || request()->is('vouchers*') || request()->routeIs('vouchers.*') ? 'true' : 'false' }}" aria-controls="villaMenu">
              <span class="nav-icon-chip chip-success"><i class="bi bi-buildings"></i></span>
              Manajemen Villa
              <i class="bi bi-chevron-down float-end mt-1" style="font-size: 0.8rem; transition: transform 0.2s ease;"></i>
            </a>
            <div class="collapse {{ request()->routeIs('villas.*') || request()->routeIs('fasilitas.*') || request()->is('vouchers*') || request()->routeIs('vouchers.*') ? 'show' : '' }}" id="villaMenu">
              <ul class="nav flex-column ms-3 gap-1 mt-1">
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('fasilitas.*') ? 'active' : '' }}" href="{{ route('fasilitas.index') }}">
                    <span class="nav-icon-chip chip-success"><i class="bi bi-list-check"></i></span>
                    Fasilitas
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('villas.*') ? 'active' : '' }}" href="{{ route('villas.index') }}">
                    <span class="nav-icon-chip chip-success"><i class="bi bi-house-door"></i></span>
                    Villa
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('vouchers.*') ? 'active' : '' }}" href="{{ route('vouchers.index') }}">
                    <span class="nav-icon-chip chip-success"><i class="bi bi-ticket-perforated"></i></span>
                    Voucher
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
              <span class="nav-icon-chip chip-warning"><i class="bi bi-people"></i></span>
              Manajemen User
            </a>
          </li>
          @endrole

          <!-- Mobile Logout Button -->
          <li class="nav-item d-md-none mt-4 mx-3 border-top pt-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-light w-100 text-start text-danger fw-medium d-flex align-items-center">
                  <i class="bi bi-box-arrow-right me-2"></i> Sign out
                </button>
            </form>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 py-md-5">
      {{-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 mb-4">
        <h1 class="page-title">@yield('page_title', 'Dashboard')</h1>
      </div> --}}

      @yield('content')
    </main>
  </div>
</div>

    @stack('scripts')
    @RegisterServiceWorkerScript
</body>
</html>
