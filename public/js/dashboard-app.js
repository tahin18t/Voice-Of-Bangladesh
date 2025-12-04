// Dashboard Application JavaScript
class DashboardApp {
    constructor() {
        this.currentLanguage = 'bn';
        this.currentSection = 'dashboard';
        this.notifications = [];
        this.feedbackData = [];
        this.charts = {};
        
        this.init();
    }

    init() {
        this.initializeLoading();
        this.setupEventListeners();
        this.initializeCharts();
        this.loadDashboardData();
        this.animateKPIValues();
        
        // Set initial language
        this.updateLanguage();
        
        console.log('🏛️ Officer Dashboard initialized successfully');
    }

    initializeLoading() {
        const loader = document.getElementById('loader');
        const loadingText = document.querySelector('.loading-text');
        
        const loadingSteps = [
            { text: { en: 'Initializing intelligent workflow system...', bn: 'বুদ্ধিমান ওয়ার্কফ্লো সিস্টেম চালু হচ্ছে...' } },
            { text: { en: 'Loading AI analytics engine...', bn: 'AI অ্যানালিটিক্স ইঞ্জিন লোড হচ্ছে...' } },
            { text: { en: 'Connecting to government database...', bn: 'সরকারি ডাটাবেসে সংযোগ হচ্ছে...' } },
            { text: { en: 'Preparing dashboard interface...', bn: 'ড্যাশবোর্ড ইন্টারফেস প্রস্তুত হচ্ছে...' } },
            { text: { en: 'Ready for secure operation!', bn: 'নিরাপদ পরিচালনার জন্য প্রস্তুত!' } }
        ];

        let currentStep = 0;
        const stepInterval = setInterval(() => {
            if (currentStep < loadingSteps.length) {
                const step = loadingSteps[currentStep];
                loadingText.textContent = step.text[this.currentLanguage];
                loadingText.setAttribute('data-en', step.text.en);
                loadingText.setAttribute('data-bn', step.text.bn);
                currentStep++;
            } else {
                clearInterval(stepInterval);
                setTimeout(() => {
                    loader.classList.add('hidden');
                    document.body.classList.remove('no-scroll');
                }, 500);
            }
        }, 600);
    }

