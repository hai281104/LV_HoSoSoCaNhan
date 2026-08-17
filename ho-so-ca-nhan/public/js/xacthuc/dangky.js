document.addEventListener('DOMContentLoaded', function() {
    // Email input auto-trim & lowercase sanitization
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            this.value = this.value.trim().toLowerCase();
        });
    }

    const form = document.querySelector('form');
    if (form && emailInput) {
        form.addEventListener('submit', function() {
            emailInput.value = emailInput.value.trim().toLowerCase();
        });
    }

    // Toggle for password field
    const passwordInput = document.getElementById('mat_khau');
    const toggleButton = document.getElementById('togglePasswordBtn');
    const eyeIcon = toggleButton.querySelector('.eyeIcon');

    toggleButton.addEventListener('click', function() {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        
        if (isPassword) {
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
            `;
            toggleButton.setAttribute('aria-label', 'Ẩn mật khẩu');
        } else {
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
            toggleButton.setAttribute('aria-label', 'Hiện mật khẩu');
        }
    });

    // Toggle for password confirm field
    const passwordConfirmInput = document.getElementById('mat_khau_xac_nhan');
    const toggleConfirmButton = document.getElementById('togglePasswordConfirmBtn');
    const eyeConfirmIcon = toggleConfirmButton.querySelector('.eyeIcon');

    toggleConfirmButton.addEventListener('click', function() {
        const isPassword = passwordConfirmInput.getAttribute('type') === 'password';
        passwordConfirmInput.setAttribute('type', isPassword ? 'text' : 'password');
        
        if (isPassword) {
            eyeConfirmIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
            `;
            toggleConfirmButton.setAttribute('aria-label', 'Ẩn mật khẩu');
        } else {
            eyeConfirmIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
            toggleConfirmButton.setAttribute('aria-label', 'Hiện mật khẩu');
        }
    });

    // Terms modal trigger logic
    const termsModal = document.getElementById('termsModal');
    const openTermsLink = document.getElementById('openTermsLink');
    const closeTermsModalHeaderBtn = document.getElementById('closeTermsModalHeaderBtn');
    const closeTermsModalBtn = document.getElementById('closeTermsModalBtn');

    function openModal() {
        termsModal.classList.add('open');
    }

    function closeModal() {
        termsModal.classList.remove('open');
    }

    openTermsLink.addEventListener('click', function(e) {
        e.preventDefault();
        openModal();
    });

    closeTermsModalHeaderBtn.addEventListener('click', closeModal);
    closeTermsModalBtn.addEventListener('click', closeModal);

    // Close modal when clicking outside the card
    termsModal.addEventListener('click', function(e) {
        if (e.target === termsModal) {
            closeModal();
        }
    });
});
