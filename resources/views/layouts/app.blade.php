<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ប្រព័ន្ធគ្រប់គ្រងស្តុកទំនិញ - Stock Controller System')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts for Khmer -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Modern Minimal Design */
        body {
            font-family: 'Noto Sans Khmer', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f8fafc;
            line-height: 1.6;
            color: #1e293b;
        }
        
        /* Clean Navigation */
        .navbar {
            background: #ffffff !important;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: #1e293b !important;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand i {
            font-size: 1.6rem;
            margin-right: 0.6rem;
            color: #3b82f6;
        }
        
        .nav-link {
            font-weight: 500;
            color: #64748b !important;
            padding: 0.7rem 1.2rem !important;
            border-radius: 0.5rem;
            margin: 0 0.2rem;
            transition: all 0.2s ease;
        }
        
        .nav-link:hover {
            background: #f1f5f9;
            color: #1e293b !important;
        }
        
        .nav-link.active {
            background: #3b82f6;
            color: #ffffff !important;
        }
        
        .nav-link i {
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }
        
        /* User Info */
        .user-info {
            background: #f1f5f9;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            color: #475569;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        /* Logout Button */
        .btn-logout {
            background: none;
            border: none;
            color: #dc2626;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .btn-logout:hover {
            background: #fef2f2;
            color: #dc2626;
        }
        
        /* Clean Alerts */
        .alert {
            border: none;
            border-radius: 0.75rem;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid #16a34a;
        }
        
        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border-left: 4px solid #ef4444;
        }
        
        .alert-warning {
            background: #fffbeb;
            color: #d97706;
            border-left: 4px solid #f59e0b;
        }
        
        .alert-info {
            background: #eff6ff;
            color: #2563eb;
            border-left: 4px solid #3b82f6;
        }
        
        /* Button Updates */
        .btn-primary {
            background: #3b82f6;
            border: none;
            color: #ffffff;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }
        
        .btn-outline-primary {
            color: #3b82f6;
            border: 1px solid #3b82f6;
            background: #ffffff;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 0.5rem;
        }
        
        .btn-outline-primary:hover {
            background: #3b82f6;
            color: #ffffff;
        }
        
        /* Card Styling */
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            background: #ffffff;
        }
        
        .card-header {
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            border-radius: 0.75rem 0.75rem 0 0;
            padding: 1.25rem;
            font-weight: 600;
            color: #1e293b;
        }
        
        .card-body {
            padding: 1.25rem;
        }
        
        /* Table Styling */
        .table {
            border-radius: 0.5rem;
            overflow: hidden;
            background: #ffffff;
        }
        
        .table thead {
            background: #f8fafc;
        }
        
        .table th {
            border: none;
            font-weight: 600;
            color: #475569;
            padding: 1rem;
        }
        
        .table td {
            border: none;
            border-bottom: 1px solid #f1f5f9;
            padding: 1rem;
        }
        
        /* Loading Spinner */
        .loading-spinner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        
        .spinner-border-custom {
            width: 3rem;
            height: 3rem;
            border-width: 0.3rem;
            color: #3b82f6;
        }
        
        /* Main Content */
        .main-content {
            min-height: calc(100vh - 120px);
            padding-bottom: 2rem;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }
            
            .nav-link {
                text-align: center;
                margin: 0.2rem 0;
            }
            
            .user-info {
                margin-top: 0.5rem;
                text-align: center;
            }
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Focus States */
        .btn:focus, .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            border-color: #3b82f6;
        }
        
        /* Clean Toggle */
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <div class="text-center">
            <div class="spinner-border spinner-border-custom" role="status">
                <span class="visually-hidden">កំពុងផ្ទុក...</span>
            </div>
            <div class="mt-3 text-white fw-medium">កំពុងផ្ទុក...</div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-box-seam"></i>
                SORIYA MALL
            </a>
            
            @auth
            
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i>ផ្ទាំងគ្រប់គ្រង
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}" href="{{ route('inventory.index') }}">
                            <i class="bi bi-box"></i>ស្តុកទំនិញ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                            <i class="bi bi-people"></i>អ្នកផ្គត់ផ្គង់
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('restock.*') ? 'active' : '' }}" href="{{ route('restock.index') }}">
                            <i class="bi bi-arrow-repeat"></i>បញ្ជាទិញស្តុក
                        </a>
                    </li>
                </ul>
                
                <!-- Desktop User Actions -->
                <div class="d-none d-lg-flex align-items-center">
                
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="bi bi-box-arrow-right me-1"></i>ចាកចេញ
                        </button>
                    </form>
                </div>
                
                <!-- Mobile Logout -->
                <div class="d-lg-none mt-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-box-arrow-right me-2"></i>ចាកចេញ
                        </button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid px-4">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <strong>ជោគជ័យ!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>កំហុស!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>ការព្រមាន!</strong> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>ព័ត៌មាន!</strong> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <!-- Validation Errors -->
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>កំហុសក្នុងទម្រង់!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Loading spinner for form submissions
            const forms = document.querySelectorAll('form');
            const loadingSpinner = document.getElementById('loadingSpinner');
            
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    if (!form.hasAttribute('data-no-loading')) {
                        loadingSpinner.style.display = 'flex';
                    }
                });
            });
            
            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert.classList.contains('show')) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>