    setupEventListeners() {
        // Sidebar toggle
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
        const sidebar = document.getElementById('sidebar');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
            });
        }

        if (mobileSidebarToggle) {
            mobileSidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('mobile-open');
            });
        }

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !mobileSidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('mobile-open');
                }
            }
        });

        // Notification dropdown
        document.addEventListener('click', (e) => {
            const notificationDropdown = document.getElementById('notification-dropdown');
            const notificationBtn = document.querySelector('.notification-btn');
            
            if (!notificationBtn.contains(e.target)) {
                notificationDropdown.classList.remove('show');
            }
        });

        // Chart timeframe changes
        const volumeTimeframe = document.getElementById('volume-timeframe');
        if (volumeTimeframe) {
            volumeTimeframe.addEventListener('change', () => {
                this.updateVolumeChart(volumeTimeframe.value);
            });
        }

        // Real-time updates
        this.startRealTimeUpdates();
    }

    initializeCharts() {
        // Volume Trend Chart
        const volumeCtx = document.getElementById('volumeTrendChart');
        if (volumeCtx) {
            this.charts.volumeChart = new Chart(volumeCtx, {
                type: 'line',
                data: {
                    labels: ['Dec 1', 'Dec 2', 'Dec 3', 'Dec 4', 'Dec 5', 'Dec 6', 'Dec 7'],
                    datasets: [{
                        label: 'Feedback Volume',
                        data: [45, 52, 38, 65, 59, 80, 67],
                        borderColor: '#4299e1',
                        backgroundColor: 'rgba(66, 153, 225, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#4299e1',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#718096'
                            }
                        },
                        y: {
                            grid: {
                                borderDash: [5, 5],
                                color: 'rgba(113, 128, 150, 0.2)'
                            },
                            ticks: {
                                color: '#718096'
                            }
                        }
                    }
                }
            });
        }

        // Category Distribution Chart
        const categoryCtx = document.getElementById('categoryChart');
        if (categoryCtx) {
            this.charts.categoryChart = new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Roads & Highways', 'Water & Sanitation', 'Health Services', 'Education', 'Others'],
                    datasets: [{
                        data: [35, 25, 20, 12, 8],
                        backgroundColor: [
                            '#4299e1',
                            '#48bb78',
                            '#ed8936',
                            '#805ad5',
                            '#f56565'
                        ],
                        borderWidth: 0,
                        hoverBorderWidth: 3,
                        hoverBorderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                color: '#4a5568'
                            }
                        }
                    }
                }
            });
        }
    }

    loadDashboardData() {
        // Simulate loading feedback data
        this.feedbackData = [
            {
                id: 'CFPIP-2024-001234',
                title: 'Road damage complaint from rural area',
                category: 'Roads & Highways',
                priority: 'High',
                status: 'Pending',
                location: 'Chittagong, Bangladesh',
                date: '2024-12-07 10:30 AM',
                description: 'The main road connecting our village to the district headquarters has developed multiple large potholes making it dangerous for vehicles and pedestrians.',
                aiAnalysis: {
                    confidence: 96,
                    urgencyScore: 8.5,
                    suggestedAction: 'Site inspection within 48 hours'
                }
            },
            {
                id: 'CFPIP-2024-001235',
                title: 'Water supply disruption in urban area',
                category: 'Water & Sanitation',
                priority: 'Medium',
                status: 'In Progress',
                location: 'Dhaka, Bangladesh',
                date: '2024-12-07 09:15 AM',
                description: 'Water supply has been disrupted in our residential area for the past 3 days.',
                aiAnalysis: {
                    confidence: 92,
                    urgencyScore: 7.2,
                    suggestedAction: 'Contact water department immediately'
                }
            }
        ];

        this.populateFeedbacksTable();
    }

    animateKPIValues() {
        const kpiValues = document.querySelectorAll('.kpi-value[data-count]');
        
        kpiValues.forEach(element => {
            const targetValue = parseInt(element.getAttribute('data-count'));
            let currentValue = 0;
            const increment = targetValue / 60; // Animate over ~1 second
            
            const animation = setInterval(() => {
                currentValue += increment;
                if (currentValue >= targetValue) {
                    currentValue = targetValue;
                    clearInterval(animation);
                }
                
                if (element.textContent.includes('%')) {
                    element.textContent = Math.round(currentValue) + '%';
                } else {
                    element.textContent = Math.round(currentValue);
                }
            }, 16);
        });
    }

    populateFeedbacksTable() {
        const tbody = document.getElementById('feedbacks-table-body');
        if (!tbody) return;

        tbody.innerHTML = '';
        
        // Generate more sample data for demo
        const sampleFeedbacks = [
            ...this.feedbackData,
            {
                id: 'CFPIP-2024-001236',
                title: 'Healthcare facility improvement needed',
                category: 'Health Services',
                priority: 'Medium',
                status: 'Pending',
                location: 'Sylhet, Bangladesh',
                date: '2024-12-06 14:20 PM'
            },
            {
                id: 'CFPIP-2024-001237',
                title: 'School infrastructure concerns',
                category: 'Education',
                priority: 'Low',
                status: 'Resolved',
                location: 'Rangpur, Bangladesh',
                date: '2024-12-05 11:45 AM'
            }
        ];

        sampleFeedbacks.forEach(feedback => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><input type="checkbox" name="feedback-select" value="${feedback.id}"></td>
                <td><strong>${feedback.id}</strong></td>
                <td>${feedback.title}</td>
                <td>${feedback.category}</td>
                <td><span class="priority-badge ${feedback.priority.toLowerCase()}">${feedback.priority}</span></td>
                <td><span class="status-badge ${feedback.status.toLowerCase().replace(' ', '-')}">${feedback.status}</span></td>
                <td>${feedback.location}</td>
                <td>${feedback.date}</td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <button class="btn btn-sm btn-primary" onclick="dashboardApp.viewFeedback('${feedback.id}')">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-secondary" onclick="dashboardApp.assignFeedback('${feedback.id}')">
                            <i class="fas fa-user-plus"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    startRealTimeUpdates() {
        // Simulate real-time updates
        setInterval(() => {
            this.updateNotificationCount();
            this.updateLastActivity();
        }, 30000); // Update every 30 seconds
    }

    updateNotificationCount() {
        const count = document.querySelector('.notification-count');
        if (count) {
            const currentCount = parseInt(count.textContent);
            if (Math.random() > 0.7) { // 30% chance of new notification
                count.textContent = currentCount + 1;
            }
        }
    }

    updateLastActivity() {
        // Update timestamps in activity timeline
        const timeElements = document.querySelectorAll('.activity-item small');
        timeElements.forEach(element => {
            const text = element.textContent;
            if (text.includes('minutes ago')) {
                const minutes = parseInt(text.match(/\d+/)[0]) + 1;
                element.textContent = `${minutes} minutes ago`;
            }
        });
    }

    updateVolumeChart(timeframe) {
        if (!this.charts.volumeChart) return;

        let labels, data;
        switch (timeframe) {
            case '7d':
                labels = ['Dec 1', 'Dec 2', 'Dec 3', 'Dec 4', 'Dec 5', 'Dec 6', 'Dec 7'];
                data = [45, 52, 38, 65, 59, 80, 67];
                break;
            case '30d':
                labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                data = [280, 320, 290, 380];
                break;
            case '3m':
                labels = ['October', 'November', 'December'];
                data = [1200, 1350, 890];
                break;
        }

        this.charts.volumeChart.data.labels = labels;
        this.charts.volumeChart.data.datasets[0].data = data;
        this.charts.volumeChart.update('active');
    }

    // Navigation functions
    showDashboardSection(sectionId) {
        // Hide all sections
        document.querySelectorAll('.dashboard-section').forEach(section => {
            section.classList.remove('active');
        });

        // Show selected section
        const targetSection = document.getElementById(`${sectionId}-section`);
        if (targetSection) {
            targetSection.classList.add('active');
        }

        // Update navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
        });
        
        const activeLink = document.querySelector(`[onclick="showDashboardSection('${sectionId}')"]`);
        if (activeLink) {
            activeLink.classList.add('active');
        }

        // Update page title
        this.updatePageTitle(sectionId);
        this.currentSection = sectionId;
    }

    updatePageTitle(sectionId) {
        const titles = {
            dashboard: { en: 'Dashboard Overview', bn: 'ড্যাশবোর্ড ওভারভিউ' },
            feedbacks: { en: 'Feedback Management', bn: 'মতামত ব্যবস্থাপনা' },
            'ai-insights': { en: 'AI Intelligence Center', bn: 'AI ইন্টেলিজেন্স সেন্টার' },
            analytics: { en: 'Advanced Analytics', bn: 'উন্নত বিশ্লেষণ' },
            workflow: { en: 'Workflow Management', bn: 'কর্মপ্রবাহ ব্যবস্থাপনা' },
            reports: { en: 'Reports & Documentation', bn: 'প্রতিবেদন ও ডকুমেন্টেশন' },
            settings: { en: 'Dashboard Settings', bn: 'ড্যাশবোর্ড সেটিংস' }
        };

        const subtitles = {
            dashboard: { en: 'AI-powered insights and workflow management', bn: 'AI-চালিত অন্তর্দৃষ্টি এবং ওয়ার্কফ্লো ব্যবস্থাপনা' },
            feedbacks: { en: 'Manage and respond to citizen feedback', bn: 'নাগরিক মতামত পরিচালনা এবং প্রতিক্রিয়া' },
            'ai-insights': { en: 'Intelligent analysis and recommendations', bn: 'বুদ্ধিমত্তা বিশ্লেষণ এবং সুপারিশ' },
            analytics: { en: 'Data-driven performance insights', bn: 'ডেটা-চালিত কর্মক্ষমতা অন্তর্দৃষ্টি' },
            workflow: { en: 'Automated process management', bn: 'স্বয়ংক্রিয় প্রক্রিয়া ব্যবস্থাপনা' },
            reports: { en: 'Generate comprehensive reports', bn: 'ব্যাপক প্রতিবেদন তৈরি করুন' },
            settings: { en: 'Customize your dashboard experience', bn: 'আপনার ড্যাশবোর্ড অভিজ্ঞতা কাস্টমাইজ করুন' }
        };

        const titleElement = document.getElementById('current-page-title');
        const subtitleElement = document.getElementById('current-page-subtitle');

        if (titleElement && titles[sectionId]) {
            titleElement.textContent = titles[sectionId][this.currentLanguage];
            titleElement.setAttribute('data-en', titles[sectionId].en);
            titleElement.setAttribute('data-bn', titles[sectionId].bn);
        }

        if (subtitleElement && subtitles[sectionId]) {
            subtitleElement.textContent = subtitles[sectionId][this.currentLanguage];
            subtitleElement.setAttribute('data-en', subtitles[sectionId].en);
            subtitleElement.setAttribute('data-bn', subtitles[sectionId].bn);
        }
    }

    // Language toggle functionality
    toggleLanguage() {
        this.currentLanguage = this.currentLanguage === 'en' ? 'bn' : 'en';
        this.updateLanguage();
        
        // Update page title for current section
        this.updatePageTitle(this.currentSection);
    }

    updateLanguage() {
        const langDisplay = document.getElementById('lang-display');
        if (langDisplay) {
            langDisplay.textContent = this.currentLanguage === 'en' ? 'বাংলা' : 'English';
        }

        // Update all translatable elements
        document.querySelectorAll(`[data-${this.currentLanguage}]`).forEach(element => {
            const translation = element.getAttribute(`data-${this.currentLanguage}`);
            if (translation) {
                if (element.tagName === 'INPUT' && element.type !== 'submit') {
                    element.placeholder = translation;
                } else {
                    element.textContent = translation;
                }
            }
        });

        // Update document language and direction
        document.documentElement.lang = this.currentLanguage;
        document.documentElement.dir = this.currentLanguage === 'bn' ? 'ltr' : 'ltr'; // Both are LTR

        console.log(`🌐 Language changed to: ${this.currentLanguage}`);
    }

    // Notification functions
    toggleNotifications() {
        const dropdown = document.getElementById('notification-dropdown');
        dropdown.classList.toggle('show');
    }

    markAllNotificationsRead() {
        document.querySelectorAll('.notification-item.unread').forEach(item => {
            item.classList.remove('unread');
        });
        
        const count = document.querySelector('.notification-count');
        if (count) {
            count.textContent = '0';
        }
    }

    // Feedback management functions
    viewFeedback(feedbackId) {
        const feedback = this.feedbackData.find(f => f.id === feedbackId);
        if (!feedback) return;

        // Populate modal with feedback data
        document.getElementById('modal-tracking-id').textContent = feedback.id;
        document.getElementById('modal-category').textContent = feedback.category;
        document.getElementById('modal-priority').textContent = feedback.priority;
        document.getElementById('modal-priority').className = `priority-badge ${feedback.priority.toLowerCase()}`;
        document.getElementById('modal-status').textContent = feedback.status;
        document.getElementById('modal-status').className = `status-badge ${feedback.status.toLowerCase().replace(' ', '-')}`;
        document.getElementById('modal-location').textContent = feedback.location;
        document.getElementById('modal-date').textContent = feedback.date;
        document.getElementById('modal-description').textContent = feedback.description || 'No detailed description available.';

        // Show modal
        this.showModal('feedback-detail-modal');
    }

    assignFeedback(feedbackId) {
        console.log('Assigning feedback:', feedbackId);
        // Implement assignment logic here
        this.showNotification('Feedback assigned successfully!', 'success');
    }

    bulkAssign() {
        const selected = document.querySelectorAll('input[name="feedback-select"]:checked');
        console.log('Bulk assigning feedbacks:', selected.length);
        this.showNotification(`${selected.length} feedback(s) assigned successfully!`, 'success');
    }

    bulkUpdateStatus() {
        const selected = document.querySelectorAll('input[name="feedback-select"]:checked');
        console.log('Bulk updating status for:', selected.length);
        this.showNotification(`Status updated for ${selected.length} feedback(s)!`, 'success');
    }

    bulkExport() {
        const selected = document.querySelectorAll('input[name="feedback-select"]:checked');
        console.log('Exporting feedbacks:', selected.length);
        this.showNotification(`Exporting ${selected.length} feedback(s)...`, 'info');
    }

    selectAllFeedbacks() {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('input[name="feedback-select"]');
        
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
    }

    useAISuggestion() {
        const aiSuggestion = document.querySelector('.ai-suggestion').textContent;
        document.getElementById('response-textarea').value = aiSuggestion;
    }

    sendResponse() {
        const response = document.getElementById('response-textarea').value;
        const status = document.getElementById('status-update').value;
        
        if (!response.trim()) {
            this.showNotification('Please enter a response', 'warning');
            return;
        }

        console.log('Sending response:', { response, status });
        this.showNotification('Response sent successfully!', 'success');
        this.closeModal('feedback-detail-modal');
    }

    // AI Insight functions
    takeAction(actionType) {
        console.log('Taking action:', actionType);
        this.showNotification('Action initiated successfully!', 'success');
    }

    viewDetails(detailType) {
        console.log('Viewing details for:', detailType);
        this.showNotification('Opening detailed analysis...', 'info');
    }

    implementSuggestion(suggestionType) {
        console.log('Implementing suggestion:', suggestionType);
        this.showNotification('Implementation plan created!', 'success');
    }

    viewAnalysis(analysisType) {
        console.log('Viewing analysis for:', analysisType);
        this.showNotification('Loading analysis report...', 'info');
    }

    viewTrend(trendType) {
        console.log('Viewing trend for:', trendType);
        this.showNotification('Opening trend analysis...', 'info');
    }

    // Utility functions
    showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }

    closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification-toast ${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${this.getNotificationIcon(type)}"></i>
                <span>${message}</span>
            </div>
            <button class="notification-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;

        // Add to page
        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }

    getNotificationIcon(type) {
        const icons = {
            success: 'check-circle',
            warning: 'exclamation-triangle',
            error: 'exclamation-circle',
            info: 'info-circle'
        };
        return icons[type] || 'info-circle';
    }

    refreshData() {
        console.log('🔄 Refreshing dashboard data...');
        this.showNotification('Refreshing data...', 'info');
        
        // Simulate data refresh
        setTimeout(() => {
            this.loadDashboardData();
            this.animateKPIValues();
            this.showNotification('Data refreshed successfully!', 'success');
        }, 1500);
    }

    refreshAIInsights() {
        console.log('🤖 Refreshing AI insights...');
        this.showNotification('Updating AI analysis...', 'info');
        
        setTimeout(() => {
            this.showNotification('AI insights updated!', 'success');
        }, 2000);
    }

    generateReport() {
        console.log('📊 Generating report...');
        this.showNotification('Generating performance report...', 'info');
        
        setTimeout(() => {
            this.showNotification('Report generated successfully!', 'success');
        }, 3000);
    }

    expandAIPanel() {
        console.log('🔍 Expanding AI panel...');
        this.showNotification('Opening detailed AI analysis...', 'info');
    }

    viewAllActivity() {
        console.log('👁️ Viewing all activity...');
        this.showNotification('Loading complete activity log...', 'info');
    }

    logout() {
        if (confirm('Are you sure you want to logout?')) {
            console.log('🚪 Logging out...');
            this.showNotification('Logging out...', 'info');
            
            setTimeout(() => {
                window.location.href = "{{ url('/index') }}";
            }, 1500);
        }
    }
}

