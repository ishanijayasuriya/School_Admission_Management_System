 document.addEventListener('DOMContentLoaded', function() {
    // Check if user is logged in (demo - replace with actual authentication check)
    checkLoginStatus();
    
    // Smooth scrolling for navigation links
    setupSmoothScrolling();
    
    // Highlight current page in navigation
    highlightCurrentPage();
    
    // Add animation to intro section
    animateIntroSection();
    
    // Setup event listeners
    setupEventListeners();
});

function checkLoginStatus() {
    // In a real app, you would check cookies/sessionStorage for login status
    const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
    const isAdmin = localStorage.getItem('userRole') === 'admin';
    
    // Update navigation based on login status
    const loginLink = document.querySelector('a[href="loging.html"]');
    const adminLink = document.querySelector('a[href="admin_login.html"]');
    const logoutLink = document.querySelector('a[href="logout.html"]');
    
    if (isLoggedIn) {
        loginLink.style.display = 'none';
        adminLink.style.display = isAdmin ? 'inline-block' : 'none';
        logoutLink.style.display = 'inline-block';
    } else {
        loginLink.style.display = 'inline-block';
        adminLink.style.display = 'inline-block';
        logoutLink.style.display = 'none';
    }
}

function setupSmoothScrolling() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
}

function highlightCurrentPage() {
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('nav a');
    
    navLinks.forEach(link => {
        const linkPage = link.getAttribute('href');
        if (linkPage === currentPage) {
            link.classList.add('active');
        }
    });
}

function animateIntroSection() {
    const introSection = document.querySelector('.intro');
    
    // Add animation class after a short delay
    setTimeout(() => {
        introSection.classList.add('animate-in');
    }, 300);
}

function setupEventListeners() {
    // Apply button hover effect
    const applyBtn = document.querySelector('a[href="apply.html"]');
    if (applyBtn) {
        applyBtn.addEventListener('mouseenter', () => {
            applyBtn.innerHTML = '<i class="fas fa-arrow-right"></i> Apply Now';
        });
        applyBtn.addEventListener('mouseleave', () => {
            applyBtn.innerHTML = 'Apply for Admission';
        });
    }
    
    // Status check button effect
    const statusBtn = document.querySelector('a[href="status.html"]');
    if (statusBtn) {
        statusBtn.addEventListener('mouseenter', () => {
            statusBtn.innerHTML = '<i class="fas fa-search"></i> Check Status';
        });
        statusBtn.addEventListener('mouseleave', () => {
            statusBtn.innerHTML = 'Check Application Status';
        });
    }
    
    // Logout confirmation
    const logoutLink = document.querySelector('a[href="logout.html"]');
    if (logoutLink) {
        logoutLink.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to log out?')) {
                e.preventDefault();
            }
        });
    }
}

// Show a welcome message if just logged in
function showWelcomeMessage() {
    const justLoggedIn = sessionStorage.getItem('justLoggedIn');
    if (justLoggedIn) {
        const userName = localStorage.getItem('userName') || 'User';
        showAlert(`Welcome back, ${userName}!`, 'success');
        sessionStorage.removeItem('justLoggedIn');
    }
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
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        ${message}
    `;
    
    document.body.prepend(alert);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

// Initialize any carousels or sliders
function initCarousels() {
    // You would implement this if you add image carousels
    console.log('Initialize carousels here if needed');
}

// Track outbound links
function trackOutboundLinks() {
    document.querySelectorAll('a').forEach(link => {
        if (link.hostname !== window.location.hostname) {
            link.addEventListener('click', function() {
                console.log('Outbound link clicked:', this.href);
                // In a real app, you might send this to analytics
            });
        }
    });
}