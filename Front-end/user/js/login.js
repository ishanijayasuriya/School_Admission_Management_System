 document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('form');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const errorMessage = document.querySelector('.error-message');

    // Clear error message when user starts typing
    [usernameInput, passwordInput].forEach(input => {
        input.addEventListener('input', () => {
            if (errorMessage) {
                errorMessage.textContent = '';
                errorMessage.style.display = 'none';
            }
        });
    });

    // Client-side form validation
    loginForm.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Clear previous error highlights
        document.querySelectorAll('.input-error').forEach(el => {
            el.classList.remove('input-error');
        });

        // Validate username
        if (usernameInput.value.trim() === '') {
            usernameInput.classList.add('input-error');
            isValid = false;
        }

        // Validate password
        if (passwordInput.value.trim() === '') {
            passwordInput.classList.add('input-error');
            isValid = false;
        } else if (passwordInput.value.length < 6) {
            passwordInput.classList.add('input-error');
            showError('Password must be at least 6 characters long');
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
        }
    });

    // Show error message function
    function showError(message) {
        if (!errorMessage) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            loginForm.insertBefore(errorDiv, loginForm.firstChild);
            errorDiv.textContent = message;
        } else {
            errorMessage.textContent = message;
            errorMessage.style.display = 'block';
        }
    }

    // Toggle password visibility (optional)
    const togglePassword = document.createElement('span');
    togglePassword.innerHTML = '👁️';
    togglePassword.style.cursor = 'pointer';
    togglePassword.style.marginLeft = '5px';
    togglePassword.title = 'Show/Hide Password';
    
    passwordInput.parentNode.insertBefore(togglePassword, passwordInput.nextSibling);
    
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    });
});                                              