// Global functions for inline event handlers
function showDashboardSection(sectionId) {
    dashboardApp.showDashboardSection(sectionId);
}

function toggleLanguage() {
    dashboardApp.toggleLanguage();
}

function toggleNotifications() {
    dashboardApp.toggleNotifications();
}

function closeModal(modalId) {
    dashboardApp.closeModal(modalId);
}

function refreshData() {
    dashboardApp.refreshData();
}

function refreshAIInsights() {
    dashboardApp.refreshAIInsights();
}

function generateReport() {
    dashboardApp.generateReport();
}

function expandAIPanel() {
    dashboardApp.expandAIPanel();
}

function viewAllActivity() {
    dashboardApp.viewAllActivity();
}

function logout() {
    dashboardApp.logout();
}

function viewDetails(type) {
    dashboardApp.viewDetails(type);
}

function takeAction(type) {
    dashboardApp.takeAction(type);
}

function implementSuggestion(type) {
    dashboardApp.implementSuggestion(type);
}

function viewAnalysis(type) {
    dashboardApp.viewAnalysis(type);
}

function viewTrend(type) {
    dashboardApp.viewTrend(type);
}

function viewFeedback(id) {
    dashboardApp.viewFeedback(id);
}

function viewResolution(id) {
    dashboardApp.viewDetails('resolution');
}

