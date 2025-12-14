// Advanced Tracking System JavaScript

// Global variables
let currentTrackingId = null;
let currentCase = null;
let stakeholders = [];
let timelineData = [];
let charts = {};
let notifications = [];
let searchTimeout = null;

// Sample data for demonstration
const sampleCases = {
    'TR2024001': {
        id: 'TR2024001',
        title: 'Road Infrastructure Improvement Request',
        description: 'Request for repairing damaged road sections in residential area',
        status: 'in-progress',
        priority: 'high',
        category: 'Infrastructure',
        location: 'Dhaka, Dhanmondi Area',
        submittedDate: '2024-09-15',
        lastUpdated: '2024-10-05',
        assignedOfficer: 'Eng. Rahman Ahmed',
        department: 'City Corporation',
        estimatedCompletion: '2024-11-15',
        progressPercentage: 68,
        citizen: {
            name: 'Md. Karim Hassan',
            email: 'karim.hassan@email.com',
            phone: '+880-1712-345678'
        }
    },
    'TR2024002': {
        id: 'TR2024002',
        title: 'Public Transport Service Enhancement',
        description: 'Proposal for additional bus routes and improved scheduling',
        status: 'pending',
        priority: 'medium',
        category: 'Transportation',
        location: 'Chittagong Metropolitan Area',
        submittedDate: '2024-09-28',
        lastUpdated: '2024-10-02',
        assignedOfficer: 'Mr. Hasan Ali',
        department: 'Transport Authority',
        estimatedCompletion: '2024-12-30',
        progressPercentage: 25,
        citizen: {
            name: 'Fatema Begum',
            email: 'fatema.begum@email.com',
            phone: '+880-1711-987654'
        }
    },
    'TR2024003': {
        id: 'TR2024003',
        title: 'Digital Service Accessibility Issue',
        description: 'Report on website accessibility barriers for disabled users',
        status: 'resolved',
        priority: 'high',
        category: 'Digital Services',
        location: 'National Level',
        submittedDate: '2024-08-20',
        lastUpdated: '2024-09-30',
        assignedOfficer: 'Dr. Nafisa Rahman',
        department: 'ICT Division',
        estimatedCompletion: '2024-09-30',
        progressPercentage: 100,
        citizen: {
            name: 'Ahmed Abdullah',
            email: 'ahmed.abdullah@email.com',
            phone: '+880-1713-246810'
        }
    }
};

const sampleStakeholders = {
    'TR2024001': [
        {
            id: 'off_001',
            name: 'Eng. Rahman Ahmed',
            role: 'Project Engineer',
            department: 'City Corporation',
            email: 'rahman.ahmed@dhakacity.gov.bd',
            phone: '+880-2-9123456',
            avatar: null,
            status: 'online',
            lastSeen: 'Active now'
        },
        {
            id: 'off_002',
            name: 'Ariful Islam',
            role: 'Site Supervisor',
            department: 'Public Works',
            email: 'arif.islam@publicworks.gov.bd',
            phone: '+880-2-9234567',
            avatar: null,
            status: 'away',
            lastSeen: '2 hours ago'
        },
        {
            id: 'cit_001',
            name: 'Md. Karim Hassan',
            role: 'Citizen Reporter',
            department: 'Public',
            email: 'karim.hassan@email.com',
            phone: '+880-1712-345678',
            avatar: null,
            status: 'offline',
            lastSeen: 'Yesterday'
        }
    ]
};

