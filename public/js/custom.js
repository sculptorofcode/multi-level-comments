// Enhanced toggle reply form with smooth animations
function toggleReplyForm(commentId) {
    const form = document.getElementById('reply-form-' + commentId);
    const button = document.querySelector(`button[onclick="toggleReplyForm(${commentId})"]`);
    
    if (form.style.display === 'none' || form.style.display === '') {
        // Show form with animation
        form.style.display = 'block';
        form.style.opacity = '0';
        form.style.transform = 'translateY(-10px)';
        
        // Trigger animation
        setTimeout(() => {
            form.style.transition = 'all 0.3s ease';
            form.style.opacity = '1';
            form.style.transform = 'translateY(0)';
        }, 10);
        
        // Focus on textarea
        const textarea = form.querySelector('textarea');
        setTimeout(() => textarea.focus(), 300);
        
        // Update button text
        button.innerHTML = '<i class="fas fa-times me-1"></i>Cancel';
        button.classList.remove('btn-outline-primary');
        button.classList.add('btn-outline-secondary');
    } else {
        // Hide form with animation
        form.style.transition = 'all 0.3s ease';
        form.style.opacity = '0';
        form.style.transform = 'translateY(-10px)';
        
        setTimeout(() => {
            form.style.display = 'none';
        }, 300);
        
        // Reset button text
        button.innerHTML = '<i class="fas fa-reply me-1"></i>Reply';
        button.classList.remove('btn-outline-secondary');
        button.classList.add('btn-outline-primary');
    }
}

// Add smooth scroll behavior
document.documentElement.style.scrollBehavior = 'smooth';

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Add loading state to forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Posting...';
                submitButton.disabled = true;
                
                // Re-enable if form validation fails
                setTimeout(() => {
                    if (form.checkValidity() === false) {
                        submitButton.innerHTML = originalText;
                        submitButton.disabled = false;
                    }
                }, 100);
            }
        });
    });

    // Add hover effects to comment cards
    const comments = document.querySelectorAll('.comment-content');
    comments.forEach(comment => {
        comment.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        comment.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Character counter for textareas
    const textareas = document.querySelectorAll('textarea[name="content"]');
    textareas.forEach(textarea => {
        const maxLength = 1000; // Set max length
        
        // Create counter element
        const counter = document.createElement('small');
        counter.className = 'text-muted float-end mt-1';
        counter.textContent = `0/${maxLength}`;
        
        // Insert counter after textarea
        textarea.parentNode.appendChild(counter);
        
        // Update counter on input
        textarea.addEventListener('input', function() {
            const length = this.value.length;
            counter.textContent = `${length}/${maxLength}`;
            
            if (length > maxLength * 0.9) {
                counter.className = 'text-warning float-end mt-1';
            } else if (length >= maxLength) {
                counter.className = 'text-danger float-end mt-1';
            } else {
                counter.className = 'text-muted float-end mt-1';
            }
        });
    });

    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Add ripple effect to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            // Add ripple animation keyframes if not exists
            if (!document.querySelector('#ripple-animation')) {
                const style = document.createElement('style');
                style.id = 'ripple-animation';
                style.textContent = `
                    @keyframes ripple {
                        to {
                            transform: scale(4);
                            opacity: 0;
                        }
                    }
                `;
                document.head.appendChild(style);
            }
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});

// Add keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + Enter to submit forms
    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
        const activeElement = document.activeElement;
        if (activeElement.tagName === 'TEXTAREA') {
            const form = activeElement.closest('form');
            if (form) {
                form.submit();
            }
        }
    }
    
    // Escape key to close reply forms
    if (e.key === 'Escape') {
        const openForms = document.querySelectorAll('.reply-form[style*="display: block"]');
        openForms.forEach(form => {
            const commentId = form.id.replace('reply-form-', '');
            toggleReplyForm(commentId);
        });
    }
});

// Lazy loading for images (if any)
document.addEventListener('DOMContentLoaded', function() {
    if ('IntersectionObserver' in window) {
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
});

// Add scroll-to-top functionality
document.addEventListener('DOMContentLoaded', function() {
    // Create scroll to top button
    const scrollTopButton = document.createElement('button');
    scrollTopButton.innerHTML = '<i class="fas fa-arrow-up"></i>';
    scrollTopButton.className = 'btn btn-primary position-fixed';
    scrollTopButton.style.cssText = `
        bottom: 2rem;
        right: 2rem;
        z-index: 1000;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: none;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    `;
    scrollTopButton.setAttribute('aria-label', 'Scroll to top');
    document.body.appendChild(scrollTopButton);

    // Show/hide scroll to top button
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollTopButton.style.display = 'block';
        } else {
            scrollTopButton.style.display = 'none';
        }
    });

    // Scroll to top functionality
    scrollTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});

// Performance optimization: Debounce scroll events
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Add debounced scroll handler for better performance
const debouncedScrollHandler = debounce(function() {
    // Add any scroll-based animations or effects here
}, 100);

window.addEventListener('scroll', debouncedScrollHandler);
