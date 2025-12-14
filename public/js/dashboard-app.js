// Dashboard Application JavaScript
class DashboardApp {
    constructor() {
        this.currentLanguage = 'bn';
        this.currentSection = 'dashboard';
        this.notifications = [];
        this.feedbackData = [];
        this.charts = {};
        this.currentUser = null;

        this.init();
    }

    init() {
        this.checkAuth();
        this.initializeLoading();
        this.setupEventListeners();
        this.initializeCharts();
        this.loadDashboardData();
        this.animateKPIValues();

        // Set initial language
        this.updateLanguage();

        console.log('🏛️ Officer Dashboard initialized successfully');
    }

    checkAuth() {
        // Get current user from localStorage
        const userStr = localStorage.getItem('user');
        const isAuthenticated = localStorage.getItem('isAuthenticated');

        if (!userStr || !isAuthenticated) {
            console.log('❌ Not authenticated, redirecting to login');
            window.location.href = '/login';
            return;
        }

        this.currentUser = JSON.parse(userStr);

        // Check if user is accessing the correct dashboard based on role
        const currentPath = window.location.pathname;
        const userRole = this.currentUser.role?.name || localStorage.getItem('userRole') || null;

        console.log('👤 Current user:', this.currentUser.name, '| Role:', userRole, '| Path:', currentPath);

        // Role-based redirect logic - server will also enforce this
        if (userRole) {
            if (userRole === 'admin' && currentPath === '/officer-dashboard') {
                console.log('🔄 Admin accessing officer dashboard, redirecting...');
                window.location.href = '/admin-dashboard';
                return;
            } else if (userRole === 'officer' && currentPath === '/admin-dashboard') {
                console.log('🔄 Officer accessing admin dashboard, redirecting...');
                window.location.href = '/officer-dashboard';
                return;
            } else if (userRole === 'citizen' && (currentPath === '/admin-dashboard' || currentPath === '/officer-dashboard')) {
                console.log('🔄 Citizen accessing wrong dashboard, redirecting...');
                window.location.href = '/citizen-dashboard';
                return;
            }
        }

        this.setupRoleBasedUI();
    }