const sampleTimeline = {
    'TR2024001': [
        {
            id: 'tl_001',
            type: 'submission',
            title: 'Case Submitted',
            description: 'Initial complaint submitted by citizen regarding road conditions',
            timestamp: '2024-09-15T09:00:00Z',
            author: 'Md. Karim Hassan',
            category: 'system'
        },
        {
            id: 'tl_002',
            type: 'assignment',
            title: 'Case Assigned',
            description: 'Case assigned to Eng. Rahman Ahmed for technical assessment',
            timestamp: '2024-09-16T14:30:00Z',
            author: 'System',
            category: 'system'
        },
        {
            id: 'tl_003',
            type: 'inspection',
            title: 'Site Inspection Completed',
            description: 'Technical team completed on-site assessment. Damage confirmed and repair plan developed.',
            timestamp: '2024-09-20T11:15:00Z',
            author: 'Eng. Rahman Ahmed',
            category: 'update'
        },
        {
            id: 'tl_004',
            type: 'approval',
            title: 'Budget Approved',
            description: 'Municipal budget allocated for road repair project. Total allocation: ৳2,50,000',
            timestamp: '2024-09-25T16:45:00Z',
            author: 'Finance Department',
            category: 'update'
        },
        {
            id: 'tl_005',
            type: 'communication',
            title: 'Citizen Update Sent',
            description: 'Progress update sent to citizen with expected timeline and work schedule',
            timestamp: '2024-10-01T10:20:00Z',
            author: 'Eng. Rahman Ahmed',
            category: 'communication'
        },
        {
            id: 'tl_006',
            type: 'work_started',
            title: 'Construction Work Started',
            description: 'Road repair work commenced. Expected completion by November 15th, 2024.',
            timestamp: '2024-10-05T08:00:00Z',
            author: 'Ariful Islam',
            category: 'update'
        }
    ]
};

// Utility functions
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function formatTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit'
    });
}

function getRelativeTime(dateString) {
    const now = new Date();
    const date = new Date(dateString);
    const diff = now - date;
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor(diff / (1000 * 60 * 60));
    const minutes = Math.floor(diff / (1000 * 60));

    if (days > 0) return `${days} day${days > 1 ? 's' : ''} ago`;
    if (hours > 0) return `${hours} hour${hours > 1 ? 's' : ''} ago`;
    if (minutes > 0) return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
    return 'Just now';
}

function animateCounter(element, start, end, duration = 1000) {
    const range = end - start;
    const increment = range / (duration / 16);
    let current = start;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= end) {
            current = end;
            clearInterval(timer);
        }
        element.textContent = Math.floor(current);
    }, 16);
}

function showNotification(title, message, type = 'info') {
    const notification = {
        id: Date.now(),
        title,
        message,
        type,
        timestamp: new Date().toISOString()
    };
    
    notifications.unshift(notification);
    
    // Create notification element (if we had a notification system)
    console.log(`Notification: ${title} - ${message}`);
    
    // Remove old notifications
    if (notifications.length > 10) {
        notifications = notifications.slice(0, 10);
    }
}

// Loading screen management
function showLoader() {
    const loader = document.querySelector('.tracking-loader');
    if (loader) {
        loader.classList.remove('hidden');
        
        // Simulate loading steps
        const steps = document.querySelectorAll('.step-item');
        steps.forEach((step, index) => {
            setTimeout(() => {
                step.classList.add('active');
                if (index > 0) {
                    steps[index - 1].classList.remove('active');
                    steps[index - 1].classList.add('completed');
                }
                
                if (index === steps.length - 1) {
                    setTimeout(() => {
                        step.classList.remove('active');
                        step.classList.add('completed');
                        hideLoader();
                    }, 800);
                }
            }, (index + 1) * 1000);
        });
    }
}

function hideLoader() {
    const loader = document.querySelector('.tracking-loader');
    if (loader) {
        loader.classList.add('hidden');
    }
}

// Search functionality
function initializeSearch() {
    const searchInput = document.getElementById('trackingId');
    const searchBtn = document.getElementById('searchBtn');
    const suggestionsContainer = document.querySelector('.search-suggestions');
    
    if (searchInput) {
        searchInput.addEventListener('input', handleSearchInput);
        searchInput.addEventListener('focus', showSearchSuggestions);
        searchInput.addEventListener('blur', () => {
            // Delay hiding to allow click on suggestions
            setTimeout(hideSearchSuggestions, 200);
        });
    }
    
    if (searchBtn) {
        searchBtn.addEventListener('click', handleSearch);
    }
    
    // Enter key support
    if (searchInput) {
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                handleSearch();
            }
        });
    }
}

function handleSearchInput(e) {
    const query = e.target.value.trim();
    
    clearTimeout(searchTimeout);
    
    if (query.length >= 3) {
        searchTimeout = setTimeout(() => {
            generateSearchSuggestions(query);
        }, 300);
    } else {
        hideSearchSuggestions();
    }
}

function generateSearchSuggestions(query) {
    const suggestions = Object.keys(sampleCases).filter(id => 
        id.toLowerCase().includes(query.toLowerCase()) ||
        sampleCases[id].title.toLowerCase().includes(query.toLowerCase()) ||
        sampleCases[id].category.toLowerCase().includes(query.toLowerCase())
    );
    
    displaySearchSuggestions(suggestions);
}

