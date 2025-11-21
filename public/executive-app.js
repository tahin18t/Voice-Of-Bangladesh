// Executive Intelligence Dashboard Application
class ExecutiveDashboard {
    constructor() {
        this.currentLanguage = 'en';
        this.charts = {};
        this.realTimeData = {
            activeUsers: 47832,
            systemUptime: 99.97,
            databaseLoad: 78
        };
        this.kpiData = {
            efficiency: 94.2,
            citizensServed: 2.4,
            responseTime: 1.8,
            securityScore: 99.7
        };
        
        this.init();
    }

    init() {
        this.initializeLoader();
        this.setupEventListeners();
        this.initializeCharts();
        this.startRealTimeUpdates();
        this.animateKPIValues();
        this.updateTimeZones();
        this.updateLanguage();
        
        console.log('👑 Executive Intelligence Dashboard initialized successfully');
    }

    initializeLoader() {
        const loader = document.getElementById('loader');
        const progressCircle = document.querySelector('.progress-circle');
        const progressPercentage = document.querySelector('.progress-percentage');
        const loadingStatus = document.querySelector('.loading-status');
        
        const loadingSteps = [
            { 
                text: { 
                    en: 'Analyzing national policy trends...', 
                    bn: 'জাতীয় নীতিগত প্রবণতা বিশ্লেষণ করা হচ্ছে...' 
                }, 
                progress: 20 
            },
            { 
                text: { 
                    en: 'Loading AI policy intelligence...', 
                    bn: 'AI নীতি বুদ্ধিমত্তা লোড হচ্ছে...' 
                }, 
                progress: 40 
            },
            { 
                text: { 
                    en: 'Connecting to ministry databases...', 
                    bn: 'মন্ত্রণালয় ডেটাবেসে সংযোগ হচ্ছে...' 
                }, 
                progress: 60 
            },
            { 
                text: { 
                    en: 'Generating strategic insights...', 
                    bn: 'কৌশলগত অন্তর্দৃষ্টি তৈরি হচ্ছে...' 
                }, 
                progress: 80 
            },
            { 
                text: { 
                    en: 'Executive dashboard ready!', 
                    bn: 'নির্বাহী ড্যাশবোর্ড প্রস্তুত!' 
                }, 
                progress: 100 
            }
        ];

        let currentStep = 0;
        const stepInterval = setInterval(() => {
            if (currentStep < loadingSteps.length) {
                const step = loadingSteps[currentStep];
                
                // Update text
                loadingStatus.textContent = step.text[this.currentLanguage];
                loadingStatus.setAttribute('data-en', step.text.en);
                loadingStatus.setAttribute('data-bn', step.text.bn);
                
                // Update progress ring and percentage
                const circumference = 2 * Math.PI * 50;
                const offset = circumference - (step.progress / 100) * circumference;
                progressCircle.style.strokeDashoffset = offset;
                progressPercentage.textContent = `${step.progress}%`;
                
                currentStep++;
            } else {
                clearInterval(stepInterval);
                setTimeout(() => {
                    loader.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }, 800);
            }
        }, 800);
    }

    setupEventListeners() {
        // Transformation timeframe selector
        const transformationTimeframe = document.getElementById('transformation-timeframe');
        if (transformationTimeframe) {
            transformationTimeframe.addEventListener('change', (e) => {
                this.updateTransformationChart(e.target.value);
            });
        }

        // Real-time data updates
        setInterval(() => {
            this.updateRealTimeData();
        }, 5000); // Update every 5 seconds

        // Time zone updates
        setInterval(() => {
            this.updateTimeZones();
        }, 1000); // Update every second
    }

    initializeCharts() {
        this.initTransformationChart();
        this.initSatisfactionGauge();
    }

