// Global Variables
let currentLanguage = 'en';
let currentCarouselIndex = 0;
let dashboardSidebarOpen = true;

let loginBtn = document.querySelector(".login-btn");

loginBtn.addEventListener('click', () => {
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    if(email && password){
        // Redirect if both fields are filled
        window.location.href = 'officer-dashboard';
    }
});

// DOM Content Loaded Event
document.addEventListener('DOMContentLoaded', function () {
    initializeApp();
});

// Initialize Application
function initializeApp() {
    // Restore saved language preference
    const savedLanguage = localStorage.getItem('preferredLanguage') || 'en';
    currentLanguage = savedLanguage;
    updateLanguage();

    // Mobile menu toggle
    initializeMobileMenu();

    // Language toggle
    initializeLanguageToggle();

    // Form validations
    initializeForms();

    // Dashboard functionality
    if (document.body.classList.contains('dashboard-body')) {
        initializeDashboard();
    }

    // Track page functionality
    if (window.location.pathname.includes('track.html')) {
        initializeTrackPage();
    }

    // Login page functionality
    if (document.body.classList.contains('login-body')) {
        initializeLoginPage();
    }

    // Carousel functionality
    initializeCarousel();

    // Stats animation
    animateStats();
}

// Mobile Menu Toggle
function initializeMobileMenu() {
    const mobileMenu = document.getElementById('mobile-toggle');
    const navMenu = document.querySelector('.nav-menu');

    if (mobileMenu && navMenu) {
        mobileMenu.addEventListener('click', function () {
            navMenu.classList.toggle('active');

            // Animate hamburger
            const bars = mobileMenu.querySelectorAll('span');
            bars.forEach((bar, index) => {
                if (navMenu.classList.contains('active')) {
                    if (index === 0) bar.style.transform = 'rotate(45deg) translate(6px, 6px)';
                    if (index === 1) bar.style.opacity = '0';
                    if (index === 2) bar.style.transform = 'rotate(-45deg) translate(6px, -6px)';
                } else {
                    bar.style.transform = '';
                    bar.style.opacity = '';
                }
            });
        });
    }
}

// Language Toggle Functionality
function initializeLanguageToggle() {
    const langButtons = document.querySelectorAll('.lang-switch, .lang-toggle');
    langButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            toggleLanguage();
        });
    });
}

function toggleLanguage() {
    currentLanguage = currentLanguage === 'en' ? 'bn' : 'en';
    updateLanguage();
}

// Make toggleLanguage globally accessible for onclick handlers
window.toggleLanguage = toggleLanguage;

function updateLanguage() {
    // Update all translatable elements first
    const translatableElements = document.querySelectorAll('[data-en][data-bn]');
    translatableElements.forEach(element => {
        const translation = currentLanguage === 'en' ? element.getAttribute('data-en') : element.getAttribute('data-bn');
        if (translation) {
            element.textContent = translation;
        }
    });

    // Update placeholders
    const placeholderElements = document.querySelectorAll('[data-placeholder-en][data-placeholder-bn]');
    placeholderElements.forEach(element => {
        const placeholder = currentLanguage === 'en' ?
            element.getAttribute('data-placeholder-en') :
            element.getAttribute('data-placeholder-bn');
        if (placeholder) {
            element.setAttribute('placeholder', placeholder);
        }
    });

    // Update document language (keep LTR direction for Bengali)
    document.documentElement.setAttribute('dir', 'ltr');
    document.documentElement.setAttribute('lang', currentLanguage === 'bn' ? 'bn' : 'en');

    // Update language display button specifically
    const langDisplay = document.getElementById('lang-display');
    if (langDisplay) {
        langDisplay.textContent = currentLanguage === 'en' ? 'বাংলা' : 'English';
    }

    // Save preference
    localStorage.setItem('preferredLanguage', currentLanguage);
}

// Form Initialization
function initializeForms() {
    // Feedback form
    const feedbackForm = document.getElementById('feedback-form');
    if (feedbackForm) {
        feedbackForm.addEventListener('submit', handleFeedbackSubmit);

        // File upload handling
        const fileInput = document.getElementById('attachment');
        if (fileInput) {
            fileInput.addEventListener('change', handleFileUpload);
        }

        // Anonymous checkbox
        const anonymousCheckbox = document.getElementById('anonymous');
        if (anonymousCheckbox) {
            anonymousCheckbox.addEventListener('change', toggleContactFields);
        }
    }

    // Track form
    const trackForm = document.getElementById('track-form');
    if (trackForm) {
        trackForm.addEventListener('submit', handleTrackSubmit);
    }

    // Login form
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', handleLogin);
    }
}

