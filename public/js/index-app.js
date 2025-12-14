/**
 * CFPIP - Modern Government Portal JavaScript
 * World-class functionality for Bangladesh Government Portal
 */

localStorage.setItem('cfpip-language', 'bn');

class ModernGovernmentPortal {
    constructor() {
        this.currentLanguage = 'bn';
        this.isLoaded = false;
        this.chartInstance = null;
        this.statsAnimated = false;
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.initializeLoader();
        this.initializeAnimations();
        this.setupLanguageSystem();
        this.initializeCharts();
        this.setupStatsCounters();
        this.setupMobileNavigation();
    }
    
    /* =========================================================================
       LOADING SYSTEM
       ========================================================================= */
    
    initializeLoader() {
        const loader = document.getElementById('loader');
        const body = document.body;
        
        if (!loader) return;
        
        // Simulate loading with progress
        const progressFill = loader.querySelector('.progress-fill');
        
        let progress = 0;
        const loadingInterval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress >= 100) {
                progress = 100;
                clearInterval(loadingInterval);
                
                // Hide loader after completion
                setTimeout(() => {
                    loader.style.opacity = '0';
                    setTimeout(() => {
                        loader.style.display = 'none';
                        body.classList.remove('loading');
                        this.isLoaded = true;
                        this.triggerPostLoadAnimations();
                    }, 500);
                }, 800);
            }
        }, 100);
    }
    
    triggerPostLoadAnimations() {
        // Initialize AOS animations
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-out-cubic',
                once: true,
                offset: 100
            });
        }
        
        // Trigger stats counter when visible
        this.observeStatsSection();
    }
    
    /* =========================================================================
       LANGUAGE SYSTEM
       ========================================================================= */
    
    setupLanguageSystem() {
        // Check for saved language preference, default to 'bn'
        const savedLanguage = localStorage.getItem('cfpip-language');
        if (savedLanguage && (savedLanguage === 'en' || savedLanguage === 'bn')) {
            this.currentLanguage = savedLanguage;
        } else {
            this.currentLanguage = 'bn'; // Default to Bengali
        }
        
        this.updateContent(); // Update all content to match current language
        this.updateLanguageDisplay();
        this.updateDirection(); // Set initial font without layout change
    }
    
    toggleLanguage() {
        this.currentLanguage = this.currentLanguage === 'en' ? 'bn' : 'en';
        this.updateContent();
        this.updateLanguageDisplay();
        this.updateDirection();
        
        // Store preference
        localStorage.setItem('cfpip-language', this.currentLanguage);
        
        // Announce change for screen readers
        this.announceLanguageChange();
    }
    
    updateContent() {
        const elements = document.querySelectorAll('[data-en][data-bn]');
        
        elements.forEach(element => {
            const content = element.dataset[this.currentLanguage];
            if (content) {
                if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                    element.placeholder = content;
                } else {
                    element.textContent = content;
                }
            }
        });
    }
    
    updateLanguageDisplay() {
        const langDisplay = document.getElementById('lang-display');
        if (langDisplay) {
            langDisplay.textContent = this.currentLanguage === 'en' ? 'বাংলা' : 'English';
        }
    }
    
    updateDirection() {
        // Bengali doesn't need RTL - just keep LTR layout with Bengali text
        document.documentElement.dir = 'ltr';
        document.body.className = this.currentLanguage === 'bn' ? 'bengali' : 'english';
    }
    
    announceLanguageChange() {
        const announcement = document.createElement('div');
        announcement.setAttribute('aria-live', 'polite');
        announcement.className = 'sr-only';
        announcement.textContent = this.currentLanguage === 'en' ? 
            'Language changed to English' : 'ভাষা বাংলায় পরিবর্তিত হয়েছে';
        document.body.appendChild(announcement);
        
        setTimeout(() => {
            if (document.body.contains(announcement)) {
                document.body.removeChild(announcement);
            }
        }, 1000);
    }
    
    /* =========================================================================
       MOBILE NAVIGATION
       ========================================================================= */
    
    setupMobileNavigation() {
        const mobileToggle = document.getElementById('mobile-toggle');
        const navMenu = document.getElementById('nav-menu');
        
        if (mobileToggle && navMenu) {
            mobileToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                mobileToggle.classList.toggle('active');
                
                // Update ARIA attributes
                const isExpanded = navMenu.classList.contains('active');
                mobileToggle.setAttribute('aria-expanded', isExpanded);
            });
            
            // Close mobile menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!mobileToggle.contains(e.target) && !navMenu.contains(e.target)) {
                    navMenu.classList.remove('active');
                    mobileToggle.classList.remove('active');
                    mobileToggle.setAttribute('aria-expanded', 'false');
                }
            });
            
            // Close mobile menu on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && navMenu.classList.contains('active')) {
                    navMenu.classList.remove('active');
                    mobileToggle.classList.remove('active');
                    mobileToggle.setAttribute('aria-expanded', 'false');
                    mobileToggle.focus();
                }
            });
        }
    }
    
    /* =========================================================================
       CHARTS AND VISUALIZATIONS
       ========================================================================= */
    
    initializeCharts() {
        this.createHeroChart();
    }
    
    createHeroChart() {
        const canvas = document.getElementById('heroChart');
        if (!canvas || typeof Chart === 'undefined') return;
        
        const ctx = canvas.getContext('2d');
        
        // Sample data for government insights
        const data = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Feedback Volume',
                data: [1200, 1900, 3000, 5000, 2000, 3000],
                borderColor: '#006747',
                backgroundColor: 'rgba(0, 103, 71, 0.1)',
                tension: 0.4,
                fill: true
            }]
        };
        
        const options = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    display: false
                },
                y: {
                    display: false
                }
            },
            elements: {
                point: {
                    radius: 3,
                    hoverRadius: 5
                }
            }
        };
        
        this.chartInstance = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });
    }
    
    /* =========================================================================
       STATISTICS COUNTERS
       ========================================================================= */
    
    setupStatsCounters() {
        // Populate stat counters from the API when possible, then observe for
        // intersection to animate. This replaces hardcoded values so empty
        // databases will show 0 instead of default large numbers.
        (async () => {
            try {
                const apiClient = new ApiClient();
                // request many items so we can compute derived metrics locally
                const resp = await apiClient.getFeedbacks({ per_page: 1000 });
                const data = resp.data || [];

                const total = resp.total || data.length || 0;
                const resolved = data.filter(f => (f.status || '').toLowerCase() === 'resolved').length;
                const aiToday = data.filter(f => f.ai_insight && f.ai_insight.created_at && (new Date(f.ai_insight.created_at)).toDateString() === (new Date()).toDateString()).length;

                // Update DOM elements which use data-count
                const statNodes = document.querySelectorAll('.live-stats .stat-item');
                statNodes.forEach(node => {
                    const label = (node.querySelector('.stat-label') || {}).textContent || '';
                    const numberEl = node.querySelector('.stat-number');
                    if (!numberEl) return;

                    if (label.toLowerCase().includes('active')) {
                        numberEl.dataset.count = total;
                    } else if (label.toLowerCase().includes('resolution')) {
                        numberEl.dataset.count = total === 0 ? 0 : Math.round((resolved / total) * 100);
                        // Keep percent sign in initial content
                        numberEl.textContent = '0%';
                    } else if (label.toLowerCase().includes('ai insights')) {
                        numberEl.dataset.count = aiToday;
                    }
                });
            } catch (e) {
                // ignore — we'll animate existing hardcoded counts as fallback
                console.warn('Could not load stats from API:', e.message || e);
            } finally {
                this.observeStatsSection();
            }
        })();
    }
    
    observeStatsSection() {
        const statNumbers = document.querySelectorAll('[data-count]');
        
        if (statNumbers.length === 0) return;
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !this.statsAnimated) {
                    this.animateStatCounters();
                    this.statsAnimated = true;
                }
            });
        }, { threshold: 0.5 });
        
        statNumbers.forEach(stat => observer.observe(stat));
    }
    
    animateStatCounters() {
        const statNumbers = document.querySelectorAll('[data-count]');
        
        statNumbers.forEach(stat => {
            const target = parseInt(stat.dataset.count);
            const isPercentage = stat.textContent.includes('%');
            const isLarge = target > 1000;
            
            this.animateCounter(stat, target, {
                duration: 2000,
                isPercentage,
                isLarge
            });
        });
    }
    
    animateCounter(element, target, options = {}) {
        const {
            duration = 2000,
            isPercentage = false,
            isLarge = false
        } = options;
        
        let current = 0;
        const increment = target / (duration / 16);
        
        const updateCounter = () => {
            current += increment;
            
            if (current >= target) {
                current = target;
            }
            
            let displayValue = Math.floor(current);
            
            if (isLarge && displayValue >= 1000) {
                if (displayValue >= 1000000) {
                    displayValue = (displayValue / 1000000).toFixed(1) + 'M';
                } else {
                    displayValue = (displayValue / 1000).toFixed(1) + 'K';
                }
            }
            
            element.textContent = displayValue + (isPercentage ? '%' : '');
            
            if (current < target) {
                requestAnimationFrame(updateCounter);
            }
        };
        
        updateCounter();
    }
    
    /* =========================================================================
       ANIMATIONS AND INTERACTIONS
       ========================================================================= */
    
    initializeAnimations() {
        this.setupScrollAnimations();
        this.setupHoverEffects();
        this.setupButtonRipples();
    }
    
    setupScrollAnimations() {
        // Navbar scroll effect
        const navbar = document.getElementById('main-nav');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar?.classList.add('scrolled');
            } else {
                navbar?.classList.remove('scrolled');
            }
        });
        
        // Parallax effect for hero background
        const heroSection = document.querySelector('.hero-section');
        const heroPattern = document.querySelector('.hero-pattern');
        
        if (heroSection && heroPattern) {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const speed = scrolled * 0.1;
                
                if (scrolled < heroSection.offsetHeight) {
                    heroPattern.style.transform = `translateY(${speed}px)`;
                }
            });
        }
    }
    
    setupHoverEffects() {
        // Enhanced card hover effects
        const cards = document.querySelectorAll('.capability-card, .kpi-card, .ministry-card');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                card.style.setProperty('--mouse-x', `${x}px`);
                card.style.setProperty('--mouse-y', `${y}px`);
            });
        });
        
        // Button hover enhancements
        const buttons = document.querySelectorAll('.btn-primary, .btn-secondary');
        
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.style.transform = 'translateY(-2px) scale(1.02)';
            });
            
            button.addEventListener('mouseleave', () => {
                button.style.transform = 'translateY(0) scale(1)';
            });
        });
    }
    
    setupButtonRipples() {
        const buttons = document.querySelectorAll('.btn-primary, .btn-secondary');
        
        buttons.forEach(button => {
            button.addEventListener('click', (e) => {
                this.createRipple(e, button);
            });
        });
    }
    
    createRipple(e, element) {
        const rect = element.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        const ripple = document.createElement('span');
        ripple.className = 'ripple-effect';
        ripple.style.left = `${x}px`;
        ripple.style.top = `${y}px`;
        
        element.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }
    
    /* =========================================================================
       ACCESSIBILITY FEATURES
       ========================================================================= */
    
    setupEventListeners() {
        // Keyboard navigation
        document.addEventListener('keydown', this.handleKeyboardNavigation.bind(this));
        
        // Focus management
        this.setupFocusManagement();
        
        // High contrast support
        this.setupHighContrastSupport();
        
        // Reduced motion support
        this.setupReducedMotionSupport();
    }
    
    handleKeyboardNavigation(e) {
        // Skip to main content
        if (e.key === 'Tab' && e.shiftKey && document.activeElement === document.body) {
            const skipLink = document.querySelector('.skip-to-main');
            if (skipLink) {
                skipLink.focus();
                e.preventDefault();
            }
        }
        
        // Language toggle with Alt + L
        if (e.altKey && e.key === 'l') {
            this.toggleLanguage();
            e.preventDefault();
        }
    }
    
    setupFocusManagement() {
        // Enhanced focus indicators
        const focusableElements = document.querySelectorAll(
            'a, button, input, textarea, select, [tabindex]:not([tabindex="-1"])'
        );
        
        focusableElements.forEach(element => {
            element.addEventListener('focus', (e) => {
                e.target.classList.add('focus-visible');
            });
            
            element.addEventListener('blur', (e) => {
                e.target.classList.remove('focus-visible');
            });
        });
    }
    
    setupHighContrastSupport() {
        // Detect high contrast preference
        const mediaQuery = window.matchMedia('(prefers-contrast: high)');
        
        const handleContrastChange = (e) => {
            document.body.classList.toggle('high-contrast', e.matches);
        };
        
        handleContrastChange(mediaQuery);
        mediaQuery.addListener(handleContrastChange);
    }
    
    setupReducedMotionSupport() {
        // Detect reduced motion preference
        const mediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
        
        const handleMotionChange = (e) => {
            document.body.classList.toggle('reduced-motion', e.matches);
            
            if (e.matches && this.chartInstance) {
                // Disable chart animations
                this.chartInstance.options.animation = false;
                this.chartInstance.update();
            }
        };
        
        handleMotionChange(mediaQuery);
        mediaQuery.addListener(handleMotionChange);
    }
    
    /* =========================================================================
       UTILITY FUNCTIONS
       ========================================================================= */
    
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-info-circle"></i>
                <span>${message}</span>
            </div>
            <button class="notification-close" aria-label="Close notification">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            notification.remove();
        }, 5000);
        
        // Close button functionality
        notification.querySelector('.notification-close').addEventListener('click', () => {
            notification.remove();
        });
    }
    
    formatNumber(num) {
        if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + 'M';
        }
        if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return num.toString();
    }
    
    debounce(func, wait) {
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
    
    /* =========================================================================
       PUBLIC API
       ========================================================================= */
    
    // Methods for external access
    getCurrentLanguage() {
        return this.currentLanguage;
    }
    
    setLanguage(lang) {
        if (lang === 'en' || lang === 'bn') {
            this.currentLanguage = lang;
            this.updateContent();
            this.updateLanguageDisplay();
            this.updateDirection();
        }
    }
    
    refreshStats() {
        this.statsAnimated = false;
        this.animateStatCounters();
    }
    
    showLoader() {
        const loader = document.getElementById('loader');
        if (loader) {
            loader.style.display = 'flex';
            loader.style.opacity = '1';
            document.body.classList.add('loading');
        }
    }
    
    hideLoader() {
        const loader = document.getElementById('loader');
        if (loader) {
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
                document.body.classList.remove('loading');
            }, 500);
        }
    }
}

