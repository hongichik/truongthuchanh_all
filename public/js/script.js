// Mobile Menu Toggle Function
function toggleMobileMenu() {
    const navMenu = document.getElementById('navMenu');
    navMenu.classList.toggle('mobile-active');
}

document.addEventListener('DOMContentLoaded', function() {
    // Navigation functionality
    initializeNavigation();
    
    // Dropdown positioning functionality
    initializeDropdownPositioning();
    
    // Quick links functionality
    initializeQuickLinks();
    
    // Video play functionality
    initializeVideoLinks();
    
    // Mobile menu toggle
    initializeMobileMenu();
    
    // Scroll to top functionality
    initializeScrollToTop();
    
    // Auto update visit counter
    updateVisitCounter();
});

// Navigation functionality  
function initializeNavigation() {
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Only prevent default for in-page anchors or empty hrefs
            // Allow normal navigation for actual page links
            if (!href || href === '#' || href.startsWith('#')) {
                e.preventDefault();
                
                // Remove active class from all links
                navLinks.forEach(l => l.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
                
                // Smooth scroll to section (if exists and href starts with #)
                if (href && href.startsWith('#')) {
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            }
            // For actual page links (like .html files), allow normal navigation
            // No preventDefault() needed - browser will handle navigation normally
        });
    });
}

// Dropdown positioning functionality
function initializeDropdownPositioning() {
    const showButton = document.getElementById('show-tuyen-sinh');
    const dropdownContent = document.getElementById('tuyen-sinh');
    
    if (!showButton || !dropdownContent) {
        return; // Exit if elements not found
    }
    
    // Set initial styles for dropdown content
    dropdownContent.style.cssText = `
        display: block!important;
        position: fixed!important;
        opacity: 0;
        background: white;
        border: 2px solid #1e3a8a;
        border-radius: 8px;
        box-shadow: 0 8px 25px rgba(30, 58, 138, 0.15);
        min-width: 220px;
        z-index: 9999;
        padding: 10px 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateY(-10px);
        left: -50px;
        top: 55px;
    `;
    
    // Variable to track dropdown state
    let isDropdownVisible = false;
    
    // Function to calculate and position dropdown
    function positionDropdown() {
        const rect = showButton.getBoundingClientRect();
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
        
        // Calculate position right below the button
        const top = rect.bottom + scrollTop + 5; // 5px gap below button
        let left = rect.left + scrollLeft;
        
        // Ensure dropdown doesn't go off screen
        const dropdownWidth = 220;
        const windowWidth = window.innerWidth;
        
        if (left + dropdownWidth > windowWidth) {
            left = windowWidth - dropdownWidth - 20; // 20px margin from edge
        }
        
        // Apply position
        // dropdownContent.style.top = `${top}px`;
    }
    
    // Function to show dropdown
    function showDropdown() {
        positionDropdown();
        dropdownContent.style.visibility = 'visible';
        dropdownContent.style.opacity = '1';
        dropdownContent.style.transform = 'translateY(0)';
        isDropdownVisible = true;
    }
    
    // Function to hide dropdown
    function hideDropdown() {
        dropdownContent.style.visibility = 'hidden';
        dropdownContent.style.opacity = '0';
        dropdownContent.style.transform = 'translateY(-10px)';
        isDropdownVisible = false;
    }
    
    // Click event for show button
    showButton.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (isDropdownVisible) {
            hideDropdown();
        } else {
            showDropdown();
        }
    });
    
    // Click outside to close dropdown
    document.addEventListener('click', function(e) {
        if (!dropdownContent.contains(e.target) && !showButton.contains(e.target)) {
            hideDropdown();
        }
    });
    
    // Prevent dropdown from closing when clicking inside it
    dropdownContent.addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    // Reposition on window resize
    window.addEventListener('resize', function() {
        if (isDropdownVisible) {
            positionDropdown();
        }
    });
    
    // Enhanced styles for dropdown links
    const dropdownLinks = dropdownContent.querySelectorAll('a');
    dropdownLinks.forEach(link => {
        link.style.cssText += `
            display: block;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            border-bottom: 1px solid #eee;
            transition: all 0.2s ease;
            font-size: 14px;
        `;
        
        // Remove border from last link
        if (link === dropdownLinks[dropdownLinks.length - 1]) {
            link.style.borderBottom = 'none';
        }
        
        // Hover effects
        link.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f0f9ff';
            this.style.color = '#1e3a8a';
            this.style.paddingLeft = '25px';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.backgroundColor = 'transparent';
            this.style.color = '#333';
            this.style.paddingLeft = '20px';
        });
        
        // Click effect
        link.addEventListener('click', function() {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
                hideDropdown(); // Close dropdown after click
            }, 100);
        });
    });
}

