
    (function() {
        'use strict';

        /* ---- NAVBAR SCROLL ---- */
        const header = document.getElementById('mainHeader');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 60) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }, { passive: true });

        /* ---- PARALLAX BACKGROUNDS ----
         * Ảnh 833312.png 750x1334 (tỉ lệ 9:16)
         * background-size: cover trên màn hình 16:9 → ảnh scale theo chiều rộng
         * Tại resolution 1920x1080: ảnh hiển thị 1920px rộng, cao = 1920*(1334/750)=3415px
         * Mỗi viewport = 1080px, tỷc lệ so ảnh = 1080/3415 ≈ 31.6% ảnh/viewport
         * Các vùng an toàn: Hero 0-30%, Meadow 28-55%, Village 53-78%, Forest 75-100%
         * Phần parallax drift: nhẹ ~8-12% để giữ hình ảnh trong vùng đó — */
        

        /* ---- FIREFLIES / PARTICLES ---- */
        function createParticles(containerId, type, count) {
            const container = document.getElementById(containerId);
            if (!container) return;

            for (let i = 0; i < count; i++) {
                const p = document.createElement('div');
                p.className = `particle ${type}`;
                p.style.left = Math.random() * 100 + '%';
                p.style.top = Math.random() * 100 + '%';
                p.style.animationDelay = (Math.random() * 8) + 's';
                p.style.animationDuration = (3 + Math.random() * 8) + 's';
                container.appendChild(p);
            }
        }

        /* Pixel art city: dust/sparks trên bầu trời, petal cho toà nhà, firefly đêm */
        createParticles('particles-hero',    'dust',    15);
        createParticles('particles-meadow',  'petal',   10);
        createParticles('particles-village', 'firefly', 20);
        createParticles('particles-forest',  'firefly', 18);

        /* ---- SCROLL-REVEAL ANIMATION ---- */
        const revealEls = document.querySelectorAll('.feature-card, .step-item, .stat-card, .cta-box, .section-header-ghibli');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = entry.target.style.transform
                        ? entry.target.style.transform.replace('translateY(40px)', 'translateY(0)')
                        : 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        revealEls.forEach((el, i) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(40px)';
            el.style.transition = `opacity 0.7s ease ${i * 0.05}s, transform 0.7s cubic-bezier(0.175, 0.885, 0.32, 1.275) ${i * 0.05}s`;
            observer.observe(el);
        });

        /* ---- SMOOTH SCROLL FOR NAV ---- */
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const target = document.querySelector(a.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        /* ---- MODAL FUNCTIONS ---- */
        window.openModal = function(id) {
            document.getElementById(id).classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        window.closeModal = function(id) {
            document.getElementById(id).classList.remove('active');
            document.body.style.overflow = '';
        };

        // Close on overlay click
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', e => {
                if (e.target === overlay) closeModal(overlay.id);
            });
        });

        // Escape key
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.active').forEach(m => closeModal(m.id));
            }
        });

        // Footer links
        const terms = document.getElementById('link-terms');
        const privacy = document.getElementById('link-privacy');
        const feedback = document.getElementById('link-feedback');

        if (terms) terms.addEventListener('click', e => { e.preventDefault(); openModal('termsModal'); });
        if (privacy) privacy.addEventListener('click', e => { e.preventDefault(); openModal('privacyModal'); });
        if (feedback) feedback.addEventListener('click', e => { e.preventDefault(); openModal('feedbackModal'); });

        /* ---- TOAST ---- */
        function showToast(msg) {
            const toast = document.getElementById('landingToast');
            const msgEl = document.getElementById('landingToastMsg');
            if (msgEl) msgEl.textContent = msg;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 4000);
        }

        /* ---- FEEDBACK FORM ---- */
        const feedbackForm = document.getElementById('formLandingFeedback');
        if (feedbackForm) {
            feedbackForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const textarea = document.getElementById('landing_noi_dung_y_kien');
                const errEl = document.getElementById('err-landing_noi_dung_y_kien');
                const btn = document.getElementById('btnSubmitLandingFeedback');

                errEl.textContent = '';

                if (!textarea.value.trim() || textarea.value.trim().length < 10) {
                    errEl.textContent = 'Vui lòng nhập ít nhất 10 ký tự.';
                    return;
                }

                const csrfToken = feedbackForm.querySelector('[name="_token"]').value;
                btn.disabled = true;
                btn.textContent = 'Đang gửi...';

                const fd = new FormData();
                fd.append('noi_dung', textarea.value.trim());
                fd.append('_token', csrfToken);

                fetch(window.landingRoutes.feedback, {
                    method: 'POST',
                    body: fd,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success || data.message) {
                        closeModal('feedbackModal');
                        showToast('Gửi đóng góp ý kiến thành công!');
                        textarea.value = '';
                    } else {
                        errEl.textContent = data.errors?.noi_dung?.[0] || 'Có lỗi xảy ra, vui lòng thử lại.';
                    }
                })
                .catch(() => {
                    errEl.textContent = 'Không thể kết nối. Vui lòng thử lại.';
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.textContent = 'Gửi đóng góp';
                });
            });
        }

    })();
    