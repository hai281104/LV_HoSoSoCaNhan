<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Hồ sơ Cá nhân - Kiến tạo sự nghiệp chuyên nghiệp</title>
    <meta name="description" content="Nền tảng quản lý hồ sơ cá nhân số hóa - xây dựng CV, portfolio và thương hiệu cá nhân chuyên nghiệp.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Noto+Serif+JP:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

    <!-- ===================================
         Text
    =================================== -->
    <header id="mainHeader">
        <div class="nav-inner">
            <a href="{{ route('landing') }}" class="nav-logo">
                <img src="{{ asset('uploads/logo/logo.png') }}" alt="Logo">
                <span class="nav-logo-text">HỒ SƠ <span>CÁ NHÂN</span></span>
            </a>

            <nav>
                <ul>
                    <li><a href="#features">Tính năng</a></li>
                    <li><a href="#showcase">Quy trình</a></li>
                    <li><a href="#cta">Bắt đầu</a></li>
                </ul>
            </nav>

            <div class="nav-buttons">
                @auth
                    <a href="{{ route('ho-so') }}" class="btn btn-ghost">Hồ sơ của tôi</a>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-gold">Đăng xuất</a>
                    <form id="logout-form" action="{{ route('dang-xuat') }}" method="POST" style="display: none;">@csrf</form>
                @else
                    <a href="{{ route('dang-nhap') }}" class="btn btn-ghost">Đăng nhập</a>
                    <a href="{{ route('dang-ky') }}" class="btn btn-gold">Đăng ký</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- ===================================
         SECTION 1: HERO (SKY / TWILIGHT)
    =================================== -->
    <section class="parallax-section section-hero" id="home" data-parallax-speed="0.4">
        <!-- Fireflies -->
        <div class="particles-layer" id="particles-hero"></div>

        <div class="section-content">
            <div class="hero-content-wrap">
                <div class="hero-eyebrow">
                    <span></span>
                    Phiên bản 2.0 · Trực quan & Chuyên nghiệp
                </div>

                <h1 class="hero-title">
                    Kiến tạo <span class="highlight">Hồ sơ Năng lực</span><br>
                    Số hóa của riêng bạn
                </h1>

                <p class="hero-desc">
                    Nền tảng giúp bạn quản lý quá trình học tập, lưu trữ chứng chỉ kỹ năng và trình bày các dự án Portfolio một cách trực quan, thu hút nhà tuyển dụng từ cái nhìn đầu tiên.
                </p>

                <div class="hero-actions">
                    @auth
                        <a href="{{ route('ho-so') }}" class="btn btn-gold btn-large">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                            Quản lý Hồ sơ ngay
                        </a>
                    @else
                        <a href="{{ route('dang-ky') }}" class="btn btn-gold btn-large">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                            Tạo tài khoản miễn phí
                        </a>
                        <a href="{{ route('dang-nhap') }}" class="btn btn-ghost btn-large">Đăng nhập hệ thống</a>
                    @endauth
                </div>


            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="scroll-indicator">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
            <span>Cuộn xuống</span>
        </div>
    </section>

    <!-- ===================================
         SECTION 2: MEADOW (FEATURES)
    =================================== -->
    <section class="parallax-section section-meadow" id="features" data-parallax-speed="0.3">
        <div class="particles-layer" id="particles-meadow"></div>

        <div class="section-content">
            <div class="section-header-ghibli">
                <div class="section-tag">Mô-đun cốt lõi</div>
                <h2 class="section-title-ghibli">Trải nghiệm quản lý hồ sơ thông minh</h2>
                <p class="section-sub-ghibli">Tối ưu hóa thời gian và quy trình thiết lập CV, Portfolio của bạn với 8 công cụ chuyên biệt tích hợp.</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" /></svg>
                    </div>
                    <h3>Bảng Điều Khiển</h3>
                    <p>Tổng hợp số liệu dự án, chứng chỉ, tiến độ học tập và các sự kiện công việc sắp tới trong một trang tổng quan.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon blue">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <h3>Hồ Sơ Cá Nhân</h3>
                    <p>Cập nhật ảnh đại diện, chức danh, thông tin liên lạc, kỹ năng cốt lõi và các liên kết mạng xã hội của bạn.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon green">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    </div>
                    <h3>Hành Trình Phát Triển</h3>
                    <p>Lưu vết lộ trình sự nghiệp, các công ty cũ đã làm việc và ghi nhận các cột mốc quan trọng.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
                    </div>
                    <h3>Học Vấn & Trình Độ</h3>
                    <p>Quản lý các cột mốc học tập, chuyên ngành học, GPA tích lũy và xếp loại bằng cấp cụ thể.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon blue">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </div>
                    <h3>Portfolio Dự Án</h3>
                    <p>Trưng bày và mô tả chi tiết các dự án bạn đã tham gia: vai trò, công nghệ, hình ảnh và liên kết demo.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon green">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <h3>Chứng Chỉ & Kỹ Năng</h3>
                    <p>Lưu trữ và xác nhận các chứng chỉ quốc tế, ngôn ngữ lập trình và kỹ năng mềm một cách chuyên nghiệp.</p>
                </div>