// Feedback Form Submission
function handleFeedbackSubmit(e) {
    e.preventDefault();

    // Validate form
    if (!validateFeedbackForm()) {
        return;
    }

    // Simulate form submission
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

    setTimeout(() => {
        // Generate tracking ID
        const trackingId = generateTrackingId();
        document.getElementById('generated-tracking-id').textContent = trackingId;

        // Show success modal
        showModal('success-modal');

        // Reset form
        e.target.reset();
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }, 2000);
}

function validateFeedbackForm() {
    const form = document.getElementById('feedback-form');
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            showFieldError(field, 'This field is required');
            isValid = false;
        } else {
            clearFieldError(field);
        }
    });

    // Email validation
    const email = form.querySelector('#email');
    if (email && email.value && !isValidEmail(email.value)) {
        showFieldError(email, 'Please enter a valid email address');
        isValid = false;
    }

    return isValid;
}

function showFieldError(field, message) {
    // Remove existing error
    clearFieldError(field);

    // Add error styling
    field.style.borderColor = '#D93025';

    // Add error message
    const errorElement = document.createElement('small');
    errorElement.className = 'field-error';
    errorElement.style.color = '#D93025';
    errorElement.textContent = message;

    field.parentNode.appendChild(errorElement);
}

function clearFieldError(field) {
    field.style.borderColor = '';
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// File Upload Handling
function handleFileUpload(e) {
    const files = e.target.files;
    const previewContainer = document.getElementById('file-preview');

    if (!previewContainer) return;

    previewContainer.innerHTML = '';

    Array.from(files).forEach((file, index) => {
        if (file.size > 10 * 1024 * 1024) { // 10MB limit
            alert(`File "${file.name}" is too large. Maximum size is 10MB.`);
            return;
        }

        const filePreview = document.createElement('div');
        filePreview.className = 'file-preview-item';
        filePreview.innerHTML = `
            <div class="file-info">
                <i class="fas fa-file"></i>
                <span class="file-name">${file.name}</span>
                <span class="file-size">(${formatFileSize(file.size)})</span>
                <button type="button" class="remove-file" onclick="removeFile(${index})">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        previewContainer.appendChild(filePreview);
    });
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function removeFile(index) {
    // This would remove the file from the input - simplified for demo
    console.log('Remove file at index:', index);
}

// Anonymous Checkbox Toggle
function toggleContactFields() {
    const anonymous = document.getElementById('anonymous');
    const contactFields = document.querySelectorAll('#name, #phone, #email');

    contactFields.forEach(field => {
        if (anonymous.checked) {
            field.disabled = true;
            field.value = '';
            field.style.opacity = '0.5';
        } else {
            field.disabled = false;
            field.style.opacity = '';
        }
    });
}

// Generate Tracking ID
function generateTrackingId() {
    const year = new Date().getFullYear();
    const randomNum = Math.floor(Math.random() * 99999).toString().padStart(5, '0');
    return `CFP-${year}-${randomNum}`;
}

// Modal Functions
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';

        // Add backdrop click to close
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                hideModal(modalId);
            }
        });
    }
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300); // Wait for animation
        document.body.style.overflow = '';
    }
}

function closeModal() {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.style.display = 'none';
    });
    document.body.style.overflow = '';
}

// Copy Tracking ID
function copyTrackingId() {
    const trackingId = document.getElementById('generated-tracking-id').textContent;
    navigator.clipboard.writeText(trackingId).then(() => {
        const copyBtn = document.querySelector('.copy-btn');
        const originalIcon = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check"></i>';
        copyBtn.style.color = '#0F9D58';

        setTimeout(() => {
            copyBtn.innerHTML = originalIcon;
            copyBtn.style.color = '';
        }, 2000);
    });
}

// Track Page Initialization
function initializeTrackPage() {
    // Sample data for tracking
    const sampleData = {
        'CFP-2025-00123': {
            id: 'CFP-2025-00123',
            title: 'Large potholes on main road causing traffic issues',
            category: 'Roads & Highways',
            location: 'Dhaka, Ward 15',
            department: 'Roads & Highways Division',
            date: 'January 15, 2025',
            status: 'action',
            description: 'There are several large potholes on the main road in Ward 15 that are causing difficulties for vehicles and pedestrians. The potholes have been there for over 2 months and are getting worse with each rain.',
            timeline: {
                received: { completed: true, date: 'January 15, 2025 - 10:30 AM' },
                review: { completed: true, date: 'January 16, 2025 - 2:15 PM' },
                action: { completed: false, active: true, date: 'In Progress' },
                resolved: { completed: false, active: false, date: 'Pending' }
            }
        },
        'CFP-2025-00124': {
            id: 'CFP-2025-00124',
            title: 'Water supply disruption in residential area',
            category: 'Water Supply',
            location: 'Chittagong, Ward 8',
            department: 'Water Supply Division',
            date: 'January 14, 2025',
            status: 'resolved',
            description: 'Water supply has been disrupted in our residential area for the past 3 days. Many families are facing difficulties.',
            timeline: {
                received: { completed: true, date: 'January 14, 2025 - 9:15 AM' },
                review: { completed: true, date: 'January 14, 2025 - 11:30 AM' },
                action: { completed: true, date: 'January 15, 2025 - 2:00 PM' },
                resolved: { completed: true, active: false, date: 'January 16, 2025 - 4:30 PM' }
            },
            response: {
                date: 'January 16, 2025',
                content: 'Dear Citizen,\n\nThank you for reporting the water supply issue. Our technical team has identified and fixed the main pipeline leak that was causing the disruption.\n\nWater supply has been restored to all affected areas. We apologize for the inconvenience caused.\n\nBest regards,\nWater Supply Division'
            }
        },
        'CFP-2025-00125': {
            id: 'CFP-2025-00125',
            title: 'Street lights not working in residential area',
            category: 'Electricity',
            location: 'Sylhet, Ward 3',
            department: 'Electricity Division',
            date: 'January 20, 2025',
            status: 'received',
            description: 'Multiple street lights in our residential area have not been working for over a week, creating safety concerns.',
            timeline: {
                received: { completed: true, date: 'January 20, 2025 - 3:45 PM' },
                review: { completed: false, active: true, date: 'In Review' },
                action: { completed: false, active: false, date: 'Pending' },
                resolved: { completed: false, active: false, date: 'Pending' }
            }
        }
    };

    window.sampleTrackingData = sampleData;
}

// Track Form Submission
function handleTrackSubmit(e) {
    e.preventDefault();

    const trackingId = document.getElementById('tracking-id').value.trim();

    if (!trackingId) {
        showError('Please enter a tracking ID');
        return;
    }

    // Validate format
    const trackingIdPattern = /^CFP-\d{4}-\d{5}$/;
    if (!trackingIdPattern.test(trackingId)) {
        showError('Please enter a valid tracking ID format (CFP-YYYY-XXXXX)');
        return;
    }

    searchFeedback(trackingId);
}

function searchFeedback(trackingId) {
    const resultsContainer = document.getElementById('track-results');
    const errorContainer = document.getElementById('error-message');

    // Hide previous results
    resultsContainer.style.display = 'none';
    errorContainer.style.display = 'none';

    // Show loading
    const searchBtn = document.querySelector('.search-btn');
    const originalText = searchBtn.innerHTML;
    searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
    searchBtn.disabled = true;

    setTimeout(() => {
        const data = window.sampleTrackingData && window.sampleTrackingData[trackingId];

        if (data) {
            displayTrackingResults(data);
            // Use CSS-defined grid layout for proper responsive design
            resultsContainer.style.display = 'grid';
        } else {
            // errorContainer.style.display = 'block';
            resultsContainer.style.display = 'grid';
        }

        searchBtn.innerHTML = originalText;
        searchBtn.disabled = false;
    }, 1500);
}

function displayTrackingResults(data) {
    // Update feedback details
    document.getElementById('feedback-id').textContent = data;
    document.getElementById('feedback-category').textContent = data.category;
    document.getElementById('feedback-date').textContent = data.date;
    document.getElementById('feedback-location').textContent = data.location;
    document.getElementById('feedback-department').textContent = data.department;
    document.getElementById('feedback-desc').textContent = data.description;
    document.getElementById('current-status').textContent = getStatusText(data.status);

    // Update timeline
    updateTimeline(data.timeline);

    // Show response if resolved
    if (data.response) {
        displayResponse(data.response);
    }

    // Show rating if resolved
    if (data.status === 'resolved') {
        document.getElementById('rating-card').style.display = 'block';
    }
}

function updateTimeline(timeline) {
    const steps = ['received', 'review', 'action', 'resolved'];

    steps.forEach(step => {
        const stepElement = document.getElementById(`step-${step}`);
        const stepData = timeline[step];

        if (!stepElement) return;

        stepElement.className = 'timeline-item';

        if (stepData.completed) {
            stepElement.classList.add('completed');
        } else if (stepData.active) {
            stepElement.classList.add('active');
        } else {
            stepElement.classList.add('pending');
        }

        const dateElement = stepElement.querySelector('.timeline-date');
        if (dateElement) {
            dateElement.textContent = stepData.date;
        }
    });
}

function getStatusText(status) {
    const statusMap = {
        'received': 'Received',
        'review': 'Under Review',
        'action': 'Action Taken',
        'resolved': 'Resolved'
    };
    return statusMap[status] || status;
}

function displayResponse(response) {
    const responseCard = document.getElementById('response-card');
    const responseDate = document.getElementById('response-date');
    const responseContent = document.getElementById('response-content');

    responseDate.textContent = response.date;
    responseContent.innerHTML = response.content.replace(/\n/g, '<br>');
    responseCard.style.display = 'block';
}

// Load Sample Data
function loadSample(trackingId) {
    document.getElementById('tracking-id').value = trackingId;
    searchFeedback(trackingId);
}

// Rating System
let currentRating = 0;

function rate(rating) {
    currentRating = rating;
    const stars = document.querySelectorAll('.star');

    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
}

// Print Details
function printDetails() {
    window.print();
}

// Dashboard Initialization
function initializeDashboard() {
    // Initialize section switching
    initializeSectionSwitching();

    // Initialize charts
    initializeCharts();

    // Update dashboard stats periodically
    setInterval(updateDashboardStats, 30000); // Update every 30 seconds
}

function initializeSectionSwitching() {
    const menuLinks = document.querySelectorAll('.menu-link');
    menuLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const sectionId = link.getAttribute('href').replace('#', '') + '-section';
            showSection(sectionId.replace('-section-section', '-section'));

            // Update active menu item
            document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));
            link.parentElement.classList.add('active');
        });
    });
}

function showSection(sectionName) {
    // Hide all sections
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });

    // Show target section
    const targetSection = document.getElementById(sectionName + '-section');
    if (targetSection) {
        targetSection.classList.add('active');
    }

    // Update menu active state
    document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));
    const menuItem = document.querySelector(`[onclick="showSection('${sectionName}')"]`);
    if (menuItem) {
        menuItem.closest('.menu-item').classList.add('active');
    }
}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    dashboardSidebarOpen = !dashboardSidebarOpen;

    if (dashboardSidebarOpen) {
        sidebar.style.marginLeft = '0';
    } else {
        sidebar.style.marginLeft = '-280px';
    }
}

// Charts Initialization (Simple Canvas Drawing)
function initializeCharts() {
    // Trend Chart
    const trendCanvas = document.getElementById('trendCanvas');
    if (trendCanvas) {
        drawTrendChart(trendCanvas);
    }

    // Category Chart
    const categoryCanvas = document.getElementById('categoryCanvas');
    if (categoryCanvas) {
        drawCategoryChart(categoryCanvas);
    }
}

function drawTrendChart(canvas) {
    const ctx = canvas.getContext('2d');
    const width = canvas.width;
    const height = canvas.height;

    // Clear canvas
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, width, height);

    // Sample data
    const data = [12, 18, 25, 15, 32, 28, 35, 42, 38, 45];
    const maxValue = Math.max(...data);

    // Draw axes
    ctx.strokeStyle = '#DADCE0';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(40, height - 40);
    ctx.lineTo(width - 20, height - 40);
    ctx.moveTo(40, height - 40);
    ctx.lineTo(40, 20);
    ctx.stroke();

    // Draw data line
    ctx.strokeStyle = '#006747';
    ctx.lineWidth = 3;
    ctx.beginPath();

    data.forEach((value, index) => {
        const x = 50 + (index * (width - 70) / (data.length - 1));
        const y = height - 50 - ((value / maxValue) * (height - 70));

        if (index === 0) {
            ctx.moveTo(x, y);
        } else {
            ctx.lineTo(x, y);
        }

        // Draw points
        ctx.fillStyle = '#006747';
        ctx.beginPath();
        ctx.arc(x, y, 4, 0, 2 * Math.PI);
        ctx.fill();
    });

    ctx.stroke();
}

function drawCategoryChart(canvas) {
    const ctx = canvas.getContext('2d');
    const centerX = canvas.width / 2;
    const centerY = canvas.height / 2;
    const radius = 100;

    // Clear canvas
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Sample data
    const categories = [
        { name: 'Roads', value: 35, color: '#1976D2' },
        { name: 'Water', value: 25, color: '#00796B' },
        { name: 'Electricity', value: 20, color: '#F57C00' },
        { name: 'Environment', value: 15, color: '#388E3C' },
        { name: 'Other', value: 5, color: '#7B1FA2' }
    ];

    let currentAngle = -Math.PI / 2;

    categories.forEach(category => {
        const sliceAngle = (category.value / 100) * 2 * Math.PI;

        // Draw slice
        ctx.fillStyle = category.color;
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.arc(centerX, centerY, radius, currentAngle, currentAngle + sliceAngle);
        ctx.closePath();
        ctx.fill();

        // Add labels
        const labelAngle = currentAngle + sliceAngle / 2;
        const labelX = centerX + Math.cos(labelAngle) * (radius + 20);
        const labelY = centerY + Math.sin(labelAngle) * (radius + 20);

        ctx.fillStyle = '#202124';
        ctx.font = '12px Poppins';
        ctx.textAlign = 'center';
        ctx.fillText(`${category.name}`, labelX, labelY);
        ctx.fillText(`${category.value}%`, labelX, labelY + 15);

        currentAngle += sliceAngle;
    });
}

// Dashboard Actions
function refreshDashboard() {
    const refreshBtn = document.querySelector('.refresh-btn');
    const originalIcon = refreshBtn.innerHTML;

    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    refreshBtn.disabled = true;

    setTimeout(() => {
        updateDashboardStats();
        refreshBtn.innerHTML = originalIcon;
        refreshBtn.disabled = false;

        // Show success message
        showToast('Dashboard refreshed successfully!');
    }, 2000);
}

function updateDashboardStats() {
    // Animate numbers
    const stats = [
        { element: 'total-feedback', target: Math.floor(Math.random() * 1000) + 12000 },
        { element: 'resolved-issues', target: Math.floor(Math.random() * 1000) + 8000 },
        { element: 'active-depts', target: 24 },
        { element: 'satisfaction', target: Math.floor(Math.random() * 10) + 85 }
    ];

    stats.forEach(stat => {
        const element = document.getElementById(stat.element);
        if (element) {
            const suffix = stat.element === 'satisfaction' ? '%' : '';
            animateNumber(element, stat.target, suffix);
        }
    });
}

function animateNumber(element, target, suffix = '') {
    const current = parseInt(element.textContent.replace(/[^0-9]/g, '')) || 0;
    const increment = (target - current) / 20;
    let currentValue = current;

    const timer = setInterval(() => {
        currentValue += increment;
        if ((increment > 0 && currentValue >= target) || (increment < 0 && currentValue <= target)) {
            currentValue = target;
            clearInterval(timer);
        }
        element.textContent = Math.floor(currentValue).toLocaleString() + suffix;
    }, 100);
}

// Feedback Management
function viewFeedbackDetails(feedbackId) {
    // Populate modal with feedback data
    document.getElementById('detail-id').textContent = feedbackId;

    // Show modal
    showModal('feedback-detail-modal');
}

function closeFeedbackModal() {
    hideModal('feedback-detail-modal');
}

function updateStatus(feedbackId) {
    console.log('Update status for:', feedbackId);
    // Implementation for status update
}

function selectAll() {
    const checkboxes = document.querySelectorAll('.feedback-table tbody input[type="checkbox"]');
    const selectAllCheckbox = document.querySelector('.feedback-table thead input[type="checkbox"]');

    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
}

function generateReport() {
    showToast('Generating report...');

    setTimeout(() => {
        showToast('Report generated successfully!');
        // In a real app, this would download a file
    }, 2000);
}

function bulkUpdate() {
    const selectedCheckboxes = document.querySelectorAll('.feedback-table tbody input[type="checkbox"]:checked');

    if (selectedCheckboxes.length === 0) {
        showToast('Please select at least one feedback item.');
        return;
    }

    showToast(`Bulk update applied to ${selectedCheckboxes.length} items.`);
}

// AI Functions for Dashboard
function useAISuggestion() {
    const suggestionText = document.querySelector('.suggested-response').textContent;
    document.getElementById('officer-response').value = suggestionText;
    showToast('AI suggestion applied to your response.');
}

function sendResponse() {
    const responseText = document.getElementById('officer-response').value;

    if (!responseText.trim()) {
        showToast('Please enter a response before sending.');
        return;
    }

    showToast('Response sent successfully!');
    closeFeedbackModal();
}

function updateFeedbackStatus() {
    const newStatus = document.querySelector('.status-select').value;
    showToast(`Status updated to: ${newStatus}`);
}

// Login Page Functionality
function initializeLoginPage() {
    // Password toggle
    const passwordToggle = document.querySelector('.password-toggle');
    if (passwordToggle) {
        passwordToggle.addEventListener('click', togglePasswordVisibility);
    }

    // Remember credentials
    loadRememberedCredentials();
}

function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('password-eye');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

function togglePasswordVisibility() {
    togglePassword();
}

function fillDemoCredentials(type) {
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');

    if (type === 'officer') {
        emailField.value = 'officer@cfpip.gov.bd';
        passwordField.value = 'password123';
    } else if (type === 'admin') {
        emailField.value = 'admin@cfpip.gov.bd';
        passwordField.value = 'admin456';
    }
}

function handleLogin(e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const remember = document.getElementById('remember').checked;

    if (!email || !password) {
        showError('Please enter both email and password.');
        return;
    }

    // Show loading
    const loginBtn = document.querySelector('.login-btn');

    const loader = document.getElementById('login-loader');
    const btnText = loginBtn.querySelector('span');

    loginBtn.disabled = true;
    loader.style.display = 'block';
    btnText.style.opacity = '0';

    // Simulate login
    setTimeout(() => {
        // Check credentials (demo)
        const validCredentials = [
            { email: 'officer@cfpip.gov.bd', password: 'password123' },
            { email: 'admin@cfpip.gov.bd', password: 'admin456' }
        ];

        let isValid = (email, password) => {
            return validCredentials.some(user =>
                user.email === email && user.password === password
            );
        }

        // const isValid = validCredentials.some(cred => 
        //     cred.email === email && cred.password === password
        // );

        if (isValid) {
            // Save credentials if remember is checked
            try {
                if (remember) {
                    localStorage.setItem('rememberedEmail', email);
                } else {
                    localStorage.removeItem('rememberedEmail');
                }
            }
            catch (e) {
                console.error('Error accessing localStorage:', e);
            }

            // Show success modal
            showModal('success-modal');

            // Redirect after animation
            setTimeout(() => {
                window.location.href = '/officer-dashboard';
            }, 3000);
        } else {
            window.location.href = '/officer-dashboard';
            // Show error modal
            showModal('error-modal');

            loginBtn.disabled = false;
            loader.style.display = 'none';
            btnText.style.opacity = '';
        }
    }, 2000);
}

function loadRememberedCredentials() {
    const rememberedEmail = localStorage.getItem('rememberedEmail');
    if (rememberedEmail) {
        document.getElementById('email').value = rememberedEmail;
        document.getElementById('remember').checked = true;
    }
}

// Dashboard Logout Function
function logout() {
    // Show confirmation
    if (confirm('Are you sure you want to logout?')) {
        // Show loading toast
        showToast('Logging out...');

        // Clear any stored data
        localStorage.removeItem('currentUser');
        sessionStorage.clear();

        // Redirect after a short delay
        setTimeout(() => {
            window.location.href = 'index.html';
        }, 1500);
    }
}

// Toast Notification System
function showToast(message, type = 'info') {
    // Remove existing toasts
    const existingToasts = document.querySelectorAll('.toast');
    existingToasts.forEach(toast => toast.remove());

    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <i class="fas ${getToastIcon(type)}"></i>
            <span>${message}</span>
        </div>
        <button class="toast-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;

    // Add styles
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10001;
        background: white;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border-left: 4px solid ${getToastColor(type)};
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        min-width: 300px;
        max-width: 400px;
        animation: slideIn 0.3s ease-out;
        font-family: 'Inter', sans-serif;
    `;

    // Add to document
    document.body.appendChild(toast);

    // Auto remove after 3 seconds
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease-in';
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 300);
    }, 3000);
}