function viewReport(type) {
    dashboardApp.viewDetails('report');
}

function selectAllFeedbacks() {
    dashboardApp.selectAllFeedbacks();
}

function bulkAssign() {
    dashboardApp.bulkAssign();
}

function bulkUpdateStatus() {
    dashboardApp.bulkUpdateStatus();
}

function bulkExport() {
    dashboardApp.bulkExport();
}

function useAISuggestion() {
    dashboardApp.useAISuggestion();
}

function sendResponse() {
    dashboardApp.sendResponse();
}

// Initialize dashboard when DOM is ready
let dashboardApp;
document.addEventListener('DOMContentLoaded', () => {
    dashboardApp = new DashboardApp();
});

// Handle window resize for responsive behavior
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.remove('mobile-open');
    }
});

// Add notification toast styles dynamically
const toastStyles = `
<style>
.notification-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    min-width: 300px;
    z-index: 10000;
    border-left: 4px solid #4299e1;
    animation: slideInRight 0.3s ease-out;
}

.notification-toast.success {
    border-left-color: #48bb78;
}

.notification-toast.warning {
    border-left-color: #ed8936;
}

.notification-toast.error {
    border-left-color: #f56565;
}

.notification-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex: 1;
}

.notification-content i {
    font-size: 1.125rem;
    color: #4299e1;
}

.notification-toast.success .notification-content i {
    color: #48bb78;
}

.notification-toast.warning .notification-content i {
    color: #ed8936;
}

.notification-toast.error .notification-content i {
    color: #f56565;
}

.notification-close {
    background: none;
    border: none;
    color: #a0aec0;
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.notification-close:hover {
    background: #f7fafc;
    color: #4a5568;
}

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
</style>
`;

document.head.insertAdjacentHTML('beforeend', toastStyles);