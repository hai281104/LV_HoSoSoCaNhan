<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - DPCS</title>
    <meta name="description" content="Trang tổng quan quản trị hệ thống DPCS - Quản lý người dùng và truy cập.">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Quản trị -->
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}?v={{ time() }}">
    
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <!-- Sidebar Admin -->
    <aside class="sidebar-admin">
        <a href="{{ route('landing') }}" class="sidebar-brand" style="text-decoration: none;">
            <img src="{{ asset('uploads/logo/logo.png') }}" alt="Logo" style="width: 44px; height: 44px; object-fit: contain; border-radius: 8px; flex-shrink: 0; background-color: rgba(255, 255, 255, 0.05); padding: 4px;">
            <div>
                <span class="brand-logo">DPCS <span class="badge-admin">Admin</span></span>
                <span class="brand-sub">Quản trị hệ thống</span>
            </div>
        </a>

        <nav class="sidebar-menu">
            <div class="menu-group">
                <div class="menu-title">Quản trị</div>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="{{ route('admin.dashboard') }}" class="menu-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                            <span>Tổng quan</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.nguoi-dung.index') }}" class="menu-link {{ Route::is('admin.nguoi-dung.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Quản lý người dùng</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.mau-cv.index') }}" class="menu-link {{ Route::is('admin.mau-cv.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Quản lý mẫu CV</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.danh-muc-chuan.index') }}" class="menu-link {{ Route::is('admin.danh-muc-chuan.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                            <span>Danh mục chuẩn</span>
                        </a>
                    </li>
                    {{-- <li class="menu-item">
                        <a href="{{ route('admin.duyet-dich-vu.index') }}" class="menu-link {{ Route::is('admin.duyet-dich-vu.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            <span>Duyệt dịch vụ</span>
                        </a>
                    </li> --}}
                    <li class="menu-item">
                        <a href="{{ route('admin.nhat-ky-hoat-dong.index') }}" class="menu-link {{ Route::is('admin.nhat-ky-hoat-dong.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span>Nhật ký hoạt động</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.nhat-ky-he-thong.index') }}" class="menu-link {{ Route::is('admin.nhat-ky-he-thong.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Nhật ký hệ thống</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.y-kien-nguoi-dung.index') }}" class="menu-link {{ Route::is('admin.y-kien-nguoi-dung.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            <span>Ý kiến người dùng</span>
                        </a>
                    </li>
                </ul>
            </div>


        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar-sm">
                    @if($anhDaiDien)
                        <img src="{{ asset($anhDaiDien) }}" alt="Avatar">
                    @else
                        <span class="js-avatar-initials-sm">{{ $tenRutGon }}</span>
                    @endif
                </div>
                <div class="user-info-sm">
                    <div class="user-name-sm">{{ $hoTen }}</div>
                    <div class="user-role-sm">{{ $chucDanh }}</div>
                </div>
            </div>
            <form id="logoutForm" action="{{ route('dang-xuat') }}" method="POST" style="display:none;">@csrf</form>
            <button type="button" class="btn-logout" onclick="if (confirm('Bạn có chắc chắn muốn đăng xuất khỏi hệ thống không?')) document.getElementById('logoutForm').submit()" title="Đăng xuất">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Đăng xuất</span>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="main-content">
        
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <h1 class="header-title">Hệ thống Quản trị</h1>
            </div>
            
            <!-- Navbar Stats Quick Indicators -->
            <div class="navbar-stats">
                <div class="nav-stat-item" title="Người dùng mới đăng ký tháng này">
                    <span class="nav-stat-dot dot-new"></span>
                    <span class="nav-stat-label">Mới:</span>
                    <span class="nav-stat-value">{{ $newUsersCount }}</span>
                </div>
                <div class="nav-stat-item" title="Tài khoản đang online (5 phút gần nhất)">
                    <span class="nav-stat-dot dot-online"></span>
                    <span class="nav-stat-label">Online:</span>
                    <span class="nav-stat-value text-online">{{ $onlineUsersCount }}</span>
                </div>
                <div class="nav-stat-item" title="Tổng lượt truy cập">
                    <span class="nav-stat-dot dot-access"></span>
                    <span class="nav-stat-label">Truy cập:</span>
                    <span class="nav-stat-value">{{ $totalAccess }}</span>
                </div>
                <div class="nav-stat-item" title="Lượt truy cập hôm nay">
                    <span class="nav-stat-dot dot-today"></span>
                    <span class="nav-stat-label">Hôm nay:</span>
                    <span class="nav-stat-value">{{ $todayAccess }}</span>
                </div>
            </div>
        </header>

        <!-- Body Content -->
        <div class="content-body">
            
            <!-- KPI Cards Section -->
            <div class="kpi-grid">
                <!-- Card 1: Người dùng mới -->
                <div class="kpi-card card-blue">
                    <div class="kpi-card-header">
                        <div class="kpi-icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        </div>
                        <span class="kpi-trend trend-up">Tháng này</span>
                    </div>
                    <div class="kpi-card-body">
                        <div class="kpi-value">{{ $newUsersCount }}</div>
                        <div class="kpi-title">Người dùng mới</div>
                        <p class="kpi-desc">Tính từ đầu tháng tới hiện tại</p>
                    </div>
                </div>

                <!-- Card 2: Tài khoản online -->
                <div class="kpi-card card-green">
                    <div class="kpi-card-header">
                        <div class="kpi-icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="kpi-trend trend-online pulsing">Live</span>
                    </div>
                    <div class="kpi-card-body">
                        <div class="kpi-value text-online">{{ $onlineUsersCount }}</div>
                        <div class="kpi-title">Tài khoản online</div>
                        <p class="kpi-desc">Hoạt động trong 5 phút qua</p>
                    </div>
                </div>

                <!-- Card 3: Tổng truy cập -->
                <div class="kpi-card card-purple">
                    <div class="kpi-card-header">
                        <div class="kpi-icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                        <span class="kpi-trend">Mọi lúc</span>
                    </div>
                    <div class="kpi-card-body">
                        <div class="kpi-value">{{ $totalAccess }}</div>
                        <div class="kpi-title">Tổng truy cập</div>
                        <p class="kpi-desc">Tổng lượt truy cập hệ thống</p>
                    </div>
                </div>

                <!-- Card 4: Truy cập hôm nay -->
                <div class="kpi-card card-orange">
                    <div class="kpi-card-header">
                        <div class="kpi-icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="kpi-trend trend-today">Hôm nay</span>
                    </div>
                    <div class="kpi-card-body">
                        <div class="kpi-value">{{ $todayAccess }}</div>
                        <div class="kpi-title">Truy cập hôm nay</div>
                        <p class="kpi-desc">Lượt truy cập trong ngày</p>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="chart-container-card">
                <div class="chart-header">
                    <div>
                        <h2 class="chart-card-title">Biểu đồ tăng trưởng người dùng</h2>
                        <p class="chart-card-subtitle">Số lượng tài khoản đăng ký mới (6 tháng gần nhất)</p>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>

        </div>
    </main>

    <!-- Script vẽ biểu đồ -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('userGrowthChart').getContext('2d');
            
            // Lấy dữ liệu từ Blade controller truyền sang
            const labels = @json($chartLabels);
            const data = @json($chartData);

            // Tạo gradient cho đường vẽ biểu đồ
            const gradientStroke = ctx.createLinearGradient(0, 0, 0, 400);
            gradientStroke.addColorStop(0, 'rgba(219, 39, 119, 0.35)'); // Rose pink
            gradientStroke.addColorStop(1, 'rgba(219, 39, 119, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Người dùng đăng ký mới',
                        data: data,
                        borderColor: '#db2777',
                        borderWidth: 3,
                        pointBackgroundColor: '#f43f5e',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        backgroundColor: gradientStroke,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Không hiển thị legend vì chỉ có 1 line duy nhất
                        },
                        tooltip: {
                            backgroundColor: '#4c0519',
                            titleFont: {
                                family: 'Inter',
                                size: 14,
                                weight: '600'
                            },
                            bodyFont: {
                                family: 'Inter',
                                size: 13
                            },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return `+ ${context.parsed.y} thành viên mới`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#884a55',
                                font: {
                                    family: 'Inter',
                                    size: 13
                                }
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(244, 63, 94, 0.08)',
                                drawBorder: false
                            },
                            ticks: {
                                precision: 0, // Chỉ hiển thị số nguyên
                                color: '#884a55',
                                font: {
                                    family: 'Inter',
                                    size: 13
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