function getToastIcon(type) {
    switch (type) {
        case 'success': return 'fa-check-circle';
        case 'error': return 'fa-exclamation-circle';
        case 'warning': return 'fa-exclamation-triangle';
        default: return 'fa-info-circle';
    }
}

function getToastColor(type) {
    switch (type) {
        case 'success': return '#16a34a';
        case 'error': return '#dc2626';
        case 'warning': return '#d97706';
        default: return '#006747';
    }
}

// Add required CSS animations to head
if (!document.querySelector('#toast-animations')) {
    const style = document.createElement('style');
    style.id = 'toast-animations';
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        .toast-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #374151;
            font-weight: 500;
        }
        
        .toast-close {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        
        .toast-close:hover {
            background: #f3f4f6;
            color: #6b7280;
        }
    `;
    document.head.appendChild(style);
}

function closeErrorModal() {
    hideModal('error-modal');
}

function showError(message) {
    const errorMessageElement = document.getElementById('error-message');
    if (errorMessageElement) {
        errorMessageElement.textContent = message;
    }
    showModal('error-modal');
}

function logout() {
    if (confirm('Are you sure you want to logout?')) {
        localStorage.removeItem('userSession');
        window.location.href = 'index.html';
    }
}

// Carousel Functionality
function initializeCarousel() {
    const carousel = document.querySelector('.insights-carousel');
    if (!carousel) return;

    const cards = carousel.children;
    const totalCards = cards.length;

    // Auto-advance carousel
    setInterval(() => {
        moveCarousel(1);
    }, 5000);
}

function moveCarousel(direction) {
    const carousel = document.querySelector('.insights-carousel');
    if (!carousel) return;

    const cards = carousel.children;
    const totalCards = cards.length;

    currentCarouselIndex += direction;

    if (currentCarouselIndex >= totalCards) {
        currentCarouselIndex = 0;
    } else if (currentCarouselIndex < 0) {
        currentCarouselIndex = totalCards - 1;
    }

    // Apply transform
    const cardWidth = cards[0].offsetWidth + 32; // Including gap
    carousel.style.transform = `translateX(-${currentCarouselIndex * cardWidth}px)`;
}

// Stats Animation on Scroll
function animateStats() {
    const stats = document.querySelectorAll('.stat-number');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = parseInt(entry.target.textContent.replace(/[^0-9]/g, ''));
                const suffix = entry.target.textContent.includes('%') ? '%' : '';
                animateNumber(entry.target, target, suffix);
                observer.unobserve(entry.target);
            }
        });
    });

    stats.forEach(stat => observer.observe(stat));
}

// Toast Notifications
function showToast(message, type = 'info') {
    // Remove existing toasts
    const existingToasts = document.querySelectorAll('.toast');
    existingToasts.forEach(toast => toast.remove());

    // Create toast
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <i class="fas fa-info-circle"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; color: inherit; margin-left: auto; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>
    `;

    // Style toast
    Object.assign(toast.style, {
        position: 'fixed',
        top: '20px',
        right: '20px',
        backgroundColor: type === 'error' ? '#D93025' : type === 'success' ? '#0F9D58' : '#1A73E8',
        color: 'white',
        padding: '1rem 1.5rem',
        borderRadius: '8px',
        display: 'flex',
        alignItems: 'center',
        gap: '0.5rem',
        boxShadow: '0 4px 6px rgba(0, 0, 0, 0.1)',
        zIndex: '3000',
        maxWidth: '400px',
        animation: 'slideInRight 0.3s ease'
    });

    document.body.appendChild(toast);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (toast.parentElement) {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
}

// Add animation keyframes
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Utility Functions
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

function throttle(func, limit) {
    let inThrottle;
    return function () {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// Error Handling
window.addEventListener('error', function (e) {
    console.error('JavaScript Error:', e.error);
    // showToast('An unexpected error occurred. Please refresh the page.', 'error');
});

// Accessibility Enhancements
document.addEventListener('keydown', function (e) {
    // ESC key to close modals
    if (e.key === 'Escape') {
        closeModal();
    }

    // Tab key navigation for modals
    if (e.key === 'Tab') {
        const openModal = document.querySelector('.modal[style*="flex"]');
        if (openModal) {
            const focusableElements = openModal.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );

            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];

            if (e.shiftKey) {
                if (document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                }
            } else {
                if (document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        }
    }
});

// Performance Monitoring
const performanceObserver = new PerformanceObserver((list) => {
    list.getEntries().forEach((entry) => {
        if (entry.entryType === 'navigation') {
            console.log('Page Load Time:', entry.loadEventEnd - entry.loadEventStart, 'ms');
        }
    });
});

performanceObserver.observe({ entryTypes: ['navigation'] });

// Service Worker Registration (for future PWA features)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then((registration) => {
                console.log('SW registered: ', registration);
            })
            .catch((registrationError) => {
                console.log('SW registration failed: ', registrationError);
            });
    });
}

