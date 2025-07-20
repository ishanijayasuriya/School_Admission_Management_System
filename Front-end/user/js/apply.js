// JavaScript for interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Add click events to service cards
            const serviceCards = document.querySelectorAll('.service-card');
            serviceCards.forEach((card, index) => {
                card.addEventListener('click', function() {
                    const grades = ["Great1.html", "Gread2to11.html", "gtead6.html", "Gread12.html"];
                    window.location.href = grades[index];
                });
            });
            
            // Add click event for login button
            const loginBtn = document.querySelector('.login-btn');
            loginBtn.addEventListener('click', function() {
                alert('Please login to access your application status.');
            });
            
            // Add click event for language toggle
            const langBtn = document.querySelector('.lang-btn');
            langBtn.addEventListener('click', function() {
                if(this.textContent === 'ENG') {
                    this.textContent = 'KOR';
                } else {
                    this.textContent = 'ENG';
                }
            });
            
            // Add click event for menu button
            const menuBtn = document.querySelector('.menu-btn');
            menuBtn.addEventListener('click', function() {
                alert('Additional menu options will be available here.');
            });
        });