    initTransformationChart() {
        const ctx = document.getElementById('transformationChart');
        if (!ctx) return;

        this.charts.transformation = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Q1 2023', 'Q2 2023', 'Q3 2023', 'Q4 2023', 'Q1 2024', 'Q2 2024', 'Q3 2024', 'Q4 2024'],
                datasets: [
                    {
                        label: 'Digital Service Adoption',
                        data: [45, 52, 61, 68, 75, 82, 89, 94.2],
                        borderColor: '#4299e1',
                        backgroundColor: 'rgba(66, 153, 225, 0.1)',
                        borderWidth: 4,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#4299e1',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 6
                    },
                    {
                        label: 'Process Efficiency',
                        data: [38, 44, 49, 55, 62, 69, 76, 84],
                        borderColor: '#48bb78',
                        backgroundColor: 'rgba(72, 187, 120, 0.1)',
                        borderWidth: 4,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#48bb78',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 6
                    },
                    {
                        label: 'Citizen Satisfaction',
                        data: [72, 75, 78, 81, 85, 88, 90, 92.4],
                        borderColor: '#ed8936',
                        backgroundColor: 'rgba(237, 137, 54, 0.1)',
                        borderWidth: 4,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ed8936',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 6
                    }
                ]
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
                            color: '#4a5568',
                            font: {
                                family: 'Inter',
                                size: 12,
                                weight: '500'
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#718096',
                            font: {
                                family: 'Inter',
                                size: 11
                            }
                        }
                    },
                    y: {
                        grid: {
                            borderDash: [5, 5],
                            color: 'rgba(113, 128, 150, 0.2)'
                        },
                        ticks: {
                            color: '#718096',
                            font: {
                                family: 'Inter',
                                size: 11
                            },
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        min: 0,
                        max: 100
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }

    initSatisfactionGauge() {
        const ctx = document.getElementById('satisfactionGauge');
        if (!ctx) return;

        this.charts.satisfaction = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Satisfied', 'Remaining'],
                datasets: [{
                    data: [92.4, 7.6],
                    backgroundColor: [
                        'linear-gradient(135deg, #48bb78, #38a169)',
                        '#e2e8f0'
                    ],
                    borderWidth: 0,
                    cutout: '75%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            },
            plugins: [{
                beforeDraw: function(chart) {
                    const ctx = chart.ctx;
                    const centerX = chart.getDatasetMeta(0).data[0].x;
                    const centerY = chart.getDatasetMeta(0).data[0].y;
                    
                    ctx.save();
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.font = 'bold 24px Inter';
                    ctx.fillStyle = '#2d3748';
                    ctx.fillText('92.4%', centerX, centerY - 10);
                    
                    ctx.font = '12px Inter';
                    ctx.fillStyle = '#718096';
                    ctx.fillText('Satisfaction', centerX, centerY + 12);
                    ctx.restore();
                }
            }]
        });
    }

    updateTransformationChart(timeframe) {
        if (!this.charts.transformation) return;

        let labels, data1, data2, data3;
        
        switch (timeframe) {
            case '1y':
                labels = ['Q1 2024', 'Q2 2024', 'Q3 2024', 'Q4 2024'];
                data1 = [75, 82, 89, 94.2];
                data2 = [62, 69, 76, 84];
                data3 = [85, 88, 90, 92.4];
                break;
            case '2y':
                labels = ['Q1 2023', 'Q2 2023', 'Q3 2023', 'Q4 2023', 'Q1 2024', 'Q2 2024', 'Q3 2024', 'Q4 2024'];
                data1 = [45, 52, 61, 68, 75, 82, 89, 94.2];
                data2 = [38, 44, 49, 55, 62, 69, 76, 84];
                data3 = [72, 75, 78, 81, 85, 88, 90, 92.4];
                break;
            case '5y':
                labels = ['2020', '2021', '2022', '2023', '2024'];
                data1 = [25, 32, 38, 60, 94.2];
                data2 = [20, 28, 35, 52, 84];
                data3 = [65, 68, 72, 79, 92.4];
                break;
            default:
                return;
        }

        this.charts.transformation.data.labels = labels;
        this.charts.transformation.data.datasets[0].data = data1;
        this.charts.transformation.data.datasets[1].data = data2;
        this.charts.transformation.data.datasets[2].data = data3;
        this.charts.transformation.update('active');
    }

    animateKPIValues() {
        const kpiElements = document.querySelectorAll('.kpi-value[data-count]');
        
        kpiElements.forEach(element => {
            const targetValue = parseFloat(element.getAttribute('data-count'));
            let currentValue = 0;
            const increment = targetValue / 80; // Slower animation for executive feel
            const isPercentage = element.textContent.includes('%') || element.getAttribute('data-count').includes('%');
            const isDecimal = targetValue % 1 !== 0;
            
            const animation = setInterval(() => {
                currentValue += increment;
                if (currentValue >= targetValue) {
                    currentValue = targetValue;
                    clearInterval(animation);
                }
                
                let displayValue;
                if (isDecimal) {
                    displayValue = currentValue.toFixed(1);
                } else {
                    displayValue = Math.round(currentValue);
                }
                
                if (element.textContent.includes('M')) {
                    element.textContent = displayValue + 'M';
                } else if (isPercentage || element.textContent.includes('%')) {
                    element.textContent = displayValue + '%';
                } else {
                    element.textContent = displayValue;
                }
            }, 20);
        });
    }

    updateTimeZones() {
        const now = new Date();
        
        // Dhaka Time (UTC+6)
        const dhakaTime = new Date(now.getTime() + (6 * 60 * 60 * 1000));
        const dhakaTimeElement = document.getElementById('dhaka-time');
        if (dhakaTimeElement) {
            dhakaTimeElement.textContent = this.formatTime(dhakaTime);
        }
        
        // UTC Time
        const utcTimeElement = document.getElementById('utc-time');
        if (utcTimeElement) {
            utcTimeElement.textContent = this.formatTime(now, true);
        }
    }

    formatTime(date, isUTC = false) {
        const options = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        };
        
        if (isUTC) {
            return date.toUTCString().split(' ')[4];
        } else {
            return date.toLocaleTimeString('en-US', options);
        }
    }

