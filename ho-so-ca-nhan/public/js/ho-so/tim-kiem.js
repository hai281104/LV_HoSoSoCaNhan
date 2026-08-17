/**
 * tim-kiem.js
 * Tìm kiếm từ khóa và highlight nội dung trên trang cá nhân
 */

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('main-search-input');
    if (!searchInput) return;

    searchInput.addEventListener('input', function () {
        const keyword = this.value;
        highlightText(keyword);
    });
});

function clearHighlights() {
    const highlights = document.querySelectorAll('mark.search-highlight');
    highlights.forEach(highlight => {
        const parent = highlight.parentNode;
        if (parent) {
            parent.replaceChild(document.createTextNode(highlight.textContent), highlight);
            parent.normalize(); // Ghép các text node liền kề lại làm một
        }
    });
}

function highlightText(keyword) {
    clearHighlights();

    const cleanKeyword = keyword.trim().toLowerCase();

    // Lọc các thẻ card dự án ở trang Portfolio
    const projectCards = document.querySelectorAll('.project-card');
    if (projectCards.length > 0) {
        projectCards.forEach(card => {
            if (!cleanKeyword) {
                card.style.display = '';
            } else {
                const textContent = card.textContent.toLowerCase();
                if (textContent.includes(cleanKeyword)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            }
        });
    }

    // Lọc các mục học vấn ở trang Học vấn & Trình độ
    const timelineItems = document.querySelectorAll('.timeline-item');
    if (timelineItems.length > 0) {
        timelineItems.forEach(item => {
            if (!cleanKeyword) {
                item.style.display = '';
            } else {
                const textContent = item.textContent.toLowerCase();
                if (textContent.includes(cleanKeyword)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            }
        });

        // Hiển thị card thông báo không có kết quả nếu không tìm thấy
        const noResults = document.getElementById('no-filter-results');
        if (noResults) {
            const anyVisible = Array.from(timelineItems).some(item => item.style.display !== 'none');
            noResults.style.display = anyVisible ? 'none' : 'block';
        }
    }

    // Lọc các mục kinh nghiệm ở trang Kinh nghiệm làm việc
    const experienceItems = document.querySelectorAll('.experience-list-item');
    if (experienceItems.length > 0) {
        experienceItems.forEach(item => {
            if (!cleanKeyword) {
                item.style.display = 'flex';
            } else {
                const textContent = item.textContent.toLowerCase();
                if (textContent.includes(cleanKeyword)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            }
        });

        // Cập nhật hiển thị nhóm timeline-group
        const timelineGroups = document.querySelectorAll('.timeline-group');
        timelineGroups.forEach(group => {
            const visibleItems = Array.from(group.querySelectorAll('.experience-list-item')).filter(el => el.style.display !== 'none');
            if (visibleItems.length > 0) {
                group.style.display = 'block';
            } else {
                group.style.display = 'none';
            }
        });

        // Hiển thị card thông báo không có kết quả nếu không tìm thấy
        const noResults = document.getElementById('no-filter-results');
        if (noResults) {
            const anyVisible = Array.from(experienceItems).some(item => item.style.display !== 'none');
            noResults.style.display = anyVisible ? 'none' : 'block';
        }
    }

    // Lọc các thẻ card thành tựu ở trang Thành tựu
    const achievementCards = document.querySelectorAll('.achievement-card');
    if (achievementCards.length > 0) {
        achievementCards.forEach(card => {
            if (!cleanKeyword) {
                card.style.display = '';
            } else {
                const textContent = card.textContent.toLowerCase();
                if (textContent.includes(cleanKeyword)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            }
        });
    }

    // Lọc các thẻ card sự kiện ở trang Album ảnh nổi bật
    const eventCards = document.querySelectorAll('.event-card');
    if (eventCards.length > 0) {
        eventCards.forEach(card => {
            if (!cleanKeyword) {
                card.style.display = '';
            } else {
                const textContent = card.textContent.toLowerCase();
                if (textContent.includes(cleanKeyword)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            }
        });

        // Cập nhật hiển thị nhóm timeline-group nếu chứa .event-card
        const timelineGroups = document.querySelectorAll('.timeline-group');
        timelineGroups.forEach(group => {
            const hasEventCards = group.querySelector('.event-card');
            if (hasEventCards) {
                const visibleCards = Array.from(group.querySelectorAll('.event-card')).filter(el => el.style.display !== 'none');
                if (visibleCards.length > 0) {
                    group.style.display = 'block';
                } else {
                    group.style.display = 'none';
                }
            }
        });

        // Hiển thị card thông báo không có kết quả nếu không tìm thấy
        const noResults = document.getElementById('no-filter-results');
        if (noResults) {
            const anyVisible = Array.from(eventCards).some(card => card.style.display !== 'none');
            noResults.style.display = anyVisible ? 'none' : 'block';
        }
    }

    // Lọc các thẻ timeline card ở trang Hành trình phát triển
    const timelineItemCards = document.querySelectorAll('.timeline-item-card');
    if (timelineItemCards.length > 0) {
        timelineItemCards.forEach(card => {
            if (!cleanKeyword) {
                card.style.display = '';
            } else {
                const textContent = card.textContent.toLowerCase();
                if (textContent.includes(cleanKeyword)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            }
        });

        // Cập nhật hiển thị nhóm timeline-milestone-group
        const milestoneGroups = document.querySelectorAll('.timeline-milestone-group');
        milestoneGroups.forEach(group => {
            const visibleCards = Array.from(group.querySelectorAll('.timeline-item-card')).filter(el => el.style.display !== 'none');
            const navLink = document.querySelector(`.milestone-nav-link[data-target="${group.id}"]`);
            if (visibleCards.length > 0) {
                group.style.display = 'block';
                if (navLink) navLink.style.display = '';
            } else {
                group.style.display = 'none';
                if (navLink) navLink.style.display = 'none';
            }
        });

        // Hiển thị card thông báo không có kết quả nếu không tìm thấy
        const noResults = document.getElementById('no-filter-results');
        if (noResults) {
            const anyVisible = Array.from(timelineItemCards).some(card => card.style.display !== 'none');
            noResults.style.display = anyVisible ? 'none' : 'block';
        }

        // Trigger scrollspy active state update
        window.dispatchEvent(new Event('scroll'));
    }

    // Lọc các mục nhật ký hoạt động ở trang Hoạt động & Nhật ký
    const logItems = document.querySelectorAll('.log-item');
    if (logItems.length > 0) {
        logItems.forEach(item => {
            if (!cleanKeyword) {
                item.style.display = 'flex';
            } else {
                const textContent = item.textContent.toLowerCase();
                if (textContent.includes(cleanKeyword)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            }
        });

        // Hiển thị card thông báo không có kết quả nếu không tìm thấy
        const noResults = document.getElementById('no-filter-results');
        if (noResults) {
            const anyVisible = Array.from(logItems).some(item => item.style.display !== 'none');
            noResults.style.display = anyVisible ? 'none' : 'block';
        }
    }

    if (!cleanKeyword || cleanKeyword.length < 1) return;

    // Tìm kiếm trong các khu vực hiển thị thông tin chính của hồ sơ, học vấn và dự án
    const searchContainers = document.querySelectorAll('.info-card, .profile-banner-card, .education-card, .education-header-card, .project-card, .project-header-card, .certificate-card, .certificate-header-card, .achievement-card, .thanh-tuu-header-card, .experience-list-item, .experience-header-card, .event-card, .album-header-card, .cv-card, .timeline-item-card, .log-item');

    searchContainers.forEach(container => {
        traverseAndHighlight(container, cleanKeyword);
    });
}

function traverseAndHighlight(node, keyword) {
    if (node.nodeType === Node.TEXT_NODE) {
        const text = node.nodeValue;
        const lowerText = text.toLowerCase();
        const index = lowerText.indexOf(keyword);

        if (index >= 0) {
            const parent = node.parentNode;
            // Bỏ qua các thẻ chứa code, script, input, button hoặc thẻ mark đã có
            if (parent && !['SCRIPT', 'STYLE', 'TEXTAREA', 'INPUT', 'BUTTON', 'SELECT', 'MARK'].includes(parent.tagName)) {
                // Không highlight các nút hành động bên trong card
                if (parent.closest('button') || parent.closest('.card-action-btn') || parent.closest('.badge-count') || parent.closest('.sidebar')) {
                    return;
                }

                const matchedText = text.substring(index, index + keyword.length);
                const beforeText = text.substring(0, index);
                const afterText = text.substring(index + keyword.length);

                const beforeNode = document.createTextNode(beforeText);
                const markNode = document.createElement('mark');
                markNode.className = 'search-highlight';
                markNode.style.backgroundColor = '#fef08a'; // Màu nền vàng nhạt nổi bật
                markNode.style.color = '#0f172a';
                markNode.style.borderRadius = '3px';
                markNode.style.padding = '1px 3px';
                markNode.textContent = matchedText;

                const afterNode = document.createTextNode(afterText);

                parent.replaceChild(afterNode, node);
                parent.insertBefore(markNode, afterNode);
                parent.insertBefore(beforeNode, markNode);

                // Tiếp tục tìm kiếm đệ quy trên phần văn bản phía sau (cho trường hợp lặp từ trong 1 text node)
                traverseAndHighlight(afterNode, keyword);
            }
        }
    } else if (node.nodeType === Node.ELEMENT_NODE) {
        // Bỏ qua các thẻ điều khiển hoặc các phần tử không mong muốn
        if (!['SCRIPT', 'STYLE', 'TEXTAREA', 'INPUT', 'BUTTON', 'SELECT', 'MARK'].includes(node.tagName) && 
            !node.classList.contains('card-action-btn') && 
            !node.classList.contains('sidebar')) {
            
            const children = Array.from(node.childNodes);
            children.forEach(child => traverseAndHighlight(child, keyword));
        }
    }
}
