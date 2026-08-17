/**
 * album.js
 * JavaScript cho chức năng Album ảnh nổi bật
 */

document.addEventListener('DOMContentLoaded', function () {
    // ---------------------------------------------------------
    // BIẾN TOÀN CỤC TRONG MODULE
    // ---------------------------------------------------------
    let selectedFiles = []; // Mảng các File object mới chọn
    let existingImages = []; // Mảng các đường dẫn ảnh cũ được giữ lại

    // assetUrl helper
    const assetUrl = (window.ROUTES && window.ROUTES.assetUrl) ? window.ROUTES.assetUrl : '/';

    // Các thành phần DOM
    const formAlbum = document.getElementById('form-album');
    const inputId = document.getElementById('input-album-id');
    const inputTitle = document.getElementById('input-album-title');
    const inputDate = document.getElementById('input-album-date');
    const inputDesc = document.getElementById('input-album-desc');
    const descCounterEl = document.getElementById('album-desc-counter');

    function updateDescCounter() {
        if (!inputDesc || !descCounterEl) return;
        const count = inputDesc.value.length;
        descCounterEl.textContent = count;
        if (count >= 1000) {
            descCounterEl.style.color = '#ef4444';
            descCounterEl.style.fontWeight = 'bold';
        } else {
            descCounterEl.style.color = '';
            descCounterEl.style.fontWeight = '';
        }
    }

    if (inputDesc) {
        inputDesc.addEventListener('input', updateDescCounter);
    }

    const fileInput = document.getElementById('album-file-input');
    const clickBox = document.getElementById('album-uploader-clickbox');
    const previewsContainer = document.getElementById('album-previews-container');
    const btnSaveAlbum = document.getElementById('btn-luu-album');
    
    const modalAlbum = document.getElementById('modal-album');
    const modalTitleEl = document.getElementById('modal-album-title');
    const modalSubtitleEl = modalAlbum ? modalAlbum.querySelector('.modal-subtitle') : null;

    // Chi tiết Modal
    const modalChiTiet = document.getElementById('modal-chi-tiet-album');
    const detailTitle = document.getElementById('detail-album-title');
    const detailDate = document.getElementById('detail-album-date');
    const detailPhotoCount = document.getElementById('detail-album-photo-count');
    const detailDesc = document.getElementById('detail-album-desc');
    const detailPhotosGrid = document.getElementById('detail-photos-gallery-grid');
    const btnDetailSua = document.getElementById('btn-detail-sua-album');
    const btnDetailXoa = document.getElementById('btn-detail-xoa-album');

    // Lightbox
    const lightbox = document.getElementById('albumLightbox');
    const lightboxImg = document.getElementById('lightboxImage');

    // Bộ lọc
    const filterThang = document.getElementById('filter-thang');
    const filterNam = document.getElementById('filter-nam');
    const btnResetFilters = document.getElementById('btn-reset-filters');
    const noResultsCard = document.getElementById('no-filter-results');

    // ---------------------------------------------------------
    // BỘ LỌC THỜI GIAN
    // ---------------------------------------------------------
    function applyFilters() {
        const selectedMonth = filterThang ? filterThang.value : '';
        const selectedYear = filterNam ? filterNam.value : '';

        const timelineGroups = document.querySelectorAll('.timeline-group');
        let totalVisibleCards = 0;

        timelineGroups.forEach(group => {
            const eventCards = group.querySelectorAll('.event-card');
            let visibleCardsInGroup = 0;

            eventCards.forEach(card => {
                const cardMonth = card.dataset.thang;
                const cardNam = card.dataset.nam;

                const matchMonth = !selectedMonth || cardMonth === selectedMonth;
                const matchYear = !selectedYear || cardNam === selectedYear;

                if (matchMonth && matchYear) {
                    card.style.display = '';
                    visibleCardsInGroup++;
                    totalVisibleCards++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Nếu nhóm có sự kiện hiển thị thì hiện nhóm, ngược lại ẩn nhóm
            if (visibleCardsInGroup > 0) {
                group.style.display = 'block';
            } else {
                group.style.display = 'none';
            }
        });

        // Hiển thị card thông báo không có kết quả nếu không tìm thấy
        if (noResultsCard) {
            noResultsCard.style.display = totalVisibleCards === 0 ? 'block' : 'none';
        }
    }

    if (filterThang) filterThang.addEventListener('change', applyFilters);
    if (filterNam) filterNam.addEventListener('change', applyFilters);

    if (btnResetFilters) {
        btnResetFilters.addEventListener('click', function () {
            if (filterThang) filterThang.value = '';
            if (filterNam) filterNam.value = '';
            
            const searchInput = document.getElementById('main-search-input');
            if (searchInput) {
                searchInput.value = '';
                if (typeof clearHighlights === 'function') {
                    clearHighlights();
                }
            }
            
            // Show all cards
            const eventCards = document.querySelectorAll('.event-card');
            eventCards.forEach(card => {
                card.style.display = '';
            });

            const timelineGroups = document.querySelectorAll('.timeline-group');
            timelineGroups.forEach(group => {
                group.style.display = 'block';
            });

            if (noResultsCard) {
                noResultsCard.style.display = 'none';
            }
        });
    }

    // ---------------------------------------------------------
    // FILE UPLOADER & THUMBNAIL PREVIEWS
    // ---------------------------------------------------------
    if (clickBox && fileInput) {
        clickBox.addEventListener('click', () => fileInput.click());
    }

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            const files = Array.from(this.files);
            
            // Validate định dạng và dung lượng
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
            const maxSizeBytes = 2 * 1024 * 1024; // 2MB

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (!allowedTypes.includes(file.type)) {
                    hienToast('error', 'Định dạng ảnh không hợp lệ. Chỉ hỗ trợ JPG, PNG, WebP.');
                    continue;
                }
                if (file.size > maxSizeBytes) {
                    hienToast('error', `Ảnh "${file.name}" vượt quá dung lượng cho phép (tối đa 2MB).`);
                    continue;
                }

                // Check tổng số ảnh
                if (existingImages.length + selectedFiles.length >= 5) {
                    hienToast('error', 'Sự kiện chỉ được có tối đa 5 ảnh minh họa.');
                    break;
                }

                selectedFiles.push(file);
            }

            // Reset input value để có thể chọn lại cùng file
            fileInput.value = '';
            renderPreviews();
        });
    }

    function renderPreviews() {
        if (!previewsContainer) return;
        previewsContainer.innerHTML = '';

        // Hiển thị ảnh cũ (khi sửa)
        existingImages.forEach((imgUrl, index) => {
            const item = document.createElement('div');
            item.className = 'photo-preview-item';
            
            const img = document.createElement('img');
            img.src = assetUrl + imgUrl;
            
            const btnRemove = document.createElement('button');
            btnRemove.type = 'button';
            btnRemove.className = 'btn-remove-preview';
            btnRemove.innerHTML = '&times;';
            btnRemove.title = 'Xóa ảnh';
            btnRemove.addEventListener('click', function (e) {
                e.stopPropagation();
                existingImages.splice(index, 1);
                renderPreviews();
            });

            item.appendChild(img);
            item.appendChild(btnRemove);
            previewsContainer.appendChild(item);
        });

        // Hiển thị ảnh mới chọn
        selectedFiles.forEach((file, index) => {
            const item = document.createElement('div');
            item.className = 'photo-preview-item';
            
            const img = document.createElement('img');
            const objectUrl = URL.createObjectURL(file);
            img.src = objectUrl;

            // Thu hồi objectUrl khi hình ảnh tải xong để tránh rò rỉ bộ nhớ
            img.onload = function() {
                URL.revokeObjectURL(objectUrl);
            };

            const btnRemove = document.createElement('button');
            btnRemove.type = 'button';
            btnRemove.className = 'btn-remove-preview';
            btnRemove.innerHTML = '&times;';
            btnRemove.title = 'Xóa ảnh';
            btnRemove.addEventListener('click', function (e) {
                e.stopPropagation();
                selectedFiles.splice(index, 1);
                renderPreviews();
            });

            item.appendChild(img);
            item.appendChild(btnRemove);
            previewsContainer.appendChild(item);
        });
    }

    // ---------------------------------------------------------
    // MỞ FORM THÊM MỚI
    // ---------------------------------------------------------
    window.moModalThemAlbum = function () {
        if (!formAlbum) return;
        formAlbum.reset();
        if (inputId) inputId.value = '';
        selectedFiles = [];
        existingImages = [];
        renderPreviews();
        updateDescCounter();

        if (modalTitleEl) modalTitleEl.textContent = 'Đăng sự kiện mới';
        if (modalSubtitleEl) modalSubtitleEl.textContent = 'Thêm sự kiện và tải lên tối đa 5 hình ảnh';

        moModal('modal-album');
    };

    const btnDangSuKien = document.getElementById('btn-dang-su-kien');
    if (btnDangSuKien) {
        btnDangSuKien.addEventListener('click', moModalThemAlbum);
    }

    // ---------------------------------------------------------
    // SUBMIT FORM LƯU ALBUM
    // ---------------------------------------------------------
    if (btnSaveAlbum) {
        btnSaveAlbum.addEventListener('click', function (e) {
            e.preventDefault();
            
            if (!formAlbum) return;

            // Validation phía client
            const titleVal = inputTitle ? inputTitle.value.trim() : '';
            const dateVal = inputDate ? inputDate.value.trim() : '';
            const descVal = inputDesc ? inputDesc.value.trim() : '';

            if (!titleVal) {
                hienToast('error', 'Tên sự kiện không được để trống.');
                if (inputTitle) inputTitle.focus();
                return;
            }
            if (titleVal.length < 2 || titleVal.length > 100) {
                hienToast('error', 'Tên sự kiện phải có độ dài từ 2 đến 100 ký tự.');
                if (inputTitle) inputTitle.focus();
                return;
            }
            
            // Regex match chữ, số, khoảng trắng, dấu gạch ngang, gạch dưới
            const titleRegex = /^[\p{L}\p{N}\s\-_]+$/u;
            if (!titleRegex.test(titleVal)) {
                hienToast('error', 'Tên sự kiện không được chứa ký tự đặc biệt.');
                if (inputTitle) inputTitle.focus();
                return;
            }

            if (!dateVal) {
                hienToast('error', 'Ngày sự kiện là bắt buộc.');
                if (inputDate) inputDate.focus();
                return;
            }

            if (descVal.length > 1000) {
                hienToast('error', 'Mô tả chi tiết không được vượt quá 1000 ký tự.');
                if (inputDesc) inputDesc.focus();
                return;
            }

            const totalPhotos = existingImages.length + selectedFiles.length;
            if (totalPhotos < 1) {
                hienToast('error', 'Sự kiện phải có tối thiểu 1 ảnh minh họa.');
                return;
            }
            if (totalPhotos > 5) {
                hienToast('error', 'Sự kiện chỉ được có tối đa 5 ảnh minh họa.');
                return;
            }

            // Chuẩn bị payload FormData
            const formData = new FormData();
            if (inputId && inputId.value) {
                formData.append('id', inputId.value);
            }
            formData.append('ten_su_kien', titleVal);
            formData.append('ngay_su_kien', dateVal);
            formData.append('mo_ta', descVal);

            // Append các ảnh cũ được giữ lại
            existingImages.forEach(img => {
                formData.append('anh_cu[]', img);
            });

            // Append các ảnh mới chọn
            selectedFiles.forEach(file => {
                formData.append('anh_moi[]', file);
            });

            datTrangThaiLoading(btnSaveAlbum, true);

            fetch(window.ROUTES.luuAlbum, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': layToken(),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async res => {
                const isJson = res.headers.get('content-type')?.includes('application/json');
                const data = isJson ? await res.json() : null;

                if (!res.ok) {
                    if (res.status === 422 && data && data.errors) {
                        const errorMsg = Object.values(data.errors).flat().join(', ');
                        throw new Error(errorMsg);
                    }
                    if (data && data.thong_bao) {
                        throw new Error(data.thong_bao);
                    }
                    throw new Error('Lỗi máy chủ (' + res.status + ')');
                }
                return data;
            })
            .then(data => {
                if (data.thanh_cong) {
                    hienToast('success', data.thong_bao || 'Lưu thông tin thành công!');
                    dongModal('modal-album');
                    setTimeout(() => {
                        window.location.reload();
                    }, 800);
                } else {
                    hienToast('error', data.thong_bao || 'Có lỗi xảy ra!');
                }
            })
            .catch(err => {
                console.error('[Album] Save error:', err);
                hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
            })
            .finally(() => {
                datTrangThaiLoading(btnSaveAlbum, false);
            });
        });
    }

    // ---------------------------------------------------------
    // MODAL XEM CHI TIẾT SỰ KIỆN
    // ---------------------------------------------------------
    let currentDetailEvent = null;

    window.moModalChiTietAlbum = function (e, skData) {
        // Tránh kích hoạt khi click vào các element hành động con nếu có
        if (e && e.target && (e.target.closest('.btn-remove-preview') || e.target.closest('button') || e.target.closest('input') || e.target.closest('textarea'))) {
            return;
        }

        currentDetailEvent = skData;

        if (detailTitle) detailTitle.textContent = skData.tieu_de;
        
        // Format ngày dd/mm/yyyy
        if (detailDate) {
            const parts = skData.ngay_dien_ra.split('-');
            detailDate.textContent = parts.length === 3 ? `${parts[2]}/${parts[1]}/${parts[0]}` : skData.ngay_dien_ra;
        }

        if (detailPhotoCount) {
            detailPhotoCount.textContent = skData.anh_danh_sach.length;
        }

        const detailDescWrapper = document.getElementById('detail-album-desc-wrapper');
        if (detailDescWrapper) {
            if (skData.mo_ta) {
                if (detailDesc) {
                    detailDesc.textContent = skData.mo_ta;
                }
                detailDescWrapper.style.display = 'flex';
            } else {
                detailDescWrapper.style.display = 'none';
            }
        }

        // Render danh sách ảnh trong Grid chi tiết
        if (detailPhotosGrid) {
            detailPhotosGrid.innerHTML = '';
            
            // Layout class tùy theo số lượng hình ảnh
            const count = skData.anh_danh_sach.length;
            detailPhotosGrid.className = 'detail-photos-grid'; // Reset class
            if (count === 1) detailPhotosGrid.classList.add('grid-1');
            else if (count === 2) detailPhotosGrid.classList.add('grid-2');
            else if (count === 3) detailPhotosGrid.classList.add('grid-3');
            else if (count === 4) detailPhotosGrid.classList.add('grid-4');
            else detailPhotosGrid.classList.add('grid-5');

            skData.anh_danh_sach.forEach(imgData => {
                const wrapper = document.createElement('div');
                wrapper.className = 'detail-photo-wrapper';
                wrapper.addEventListener('click', function () {
                    moLightbox(assetUrl + imgData.url_hinh_anh);
                });

                const img = document.createElement('img');
                img.src = assetUrl + imgData.url_hinh_anh;
                img.alt = skData.tieu_de;

                const overlay = document.createElement('div');
                overlay.className = 'detail-photo-overlay';
                overlay.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                </svg>`;

                wrapper.appendChild(img);
                wrapper.appendChild(overlay);
                detailPhotosGrid.appendChild(wrapper);
            });
        }

        moModal('modal-chi-tiet-album');
    };

    // Nút Sửa từ modal chi tiết
    if (btnDetailSua) {
        btnDetailSua.addEventListener('click', function () {
            if (!currentDetailEvent) return;
            dongModal('modal-chi-tiet-album');

            const sk = currentDetailEvent;

            // Điền thông tin vào form chỉnh sửa
            if (inputId) inputId.value = sk.id;
            if (inputTitle) inputTitle.value = sk.tieu_de;
            if (inputDate) inputDate.value = sk.ngay_dien_ra;
            if (inputDesc) inputDesc.value = sk.mo_ta || '';

            // Copy list ảnh cũ
            existingImages = sk.anh_danh_sach.map(img => img.url_hinh_anh);
            selectedFiles = []; // Clear ảnh mới chọn
            renderPreviews();
            updateDescCounter();

            if (modalTitleEl) modalTitleEl.textContent = 'Cập nhật sự kiện';
            if (modalSubtitleEl) modalSubtitleEl.textContent = 'Chỉnh sửa thông tin và sắp xếp hình ảnh sự kiện';

            moModal('modal-album');
        });
    }

    // Nút Xóa từ modal chi tiết
    if (btnDetailXoa) {
        btnDetailXoa.addEventListener('click', function () {
            if (!currentDetailEvent) return;

            if (confirm('Bạn có chắc chắn muốn xóa sự kiện này? Hành động này không thể hoàn tác.')) {
                dongModal('modal-chi-tiet-album');
                
                const deleteUrl = window.ROUTES.xoaAlbum.replace('ID_PLACEHOLDER', currentDetailEvent.id);
                
                fetch(deleteUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': layToken(),
                        'Accept': 'application/json'
                    }
                })
                .then(async res => {
                    const isJson = res.headers.get('content-type')?.includes('application/json');
                    const data = isJson ? await res.json() : null;

                    if (!res.ok) {
                        if (data && data.thong_bao) {
                            throw new Error(data.thong_bao);
                        }
                        throw new Error('Lỗi máy chủ (' + res.status + ')');
                    }
                    return data;
                })
                .then(data => {
                    if (data.thanh_cong) {
                        hienToast('success', data.thong_bao || 'Xóa sự kiện thành công!');
                        setTimeout(() => {
                            window.location.reload();
                        }, 800);
                    } else {
                        hienToast('error', data.thong_bao || 'Có lỗi xảy ra!');
                    }
                })
                .catch(err => {
                    console.error('[Album] Delete error:', err);
                    hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
                });
            }
        });
    }

    // ---------------------------------------------------------
    // LIGHTBOX VIEWER
    // ---------------------------------------------------------
    function moLightbox(src) {
        if (!lightbox || !lightboxImg) return;
        lightboxImg.src = src;
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function dongLightbox() {
        if (!lightbox) return;
        lightbox.classList.remove('active');
        if (!document.querySelector('.modal-overlay.active')) {
            document.body.style.overflow = '';
        }
    }

    if (lightbox) {
        lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox || e.target.classList.contains('lightbox-close')) {
                dongLightbox();
            }
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            dongLightbox();
        }
    });
});