    updateRealTimeData() {
        // Simulate real-time data updates
        this.realTimeData.activeUsers += Math.floor(Math.random() * 100 - 50);
        this.realTimeData.systemUptime = Math.min(99.99, this.realTimeData.systemUptime + (Math.random() * 0.01 - 0.005));
        this.realTimeData.databaseLoad += Math.floor(Math.random() * 10 - 5);
        this.realTimeData.databaseLoad = Math.max(50, Math.min(95, this.realTimeData.databaseLoad));

        // Update UI
        const activeUsersElement = document.querySelector('.monitor-item:nth-child(2) .monitor-value');
        if (activeUsersElement) {
            activeUsersElement.textContent = this.realTimeData.activeUsers.toLocaleString();
        }

        const uptimeElement = document.querySelector('.monitor-item:nth-child(1) .monitor-value');
        if (uptimeElement) {
            uptimeElement.textContent = this.realTimeData.systemUptime.toFixed(2) + '%';
        }

        const dbLoadElement = document.querySelector('.monitor-item:nth-child(3) .monitor-value');
        if (dbLoadElement) {
            dbLoadElement.textContent = this.realTimeData.databaseLoad + '%';
            
            // Update warning status
            const dbItem = document.querySelector('.monitor-item:nth-child(3)');
            const dbStatus = document.querySelector('.monitor-item:nth-child(3) .monitor-status');
            if (this.realTimeData.databaseLoad > 80) {
                dbItem.classList.add('warning');
                dbStatus.classList.remove('online');
                dbStatus.classList.add('warning');
            } else {
                dbItem.classList.remove('warning');
                dbStatus.classList.remove('warning');
                dbStatus.classList.add('online');
            }
        }
    }

    startRealTimeUpdates() {
        // Update every 3 seconds for executive dashboard
        setInterval(() => {
            this.updateRealTimeData();
        }, 3000);
    }

    // Language Toggle
    toggleLanguage() {
        this.currentLanguage = this.currentLanguage === 'en' ? 'bn' : 'en';
        this.updateLanguage();
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

        // Update document language
        document.documentElement.lang = this.currentLanguage;
        
        console.log(`🌐 Executive Dashboard language changed to: ${this.currentLanguage}`);
    }

    // Executive Action Functions
    exportStrategicReport() {
        this.showExecutiveNotification('Generating comprehensive strategic report...', 'info');
        setTimeout(() => {
            this.showExecutiveNotification('Strategic report exported successfully!', 'success');
        }, 3000);
        console.log('📊 Exporting strategic report for ministry leadership');
    }

    scheduleMinistryBriefing() {
        this.showExecutiveNotification('Scheduling inter-ministerial briefing...', 'info');
        setTimeout(() => {
            this.showExecutiveNotification('Ministry briefing scheduled for next week!', 'success');
        }, 2000);
        console.log('📅 Scheduling ministry briefing');
    }

    emergencyAlert() {
        this.showExecutiveNotification('Emergency alert system activated!', 'warning');
        console.log('🚨 Emergency alert system activated');
    }

    // Policy Intelligence Functions
    refreshPolicyIntelligence() {
        this.showExecutiveNotification('Refreshing AI policy intelligence...', 'info');
        setTimeout(() => {
            this.showExecutiveNotification('Policy intelligence updated successfully!', 'success');
        }, 2500);
        console.log('🧠 Refreshing policy intelligence');
    }

    generatePolicyBrief() {
        this.showExecutiveNotification('Generating AI policy brief...', 'info');
        setTimeout(() => {
            this.showExecutiveNotification('Policy brief generated and ready for review!', 'success');
        }, 4000);
        console.log('📄 Generating AI policy brief');
    }