// AMAZING BUTTON RIPPLE EFFECTS
function addRippleEffect() {
    document.querySelectorAll('.btn-3d').forEach(button => {
        button.addEventListener('click', function (e) {
            const ripple = this.querySelector('.btn-ripple');
            if (ripple) {
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                // Reset ripple
                ripple.style.width = '0';
                ripple.style.height = '0';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';

                // Animate ripple
                requestAnimationFrame(() => {
                    ripple.style.width = size * 2 + 'px';
                    ripple.style.height = size * 2 + 'px';
                });

                // Remove ripple after animation
                setTimeout(() => {
                    ripple.style.width = '0';
                    ripple.style.height = '0';
                }, 600);
            }
        });
    });
}

// ANIMATED TITLE WORDS
function initAnimatedTitle() {
    const titles = document.querySelectorAll('.animated-title');
    titles.forEach(title => {
        const text = title.textContent.trim();
        const words = text.split(' ');
        title.innerHTML = words.map(word => `<span class="word">${word}</span>`).join(' ');
    });
}

// COUNTER ANIMATION
function animateCounters() {
    const counters = document.querySelectorAll('.counter');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.dataset.target) || 0;
                const isPercentage = counter.textContent.includes('%');

                let current = 0;
                const increment = target / 50;
                const duration = 2000;
                const step = duration / 50;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }

                    const displayValue = Math.round(current);
                    counter.textContent = isPercentage ?
                        displayValue + '%' :
                        displayValue.toLocaleString();
                }, step);

                observer.unobserve(counter);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => observer.observe(counter));
}

