document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('mat_khau');
    const toggleButton = document.getElementById('togglePasswordBtn');
    const eyeIcon = document.getElementById('eyeIcon');

    toggleButton.addEventListener('click', function() {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        
        if (isPassword) {
            // Switch to eye off icon
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
            `;
            toggleButton.setAttribute('aria-label', 'Ẩn mật khẩu');
        } else {
            // Switch back to eye on icon
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
            toggleButton.setAttribute('aria-label', 'Hiện mật khẩu');
        }
    });

    // Logic ghi nho tu dong dien qua localStorage
    const emailInput = document.getElementById('email');
    const rememberCheckbox = document.getElementById('ghi_nho');
    const loginForm = document.querySelector('form');

    // Dien thong tin tu truoc
    if (localStorage.getItem('remember_me') === 'true') {
        emailInput.value = localStorage.getItem('saved_email') || '';
        passwordInput.value = localStorage.getItem('saved_password') || '';
        rememberCheckbox.checked = true;
    }

    // Luu khi submit form
    loginForm.addEventListener('submit', function() {
        if (rememberCheckbox.checked) {
            localStorage.setItem('saved_email', emailInput.value);
            localStorage.setItem('saved_password', passwordInput.value);
            localStorage.setItem('remember_me', 'true');
        } else {
            localStorage.removeItem('saved_email');
            localStorage.removeItem('saved_password');
            localStorage.removeItem('remember_me');
        }
    });
});