    initiateEmergencyReview(type) {
        this.showExecutiveNotification(`Initiating emergency review for ${type}...`, 'warning');
        console.log(`🚨 Emergency review initiated: ${type}`);
    }

    viewDetailedAnalysis(type) {
        this.showExecutiveNotification(`Loading detailed analysis for ${type}...`, 'info');
        console.log(`📊 Viewing detailed analysis: ${type}`);
    }

    approveScaling(program) {
        this.showExecutiveNotification(`Approving scaling for ${program} program...`, 'success');
        console.log(`✅ Scaling approved: ${program}`);
    }

    viewProjections(program) {
        this.showExecutiveNotification(`Loading projections for ${program}...`, 'info');
        console.log(`📈 Viewing projections: ${program}`);
    }

    initiatePolicyDraft(policy) {
        this.showExecutiveNotification(`Initiating policy draft for ${policy}...`, 'info');
        console.log(`📝 Policy draft initiated: ${policy}`);
    }

    viewStakeholders(policy) {
        this.showExecutiveNotification(`Loading stakeholder list for ${policy}...`, 'info');
        console.log(`👥 Viewing stakeholders: ${policy}`);
    }

    // Executive Action Center Functions
    approveAction(actionId) {
        this.showExecutiveNotification('Action approved and forwarded for implementation!', 'success');
        console.log(`✅ Action approved: ${actionId}`);
    }

    reviewAction(actionId) {
        this.showExecutiveNotification('Opening detailed action review...', 'info');
        console.log(`👁️ Reviewing action: ${actionId}`);
    }

    deferAction(actionId) {
        this.showExecutiveNotification('Action deferred for further review.', 'warning');
        console.log(`⏸️ Action deferred: ${actionId}`);
    }

    initiateConsultation(policy) {
        this.showExecutiveNotification(`Starting public consultation for ${policy}...`, 'info');
        console.log(`🗣️ Consultation initiated: ${policy}`);
    }

    reviewDraft(policy) {
        this.showExecutiveNotification(`Opening policy draft for ${policy}...`, 'info');
        console.log(`📖 Reviewing draft: ${policy}`);
    }

    prepareReports(meeting) {
        this.showExecutiveNotification(`Preparing reports for ${meeting}...`, 'info');
        setTimeout(() => {
            this.showExecutiveNotification('Reports prepared and ready for meeting!', 'success');
        }, 3000);
        console.log(`📊 Preparing reports: ${meeting}`);
    }

    viewAgenda(meeting) {
        this.showExecutiveNotification(`Loading agenda for ${meeting}...`, 'info');
        console.log(`📋 Viewing agenda: ${meeting}`);
    }

    toggleExecutiveMenu() {
        console.log('⚙️ Executive menu toggled');
        this.showExecutiveNotification('Executive menu options coming soon...', 'info');
    }