function displaySearchSuggestions(suggestions) {
    const container = document.querySelector('.search-suggestions');
    if (!container) return;
    
    container.innerHTML = '';
    
    suggestions.forEach(caseId => {
        const caseData = sampleCases[caseId];
        const item = document.createElement('div');
        item.className = 'suggestion-item';
        item.innerHTML = `
            <i class="fas fa-search"></i>
            <span>${caseId}</span>
            <small>${caseData.category}</small>
        `;
        
        item.addEventListener('click', () => {
            document.getElementById('trackingId').value = caseId;
            hideSearchSuggestions();
            handleSearch();
        });
        
        container.appendChild(item);
    });
    
    if (suggestions.length > 0) {
        showSearchSuggestions();
    } else {
        hideSearchSuggestions();
    }
}

function showSearchSuggestions() {
    const container = document.querySelector('.search-suggestions');
    if (container) {
        container.classList.add('show');
    }
}

function hideSearchSuggestions() {
    const container = document.querySelector('.search-suggestions');
    if (container) {
        container.classList.remove('show');
    }
}

function handleSearch() {
    const trackingId = document.getElementById('trackingId').value.trim();
    
    if (!trackingId) {
        showNotification('Input Required', 'Please enter a tracking ID', 'warning');
        return;
    }
    
    showLoader();
    hideSearchSuggestions();
    
    // Simulate API call
    setTimeout(() => {
        if (sampleCases[trackingId]) {
            currentTrackingId = trackingId;
            currentCase = sampleCases[trackingId];
            loadCaseData(trackingId);
        } else {
            showCaseNotFound(trackingId);
        }
    }, 2000);
}

// Case data loading
function loadCaseData(trackingId) {
    const initialState = document.querySelector('.initial-state');
    const resultsState = document.querySelector('.tracking-results');
    
    if (initialState) initialState.style.display = 'none';
    if (resultsState) resultsState.style.display = 'block';
    
    // Load different sections
    populateCaseHeader();
    populateProgressOverview();
    populateTimeline();
    populateStakeholders();
    populateAIInsights();
    
    showNotification('Case Loaded', `Successfully loaded case ${trackingId}`, 'success');
}

function showCaseNotFound(trackingId) {
    showNotification('Case Not Found', `No case found with ID: ${trackingId}`, 'error');
    
    // You could show a "case not found" message here
    const initialState = document.querySelector('.initial-state');
    if (initialState) {
        const emptyState = initialState.querySelector('.empty-state');
        if (emptyState) {
            emptyState.innerHTML = `
                <div class="lottie-animation" id="notFoundAnimation"></div>
                <h2 data-en="Case Not Found" data-bn="কেস পাওয়া যায়নি">Case Not Found</h2>
                <p data-en="The tracking ID '${trackingId}' could not be found in our system. Please check the ID and try again." 
                   data-bn="ট্র্যাকিং আইডি '${trackingId}' আমাদের সিস্টেমে পাওয়া যায়নি। আইডি চেক করে আবার চেষ্টা করুন।">
                   The tracking ID '${trackingId}' could not be found in our system. Please check the ID and try again.
                </p>
                <div class="demo-btn-container">
                    <button class="demo-btn" onclick="resetSearch()">
                        <i class="fas fa-search"></i>
                        <span data-en="Search Again" data-bn="আবার খুঁজুন">Search Again</span>
                    </button>
                </div>
            `;
        }
    }
}

function resetSearch() {
    const initialState = document.querySelector('.initial-state');
    const resultsState = document.querySelector('.tracking-results');
    
    if (initialState) initialState.style.display = 'block';
    if (resultsState) resultsState.style.display = 'none';
    
    document.getElementById('trackingId').value = '';
    document.getElementById('trackingId').focus();
    
    // Reset to original empty state
    location.reload();
}

