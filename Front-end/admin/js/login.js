document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggle
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.querySelector('#admin-password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }

    // Form validation
    const form = document.getElementById('adminLoginForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const username = document.getElementById('admin-username').value.trim();
            const password = document.getElementById('admin-password').value.trim();
            
            if (!username || !password) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return false;
            }
            
            return true;
        });
    }

    // Form submission handling
    const loginForm = document.getElementById('adminLoginForm');
    
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form values
        const username = document.getElementById('admin-username').value.trim();
        const password = document.getElementById('admin-password').value;
        const otp = document.getElementById('admin-otp').value.trim();
        const remember = document.getElementById('remember').checked;
        
        // Validate inputs
        if (!username || !password) {
            showAlert('Please enter both username and password', 'error');
            return;
        }
        
        // Show loading state
        const submitBtn = loginForm.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Authenticating...';
        
        // In a real application, this would be an AJAX call to your backend
        simulateLogin(username, password, otp, remember)
            .then(response => {
                if (response.success) {
                    showAlert('Login successful! Redirecting...', 'success');
                    // Redirect to admin dashboard after 1.5 seconds
                    setTimeout(() => {
                        window.location.href = 'admin.html';
                    }, 1500);
                } else {
                    showAlert(response.message, 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Login';
                }
            })
            .catch(error => {
                showAlert('An error occurred during login', 'error');
                console.error('Login error:', error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Login';
            });
    });

    // Input validation
    document.getElementById('admin-otp').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
    });
});

// Simulate login (replace with actual API call in production)
function simulateLogin(username, password, otp, remember) {
    return new Promise((resolve) => {
        // Simulate network delay
        setTimeout(() => {
            // These are demo credentials - in real app, validate against your backend
            const validCredentials = (
                (username === 'admin' && password === 'Admin@123') || 
                (username === 'superadmin' && password === 'Super@123')
            );
            
            if (validCredentials) {
                // If OTP is required (demo: any 6-digit OTP is valid if provided)
                if (otp && otp.length !== 6) {
                    resolve({
                        success: false,
                        message: 'OTP must be 6 digits'
                    });
                    return;
                }
                
                resolve({
                    success: true,
                    message: 'Authentication successful'
                });
            } else {
                resolve({
                    success: false,
                    message: 'Invalid username or password'
                });
            }
        }, 1000); // Simulate 1 second delay
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
    
    document.querySelector('.login-container').prepend(alert);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

// Security features - session timeout warning
let idleTimer;
const timeoutInMinutes = 25; // Warn 5 minutes before 30-minute timeout
const warningTime = timeoutInMinutes * 60 * 1000;

function resetIdleTimer() {
    clearTimeout(idleTimer);
    idleTimer = setTimeout(() => {
        showSessionWarning();
    }, warningTime);
}

function showSessionWarning() {
    const warning = document.createElement('div');
    warning.className = 'session-warning';
    warning.innerHTML = `
        <div class="warning-content">
            <i class="fas fa-exclamation-triangle"></i>
            <h3>Session About to Expire</h3>
            <p>Your session will timeout in 5 minutes due to inactivity.</p>
            <div class="warning-actions">
                <button id="continueSession">Continue Session</button>
                <button id="logoutNow">Logout Now</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(warning);
    
    document.getElementById('continueSession').addEventListener('click', () => {
        warning.remove();
        resetIdleTimer();
    });
    
    document.getElementById('logoutNow').addEventListener('click', () => {
        window.location.href = 'logout.html';
    });
}

// Set up idle timer
window.onload = resetIdleTimer;
window.onmousemove = resetIdleTimer;
window.onmousedown = resetIdleTimer;
window.ontouchstart = resetIdleTimer;
window.onclick = resetIdleTimer;
window.onkeypress = resetIdleTimer;