document.addEventListener("DOMContentLoaded", function () {
    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector(".mobile-menu-btn");
    const mainNav = document.querySelector(".main-nav");

    mobileMenuBtn.addEventListener("click", function () {
        mainNav.classList.toggle("active");
    });

    // Smooth scroll for internal links
    const navLinks = document.querySelectorAll('a[href^="#"]');

    navLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const targetId = this.getAttribute("href").substring(1);
            const targetSection = document.getElementById(targetId);

            if (targetSection) {
                window.scrollTo({
                    top: targetSection.offsetTop - 80, // Adjust for fixed header
                    behavior: "smooth"
                });
            }
        });
    });

    // Optional: Close mobile menu on link click (for small screens)
    const navItems = document.querySelectorAll(".main-nav ul li a");
    navItems.forEach(item => {
        item.addEventListener("click", () => {
            if (mainNav.classList.contains("active")) {
                mainNav.classList.remove("active");
            }
        });
    });
});
