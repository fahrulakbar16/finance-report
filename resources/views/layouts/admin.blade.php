<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Dashboard</title>

    <!-- Fonts: Inter matches Filament -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --fi-color-primary: #d97706; /* Amber 600 */
            --fi-color-primary-hover: #b45309; /* Amber 700 */
            --fi-bg-body: #f8fafc; /* Slate 50 */
            --fi-border-color: #e2e8f0; /* Slate 200 */
            --fi-text-primary: #0f172a; /* Slate 900 */
            --fi-text-muted: #64748b; /* Slate 500 */
            --fi-bg-card: #ffffff;
            --fi-radius: 0.75rem;
            --fi-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            background-color: var(--fi-bg-body);
            color: var(--fi-text-primary);
        }

        /* Top Navbar */
        .navbar-top {
            background-color: #fff;
            border-bottom: 1px solid var(--fi-border-color);
            height: 64px;
            z-index: 1030;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--fi-text-primary) !important;
            font-size: 1.25rem;
            letter-spacing: -0.025em;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 64px;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 0;
            background-color: #fff !important;
            border-right: 1px solid var(--fi-border-color);
            transition: all 0.3s;
        }

        .sidebar-sticky {
            position: relative;
            height: calc(100vh - 64px);
            padding-top: 1rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            font-weight: 500;
            color: var(--fi-text-muted);
            padding: 0.5rem 1rem;
            margin: 0.25rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link .bi {
            margin-right: 0.75rem;
            font-size: 1.2rem;
            color: #94a3b8; /* Slate 400 */
            transition: color 0.2s ease;
        }

        .sidebar .nav-link:hover {
            color: var(--fi-text-primary);
            background-color: #f1f5f9; /* Slate 100 */
        }

        .sidebar .nav-link:hover .bi {
            color: var(--fi-text-primary);
        }

        .sidebar .nav-link.active {
            color: var(--fi-color-primary);
            background-color: #fef3c7; /* Amber 50 */
            font-weight: 600;
        }

        .sidebar .nav-link.active .bi {
            color: var(--fi-color-primary);
        }

        .sidebar-heading {
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8 !important;
            letter-spacing: 0.05em;
        }

        /* Cards mimicking Filament */
        .card {
            background-color: var(--fi-bg-card);
            border: 1px solid var(--fi-border-color);
            border-radius: var(--fi-radius);
            box-shadow: var(--fi-shadow);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--fi-border-color);
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            color: var(--fi-text-primary);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Tables mimicking Filament */
        .table {
            color: var(--fi-text-primary);
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            color: var(--fi-text-muted);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--fi-border-color);
            padding: 0.75rem 1.5rem;
            background-color: #f8fafc;
        }

        .table td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--fi-border-color);
        }

        /* Buttons matching Amber primary */
        .btn-primary {
            background-color: var(--fi-color-primary);
            border-color: var(--fi-color-primary);
            color: white;
            font-weight: 500;
            border-radius: 0.5rem;
            padding: 0.375rem 1rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--fi-color-primary-hover);
            border-color: var(--fi-color-primary-hover);
        }

        /* Customizing Main Area */
        main {
            padding-top: 64px;
            min-height: 100vh;
        }

        h1.page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--fi-text-primary);
            letter-spacing: -0.025em;
        }

        @media (max-width: 767.98px) {
            .sidebar {
                top: 64px;
            }
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
          <i class="bi bi-buildings-fill text-warning me-2"></i>Villa Finance
      </a>
  </div>

  <div class="navbar-nav ms-auto my-auto d-none d-md-flex align-items-center">
    <div class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-dark fw-medium d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white me-2" style="width: 32px; height: 32px;">
                {{ substr(Auth::user()->name ?? 'G', 0, 1) }}
            </div>
            {{ Auth::user()->name ?? 'Guest' }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown" style="border-radius: var(--fi-radius);">
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item py-2 text-danger">
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
            <a class="nav-link {{ request()->routeIs('transactions.index') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
              <i class="bi bi-wallet2"></i>
              Laporan Transaksi
            </a>
          </li>

          @role('pengelola')
          <li class="nav-item mt-3">
            <h6 class="sidebar-heading px-3 mb-2 text-uppercase">
              Administration
            </h6>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('villas.*') ? 'active' : '' }}" href="{{ route('villas.index') }}">
              <i class="bi bi-buildings"></i>
              Manajemen Villa
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
              <i class="bi bi-people"></i>
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

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 mb-4">
        <h1 class="page-title">@yield('page_title', 'Dashboard')</h1>
      </div>

      @yield('content')
    </main>
  </div>
</div>

</body>
</html>