// Case header population
function populateCaseHeader() {
    if (!currentCase) return;
    
    const header = document.querySelector('.case-header');
    if (!header) return;
    
    header.innerHTML = `
        <div class="case-info">
            <div class="case-id">
                <h2>${currentCase.id}</h2>
                <div class="case-status">
                    <span class="status-badge ${currentCase.status}">${currentCase.status.replace('-', ' ')}</span>
                    <span class="case-priority ${currentCase.priority}">${currentCase.priority} priority</span>
                </div>
            </div>
            
            <div class="case-meta">
                <div class="meta-item">
                    <i class="fas fa-calendar"></i>
                    <span><strong>Submitted:</strong> ${formatDate(currentCase.submittedDate)}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-clock"></i>
                    <span><strong>Last Updated:</strong> ${formatDate(currentCase.lastUpdated)}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-user-tie"></i>
                    <span><strong>Assigned To:</strong> ${currentCase.assignedOfficer}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-building"></i>
                    <span><strong>Department:</strong> ${currentCase.department}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><strong>Location:</strong> ${currentCase.location}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-target"></i>
                    <span><strong>Expected Completion:</strong> ${formatDate(currentCase.estimatedCompletion)}</span>
                </div>
            </div>
        </div>
        
        <div class="case-actions">
            <button class="action-btn secondary" onclick="downloadReport()">
                <i class="fas fa-download"></i>
                <span>Download Report</span>
            </button>
            <button class="action-btn primary" onclick="openCommunication()">
                <i class="fas fa-comments"></i>
                <span>Contact Officer</span>
            </button>
        </div>
    `;
}

// Progress overview population
function populateProgressOverview() {
    if (!currentCase) return;
    
    const overview = document.querySelector('.progress-overview');
    if (!overview) return;
    
    const stepsCompleted = Math.floor((currentCase.progressPercentage / 100) * 6);
    const stakeholderCount = sampleStakeholders[currentCase.id]?.length || 0;
    const daysElapsed = Math.floor((new Date() - new Date(currentCase.submittedDate)) / (1000 * 60 * 60 * 24));
    
    overview.innerHTML = `
        <div class="section-header">
            <h3><i class="fas fa-chart-line"></i>Progress Overview</h3>
        </div>
        
        <div class="progress-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-content">
                    <h3 id="stepsCounter">0</h3>
                    <p>Steps Completed</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3 id="stakeholderCounter">0</h3>
                    <p>Stakeholders Involved</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-content">
                    <h3 id="daysCounter">0</h3>
                    <p>Days Elapsed</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon info">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="stat-content">
                    <h3 id="progressCounter">0</h3>
                    <p>Completion</p>
                </div>
            </div>
        </div>
        
        <div class="progress-bar-container">
            <div class="progress-bar">
                <div class="progress-fill" style="width: 0%" id="progressBar"></div>
            </div>
            <div class="progress-labels">
                <span>Started</span>
                <span>${currentCase.progressPercentage}% Complete</span>
                <span>Finished</span>
            </div>
        </div>
    `;
    
    // Animate counters
    setTimeout(() => {
        animateCounter(document.getElementById('stepsCounter'), 0, stepsCompleted);
        animateCounter(document.getElementById('stakeholderCounter'), 0, stakeholderCount);
        animateCounter(document.getElementById('daysCounter'), 0, daysElapsed);
        animateCounter(document.getElementById('progressCounter'), 0, currentCase.progressPercentage);
        
        // Animate progress bar
        const progressBar = document.getElementById('progressBar');
        if (progressBar) {
            setTimeout(() => {
                progressBar.style.width = `${currentCase.progressPercentage}%`;
            }, 500);
        }
    }, 300);
}

// Timeline population
function populateTimeline() {
    if (!currentCase) return;
    
    const timelineSection = document.querySelector('.timeline-section');
    if (!timelineSection) return;
    
    const timeline = sampleTimeline[currentCase.id] || [];
    
    let timelineHTML = `
        <div class="section-header">
            <h3><i class="fas fa-history"></i>Timeline</h3>
            <div class="timeline-controls">
                <button class="timeline-filter active" onclick="filterTimeline('all')">All</button>
                <button class="timeline-filter" onclick="filterTimeline('update')">Updates</button>
                <button class="timeline-filter" onclick="filterTimeline('communication')">Communications</button>
                <button class="timeline-filter" onclick="filterTimeline('system')">System</button>
            </div>
        </div>
        
        <div class="timeline-container">
            <div class="timeline">
    `;
    
    timeline.forEach(item => {
        timelineHTML += `
            <div class="timeline-item ${item.category}" data-category="${item.category}">
                <div class="timeline-header">
                    <h4>${item.title}</h4>
                    <div class="timeline-meta">
                        <span class="timeline-author">${item.author}</span>
                        <span class="timeline-date">${formatDate(item.timestamp)}</span>
                        <span class="timeline-time">${formatTime(item.timestamp)}</span>
                    </div>
                </div>
                <p>${item.description}</p>
                <div class="timeline-actions">
                    <button class="timeline-btn" onclick="viewTimelineDetails('${item.id}')">
                        <i class="fas fa-eye"></i> View Details
                    </button>
                </div>
            </div>
        `;
    });
    
    timelineHTML += `
            </div>
        </div>
    `;
    
    timelineSection.innerHTML = timelineHTML;
}