// FLOATING ANIMATIONS
function initFloatingAnimations() {
    // Add staggered delays to floating elements
    document.querySelectorAll('.floating').forEach((element, index) => {
        element.style.animationDelay = (index * 0.2) + 's';
    });
}

// PARTICLE SPARKLES
function createSparkles() {
    const sparkleContainers = document.querySelectorAll('.stat-card');

    sparkleContainers.forEach(container => {
        if (!container.querySelector('.sparkle-container')) {
            const sparkleContainer = document.createElement('div');
            sparkleContainer.className = 'sparkle-container';
            sparkleContainer.style.cssText = `
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                pointer-events: none;
                overflow: hidden;
            `;

            for (let i = 0; i < 5; i++) {
                const sparkle = document.createElement('div');
                sparkle.className = 'dynamic-sparkle';
                sparkle.style.cssText = `
                    position: absolute;
                    width: 4px;
                    height: 4px;
                    background: radial-gradient(circle, #fff, transparent);
                    border-radius: 50%;
                    opacity: 0;
                    animation: sparkleFloat ${2 + Math.random() * 3}s ease-in-out infinite;
                    animation-delay: ${Math.random() * 2}s;
                    left: ${Math.random() * 100}%;
                    top: ${Math.random() * 100}%;
                `;
                sparkleContainer.appendChild(sparkle);
            }

            container.appendChild(sparkleContainer);
        }
    });
}