// Quick links functionality
function initializeQuickLinks() {
    const quickLinks = document.querySelectorAll('.quick-link-item');
    
    quickLinks.forEach(link => {
        link.addEventListener('click', function() {
            const linkText = this.textContent.trim().toLowerCase();
            
            // Add visual feedback
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
            
            // Handle different link actions
            switch(linkText) {
                case 'tài liệu':
                    showNotification('Đang tải tài liệu...');
                    break;
                case 'văn bản':
                    showNotification('Đang tải văn bản...');
                    break;
                case 'video clip':
                    scrollToSection('.sidebar .video-item');
                    break;
                case 'album ảnh':
                    showNotification('Đang tải album ảnh...');
                    break;
                default:
                    showNotification(`Đang điều hướng đến ${this.textContent}...`);
            }
        });
    });
}

// Video links functionality
function initializeVideoLinks() {
    const videoItems = document.querySelectorAll('.video-item');
    
    videoItems.forEach(item => {
        item.addEventListener('click', function() {
            const title = this.querySelector('h4').textContent;
            showNotification(`Đang phát video: ${title}`);
            
            // Add visual feedback
            this.style.backgroundColor = '#f0f0f0';
            setTimeout(() => {
                this.style.backgroundColor = '';
            }, 300);
        });
    });
}

// Mobile menu toggle
function initializeMobileMenu() {
    // Create mobile menu button
    const navbar = document.querySelector('.navbar');
    const navMenu = document.querySelector('.nav-menu');
    
    if (window.innerWidth <= 768) {
        const menuButton = document.createElement('button');
        menuButton.innerHTML = '<i class="fas fa-bars"></i>';
        menuButton.className = 'mobile-menu-btn';
        menuButton.style.cssText = `
            display: block;
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            padding: 10px 15px;
            cursor: pointer;
        `;
        
        navbar.querySelector('.container').prepend(menuButton);
        
        menuButton.addEventListener('click', function() {
            navMenu.classList.toggle('mobile-open');
            
            if (navMenu.classList.contains('mobile-open')) {
                navMenu.style.display = 'flex';
                navMenu.style.flexDirection = 'column';
                this.innerHTML = '<i class="fas fa-times"></i>';
            } else {
                navMenu.style.display = 'none';
                this.innerHTML = '<i class="fas fa-bars"></i>';
            }
        });
    }
}

// Scroll to top functionality
function initializeScrollToTop() {
    // Create scroll to top button
    const scrollBtn = document.createElement('button');
    scrollBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    scrollBtn.className = 'scroll-to-top';
    scrollBtn.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #1e3a8a;
        color: white;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        cursor: pointer;
        display: none;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
    `;
    
    document.body.appendChild(scrollBtn);
    
    // Show/hide scroll button based on scroll position
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollBtn.style.display = 'block';
        } else {
            scrollBtn.style.display = 'none';
        }
    });
    
    // Scroll to top functionality
    scrollBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Update visit counter (demo functionality)
function updateVisitCounter() {
    const accessStats = document.querySelector('.access-stats');
    if (accessStats) {
        // Simulate real-time counter updates
        setInterval(() => {
            const currentVisitors = accessStats.querySelector('p:first-child strong:last-child');
            if (currentVisitors) {
                let count = parseInt(currentVisitors.textContent);
                count = Math.max(1, count + Math.floor(Math.random() * 3) - 1);
                currentVisitors.textContent = count;
            }
        }, 30000); // Update every 30 seconds
    }
}

// Utility functions
function showNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #1e3a8a;
        color: white;
        padding: 15px 20px;
        border-radius: 5px;
        z-index: 1001;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        animation: slideInRight 0.3s ease;
    `;
    
    // Add animation keyframes if not already added
    if (!document.querySelector('#notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(notification);
    
    // Auto remove notification after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

function scrollToSection(selector) {
    const element = document.querySelector(selector);
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Handle window resize for responsive features
window.addEventListener('resize', function() {
    // Re-initialize mobile menu if needed
    if (window.innerWidth > 768) {
        const mobileBtn = document.querySelector('.mobile-menu-btn');
        if (mobileBtn) {
            mobileBtn.remove();
        }
        
        const navMenu = document.querySelector('.nav-menu');
        navMenu.style.display = 'flex';
        navMenu.style.flexDirection = 'row';
        navMenu.classList.remove('mobile-open');
    }
});

// Add smooth scrolling to all anchor links
document.addEventListener('click', function(e) {
    if (e.target.matches('a[href^="#"]')) {
        e.preventDefault();
        const target = document.querySelector(e.target.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    }
});

// Image lazy loading for better performance
function lazyLoadImages() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Initialize lazy loading if supported
if ('IntersectionObserver' in window) {
    lazyLoadImages();
}