    // Utility Functions
    showExecutiveNotification(message, type = 'info') {
        // Create executive-style notification
        const notification = document.createElement('div');
        notification.className = `executive-notification ${type}`;
        notification.innerHTML = `
            <div class="notification-icon">
                <i class="fas fa-${this.getNotificationIcon(type)}"></i>
            </div>
            <div class="notification-content">
                <span>${message}</span>
            </div>
            <button class="notification-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;

        // Add to page
        document.body.appendChild(notification);

        // Auto remove after 6 seconds (longer for executive)
        setTimeout(() => {
            if (notification.parentElement) {
                notification.classList.add('fade-out');
                setTimeout(() => notification.remove(), 300);
            }
        }, 6000);
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
}

// Global functions for inline event handlers
function toggleLanguage() {
    executiveDashboard.toggleLanguage();
}

function exportStrategicReport() {
    executiveDashboard.exportStrategicReport();
}

function scheduleMinistryBriefing() {
    executiveDashboard.scheduleMinistryBriefing();
}

function emergencyAlert() {
    executiveDashboard.emergencyAlert();
}

function refreshPolicyIntelligence() {
    executiveDashboard.refreshPolicyIntelligence();
}

function generatePolicyBrief() {
    executiveDashboard.generatePolicyBrief();
}

function initiateEmergencyReview(type) {
    executiveDashboard.initiateEmergencyReview(type);
}

function viewDetailedAnalysis(type) {
    executiveDashboard.viewDetailedAnalysis(type);
}

function approveScaling(program) {
    executiveDashboard.approveScaling(program);
}

function viewProjections(program) {
    executiveDashboard.viewProjections(program);
}

function initiatePolicyDraft(policy) {
    executiveDashboard.initiatePolicyDraft(policy);
}

function viewStakeholders(policy) {
    executiveDashboard.viewStakeholders(policy);
}

function approveAction(actionId) {
    executiveDashboard.approveAction(actionId);
}

function reviewAction(actionId) {
    executiveDashboard.reviewAction(actionId);
}

function deferAction(actionId) {
    executiveDashboard.deferAction(actionId);
}

function initiateConsultation(policy) {
    executiveDashboard.initiateConsultation(policy);
}

function reviewDraft(policy) {
    executiveDashboard.reviewDraft(policy);
}

function prepareReports(meeting) {
    executiveDashboard.prepareReports(meeting);
}

function viewAgenda(meeting) {
    executiveDashboard.viewAgenda(meeting);
}

function toggleExecutiveMenu() {
    executiveDashboard.toggleExecutiveMenu();
}

// Initialize dashboard when DOM is ready
let executiveDashboard;
document.addEventListener('DOMContentLoaded', () => {
    executiveDashboard = new ExecutiveDashboard();
});

// Add executive notification styles dynamically
const executiveNotificationStyles = `
<style>
.executive-notification {
    position: fixed;
    top: 30px;
    right: 30px;
    background: linear-gradient(135deg, #ffffff, #f7fafc);
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    border: 1px solid #e2e8f0;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    min-width: 350px;
    max-width: 450px;
    z-index: 10000;
    animation: slideInFromRight 0.4s ease-out;
    border-left: 4px solid #4299e1;
}

.executive-notification.success {
    border-left-color: #48bb78;
}

.executive-notification.warning {
    border-left-color: #ed8936;
}

.executive-notification.error {
    border-left-color: #f56565;
}

.executive-notification.fade-out {
    animation: fadeOutToRight 0.3s ease-in forwards;
}

.notification-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
    background: rgba(66, 153, 225, 0.1);
    color: #4299e1;
    flex-shrink: 0;
}

.executive-notification.success .notification-icon {
    background: rgba(72, 187, 120, 0.1);
    color: #48bb78;
}

.executive-notification.warning .notification-icon {
    background: rgba(237, 137, 54, 0.1);
    color: #ed8936;
}

.executive-notification.error .notification-icon {
    background: rgba(245, 101, 101, 0.1);
    color: #f56565;
}

.notification-content {
    flex: 1;
    font-size: 0.875rem;
    color: #2d3748;
    font-weight: 500;
    line-height: 1.4;
}

.notification-close {
    background: none;
    border: none;
    color: #a0aec0;
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: all 0.2s ease;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.notification-close:hover {
    background: #f7fafc;
    color: #4a5568;
}

@keyframes slideInFromRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes fadeOutToRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

/* Executive notification responsive */
@media (max-width: 768px) {
    .executive-notification {
        top: 20px;
        right: 20px;
        left: 20px;
        min-width: auto;
        max-width: none;
    }
    
    @keyframes slideInFromRight {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    @keyframes fadeOutToRight {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(-100%);
            opacity: 0;
        }
    }
}
</style>
`;

document.head.insertAdjacentHTML('beforeend', executiveNotificationStyles);

// Executive Navigation Handler
function navigateTo(section) {
    // Update active button in sidebar
    const navButtons = document.querySelectorAll('.nav-btn');
    navButtons.forEach(btn => btn.classList.remove('active'));
    
    const activeBtn = document.querySelector(`[onclick="navigateTo('${section}')"]`);
    if (activeBtn) {
        activeBtn.classList.add('active');
    }

    // Navigate based on section
    switch(section) {
        case 'dashboard':
            // Stay on executive dashboard
            console.log('Executive Dashboard - Overview selected');
            showExecutiveNotification('Executive Dashboard loaded', 'success');
            break;
        case 'feedback':
            // Navigate to feedback page
            window.location.href = 'submit-feedback.html';
            break;
        case 'governance':
            // Navigate to intelligent governance section
            console.log('Intelligent Governance section selected');
            showExecutiveNotification('Intelligent Governance - Coming Soon', 'info');
            // You can add actual navigation here
            // window.location.href = 'intelligent-governance.html';
            break;
        default:
            console.log('Navigation to:', section);
    }
}

// Initialize active button on page load
document.addEventListener('DOMContentLoaded', function() {
    const firstNavBtn = document.querySelector('.nav-btn');
    if (firstNavBtn) {
        firstNavBtn.classList.add('active');
    }
});
