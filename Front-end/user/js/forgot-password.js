document.addEventListener('DOMContentLoaded', function() {
    const forgotPasswordForm = document.querySelector('form');
    const emailInput = document.querySelector('input[type="email"]');
    const submitBtn = document.querySelector('button[type="submit"]');

    // Form submission handler
    forgotPasswordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = emailInput.value.trim();
        
        // Validate email
        if (!validateEmail(email)) {
            showAlert('Please enter a valid email address', 'error');
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        
        // Simulate sending reset link (replace with actual API call)
        sendPasswordResetLink(email)
            .then(response => {
                if (response.success) {
                    showAlert(response.message, 'success');
                    // Clear the email field
                    emailInput.value = '';
                    // Update button to show success
                    submitBtn.innerHTML = '<i class="fas fa-check"></i> Sent!';
                    
                    // Redirect after delay (optional)
                    setTimeout(() => {
                        window.location.href = '../Front-end/user/login.html';
                    }, 3000);
                } else {
                    showAlert(response.message, 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Send Reset Link';
                }
            })
            .catch(error => {
                showAlert('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Send Reset Link';
            });
    });

    // Email validation on input
    emailInput.addEventListener('input', function() {
        const email = this.value.trim();
        if (email && !validateEmail(email)) {
            this.setCustomValidity('Please enter a valid email address');
        } else {
            this.setCustomValidity('');
        }
    });
});

// Validate email format
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Simulate sending password reset link (replace with actual API call)
function sendPasswordResetLink(email) {
    return new Promise((resolve) => {
        // Simulate network delay
        setTimeout(() => {
            // In a real app, this would check if email exists in your database
            const emailExists = Math.random() > 0.3; // 70% chance email exists (for demo)
            
            if (emailExists) {
                resolve({
                    success: true,
                    message: 'Password reset link sent to your email. Please check your inbox.'
                });
            } else {
                resolve({
                    success: false,
                    message: 'No account found with this email address.'
                });
            }
        }, 1500);
    });
}

// Show alert message
function showAlert(message, type) {
    // Remove any existing alerts
    const existingAlert = document.querySelector('.alert');
    if (existingAlert) {
        existingAlert.remove();
    }
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.innerHTML = `
        <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'}"></i>
        ${message}
    `;
    
    // Insert after the form title
    const formTitle = document.querySelector('.forgot-password-container h2');
    formTitle.insertAdjacentElement('afterend', alert);
    
    // Auto-hide after 5 seconds (except for success messages)
    if (type !== 'success') {
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
}