// Add sparkle animation CSS
if (!document.getElementById('sparkle-styles')) {
    const style = document.createElement('style');
    style.id = 'sparkle-styles';
    style.textContent = `
        @keyframes sparkleFloat {
            0%, 100% { opacity: 0; transform: translateY(0) scale(0); }
            50% { opacity: 1; transform: translateY(-20px) scale(1); }
        }
    `;
    document.head.appendChild(style);
}

// ENHANCED SCROLL EFFECTS
function initScrollEffects() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    // Observe all major sections
    document.querySelectorAll('.hero, .stats, .insights, .about, .footer').forEach(section => {
        observer.observe(section);
    });
}

// DYNAMIC BACKGROUND EFFECTS
function initDynamicBackgrounds() {
    // Add moving gradient to hero
    const hero = document.querySelector('.hero');
    if (hero) {
        let gradientAngle = 0;
        setInterval(() => {
            gradientAngle += 1;
            hero.style.background = `linear-gradient(${gradientAngle}deg, rgba(0, 103, 71, 0.03), rgba(228, 30, 38, 0.03))`;
        }, 100);
    }
}

// Initialize all amazing effects when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Add ripple effects to buttons
    addRippleEffect();

    // Initialize animated titles
    initAnimatedTitle();

    // Initialize counters
    animateCounters();

    // Initialize floating animations
    initFloatingAnimations();

    // Create sparkles
    createSparkles();

    // Initialize scroll effects
    initScrollEffects();

    // Initialize dynamic backgrounds
    initDynamicBackgrounds();

    console.log('🎉 Amazing effects initialized!');
});

// Export functions for global access
window.toggleLanguage = toggleLanguage;
window.showSection = showSection;
window.toggleSidebar = toggleSidebar;
window.moveCarousel = moveCarousel;
window.loadSample = loadSample;
window.rate = rate;
window.printDetails = printDetails;
window.copyTrackingId = copyTrackingId;
window.closeModal = closeModal;
window.togglePassword = togglePassword;
window.fillDemoCredentials = fillDemoCredentials;
window.closeErrorModal = closeErrorModal;
window.refreshDashboard = refreshDashboard;
window.viewFeedbackDetails = viewFeedbackDetails;
window.closeFeedbackModal = closeFeedbackModal;
window.updateStatus = updateStatus;
window.selectAll = selectAll;
window.generateReport = generateReport;
window.bulkUpdate = bulkUpdate;
window.useAISuggestion = useAISuggestion;
window.sendResponse = sendResponse;
window.updateFeedbackStatus = updateFeedbackStatus;
window.logout = logout;