{{-- 
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <h3>Lịch & Công Việc</h3>
                    <p>Lập kế hoạch công việc, đặt lịch nhắc nhở các sự kiện quan trọng, tối ưu hiệu suất công tác hàng ngày.</p>
                </div>
--}}

                <div class="feature-card">
                    <div class="feature-icon blue">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <h3>CV Chuyên Nghiệp</h3>
                    <p>Tự động tạo CV đẹp từ dữ liệu hồ sơ, chọn nhiều mẫu thiết kế hiện đại và xuất ra file PDF chất lượng cao.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================
         SECTION 3: VILLAGE (STEPS)
    =================================== -->
    <section class="parallax-section section-village" id="showcase" data-parallax-speed="0.25">
        <div class="particles-layer" id="particles-village"></div>

        <div class="section-content">
            <div class="section-header-ghibli">
                <div class="section-tag gold">Quy trình vận hành</div>
                <h2 class="section-title-ghibli">Dễ dàng thiết lập trong 3 bước ngắn gọn</h2>
                <p class="section-sub-ghibli">Bắt đầu hành trình số hoá thương hiệu cá nhân của bạn ngay hôm nay với các thao tác tối giản và hiệu quả.</p>
            </div>

            <div class="showcase-layout">
                <div class="steps-list">
                    <div class="step-item">
                        <div class="step-num">1</div>
                        <div class="step-body">
                            <h4>Đăng ký tài khoản hệ thống</h4>
                            <p>Điền các thông tin cơ bản để thiết lập một trang hồ sơ cá nhân hoàn toàn bảo mật và thuộc về riêng bạn.</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-num">2</div>
                        <div class="step-body">
                            <h4>Cập nhật dữ liệu thành phần</h4>
                            <p>Thêm thông tin liên lạc, học vấn, dự án hay chứng chỉ để hoàn thiện bộ hồ sơ năng lực đầy đủ nhất.</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-num">3</div>
                        <div class="step-body">
                            <h4>Chia sẻ & Toả sáng</h4>
                            <p>Hồ sơ lưu trữ luôn sẵn sàng hoạt động giúp bạn truy xuất và chia sẻ với nhà tuyển dụng bất kỳ lúc nào.</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

    <!-- ===================================
         SECTION 4: FOREST (CTA)
    =================================== -->
    <section class="parallax-section section-forest" id="cta" data-parallax-speed="0.2">
        <div class="particles-layer" id="particles-forest"></div>

        <div class="section-content">
            <div class="cta-box">
                <div class="section-tag blue">Sẵn sàng bắt đầu</div>
                <h2 class="cta-title">
                    Xây dựng <span class="accent">hồ sơ chuyên nghiệp</span><br>
                    của riêng bạn hôm nay
                </h2>
                <p class="cta-desc">
                    Gia nhập cộng đồng người dùng thông thái và số hóa toàn bộ lộ trình sự nghiệp học tập của bạn. Không cần thẻ tín dụng, miễn phí hoàn toàn.
                </p>
                <div class="cta-actions">
                    @auth
                        <a href="{{ route('ho-so') }}" class="btn btn-forest btn-large">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                            Đi tới Bảng điều khiển
                        </a>
                    @else
                        <a href="{{ route('dang-ky') }}" class="btn btn-forest btn-large">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                            Đăng ký ngay bây giờ
                        </a>
                        <a href="{{ route('dang-nhap') }}" class="btn btn-ghost btn-large">Đăng nhập hệ thống</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================
         FOOTER
    =================================== -->
    <footer>
        <div class="footer-inner">
            <div class="footer-grid">
                <div>
                    <a href="{{ route('landing') }}" class="footer-brand-logo">
                        <img src="{{ asset('uploads/logo/logo.png') }}" alt="Logo">
                        <span>HỒ SƠ CÁ NHÂN</span>
                    </a>
                    <p class="footer-desc">Hệ thống quản lý và số hóa hồ sơ cá nhân toàn diện, giúp bạn xây dựng thương hiệu cá nhân và kiến tạo sự nghiệp chuyên nghiệp.</p>
                    <div class="footer-contacts">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            254 Nguyễn Văn Linh, Quận Thanh Khê, Đà Nẵng
                        </span>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            1900 1234
                        </span>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            support@hosocanhan.vn
                        </span>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Hệ thống</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('trang-chu') }}">Dashboard</a></li>
                        <li><a href="{{ route('ho-so') }}">Hồ sơ cá nhân</a></li>
                        <li><a href="{{ route('ho-so.hanh-trinh') }}">Hành trình</a></li>
                        <li><a href="{{ route('ho-so.hoc-van') }}">Học vấn</a></li>
                        <li><a href="{{ route('ho-so.du-an') }}">Portfolio</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Công cụ</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('ho-so.cv.index') }}">Quản lý CV</a></li>
                        <li><a href="{{ route('ho-so.chung-chi') }}">Chứng chỉ</a></li>
{{-- 
                        <li><a href="{{ route('ho-so.lich') }}">Lịch & Công việc</a></li>
                        <li><a href="{{ route('ho-so.dich-vu') }}">Dịch vụ cá nhân</a></li>
--}}
                        <li><a href="{{ route('ho-so.nhat-ky') }}">Nhật ký</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Hỗ trợ</h4>
                    <ul class="footer-links">
                        <li><a href="#" id="link-terms">Điều khoản sử dụng</a></li>
                        <li><a href="#" id="link-privacy">Chính sách bảo mật</a></li>
                        <li><a href="#" id="link-feedback">Đóng góp ý kiến</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <span class="footer-copyright">&copy; 2026 DPCS · Bảo lưu mọi quyền.</span>
                <div class="footer-socials">
                    <a href="https://facebook.com" target="_blank" class="footer-social-btn" title="Facebook">
                        <svg viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.8z"/></svg>
                    </a>
                    <a href="https://github.com" target="_blank" class="footer-social-btn" title="GitHub">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.579.688.481C19.137 20.162 22 16.418 22 12c0-5.523-4.477-10-10-10z"/></svg>
                    </a>
                    <a href="https://linkedin.com" target="_blank" class="footer-social-btn" title="LinkedIn">
                        <svg viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ===================================
         MODALS
    =================================== -->

    <!-- Terms Modal -->
    <div class="modal-overlay" id="termsModal">
        <div class="modal-card wide">
            <div class="modal-header">
                <h3 class="modal-title">Điều khoản sử dụng dịch vụ</h3>
                <button class="modal-close" onclick="closeModal('termsModal')">&times;</button>
            </div>
            <div class="modal-body">
                <p>Chào mừng bạn đến với Nền tảng Hồ sơ Cá nhân (DPCS). Bằng việc đăng ký tài khoản và sử dụng hệ thống của chúng tôi, bạn đồng ý tuân thủ các điều khoản và điều kiện sử dụng dưới đây:</p>
                <h4>1. Tài khoản Người dùng</h4>
                <p>Bạn phải cung cấp thông tin đăng ký chính xác và tự bảo mật thông tin tài khoản đăng nhập của mình. Mọi hoạt động được thực hiện dưới tài khoản của bạn sẽ thuộc trách nhiệm cá nhân của bạn.</p>
                <h4>2. Quyền sở hữu trí tuệ</h4>
                <p>Tất cả nội dung, biểu tượng, mã nguồn và giao diện người dùng trên hệ thống đều thuộc quyền sở hữu của DPCS. Bạn chỉ được phép sử dụng hệ thống cho mục đích lưu trữ thông tin cá nhân và giới thiệu năng lực bản thân.</p>
                <h4>3. Hành vi bị nghiêm cấm</h4>
                <p>Nghiêm cấm tải lên các nội dung vi phạm pháp luật, xúc phạm người khác, hoặc phát tán mã độc gây hại cho hệ thống. Chúng tôi có quyền khóa hoặc xóa tài khoản vi phạm mà không cần thông báo trước.</p>
                <h4>4. Giới hạn trách nhiệm</h4>
                <p>Chúng tôi nỗ lực tối đa để bảo vệ dữ liệu hồ sơ cá nhân của bạn, nhưng không chịu trách nhiệm đối với bất kỳ mất mát dữ liệu nào do sự cố bất khả kháng hoặc tấn công mạng ngoài tầm kiểm soát.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-ghost" onclick="closeModal('termsModal')">Đóng</button>
            </div>
        </div>
    </div>

    <!-- Privacy Modal -->
    <div class="modal-overlay" id="privacyModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Chính sách bảo mật thông tin</h3>
                <button class="modal-close" onclick="closeModal('privacyModal')">&times;</button>
            </div>
            <div class="modal-body">
                <p>Chính sách bảo mật này mô tả cách thức hệ thống DPCS thu thập, xử lý và bảo vệ thông tin cá nhân của bạn:</p>
                <h4>1. Thu thập thông tin</h4>
                <p>Chúng tôi thu thập các thông tin do bạn chủ động cung cấp bao gồm: Họ tên, email, ảnh đại diện, lịch sử học vấn, các dự án, chứng chỉ và hoạt động nhằm mục đích hiển thị trên hồ sơ cá nhân của bạn.</p>
                <h4>2. Bảo mật mật khẩu</h4>
                <p>Mật khẩu của bạn được mã hóa một chiều bằng thuật toán Bcrypt trước khi lưu trữ vào cơ sở dữ liệu. Chúng tôi hoàn toàn không thể đọc được mật khẩu của bạn.</p>
                <h4>3. Chia sẻ thông tin</h4>
                <p>Hồ sơ cá nhân của bạn chỉ được công khai khi bạn sử dụng chức năng Chia sẻ hồ sơ. Chúng tôi cam kết không bán hoặc cung cấp thông tin của bạn cho bên thứ ba vì mục đích thương mại.</p>
                <h4>4. Quyền kiểm soát</h4>
                <p>Bạn có quyền chỉnh sửa, ẩn đi hoặc yêu cầu xóa bỏ tài khoản của mình bất cứ lúc nào thông qua chức năng cài đặt trong hệ thống.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-ghost" onclick="closeModal('privacyModal')">Đã hiểu</button>
            </div>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div class="modal-overlay" id="feedbackModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Đóng góp ý kiến</h3>
                <button class="modal-close" onclick="closeModal('feedbackModal')">&times;</button>
            </div>
            @auth
                <form id="formLandingFeedback">
                    @csrf
                    <div class="modal-body">
                        <p>Chúng tôi rất trân trọng những ý kiến đóng góp quý báu từ bạn để cải tiến hệ thống ngày một tốt hơn.</p>
                        <div class="form-group">
                            <label for="landing_noi_dung_y_kien">Nội dung đóng góp ý kiến</label>
                            <textarea name="noi_dung" id="landing_noi_dung_y_kien" required class="form-textarea" placeholder="Nhập ý kiến đóng góp của bạn tại đây (tối thiểu 10 ký tự)..." rows="5"></textarea>
                            <span class="form-error" id="err-landing_noi_dung_y_kien"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-ghost" onclick="closeModal('feedbackModal')">Hủy</button>
                        <button type="submit" class="btn btn-gold" id="btnSubmitLandingFeedback">Gửi đóng góp</button>
                    </div>
                </form>
            @else
                <div class="modal-body" style="text-align: center; padding: 40px 24px;">
                    <div style="width: 64px; height: 64px; background: rgba(212,160,23,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: var(--accent-gold);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="32" height="32"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <h4 style="font-size: 18px; font-weight: 700; color: #fff8f0; margin-bottom: 8px;">Yêu cầu đăng nhập</h4>
                    <p>Vui lòng đăng nhập hoặc đăng ký tài khoản để gửi ý kiến đóng góp cho ban quản trị hệ thống.</p>
                    <div style="display: flex; gap: 12px; justify-content: center; margin-top: 20px;">
                        <a href="{{ route('dang-nhap') }}" class="btn btn-ghost">Đăng nhập</a>
                        <a href="{{ route('dang-ky') }}" class="btn btn-gold">Đăng ký ngay</a>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <!-- Toast -->
    <div class="toast-bar" id="landingToast">
        <div class="toast-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div class="toast-msg" id="landingToastMsg">Gửi đóng góp ý kiến thành công!</div>
    </div>

    <!-- ===================================
         JAVASCRIPT
    =================================== -->
    <script>
        window.landingRoutes = {
            feedback: "{{ route('cai-dat.y-kien') }}"
        };
    </script>
    <script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>