function filterTimeline(category) {
    const items = document.querySelectorAll('.timeline-item');
    const filters = document.querySelectorAll('.timeline-filter');
    
    // Update filter buttons
    filters.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Show/hide timeline items
    items.forEach(item => {
        if (category === 'all' || item.dataset.category === category) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

// Stakeholders population
function populateStakeholders() {
    if (!currentCase) return;
    
    const communicationSection = document.querySelector('.communication-section');
    if (!communicationSection) return;
    
    const stakeholdersList = sampleStakeholders[currentCase.id] || [];
    
    let stakeholdersHTML = `
        <div class="section-header">
            <h3><i class="fas fa-users"></i>Stakeholder Communication</h3>
            <button class="add-message-btn" onclick="openCommunication()">
                <i class="fas fa-plus"></i>
                <span>New Message</span>
            </button>
        </div>
        
        <div class="stakeholders-grid">
    `;
    
    stakeholdersList.forEach(stakeholder => {
        stakeholdersHTML += `
            <div class="stakeholder-card">
                <div class="stakeholder-avatar">
                    ${stakeholder.avatar ? 
                        `<img src="${stakeholder.avatar}" alt="${stakeholder.name}">` :
                        `<div class="avatar-placeholder">
                            <i class="fas fa-user"></i>
                        </div>`
                    }
                    <div class="status-dot ${stakeholder.status}"></div>
                </div>
                <div class="stakeholder-info">
                    <h4>${stakeholder.name}</h4>
                    <p>${stakeholder.role}</p>
                    <small>${stakeholder.lastSeen}</small>
                </div>
                <div class="stakeholder-actions">
                    <button class="contact-btn" onclick="openCommunication('${stakeholder.id}')" title="Send Message">
                        <i class="fas fa-envelope"></i>
                    </button>
                    <button class="call-btn" onclick="initiateCall('${stakeholder.phone}')" title="Call">
                        <i class="fas fa-phone"></i>
                    </button>
                </div>
            </div>
        `;
    });
    
    stakeholdersHTML += `</div>`;
    
    communicationSection.innerHTML = stakeholdersHTML;
}

// AI Insights population
function populateAIInsights() {
    if (!currentCase) return;
    
    const insightsSection = document.querySelector('.ai-insights-section');
    if (!insightsSection) return;
    
    // Generate AI insights based on case data
    const insights = generateAIInsights(currentCase);
    
    let insightsHTML = `
        <div class="section-header">
            <h3><i class="fas fa-brain"></i>AI-Powered Insights</h3>
        </div>
        
        <div class="insights-grid">
    `;
    
    insights.forEach(insight => {
        insightsHTML += `
            <div class="insight-card ${insight.type}">
                <div class="insight-header">
                    <div class="insight-icon">
                        <i class="fas fa-${insight.icon}"></i>
                    </div>
                    <h4>${insight.title}</h4>
                </div>
                
                <div class="insight-content">
                    ${insight.content}
                </div>
            </div>
        `;
    });
    
    insightsHTML += `</div>`;
    
    insightsSection.innerHTML = insightsHTML;
}

function generateAIInsights(caseData) {
    const insights = [];
    
    // Completion prediction
    const daysRemaining = Math.floor((new Date(caseData.estimatedCompletion) - new Date()) / (1000 * 60 * 60 * 24));
    insights.push({
        type: 'prediction',
        icon: 'crystal-ball',
        title: 'Completion Prediction',
        content: `
            <div class="prediction-date">
                <span class="date-value">${daysRemaining} days</span>
                <span class="confidence">87% confidence</span>
            </div>
            <p>Based on current progress and historical data, the case is likely to be completed within the estimated timeline.</p>
        `
    });
    
    // Progress analysis
    const expectedProgress = Math.floor(((new Date() - new Date(caseData.submittedDate)) / (new Date(caseData.estimatedCompletion) - new Date(caseData.submittedDate))) * 100);
    insights.push({
        type: 'analysis',
        icon: 'chart-bar',
        title: 'Progress Analysis',
        content: `
            <div class="analysis-stats">
                <div class="stat">
                    <span class="stat-value">${caseData.progressPercentage}%</span>
                    <span class="stat-label">Actual</span>
                </div>
                <div class="stat">
                    <span class="stat-value">${expectedProgress}%</span>
                    <span class="stat-label">Expected</span>
                </div>
            </div>
            <p>${caseData.progressPercentage > expectedProgress ? 
                'Case is progressing ahead of schedule.' : 
                'Case may need additional attention to stay on track.'}</p>
        `
    });
    
    // Recommendations
    let recommendation = '';
    let priority = 'medium';
    
    if (caseData.status === 'pending') {
        recommendation = 'Consider expediting the initial review process to prevent delays.';
        priority = 'high';
    } else if (caseData.progressPercentage < 50 && daysRemaining < 30) {
        recommendation = 'Resource allocation may need to be increased to meet deadline.';
        priority = 'high';
    } else {
        recommendation = 'Case is progressing well. Continue regular monitoring.';
        priority = 'low';
    }
    
    insights.push({
        type: 'recommendation',
        icon: 'lightbulb',
        title: 'AI Recommendation',
        content: `
            <div class="recommendation-priority ${priority}">
                <i class="fas fa-exclamation-triangle"></i>
                ${priority} priority
            </div>
            <p>${recommendation}</p>
        `
    });
    
    return insights;
}

// Communication modal functions
function openCommunication(stakeholderId = null) {
    const modal = document.getElementById('communicationModal');
    if (!modal) {
        createCommunicationModal();
        return;
    }
    
    if (stakeholderId) {
        const stakeholder = sampleStakeholders[currentCase.id]?.find(s => s.id === stakeholderId);
        if (stakeholder) {
            populateCommunicationModal(stakeholder);
        }
    } else {
        // Show general communication interface
        const primaryOfficer = sampleStakeholders[currentCase.id]?.find(s => s.role.includes('Engineer') || s.role.includes('Officer'));
        if (primaryOfficer) {
            populateCommunicationModal(primaryOfficer);
        }
    }
    
    modal.classList.add('show');
    
    // Focus on message input
    setTimeout(() => {
        const messageInput = document.getElementById('message-text');
        if (messageInput) messageInput.focus();
    }, 300);
}

function createCommunicationModal() {
    const modalHTML = `
        <div id="communicationModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Contact Officer</h3>
                    <button class="modal-close" onclick="closeCommunication()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="communication-interface">
                        <!-- Will be populated dynamically -->
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Close modal when clicking outside
    const modal = document.getElementById('communicationModal');
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeCommunication();
        }
    });
}

function populateCommunicationModal(officer) {
    const interface = document.querySelector('.communication-interface');
    if (!interface) return;
    
    interface.innerHTML = `
        <div class="officer-info">
            <div class="officer-avatar">
                ${officer.avatar ? 
                    `<img src="${officer.avatar}" alt="${officer.name}">` :
                    `<div class="avatar-placeholder">
                        <i class="fas fa-user"></i>
                    </div>`
                }
            </div>
            <div class="officer-details">
                <h4>${officer.name}</h4>
                <p>${officer.role} - ${officer.department}</p>
                <div class="contact-info">
                    <span><i class="fas fa-envelope"></i>${officer.email}</span>
                    <span><i class="fas fa-phone"></i>${officer.phone}</span>
                </div>
            </div>
        </div>
        
        <div class="message-composer">
            <div class="message-type-selector">
                <button class="type-btn active" data-type="inquiry">
                    <i class="fas fa-question-circle"></i>
                    <span>Inquiry</span>
                </button>
                <button class="type-btn" data-type="update">
                    <i class="fas fa-info-circle"></i>
                    <span>Update Request</span>
                </button>
                <button class="type-btn" data-type="complaint">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Complaint</span>
                </button>
            </div>
            
            <div class="message-form">
                <textarea id="message-text" placeholder="Type your message here..."></textarea>
                
                <div class="message-actions">
                    <button class="attach-btn">
                        <i class="fas fa-paperclip"></i>
                        <span>Attach File</span>
                    </button>
                    <button class="send-btn" onclick="sendMessage()">
                        <i class="fas fa-paper-plane"></i>
                        <span>Send Message</span>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    // Initialize message type selector
    const typeButtons = interface.querySelectorAll('.type-btn');
    typeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            typeButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });
}

function closeCommunication() {
    const modal = document.getElementById('communicationModal');
    if (modal) {
        modal.classList.remove('show');
    }
}

function sendMessage() {
    const messageText = document.getElementById('message-text');
    const activeType = document.querySelector('.type-btn.active');
    
    if (!messageText || !messageText.value.trim()) {
        showNotification('Message Required', 'Please enter a message', 'warning');
        return;
    }
    
    // Simulate sending message
    showNotification('Message Sent', 'Your message has been sent successfully', 'success');
    
    // Clear form
    messageText.value = '';
    
    // Close modal after delay
    setTimeout(() => {
        closeCommunication();
    }, 1500);
}

// Utility functions
function downloadReport() {
    showNotification('Download Started', 'Generating case report...', 'info');
    
    // Simulate download
    setTimeout(() => {
        showNotification('Download Complete', 'Case report downloaded successfully', 'success');
    }, 2000);
}

function initiateCall(phoneNumber) {
    showNotification('Call Initiated', `Calling ${phoneNumber}...`, 'info');
    
    // In a real app, this would integrate with the device's phone app
    setTimeout(() => {
        showNotification('Call Connected', 'Call connected successfully', 'success');
    }, 1000);
}

function viewTimelineDetails(timelineId) {
    showNotification('Timeline Details', 'Loading detailed timeline information...', 'info');
    
    // This would open a detailed view of the timeline item
    console.log('Viewing timeline details for:', timelineId);
}

// Demo functionality
function loadDemoCase() {
    document.getElementById('trackingId').value = 'TR2024001';
    handleSearch();
}

// Language toggle functionality
function toggleLanguage() {
    const currentLang = document.documentElement.getAttribute('data-lang') || 'en';
    const newLang = currentLang === 'en' ? 'bn' : 'en';
    
    document.documentElement.setAttribute('data-lang', newLang);
    
    // Update all elements with language attributes
    const elements = document.querySelectorAll('[data-en][data-bn]');
    elements.forEach(element => {
        if (newLang === 'bn') {
            element.textContent = element.getAttribute('data-bn');
        } else {
            element.textContent = element.getAttribute('data-en');
        }
    });
    
    // Update language toggle button
    const langToggle = document.querySelector('.lang-toggle');
    if (langToggle) {
        if (newLang === 'bn') {
            langToggle.innerHTML = `
                <span class="flag-icon">🇧🇩</span>
                <span class="lang-label">বাংলা</span>
            `;
        } else {
            langToggle.innerHTML = `
                <span class="flag-icon">🇬🇧</span>
                <span class="lang-label">English</span>
            `;
        }
    }
}

// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    console.log('Advanced Tracking System initialized');
    
    // Initialize search functionality
    initializeSearch();
    
    // Initialize language toggle
    const langToggle = document.querySelector('.lang-toggle');
    if (langToggle) {
        langToggle.addEventListener('click', toggleLanguage);
    }
    
    // Initialize demo button
    const demoBtn = document.querySelector('.demo-btn');
    if (demoBtn) {
        demoBtn.addEventListener('click', loadDemoCase);
    }
    
    // Initialize AOS animations if available
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    }
    
    // Show initial state
    const initialState = document.querySelector('.initial-state');
    const resultsState = document.querySelector('.tracking-results');
    
    if (initialState) initialState.style.display = 'block';
    if (resultsState) resultsState.style.display = 'none';
    
    // Focus on search input
    const searchInput = document.getElementById('trackingId');
    if (searchInput) {
        setTimeout(() => searchInput.focus(), 500);
    }
});

// Export functions for global access
window.trackingApp = {
    handleSearch,
    loadDemoCase,
    openCommunication,
    closeCommunication,
    sendMessage,
    downloadReport,
    filterTimeline,
    toggleLanguage,
    resetSearch
};