/* =============================================================================
   INITIALIZATION
   ============================================================================= */

// Initialize the portal when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.CFPIPPortal = new ModernGovernmentPortal();
});

// Global functions for HTML onclick handlers
window.toggleLanguage = () => {
    if (window.CFPIPPortal) {
        window.CFPIPPortal.toggleLanguage();
    }
};

/* =============================================================================
   SERVICE WORKER REGISTRATION (for future PWA features)
   ============================================================================= */

if ('serviceWorker' in navigator) {
    window.addEventListener('load', async () => {
        try {
            // const registration = await navigator.serviceWorker.register('/sw.js');
            // console.log('SW registered: ', registration);
        } catch (registrationError) {
            console.log('SW registration failed: ', registrationError);
        }
    });
}

/* =============================================================================
   ADDITIONAL STYLES (for dynamic elements)
   ============================================================================= */

// Add dynamic styles for enhanced interactions
const dynamicStyles = document.createElement('style');
dynamicStyles.textContent = `
    .ripple-effect {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: translate(-50%, -50%);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: translate(-50%, -50%) scale(4);
            opacity: 0;
        }
    }
    
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-xl);
        border-left: 4px solid var(--primary);
        padding: var(--space-4);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: var(--space-3);
        z-index: 10000;
        transform: translateX(100%);
        animation: slideIn 0.3s ease-out forwards;
        max-width: 400px;
        min-width: 300px;
    }
    
    @keyframes slideIn {
        to { transform: translateX(0); }
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        color: var(--gray-800);
    }
    
    .notification-close {
        background: none;
        border: none;
        color: var(--gray-500);
        cursor: pointer;
        padding: var(--space-1);
        border-radius: var(--radius);
        transition: all var(--transition-fast);
    }
    
    .notification-close:hover {
        background: var(--gray-100);
        color: var(--gray-800);
    }
    
    .notification-success { border-left-color: var(--success); }
    .notification-warning { border-left-color: var(--warning); }
    .notification-error { border-left-color: var(--danger); }
    
    .focus-visible {
        outline: 2px solid var(--primary) !important;
        outline-offset: 2px !important;
    }
    
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }
    
    @media (prefers-reduced-motion: reduce) {
        .ripple-effect {
            display: none;
        }
        
        .notification {
            animation: none;
            transform: translateX(0);
        }
    }
    
    @media (max-width: 768px) {
        .notification {
            top: 10px;
            right: 10px;
            left: 10px;
            max-width: none;
            min-width: auto;
        }
    }
`;

document.head.appendChild(dynamicStyles);

/* =============================================================================
   EXPORT FOR MODULE SYSTEMS
   ============================================================================= */

if (typeof module !== 'undefined' && module.exports) {
    module.exports = ModernGovernmentPortal;
}