    setupRoleBasedUI() {
        // Update user info display
        const officerName = document.querySelector('.officer-details h4');
        const officerRole = document.querySelector('.officer-details p');

        if (officerName && this.currentUser.name) {
            officerName.textContent = this.currentUser.name;
        }

        // Show/hide admin-only sections
        const adminNavItems = document.querySelectorAll('.admin-only');
        const isAdmin = this.currentUser.role_id === 1 ||
                       (this.currentUser.role && this.currentUser.role.name === 'admin');

        adminNavItems.forEach(item => {
            if (isAdmin) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });

        // Update role display
        if (officerRole) {
            if (isAdmin) {
                officerRole.textContent = 'System Administrator';
                officerRole.setAttribute('data-en', 'System Administrator');
                officerRole.setAttribute('data-bn', 'সিস্টেম প্রশাসক');
            } else {
                officerRole.textContent = 'Senior Officer';
                officerRole.setAttribute('data-en', 'Senior Officer');
                officerRole.setAttribute('data-bn', 'সিনিয়র কর্মকর্তা');
            }
        }

        console.log('👤 User role:', isAdmin ? 'Admin' : 'Officer');
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

        // Feedback filter controls
        const statusFilter = document.getElementById('status-filter');
        const priorityFilter = document.getElementById('priority-filter');
        const categoryFilter = document.getElementById('category-filter');
        const searchInput = document.getElementById('feedback-search');
        const headerCheckbox = document.getElementById('header-checkbox');

        if (statusFilter) {
            statusFilter.addEventListener('change', () => this.applyFilters());
        }

        if (priorityFilter) {
            priorityFilter.addEventListener('change', () => this.applyFilters());
        }

        if (categoryFilter) {
            categoryFilter.addEventListener('change', () => this.applyFilters());
        }

        if (searchInput) {
            // Debounce search to avoid too many requests
            let searchTimeout;
            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => this.applyFilters(), 500);
            });
        }

        if (headerCheckbox) {
            headerCheckbox.addEventListener('change', (e) => {
                const checkboxes = document.querySelectorAll('input[name="feedback-select"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = e.target.checked;
                });
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

    async loadDashboardData() {
        try {
            console.log('📊 Loading dashboard data...');

            // Fetch all dashboard data in parallel for better performance
            const [statsResponse, feedbackResponse, notificationsResponse, analyticsResponse] = await Promise.all([
                fetch('/api/dashboard/stats', {
                    headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
                    credentials: 'same-origin'
                }),
                fetch('/api/dashboard/recent-feedback', {
                    headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
                    credentials: 'same-origin'
                }),
                fetch('/api/dashboard/notifications', {
                    headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
                    credentials: 'same-origin'
                }).catch(() => ({ ok: false })),
                fetch('/api/dashboard/analytics', {
                    headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
                    credentials: 'same-origin'
                }).catch(() => ({ ok: false }))
            ]);

            // Process statistics
            if (statsResponse.ok) {
                const statsData = await statsResponse.json();
                if (statsData.success) {
                    this.updateDashboardStats(statsData.stats);
                }
            }

            // Process recent feedback
            if (feedbackResponse.ok) {
                const feedbackData = await feedbackResponse.json();
                if (feedbackData.success) {
                    this.feedbackData = feedbackData.feedbacks || [];
                    console.log('✅ Loaded', this.feedbackData.length, 'feedbacks');
                }
            }

            // Process notifications
            if (notificationsResponse.ok) {
                const notificationsData = await notificationsResponse.json();
                if (notificationsData.success) {
                    this.notifications = notificationsData.notifications || [];
                    this.updateNotificationBadge(notificationsData.unread_count || 0);
                    console.log('✅ Loaded', this.notifications.length, 'notifications');
                }
            }

            // Process analytics
            if (analyticsResponse.ok) {
                const analyticsData = await analyticsResponse.json();
                if (analyticsData.success) {
                    this.updateChartData(analyticsData);
                    console.log('✅ Loaded analytics data');
                }
            }

        } catch (error) {
            console.error('❌ Error loading dashboard data:', error);
            this.feedbackData = [];
        }

        this.populateFeedbacksTable();
    }

    updateDashboardStats(stats) {
        // Update KPI cards with real data
        const kpiMapping = {
            'total_feedback': 'total-feedback',
            'pending_feedback': 'pending-feedback',
            'in_progress': 'in-progress',
            'resolved': 'resolved',
            'resolved_today': 'resolved-today',
            'total_users': 'total-users',
            'active_officers': 'active-officers',
            'assigned_to_me': 'assigned-to-me',
            'avg_response_time': 'avg-response-time',
            'satisfaction_rate': 'satisfaction-rate'
        };

        Object.keys(stats).forEach(key => {
            const elementId = kpiMapping[key];
            if (elementId) {
                const element = document.getElementById(elementId);
                if (element) {
                    let value = stats[key];

                    // Format based on data type
                    if (key === 'avg_response_time') {
                        value = parseFloat(value).toFixed(1);
                    } else if (key === 'satisfaction_rate') {
                        value = Math.round(value) + '%';
                    } else {
                        value = Math.round(value);
                    }

                    element.setAttribute('data-count', stats[key]);
                    element.textContent = value;
                }
            }
        });

        // Update KPI values directly from stats
        document.querySelectorAll('.kpi-value').forEach(el => {
            if (el.closest('.kpi-card')) {
                const label = el.nextElementSibling?.textContent.toLowerCase();

                if (label?.includes('pending') && stats.pending_feedback !== undefined) {
                    el.setAttribute('data-count', stats.pending_feedback);
                    el.textContent = stats.pending_feedback;
                } else if (label?.includes('resolved today') && stats.resolved_today !== undefined) {
                    el.setAttribute('data-count', stats.resolved_today);
                    el.textContent = stats.resolved_today;
                } else if (label?.includes('avg response') && stats.avg_response_time !== undefined) {
                    el.textContent = parseFloat(stats.avg_response_time).toFixed(1);
                } else if (label?.includes('satisfaction') && stats.satisfaction_rate !== undefined) {
                    el.setAttribute('data-count', stats.satisfaction_rate);
                    el.textContent = Math.round(stats.satisfaction_rate) + '%';
                }
            }
        });

        console.log('✅ Dashboard stats updated:', stats);
    }

    updateNotificationBadge(count) {
        const badge = document.querySelector('.notification-count');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }
    }

    updateChartData(analyticsData) {
        // Update volume trend chart
        if (analyticsData.trend && this.charts.volumeChart) {
            const labels = analyticsData.trend.map(item => item.date);
            const data = analyticsData.trend.map(item => item.count);

            this.charts.volumeChart.data.labels = labels;
            this.charts.volumeChart.data.datasets[0].data = data;
            this.charts.volumeChart.update();
        }

        // Update category chart
        if (analyticsData.categories && this.charts.categoryChart) {
            const labels = analyticsData.categories.map(item => item.category);
            const data = analyticsData.categories.map(item => item.count);

            this.charts.categoryChart.data.labels = labels;
            this.charts.categoryChart.data.datasets[0].data = data;
            this.charts.categoryChart.update();
        }
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

        const feedbacks = this.feedbackData.length > 0 ? this.feedbackData : [];

        if (feedbacks.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="9" style="text-align: center; padding: 2rem;">
                        <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                        <p style="color: #666;">No feedback found</p>
                    </td>
                </tr>
            `;
            return;
        }

        feedbacks.forEach(feedback => {
            const row = document.createElement('tr');
            const category = feedback.category || 'Unknown';
            const priority = feedback.priority || 'low';
            const status = feedback.status || 'pending';
            const location = feedback.location || 'N/A';
            const createdAt = feedback.created_at ? new Date(feedback.created_at).toLocaleString() : 'N/A';

            row.innerHTML = `
                <td><input type="checkbox" name="feedback-select" value="${feedback.id}"></td>
                <td><strong>${feedback.tracking_id || feedback.id}</strong></td>
                <td>${feedback.title || 'No title'}</td>
                <td>${category}</td>
                <td><span class="priority-badge ${priority.toLowerCase()}">${priority}</span></td>
                <td><span class="status-badge ${status.toLowerCase().replace(' ', '-').replace('_', '-')}">${status.replace('_', ' ')}</span></td>
                <td>${location}</td>
                <td>${createdAt}</td>
                <td>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <button class="btn btn-sm btn-primary" onclick="dashboardApp.viewFeedback('${feedback.id}')" title="View Details">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-success" onclick="dashboardApp.showStatusModal('${feedback.id}', '${status}')" title="Update Status">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <button class="btn btn-sm btn-secondary" onclick="dashboardApp.assignFeedback('${feedback.id}')" title="Assign">
                            <i class="fas fa-user-plus"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    async loadAllFeedbacks(filters = {}) {
        try {
            console.log('📋 Loading all feedbacks...');

            const params = new URLSearchParams({
                per_page: filters.per_page || 10,
                ...(filters.page && { page: filters.page }),
                ...(filters.status && { status: filters.status }),
                ...(filters.priority && { priority: filters.priority }),
                ...(filters.category && { category: filters.category }),
                ...(filters.search && { search: filters.search })
            });

            const response = await fetch(`/api/feedbacks?${params}`, {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                if (data.success) {
                    this.feedbackData = data.feedbacks || [];
                    this.populateFeedbacksTable();
                    console.log('✅ Loaded', this.feedbackData.length, 'feedbacks');

                    // Update pagination if exists
                    if (data.pagination) {
                        this.updatePagination(data.pagination);
                    }
                }
            }
        } catch (error) {
            console.error('❌ Error loading feedbacks:', error);
            this.showNotification('Failed to load feedbacks', 'error');
        }
    }

    applyFilters() {
        const filters = {};

        const statusFilter = document.getElementById('status-filter');
        const priorityFilter = document.getElementById('priority-filter');
        const categoryFilter = document.getElementById('category-filter');
        const searchInput = document.getElementById('feedback-search');

        if (statusFilter && statusFilter.value !== 'all') {
            filters.status = statusFilter.value;
        }

        if (priorityFilter && priorityFilter.value !== 'all') {
            filters.priority = priorityFilter.value;
        }

        if (categoryFilter && categoryFilter.value !== 'all') {
            filters.category = categoryFilter.value;
        }

        if (searchInput && searchInput.value.trim()) {
            filters.search = searchInput.value.trim();
        }

        console.log('🔍 Applying filters:', filters);
        this.loadAllFeedbacks(filters);
    }

    updatePagination(pagination) {
        const paginationInfo = document.querySelector('.pagination-info span');
        const paginationControls = document.querySelector('.pagination-controls');

        if (!pagination) return;

        // Update pagination info text
        if (paginationInfo) {
            const { from, to, total } = pagination;
            paginationInfo.textContent = `Showing ${from || 0}-${to || 0} of ${total || 0} results`;
        }

        // Update pagination controls
        if (paginationControls) {
            paginationControls.innerHTML = '';

            const { current_page, last_page } = pagination;

            // Previous button
            const prevBtn = document.createElement('button');
            prevBtn.className = 'page-btn';
            prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
            prevBtn.disabled = current_page === 1;
            prevBtn.onclick = () => {
                const filters = this.getCurrentFilters();
                filters.page = current_page - 1;
                this.loadAllFeedbacks(filters);
            };
            paginationControls.appendChild(prevBtn);

            // Page numbers (show max 5 pages)
            const startPage = Math.max(1, current_page - 2);
            const endPage = Math.min(last_page, current_page + 2);

            for (let i = startPage; i <= endPage; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.className = 'page-btn' + (i === current_page ? ' active' : '');
                pageBtn.textContent = i;
                pageBtn.onclick = () => {
                    const filters = this.getCurrentFilters();
                    filters.page = i;
                    this.loadAllFeedbacks(filters);
                };
                paginationControls.appendChild(pageBtn);
            }

            // Next button
            const nextBtn = document.createElement('button');
            nextBtn.className = 'page-btn';
            nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
            nextBtn.disabled = current_page === last_page;
            nextBtn.onclick = () => {
                const filters = this.getCurrentFilters();
                filters.page = current_page + 1;
                this.loadAllFeedbacks(filters);
            };
            paginationControls.appendChild(nextBtn);
        }
    }

    getCurrentFilters() {
        const filters = {};

        const statusFilter = document.getElementById('status-filter');
        const priorityFilter = document.getElementById('priority-filter');
        const categoryFilter = document.getElementById('category-filter');
        const searchInput = document.getElementById('feedback-search');

        if (statusFilter && statusFilter.value !== 'all') {
            filters.status = statusFilter.value;
        }

        if (priorityFilter && priorityFilter.value !== 'all') {
            filters.priority = priorityFilter.value;
        }

        if (categoryFilter && categoryFilter.value !== 'all') {
            filters.category = categoryFilter.value;
        }

        if (searchInput && searchInput.value.trim()) {
            filters.search = searchInput.value.trim();
        }

        return filters;
    }

    async updateFeedbackStatus(feedbackId, newStatus) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const response = await fetch(`/api/feedbacks/${feedbackId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || ''
                },
                credentials: 'same-origin',
                body: JSON.stringify({ status: newStatus })
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification('Feedback status updated successfully', 'success');

                // Update local data
                const feedbackIndex = this.feedbackData.findIndex(f => f.id == feedbackId);
                if (feedbackIndex !== -1) {
                    this.feedbackData[feedbackIndex] = data.feedback;
                }

                // Refresh table
                this.populateFeedbacksTable();

                // Reload dashboard stats
                this.loadDashboardData();
            } else {
                this.showNotification(data.message || 'Failed to update status', 'error');
            }
        } catch (error) {
            console.error('❌ Error updating status:', error);
            this.showNotification('Failed to update feedback status', 'error');
        }
    }

    showStatusModal(feedbackId, currentStatus) {
        console.log('✏️ Opening status update modal for feedback:', feedbackId);

        // Set feedback ID in hidden field
        document.getElementById('status-feedback-id').value = feedbackId;

        // Set current status
        const statusSelect = document.getElementById('status-select');
        if (statusSelect) {
            // Convert status format
            const normalizedStatus = currentStatus.toLowerCase().replace(' ', '-').replace('_', '-');
            statusSelect.value = normalizedStatus;
        }

        // Reset comment
        document.getElementById('status-comment').value = '';

        // Show modal
        this.showModal('status-update-modal');
    }

    async confirmStatusUpdate() {
        try {
            const feedbackId = document.getElementById('status-feedback-id').value;
            const newStatus = document.getElementById('status-select').value;
            const comment = document.getElementById('status-comment').value;

            if (!newStatus) {
                this.showNotification('Please select a status', 'warning');
                return;
            }

            // Disable button to prevent double submission
            const updateBtn = document.getElementById('status-update-btn');
            updateBtn.disabled = true;
            updateBtn.innerHTML = '<i class=\"fas fa-spinner fa-spin\"></i> Updating...';

            const csrfToken = document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content');

            const payload = {
                status: newStatus,
                comment: comment || null
            };

            const response = await fetch(`/api/feedbacks/${feedbackId}/status`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || ''
                },
                credentials: 'include',
                body: JSON.stringify(payload)
            });

            if (!response.ok && (response.status === 401 || response.status === 403)) {
                this.showNotification('Please login to continue', 'error');
                setTimeout(() => window.location.href = '/login', 2000);
                return;
            }

            const data = await response.json();

            if (response.ok) {
                this.showNotification('Status updated successfully!', 'success');

                // Update local data if feedback exists
                const feedbackIndex = this.feedbackData.findIndex(f => f.id == feedbackId);
                if (feedbackIndex !== -1 && data.feedback) {
                    this.feedbackData[feedbackIndex] = data.feedback;
                } else if (feedbackIndex !== -1) {
                    this.feedbackData[feedbackIndex].status = newStatus;
                }

                // Close modal
                this.closeModal('status-update-modal');

                // Refresh table and dashboard
                this.populateFeedbacksTable();
                this.loadDashboardData();
            } else {
                throw new Error(data.message || 'Failed to update status');
            }
        } catch (error) {
            console.error('❌ Error updating status:', error);
            this.showNotification(error.message || 'Failed to update feedback status', 'error');
        } finally {
            // Re-enable button
            const updateBtn = document.getElementById('status-update-btn');
            updateBtn.disabled = false;
            updateBtn.innerHTML = '<i class=\"fas fa-check\"></i> Update Status';
        }
    }

    populateNotifications() {
        const notificationList = document.querySelector('.notification-list');
        if (!notificationList || this.notifications.length === 0) return;

        notificationList.innerHTML = '';

        this.notifications.forEach(notification => {
            const notifItem = document.createElement('div');
            notifItem.className = `notification-item ${!notification.is_read ? 'unread' : ''}`;

            const iconClass = notification.type === 'warning' ? 'fa-exclamation-triangle text-warning' :
                            notification.type === 'success' ? 'fa-check-circle text-success' :
                            notification.type === 'info' ? 'fa-info-circle text-info' :
                            'fa-bell text-primary';

            const timeAgo = this.getTimeAgo(notification.created_at);

            notifItem.innerHTML = `
                <div class="notification-icon">
                    <i class="fas ${iconClass}"></i>
                </div>
                <div class="notification-content">
                    <p>${notification.message}</p>
                    <small>${timeAgo}</small>
                </div>
            `;

            notificationList.appendChild(notifItem);
        });
    }

    populateActivityLogs(logs) {
        const activityList = document.querySelector('.activity-list');
        if (!activityList || logs.length === 0) return;

        activityList.innerHTML = '';

        logs.slice(0, 10).forEach(log => {
            const activityItem = document.createElement('div');
            activityItem.className = 'activity-item';

            const timeAgo = this.getTimeAgo(log.created_at);

            activityItem.innerHTML = `
                <div class="activity-icon">
                    <i class="fas fa-circle"></i>
                </div>
                <div class="activity-content">
                    <p><strong>${log.user?.name || 'User'}</strong> ${log.action}</p>
                    <small>${timeAgo}</small>
                </div>
            `;

            activityList.appendChild(activityItem);
        });
    }

    populateAIInsights(insights) {
        const insightsContainer = document.querySelector('.ai-insights-list');
        if (!insightsContainer || insights.length === 0) return;

        insightsContainer.innerHTML = '';

        insights.forEach(insight => {
            const insightItem = document.createElement('div');
            insightItem.className = 'ai-insight-item';

            const sentiment = insight.sentiment || 'neutral';
            const sentimentClass = sentiment === 'positive' ? 'success' :
                                  sentiment === 'negative' ? 'danger' :
                                  'warning';

            insightItem.innerHTML = `
                <div class="insight-header">
                    <span class="insight-badge ${sentimentClass}">${sentiment}</span>
                    <small>${this.getTimeAgo(insight.created_at)}</small>
                </div>
                <p class="insight-summary">${insight.summary || ''}</p>
                <div class="insight-tags">
                    ${insight.category ? `<span class="tag">${insight.category}</span>` : ''}
                    ${insight.priority ? `<span class="tag">${insight.priority}</span>` : ''}
                </div>
            `;

            insightsContainer.appendChild(insightItem);
        });
    }

    getTimeAgo(dateString) {
        if (!dateString) return '';

        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);

        if (seconds < 60) return 'Just now';
        if (seconds < 3600) return `${Math.floor(seconds / 60)} minutes ago`;
        if (seconds < 86400) return `${Math.floor(seconds / 3600)} hours ago`;
        if (seconds < 604800) return `${Math.floor(seconds / 86400)} days ago`;

        return date.toLocaleDateString();
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
    async viewFeedback(feedbackId) {
        try {
            console.log('📋 Loading feedback details:', feedbackId);

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const response = await fetch(`/api/feedbacks/${feedbackId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || ''
                },
                credentials: 'include'
            });

            if (!response.ok) {
                if (response.status === 401 || response.status === 403) {
                    this.showNotification('Please login to continue', 'error');
                    setTimeout(() => window.location.href = '/login', 2000);
                    return;
                }
                throw new Error('Failed to load feedback');
            }

            const feedback = await response.json();
            console.log('✅ Feedback loaded:', feedback);

            // Populate basic information
            document.getElementById('modal-feedback-id').textContent = `#${feedback.id}`;
            document.getElementById('modal-tracking-id').textContent = feedback.tracking_id || `FB-${feedback.id}`;
            document.getElementById('modal-title').textContent = feedback.title || 'No title';
            document.getElementById('modal-category').textContent = feedback.category || 'Unknown';
            document.getElementById('modal-priority').textContent = (feedback.priority || 'low').toUpperCase();
            document.getElementById('modal-priority').className = `priority-badge ${(feedback.priority || 'low').toLowerCase()}`;

            const statusText = (feedback.status || 'pending').replace('_', ' ').replace('-', ' ');
            document.getElementById('modal-status').textContent = statusText.charAt(0).toUpperCase() + statusText.slice(1);
            document.getElementById('modal-status').className = `status-badge ${(feedback.status || 'pending').toLowerCase().replace(' ', '-').replace('_', '-')}`;

            document.getElementById('modal-location').textContent = feedback.location || 'N/A';
            document.getElementById('modal-date').textContent = feedback.created_at ? new Date(feedback.created_at).toLocaleString() : 'N/A';
            document.getElementById('modal-description').textContent = feedback.description || 'No detailed description available.';

            // Show reporter information if available
            const reporterSection = document.getElementById('modal-reporter-section');
            if (feedback.reporter || feedback.user_id) {
                reporterSection.style.display = 'block';
                const reporter = feedback.reporter || {};
                document.getElementById('modal-reporter-name').textContent = reporter.name || 'Anonymous';
                document.getElementById('modal-reporter-email').textContent = reporter.email || 'N/A';
            } else {
                reporterSection.style.display = 'none';
            }

            // Show assignee information if available
            const assigneeSection = document.getElementById('modal-assignee-section');
            if (feedback.assignee || feedback.assigned_to) {
                assigneeSection.style.display = 'block';
                const assignee = feedback.assignee || {};
                document.getElementById('modal-assignee-name').textContent = assignee.name || 'N/A';
                document.getElementById('modal-assignee-dept').textContent = assignee.department || 'N/A';
            } else {
                assigneeSection.style.display = 'none';
            }

            // Show attachments if available
            const attachmentsSection = document.getElementById('modal-attachments-section');
            const attachmentsContainer = document.getElementById('modal-attachments');
            if (feedback.attachments && feedback.attachments.length > 0) {
                attachmentsSection.style.display = 'block';
                attachmentsContainer.innerHTML = feedback.attachments.map(file => {
                    const isImage = /\\.(jpg|jpeg|png|gif|webp)$/i.test(file);
                    if (isImage) {
                        return `<div class="attachment-item"><img src="${file}" alt="Attachment" style="max-width: 200px; border-radius: 8px; margin: 0.5rem;"></div>`;
                    } else {
                        return `<div class="attachment-item"><a href="${file}" target="_blank" style="color: #4299e1;"><i class="fas fa-file"></i> ${file.split('/').pop()}</a></div>`;
                    }
                }).join('');
            } else {
                attachmentsSection.style.display = 'none';
            }

            // Show AI insights if available
            const aiSection = document.getElementById('modal-ai-section');
            const aiContent = document.getElementById('modal-ai-content');
            if (feedback.aiInsight || feedback.ai_insight) {
                const aiInsight = feedback.aiInsight || feedback.ai_insight || {};
                document.getElementById('modal-ai-confidence').textContent = aiInsight.confidence ? `${aiInsight.confidence}%` : 'N/A';
                document.getElementById('modal-ai-category').textContent = aiInsight.suggested_category || 'N/A';
                document.getElementById('modal-ai-priority').textContent = aiInsight.suggested_priority || 'N/A';
                document.getElementById('modal-ai-summary').textContent = aiInsight.summary || 'No AI analysis available';
            } else {
                document.getElementById('modal-ai-confidence').textContent = 'N/A';
                document.getElementById('modal-ai-category').textContent = 'N/A';
                document.getElementById('modal-ai-priority').textContent = 'N/A';
                document.getElementById('modal-ai-summary').textContent = 'No AI analysis available yet';
            }

            // Show modal
            this.showModal('feedback-detail-modal');
        } catch (error) {
            console.error('❌ Error viewing feedback:', error);
            this.showNotification('Error loading feedback details', 'error');
        }
    }

    async assignFeedback(feedbackId) {
        try {
            console.log('👤 Opening assignment modal for feedback:', feedbackId);

            // Set feedback ID in hidden field
            document.getElementById('assign-feedback-id').value = feedbackId;

            // Load staff members
            await this.loadStaffMembers();

            // Reset form
            document.getElementById('assign-person-form').reset();
            document.getElementById('assign-feedback-id').value = feedbackId;
            document.getElementById('assign-department').value = '';

            // Show modal
            this.showModal('assign-person-modal');
        } catch (error) {
            console.error('❌ Error opening assignment modal:', error);
            this.showNotification('Error loading assignment form', 'error');
        }
    }

    async loadStaffMembers() {
        try {
            const csrfToken = document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content');
            const response = await fetch('/api/users', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || ''
                },
                credentials: 'include'
            });

            if (!response.ok) {
                if (response.status === 401 || response.status === 403) {
                    this.showNotification('Please login to continue', 'error');
                    setTimeout(() => window.location.href = '/login', 2000);
                    return;
                }
                throw new Error('Failed to load staff members');
            }

            const data = await response.json();
            const users = data.data || data;

            // Filter for staff/officers (role_id 2 or 3)
            const staffMembers = users.filter(user => user.role_id === 2 || user.role_id === 3 || (user.role && (user.role.name === 'officer' || user.role.name === 'staff')));

            console.log('✅ Loaded staff members:', staffMembers.length);

            // Populate select dropdown
            const selectElement = document.getElementById('assign-to-select');
            selectElement.innerHTML = '<option value=\"\">-- Select Staff Member --</option>';

            staffMembers.forEach(staff => {
                const option = document.createElement('option');
                option.value = staff.id;
                option.textContent = `${staff.name}${staff.department ? ' - ' + staff.department : ''}`;
                option.dataset.department = staff.department || '';
                selectElement.appendChild(option);
            });

            // Update department when staff is selected
            selectElement.addEventListener('change', (e) => {
                const selectedOption = e.target.selectedOptions[0];
                const department = selectedOption?.dataset.department || '';
                document.getElementById('assign-department').value = department;
            });
        } catch (error) {
            console.error('❌ Error loading staff members:', error);
            const selectElement = document.getElementById('assign-to-select');
            selectElement.innerHTML = '<option value=\"\">-- Error loading staff --</option>';
            this.showNotification('Could not load staff members', 'warning');
        }
    }

    async confirmAssignment() {
        try {
            const feedbackId = document.getElementById('assign-feedback-id').value;
            const assignedTo = document.getElementById('assign-to-select').value;
            const priority = document.getElementById('assign-priority').value;
            const deadline = document.getElementById('assign-deadline').value;
            const note = document.getElementById('assign-note').value;

            if (!assignedTo) {
                this.showNotification('Please select a staff member', 'warning');
                return;
            }

            // Disable button to prevent double submission
            const assignBtn = document.getElementById('assign-person-btn');
            assignBtn.disabled = true;
            assignBtn.innerHTML = '<i class=\"fas fa-spinner fa-spin\"></i> Assigning...';

            const csrfToken = document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content');

            const payload = {
                assigned_to: assignedTo,
                note: note || null,
                priority: priority || null,
                deadline: deadline || null
            };

            const response = await fetch(`/api/feedbacks/${feedbackId}/assign`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || ''
                },
                credentials: 'include',
                body: JSON.stringify(payload)
            });

            if (!response.ok && (response.status === 401 || response.status === 403)) {
                this.showNotification('Please login to continue', 'error');
                setTimeout(() => window.location.href = '/login', 2000);
                return;
            }

            const data = await response.json();

            if (response.ok) {
                this.showNotification('Feedback assigned successfully!', 'success');

                // Update local data if feedback exists
                const feedbackIndex = this.feedbackData.findIndex(f => f.id == feedbackId);
                if (feedbackIndex !== -1 && data.feedback) {
                    this.feedbackData[feedbackIndex] = data.feedback;
                }

                // Close modal
                this.closeModal('assign-person-modal');

                // Refresh table and dashboard
                this.populateFeedbacksTable();
                this.loadDashboardData();
            } else {
                throw new Error(data.message || 'Failed to assign feedback');
            }
        } catch (error) {
            console.error('❌ Error assigning feedback:', error);
            this.showNotification(error.message || 'Failed to assign feedback', 'error');
        } finally {
            // Re-enable button
            const assignBtn = document.getElementById('assign-person-btn');
            assignBtn.disabled = false;
            assignBtn.innerHTML = '<i class=\"fas fa-user-check\"></i> Assign Feedback';
        }
    }

    async bulkAssign() {
        try {
            const selected = document.querySelectorAll('input[name="feedback-select"]:checked');
            if (selected.length === 0) {
                this.showNotification('Please select at least one feedback', 'warning');
                return;
            }

            const assigneeId = prompt('Enter assignee user ID:');
            if (!assigneeId) return;

            if (api && api.getToken()) {
                const feedbackIds = Array.from(selected).map(cb => cb.value);

                // Assign each feedback
                for (const feedbackId of feedbackIds) {
                    await api.assignFeedback(feedbackId, assigneeId);
                }

                this.showNotification(`${selected.length} feedback(s) assigned successfully!`, 'success');
                await this.loadDashboardData();
            } else {
                this.showNotification('Please log in to assign feedbacks', 'error');
            }
        } catch (error) {
            console.error('Error bulk assigning feedbacks:', error);
            this.showNotification('Error assigning feedbacks', 'error');
        }
    }

    async bulkUpdateStatus() {
        try {
            const selected = document.querySelectorAll('input[name="feedback-select"]:checked');
            if (selected.length === 0) {
                this.showNotification('Please select at least one feedback', 'warning');
                return;
            }

            const newStatus = prompt('Enter new status (pending, in_progress, resolved, closed):');
            if (!newStatus) return;

            if (api && api.getToken()) {
                const feedbackIds = Array.from(selected).map(cb => cb.value);

                // Update status for each feedback
                for (const feedbackId of feedbackIds) {
                    await api.updateFeedbackStatus(feedbackId, newStatus);
                }

                this.showNotification(`Status updated for ${selected.length} feedback(s)!`, 'success');
                await this.loadDashboardData();
            } else {
                this.showNotification('Please log in to update feedbacks', 'error');
            }
        } catch (error) {
            console.error('Error bulk updating status:', error);
            this.showNotification('Error updating feedback status', 'error');
        }
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
            modal.style.display = 'flex';
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';

            // Add backdrop click to close
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    this.closeModal(modalId);
                }
            });
        }
    }

    closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
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
        if (!confirm('Are you sure you want to logout?')) {
            return;
        }

        console.log('🚪 Logging out...');
        this.showNotification('Logging out...', 'info');

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch('/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken || ''
            },
            credentials: 'same-origin'
        })
        .then(res => res.json())
        .then(response => {
            // Clear local storage
            localStorage.removeItem('user');
            localStorage.removeItem('userRole');
            localStorage.removeItem('isAuthenticated');
            localStorage.removeItem('auth_token');

            console.log('✅ Logged out successfully');
            window.location.href = '/login';
        })
        .catch(error => {
            console.error('❌ Logout error:', error);
            // Clear local storage anyway
            localStorage.removeItem('user');
            localStorage.removeItem('userRole');
            localStorage.removeItem('isAuthenticated');
            localStorage.removeItem('auth_token');
            window.location.href = '/login';
        });
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
