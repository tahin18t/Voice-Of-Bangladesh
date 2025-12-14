<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Officer Dashboard - AI-Powered Governance | CFPIP Bangladesh</title>
    <meta name="description" content="Advanced officer dashboard with AI-powered insights, workflow management, and real-time analytics for government officials.">
    
    <!-- Government Portal Meta Tags -->
    <meta name="keywords" content="Officer Dashboard, AI Analytics, Government Workflow, Bangladesh Ministry, Policy Intelligence">
    <meta name="author" content="Government of Bangladesh">
    <meta property="og:title" content="AI-Powered Officer Dashboard | CFPIP">
    <meta property="og:description" content="Enterprise-grade dashboard for government officers with AI insights and workflow management.">
    
    <!-- Government Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Bengali:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    
    <!-- Charts and Data Visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏛️</text></svg>">
    
    <link rel="stylesheet" href="{{ asset('css/modern-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/executive-styles.css') }}">
</head>

<body class="dashboard-body">
    <!-- Loading Screen -->
    <div id="loader" class="loader-overlay">
        <div class="loader-container">
            <div class="govt-logo">
                <div class="logo-emblem">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="logo-text">
                    <h3 data-en="Officer Dashboard" data-bn="কর্মকর্তা ড্যাশবোর্ড">Officer Dashboard</h3>
                    <p data-en="Loading AI Analytics..." data-bn="AI অ্যানালিটিক্স লোড হচ্ছে...">Loading AI Analytics...</p>
                </div>
            </div>
            <div class="loading-progress">
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <p class="loading-text" data-en="Initializing intelligent workflow system..." data-bn="বুদ্ধিমান ওয়ার্কফ্লো সিস্টেম চালু হচ্ছে...">Initializing intelligent workflow system...</p>
            </div>
        </div>
    </div>

    <!-- Dashboard Layout -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <div class="brand-logo">
                        <i class="fas fa-landmark"></i>
                        <span class="brand-text">VOBD</span>
                    </div>
                </div>
                <div class="officer-info">
                    <div class="officer-avatar">
                        <img src="{{ asset('image/tahin.jpg') }}" alt="Officer" class="avatar-img">
                        <div class="status-indicator online"></div>
                    </div>
                    <div class="officer-details">
                        <h4 class="officer-name" data-en="" data-bn=""></h4>
                        <p class="officer-role" data-en="" data-bn=""></p>
                        <small class="officer-department" data-en="" data-bn=""></small>
                    </div>
                </div>
            </div>
                <button class="sidebar-toggle" id="sidebar-toggle" aria-label="Toggle sidebar">
                    <i class="fas fa-bars"></i>
                </button>

            <nav class="sidebar-nav">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="#dashboard" class="nav-link active" onclick="showDashboardSection('dashboard')">
                            <i class="fas fa-tachometer-alt"></i>
                            <span data-en="Dashboard" data-bn="ড্যাশবোর্ড">Dashboard</span>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#feedbacks" class="nav-link" onclick="showDashboardSection('feedbacks')">
                            <i class="fas fa-comments"></i>
                            <span data-en="My Feedbacks" data-bn="আমার মতামত">My Feedbacks</span>
                            <div class="notification-badge">12</div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#governance" class="nav-link" onclick="showDashboardSection('governance')">
                            <i class="fas fa-brain"></i>
                            <span data-en="Intelligent Governance" data-bn="বুদ্ধিমান শাসন">Intelligent Governance</span>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                </ul>

                <div class="sidebar-footer">
                    <div class="quick-stats">
                        <div class="quick-stat">
                            <i class="fas fa-clock"></i>
                            <div class="stat-info">
                                <span class="stat-number">2.3</span>
                                <span class="stat-label" data-en="Avg Response" data-bn="গড় প্রতিক্রিয়া">Avg Response</span>
                            </div>
                        </div>
                        <div class="quick-stat">
                            <i class="fas fa-check-circle"></i>
                            <div class="stat-info">
                                <span class="stat-number">94%</span>
                                <span class="stat-label" data-en="Success Rate" data-bn="সফলতার হার">Success Rate</span>
                            </div>
                        </div>
                    </div>
                    
                    <button class="logout-btn" onclick="logout()">
                        <i class="fas fa-sign-out-alt"></i>
                        <span data-en="Logout" data-bn="লগআউট">Logout</span>
                    </button>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="topbar">
                <div class="topbar-left">
                    <button class="mobile-sidebar-toggle" id="mobile-sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="page-title">
                        <h1 id="current-page-title" data-en="Dashboard Overview" data-bn="ড্যাশবোর্ড ওভারভিউ">Dashboard Overview</h1>
                        <p id="current-page-subtitle" data-en="AI-powered insights and workflow management" data-bn="AI-চালিত অন্তর্দৃষ্টি এবং ওয়ার্কফ্লো ব্যবস্থাপনা">AI-powered insights and workflow management</p>
                    </div>
                </div>

                <div class="topbar-right">
                    <!-- Real-time Notifications -->
                    <div class="notification-center">
                        <button class="notification-btn" onclick="toggleNotifications()">
                            <i class="fas fa-bell"></i>
                            <span class="notification-count">5</span>
                        </button>
                        <div class="notification-dropdown" id="notification-dropdown">
                            <div class="notification-header">
                                <h4 data-en="Recent Notifications" data-bn="সাম্প্রতিক বিজ্ঞপ্তি">Recent Notifications</h4>
                                <button class="mark-all-read" data-en="Mark all read" data-bn="সব পড়া হয়েছে">Mark all read</button>
                            </div>
                            <div class="notification-list">
                                <div class="notification-item unread">
                                    <div class="notification-icon">
                                        <i class="fas fa-exclamation-triangle text-warning"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p data-en="High priority feedback requires immediate attention" data-bn="উচ্চ অগ্রাধিকারের মতামত তাৎক্ষণিক মনোযোগ প্রয়োজন">High priority feedback requires immediate attention</p>
                                        <small>2 minutes ago</small>
                                    </div>
                                </div>
                                <div class="notification-item unread">
                                    <div class="notification-icon">
                                        <i class="fas fa-robot text-primary"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p data-en="AI has identified a trending issue pattern" data-bn="AI একটি ট্রেন্ডিং সমস্যার প্যাটার্ন চিহ্নিত করেছে">AI has identified a trending issue pattern</p>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                                <div class="notification-item">
                                    <div class="notification-icon">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p data-en="Weekly performance report is ready" data-bn="সাপ্তাহিক কর্মক্ষমতা রিপোর্ট প্রস্তুত">Weekly performance report is ready</p>
                                        <small>1 hour ago</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <!-- <div class="quick-actions"> -->
                        <button class="lang-switch" onclick="toggleLanguage()">
                            <span class="flag-icon">🇧🇩</span>
                            <span class="lang-text" id="lang-display">বাংলা</span>
                        </button>
                        <button class="quick-action-btn" onclick="generateReport()" data-en="Generate Report" data-bn="রিপোর্ট তৈরি করুন">
                            <i class="fas fa-file-export"></i>
                        </button>
                        <button class="quick-action-btn" onclick="refreshData()" data-en="Refresh Data" data-bn="ডেটা রিফ্রেশ করুন">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    <!-- </div> -->
                </div>
            </header>

            <!-- Dashboard Sections -->
            <div class="content-area">
                <!-- Dashboard Overview -->
                <section id="dashboard-section" class="dashboard-section active">
                    <!-- KPI Cards -->
                    <div class="kpi-grid" data-aos="fade-up">
                        <div class="kpi-card">
                            <div class="kpi-header">
                                <div class="kpi-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <div class="kpi-actions">
                                    <button class="kpi-action" onclick="viewDetails('pending')">
                                        <i class="fas fa-external-link-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="kpi-content">
                                <h3 class="kpi-value" data-count="47">0</h3>
                                <p class="kpi-label" data-en="Pending Reviews" data-bn="পেন্ডিং রিভিউ">Pending Reviews</p>
                                <div class="kpi-trend positive">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+12% from yesterday</span>
                                </div>
                            </div>
                        </div>

                        <div class="kpi-card">
                            <div class="kpi-header">
                                <div class="kpi-icon success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="kpi-actions">
                                    <button class="kpi-action" onclick="viewDetails('resolved')">
                                        <i class="fas fa-external-link-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="kpi-content">
                                <h3 class="kpi-value" data-count="234">0</h3>
                                <p class="kpi-label" data-en="Resolved Today" data-bn="আজ সমাধান">Resolved Today</p>
                                <div class="kpi-trend positive">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+8% from yesterday</span>
                                </div>
                            </div>
                        </div>

                        <div class="kpi-card">
                            <div class="kpi-header">
                                <div class="kpi-icon warning">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="kpi-actions">
                                    <button class="kpi-action" onclick="viewDetails('overdue')">
                                        <i class="fas fa-external-link-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="kpi-content">
                                <h3 class="kpi-value">2.3</h3>
                                <p class="kpi-label" data-en="Avg Response (days)" data-bn="গড় প্রতিক্রিয়া (দিন)">Avg Response (days)</p>
                                <div class="kpi-trend negative">
                                    <i class="fas fa-arrow-down"></i>
                                    <span>-0.2 days improved</span>
                                </div>
                            </div>
                        </div>

                        <div class="kpi-card">
                            <div class="kpi-header">
                                <div class="kpi-icon info">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="kpi-actions">
                                    <button class="kpi-action" onclick="viewDetails('satisfaction')">
                                        <i class="fas fa-external-link-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="kpi-content">
                                <h3 class="kpi-value" data-count="94">0%</h3>
                                <p class="kpi-label" data-en="Satisfaction Rate" data-bn="সন্তুষ্টির হার">Satisfaction Rate</p>
                                <div class="kpi-trend positive">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+3% this week</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AI Insights Panel -->
                    <div class="insights-container" data-aos="fade-up" data-aos-delay="100">
                        <div class="ai-insights-panel">
                            <div class="panel-header">
                                <h3>
                                    <i class="fas fa-robot"></i>
                                    <span data-en="AI Intelligence Center" data-bn="AI ইন্টেলিজেন্স সেন্টার">AI Intelligence Center</span>
                                </h3>
                                <div class="panel-actions">
                                    <button class="panel-action" onclick="refreshAIInsights()">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                    <button class="panel-action" onclick="expandAIPanel()">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="ai-insights-grid">
                                <div class="ai-insight-card priority-high">
                                    <div class="insight-header">
                                        <div class="insight-icon">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <div class="insight-priority">HIGH PRIORITY</div>
                                    </div>
                                    <div class="insight-content">
                                        <h4 data-en="Critical Infrastructure Alert" data-bn="গুরুত্বপূর্ণ অবকাঠামো সতর্কতা">Critical Infrastructure Alert</h4>
                                        <p data-en="AI detected 340% spike in road quality complaints in Chittagong division. Recommend immediate site inspection." data-bn="AI চট্টগ্রাম বিভাগে সড়কের মানের অভিযোগ ৩৪০% বৃদ্ধি সনাক্ত করেছে। তাৎক্ষণিক সাইট পরিদর্শনের সুপারিশ।">AI detected 340% spike in road quality complaints in Chittagong division. Recommend immediate site inspection.</p>
                                        <div class="insight-actions">
                                            <button class="insight-btn primary" onclick="takeAction('infrastructure')">Take Action</button>
                                            <button class="insight-btn secondary" onclick="viewDetails('infrastructure')">View Details</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="ai-insight-card priority-medium">
                                    <div class="insight-header">
                                        <div class="insight-icon">
                                            <i class="fas fa-lightbulb"></i>
                                        </div>
                                        <div class="insight-priority">RECOMMENDATION</div>
                                    </div>
                                    <div class="insight-content">
                                        <h4 data-en="Process Optimization Opportunity" data-bn="প্রক্রিয়া অপ্টিমাইজেশন সুযোগ">Process Optimization Opportunity</h4>
                                        <p data-en="Pattern analysis suggests implementing mobile inspection units could reduce response time by 45% for rural areas." data-bn="প্যাটার্ন বিশ্লেষণ পরামর্শ দেয় যে মোবাইল পরিদর্শন ইউনিট বাস্তবায়ন গ্রামীণ এলাকার জন্য প্রতিক্রিয়ার সময় ৪৫% কমাতে পারে।">Pattern analysis suggests implementing mobile inspection units could reduce response time by 45% for rural areas.</p>
                                        <div class="insight-actions">
                                            <button class="insight-btn primary" onclick="implementSuggestion('mobile-units')">Implement</button>
                                            <button class="insight-btn secondary" onclick="viewAnalysis('mobile-units')">View Analysis</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="ai-insight-card priority-low">
                                    <div class="insight-header">
                                        <div class="insight-icon">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <div class="insight-priority">TREND ANALYSIS</div>
                                    </div>
                                    <div class="insight-content">
                                        <h4 data-en="Positive Feedback Trend" data-bn="ইতিবাচক মতামত প্রবণতা">Positive Feedback Trend</h4>
                                        <p data-en="Citizen satisfaction increased 23% following implementation of digital tracking system. Continue current approach." data-bn="ডিজিটাল ট্র্যাকিং সিস্টেম বাস্তবায়নের পর নাগরিক সন্তুষ্টি ২৩% বৃদ্ধি পেয়েছে। বর্তমান পদ্ধতি অব্যাহত রাখুন।">Citizen satisfaction increased 23% following implementation of digital tracking system. Continue current approach.</p>
                                        <div class="insight-actions">
                                            <button class="insight-btn secondary" onclick="viewTrend('satisfaction')">View Trend</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Charts -->
                        <div class="charts-container">
                            <div class="chart-card">
                                <div class="chart-header">
                                    <h4 data-en="Feedback Volume Trend" data-bn="মতামত ভলিউম ট্রেন্ড">Feedback Volume Trend</h4>
                                    <div class="chart-controls">
                                        <select id="volume-timeframe">
                                            <option value="7d">Last 7 Days</option>
                                            <option value="30d">Last 30 Days</option>
                                            <option value="3m">Last 3 Months</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="chart-container">
                                    <canvas id="volumeTrendChart"></canvas>
                                </div>
                            </div>

                            <div class="chart-card">
                                <div class="chart-header">
                                    <h4 data-en="Category Distribution" data-bn="বিভাগ বিতরণ">Category Distribution</h4>
                                </div>
                                <div class="chart-container">
                                    <canvas id="categoryChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="activity-section" data-aos="fade-up" data-aos-delay="200">
                        <div class="section-header">
                            <h3 data-en="Recent Activity" data-bn="সাম্প্রতিক কার্যকলাপ">Recent Activity</h3>
                            <button class="section-action" onclick="viewAllActivity()">
                                <span data-en="View All" data-bn="সব দেখুন">View All</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                        
                        <div class="activity-timeline">
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-comment-dots"></i>
                                </div>
                                <div class="activity-content">
                                    <h5 data-en="New high-priority feedback assigned" data-bn="নতুন উচ্চ অগ্রাধিকার মতামত বরাদ্দ">New high-priority feedback assigned</h5>
                                    <p data-en="Road damage complaint from Chittagong district requires immediate attention." data-bn="চট্টগ্রাম জেলা থেকে সড়ক ক্ষতির অভিযোগ তাৎক্ষণিক মনোযোগ প্রয়োজন।">Road damage complaint from Chittagong district requires immediate attention.</p>
                                    <small>5 minutes ago</small>
                                </div>
                                <button class="activity-action" onclick="viewFeedback('FB-2024-001234')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="activity-content">
                                    <h5 data-en="Feedback successfully resolved" data-bn="মতামত সফলভাবে সমাধান">Feedback successfully resolved</h5>
                                    <p data-en="Bridge repair complaint completed with 5-star citizen rating." data-bn="ব্রিজ মেরামত অভিযোগ ৫-তারকা নাগরিক রেটিং সহ সম্পন্ন।">Bridge repair complaint completed with 5-star citizen rating.</p>
                                    <small>2 hours ago</small>
                                </div>
                                <button class="activity-action" onclick="viewResolution('FB-2024-001198')">
                                    <i class="fas fa-star"></i>
                                </button>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon info">
                                    <i class="fas fa-robot"></i>
                                </div>
                                <div class="activity-content">
                                    <h5 data-en="AI analysis report generated" data-bn="AI বিশ্লেষণ প্রতিবেদন তৈরি">AI analysis report generated</h5>
                                    <p data-en="Weekly trends analysis shows improvement in response times across all categories." data-bn="সাপ্তাহিক ট্রেন্ড বিশ্লেষণ সব বিভাগে প্রতিক্রিয়া সময়ের উন্নতি দেখাচ্ছে।">Weekly trends analysis shows improvement in response times across all categories.</p>
                                    <small>1 day ago</small>
                                </div>
                                <button class="activity-action" onclick="viewReport('weekly-trends')">
                                    <i class="fas fa-chart-line"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Feedbacks Section -->
                <section id="feedbacks-section" class="dashboard-section">
                    <div class="section-content">
                        <div class="feedbacks-header">
                            <div class="search-filters">
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" placeholder="Search feedbacks..." id="feedback-search">
                                </div>
                                <div class="filter-controls">
                                    <select id="status-filter">
                                        <option value="all">All Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="in-progress">In Progress</option>
                                        <option value="resolved">Resolved</option>
                                    </select>
                                    <select id="priority-filter">
                                        <option value="all">All Priorities</option>
                                        <option value="high">High</option>
                                        <option value="medium">Medium</option>
                                        <option value="low">Low</option>
                                    </select>
                                    <select id="category-filter">
                                        <option value="all">All Categories</option>
                                        <option value="roads">Roads & Highways</option>
                                        <option value="water">Water & Sanitation</option>
                                        <option value="health">Health Services</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="bulk-actions">
                                <input type="checkbox" id="select-all" onchange="selectAllFeedbacks()">
                                <button class="bulk-action-btn" onclick="bulkAssign()">
                                    <i class="fas fa-user-plus"></i>
                                    Assign
                                </button>
                                <button class="bulk-action-btn" onclick="bulkUpdateStatus()">
                                    <i class="fas fa-edit"></i>
                                    Update Status
                                </button>
                                <button class="bulk-action-btn" onclick="bulkExport()">
                                    <i class="fas fa-download"></i>
                                    Export
                                </button>
                            </div>
                        </div>

                        <div class="feedbacks-table-container">
                            <table class="feedbacks-table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="header-checkbox"></th>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Location</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="feedbacks-table-body">
                                    <!-- Table rows will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>

                        <div class="table-pagination">
                            <div class="pagination-info">
                                <span>Showing 1-10 of 47 results</span>
                            </div>
                            <div class="pagination-controls">
                                <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
                                <button class="page-btn active">1</button>
                                <button class="page-btn">2</button>
                                <button class="page-btn">3</button>
                                <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Other sections will be implemented similarly... -->
                <section id="ai-insights-section" class="dashboard-section">
                    <div class="coming-soon">
                        <i class="fas fa-robot"></i>
                        <h3>Advanced AI Insights</h3>
                        <p>Detailed AI analysis and recommendations coming soon...</p>
                    </div>
                </section>

                <section id="analytics-section" class="dashboard-section">
                    <div class="coming-soon">
                        <i class="fas fa-chart-line"></i>
                        <h3>Advanced Analytics</h3>
                        <p>Comprehensive analytics dashboard coming soon...</p>
                    </div>
                </section>

                <section id="workflow-section" class="dashboard-section">
                    <div class="coming-soon">
                        <i class="fas fa-project-diagram"></i>
                        <h3>Workflow Management</h3>
                        <p>Intelligent workflow automation coming soon...</p>
                    </div>
                </section>

                <section id="reports-section" class="dashboard-section">
                    <div class="coming-soon">
                        <i class="fas fa-file-alt"></i>
                        <h3>Advanced Reports</h3>
                        <p>Automated report generation coming soon...</p>
                    </div>
                </section>

                <section id="settings-section" class="dashboard-section">
                    <div class="coming-soon">
                        <i class="fas fa-cog"></i>
                        <h3>Dashboard Settings</h3>
                        <p>Personalization and configuration options coming soon...</p>
                    </div>
                </section>

                <section id="governance-section" class="dashboard-section">
                    <!-- AI Policy Intelligence Center -->
                    <section class="policy-intelligence" data-aos="fade-up">
                        <div class="intelligence-header">
                            <h2>
                                <i class="fas fa-brain"></i>
                                <span data-en="AI Policy Intelligence Center" data-bn="AI নীতি বুদ্ধিমত্তা কেন্দ্র">AI Policy Intelligence Center</span>
                            </h2>
                            <div class="intelligence-controls">
                                <button class="control-btn" onclick="refreshPolicyIntelligence()">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                                <button class="control-btn" onclick="generatePolicyBrief()">
                                    <i class="fas fa-file-medical-alt"></i>
                                </button>
                            </div>
                        </div>

                        <div class="intelligence-grid">
                            <div class="policy-alert critical">
                                <div class="alert-header">
                                    <div class="alert-icon">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="alert-priority">#HIGH</div>
                                </div>
                                <div class="alert-content">
                                    <h4 data-en="Infrastructure Investment Gap Detected" data-bn="অবকাঠামো বিনিয়োগের ঘাটতি সনাক্ত">Infrastructure Investment Gap Detected</h4>
                                    <p data-en="AI analysis indicates 67% increase in infrastructure-related citizen complaints. Recommend immediate policy review and budget reallocation for Q1 2025." data-bn="AI বিশ্লেষণ অবকাঠামো সম্পর্কিত নাগরিক অভিযোগে ৬৭% বৃদ্ধি নির্দেশ করে। ২০২৫ এর প্রথম ত্রৈমাসিকের জন্য তাৎক্ষণিক নীতি পর্যালোচনা এবং বাজেট পুনর্বণ্টনের সুপারিশ।">AI analysis indicates 67% increase in infrastructure-related citizen complaints. Recommend immediate policy review and budget reallocation for Q1 2025.</p>
                                    <div class="alert-actions">
                                        <button class="action-btn primary" onclick="initiateEmergencyReview('infrastructure')">Initiate Emergency Review</button>
                                        <button class="action-btn secondary" onclick="viewDetailedAnalysis('infrastructure-gap')">View Analysis</button>
                                    </div>
                                </div>
                            </div>

                            <div class="policy-insight strategic">
                                <div class="insight-header">
                                    <div class="insight-icon">
                                        <i class="fas fa-lightbulb"></i>
                                    </div>
                                    <div class="insight-type">#RECOMMENDATION</div>
                                </div>
                                <div class="insight-content">
                                    <h4 data-en="Digital Literacy Initiative Success" data-bn="ডিজিটাল সাক্ষরতা উদ্যোগের সাফল্য">Digital Literacy Initiative Success</h4>
                                    <p data-en="Pattern recognition shows 340% ROI from digital literacy programs. Scaling recommendation: expand to 64 districts with projected 2.1M additional digital citizens by Q3 2025." data-bn="প্যাটার্ন সনাক্তকরণ ডিজিটাল সাক্ষরতা কর্মসূচি থেকে ৩৪০% ROI দেখায়। স্কেলিং সুপারিশ: ৬৪টি জেলায় সম্প্রসারণ করুন যার অনুমিত ২০২৫ সালের তৃতীয় ত্রৈমাসিকের মধ্যে ২.১ মিলিয়ন অতিরিক্ত ডিজিটাল নাগরিক।">Pattern recognition shows 340% ROI from digital literacy programs. Scaling recommendation: expand to 64 districts with projected 2.1M additional digital citizens by Q3 2025.</p>
                                    <div class="insight-metrics">
                                        <div class="metric">
                                            <span class="metric-value">340%</span>
                                            <span class="metric-label">ROI Achieved</span>
                                        </div>
                                        <div class="metric">
                                            <span class="metric-value">2.1M</span>
                                            <span class="metric-label">Projected Users</span>
                                        </div>
                                    </div>
                                    <div class="insight-actions">
                                        <button class="action-btn primary" onclick="approveScaling('digital-literacy')">Approve Scaling</button>
                                        <button class="action-btn secondary" onclick="viewProjections('digital-literacy')">View Projections</button>
                                    </div>
                                </div>
                            </div>

                            <div class="policy-recommendation trending">
                                <div class="recommendation-header">
                                    <div class="recommendation-icon">
                                        <i class="fas fa-trending-up"></i>
                                    </div>
                                    <div class="recommendation-type">#TREND</div>
                                </div>
                                <div class="recommendation-content">
                                    <h4 data-en="Green Technology Adoption Accelerating" data-bn="সবুজ প্রযুক্তি গ্রহণ ত্বরান্বিত">Green Technology Adoption Accelerating</h4>
                                    <p data-en="Cross-ministry data shows 85% citizen support for green tech initiatives. Recommendation: establish national green-tech policy framework with dedicated funding mechanism." data-bn="আন্তঃমন্ত্রণালয় ডেটা সবুজ প্রযুক্তি উদ্যোগের জন্য ৮৫% নাগরিক সমর্থন দেখায়। সুপারিশ: নিবেদিত তহবিল ব্যবস্থা সহ জাতীয় সবুজ-প্রযুক্তি নীতি কাঠামো প্রতিষ্ঠা করুন।">Cross-ministry data shows 85% citizen support for green tech initiatives. Recommendation: establish national green-tech policy framework with dedicated funding mechanism.</p>
                                    <div class="recommendation-timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-date">Q1 2025</div>
                                            <div class="timeline-action">Policy Framework Draft</div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-date">Q2 2025</div>
                                            <div class="timeline-action">Stakeholder Consultation</div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-date">Q3 2025</div>
                                            <div class="timeline-action">Implementation Launch</div>
                                        </div>
                                    </div>
                                    <div class="recommendation-actions">
                                        <button class="action-btn primary" onclick="initiatePolicyDraft('green-tech')">Draft Policy</button>
                                        <button class="action-btn secondary" onclick="viewStakeholders('green-tech')">View Stakeholders</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Strategic Analytics Grid -->
                    <section class="strategic-analytics" data-aos="fade-up" data-aos-delay="200">
                        <div class="analytics-grid">
                            <div class="analytics-card large">
                                <div class="card-header">
                                    <h3 data-en="National Digital Transformation Index" data-bn="জাতীয় ডিজিটাল রূপান্তর সূচক">National Digital Transformation Index</h3>
                                    <div class="card-controls">
                                        <select id="transformation-timeframe">
                                            <option value="1y">Last Year</option>
                                            <option value="2y">Last 2 Years</option>
                                            <option value="5y">Last 5 Years</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="chart-container">
                                    <canvas id="transformationChart"></canvas>
                                </div>
                                <div class="chart-insights">
                                    <div class="insight-item">
                                        <i class="fas fa-arrow-up text-success"></i>
                                        <span data-en="Digital services adoption up 145% since implementation" data-bn="বাস্তবায়নের পর থেকে ডিজিটাল সেবা গ্রহণ ১৪৫% বৃদ্ধি">Digital services adoption up 145% since implementation</span>
                                    </div>
                                    <div class="insight-item">
                                        <i class="fas fa-clock text-warning"></i>
                                        <span data-en="Average processing time reduced by 62%" data-bn="গড় প্রক্রিয়াকরণ সময় ৬২% হ্রাস">Average processing time reduced by 62%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="analytics-card medium">
                                <div class="card-header">
                                    <h3 data-en="Ministry Performance Matrix" data-bn="মন্ত্রণালয় কর্মক্ষমতা ম্যাট্রিক্স">Ministry Performance Matrix</h3>
                                </div>
                                <div class="performance-matrix">
                                    <div class="matrix-item excellent">
                                        <div class="matrix-ministry" data-en="Digital Governance" data-bn="ডিজিটাল শাসন">Digital Governance</div>
                                        <div class="matrix-score">94.2%</div>
                                        <div class="matrix-trend positive">
                                            <i class="fas fa-arrow-up"></i>
                                            <span>+5.2%</span>
                                        </div>
                                    </div>
                                    <div class="matrix-item good">
                                        <div class="matrix-ministry" data-en="Education" data-bn="শিক্ষা">Education</div>
                                        <div class="matrix-score">87.6%</div>
                                        <div class="matrix-trend positive">
                                            <i class="fas fa-arrow-up"></i>
                                            <span>+3.1%</span>
                                        </div>
                                    </div>
                                    <div class="matrix-item average">
                                        <div class="matrix-ministry" data-en="Healthcare" data-bn="স্বাস্থ্যসেবা">Healthcare</div>
                                        <div class="matrix-score">78.4%</div>
                                        <div class="matrix-trend neutral">
                                            <i class="fas fa-minus"></i>
                                            <span>+0.5%</span>
                                        </div>
                                    </div>
                                    <div class="matrix-item needs-attention">
                                        <div class="matrix-ministry" data-en="Infrastructure" data-bn="অবকাঠামো">Infrastructure</div>
                                        <div class="matrix-score">65.8%</div>
                                        <div class="matrix-trend negative">
                                            <i class="fas fa-arrow-down"></i>
                                            <span>-2.3%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="analytics-card small">
                                <div class="card-header">
                                    <h3 data-en="Citizen Satisfaction" data-bn="নাগরিক সন্তুষ্টি">Citizen Satisfaction</h3>
                                </div>
                                <div class="satisfaction-gauge">
                                    <canvas id="satisfactionGauge"></canvas>
                                </div>
                                <div class="satisfaction-details">
                                    <div class="satisfaction-score">
                                        <span class="score-value">92.4%</span>
                                        <span class="score-label" data-en="Overall Satisfaction" data-bn="সামগ্রিক সন্তুষ্টি">Overall Satisfaction</span>
                                    </div>
                                    <div class="satisfaction-breakdown">
                                        <div class="breakdown-item">
                                            <span class="breakdown-label" data-en="Service Quality" data-bn="সেবার মান">Service Quality</span>
                                            <span class="breakdown-value">95%</span>
                                        </div>
                                        <div class="breakdown-item">
                                            <span class="breakdown-label" data-en="Response Time" data-bn="প্রতিক্রিয়া সময়">Response Time</span>
                                            <span class="breakdown-value">89%</span>
                                        </div>
                                        <div class="breakdown-item">
                                            <span class="breakdown-label" data-en="Digital Experience" data-bn="ডিজিটাল অভিজ্ঞতা">Digital Experience</span>
                                            <span class="breakdown-value">93%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="analytics-card small">
                                <div class="card-header">
                                    <h3 data-en="Real-time Operations" data-bn="রিয়েল-টাইম অপারেশনস">Real-time Operations</h3>
                                </div>
                                <div class="operations-monitor">
                                    <div class="monitor-item active">
                                        <div class="monitor-icon">
                                            <i class="fas fa-server"></i>
                                        </div>
                                        <div class="monitor-details">
                                            <div class="monitor-label" data-en="System Uptime" data-bn="সিস্টেম আপটাইম">System Uptime</div>
                                            <div class="monitor-value">99.97%</div>
                                        </div>
                                        <div class="monitor-status online"></div>
                                    </div>
                                    <div class="monitor-item active">
                                        <div class="monitor-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="monitor-details">
                                            <div class="monitor-label" data-en="Active Users" data-bn="সক্রিয় ব্যবহারকারী">Active Users</div>
                                            <div class="monitor-value">47,832</div>
                                        </div>
                                        <div class="monitor-status online"></div>
                                    </div>
                                    <div class="monitor-item warning">
                                        <div class="monitor-icon">
                                            <i class="fas fa-database"></i>
                                        </div>
                                        <div class="monitor-details">
                                            <div class="monitor-label" data-en="Database Load" data-bn="ডেটাবেস লোড">Database Load</div>
                                            <div class="monitor-value">78%</div>
                                        </div>
                                        <div class="monitor-status warning"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Executive Actions Panel -->
                    <section class="executive-actions" data-aos="fade-up" data-aos-delay="300">
                        <div class="actions-header">
                            <h2>
                                <i class="fas fa-bolt"></i>
                                <span data-en="Executive Action Center" data-bn="নির্বাহী কর্ম কেন্দ্র">Executive Action Center</span>
                            </h2>
                        </div>
                        <div class="actions-grid">
                            <div class="action-card priority-high">
                                <div class="action-header">
                                    <div class="action-icon">
                                        <i class="fas fa-gavel"></i>
                                    </div>
                                    <div class="action-status pending">PENDING APPROVAL</div>
                                </div>
                                <div class="action-content">
                                    <h4 data-en="Emergency Infrastructure Budget Approval" data-bn="জরুরি অবকাঠামো বাজেট অনুমোদন">Emergency Infrastructure Budget Approval</h4>
                                    <p data-en="Critical budget reallocation required for infrastructure improvements based on AI analysis. Waiting for ministerial approval." data-bn="AI বিশ্লেষণের ভিত্তিতে অবকাঠামো উন্নতির জন্য গুরুত্বপূর্ণ বাজেট পুনর্বণ্টন প্রয়োজন। মন্ত্রী পর্যায়ের অনুমোদনের অপেক্ষায়।">Critical budget reallocation required for infrastructure improvements based on AI analysis. Waiting for ministerial approval.</p>
                                    <div class="action-details">
                                        <div class="detail-item">
                                            <span class="detail-label">Amount:</span>
                                            <span class="detail-value">৳2.3B</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Timeline:</span>
                                            <span class="detail-value">7 days</span>
                                        </div>
                                    </div>
                                    <div class="action-buttons">
                                        <button class="action-btn approve" onclick="approveAction('budget-reallocation')">
                                            <i class="fas fa-check"></i>
                                            Approve
                                        </button>
                                        <button class="action-btn review" onclick="reviewAction('budget-reallocation')">
                                            <i class="fas fa-eye"></i>
                                            Review Details
                                        </button>
                                        <button class="action-btn defer" onclick="deferAction('budget-reallocation')">
                                            <i class="fas fa-clock"></i>
                                            Defer
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="action-card priority-medium">
                                <div class="action-header">
                                    <div class="action-icon">
                                        <i class="fas fa-scroll"></i>
                                    </div>
                                    <div class="action-status draft">POLICY DRAFT</div>
                                </div>
                                <div class="action-content">
                                    <h4 data-en="National Digital Identity Framework" data-bn="জাতীয় ডিজিটাল পরিচয় কাঠামো">National Digital Identity Framework</h4>
                                    <p data-en="Comprehensive policy framework for national digital identity system. Ready for stakeholder review and public consultation." data-bn="জাতীয় ডিজিটাল পরিচয় ব্যবস্থার জন্য ব্যাপক নীতি কাঠামো। স্টেকহোল্ডার পর্যালোচনা এবং জনসাধারণের পরামর্শের জন্য প্রস্তুত।">Comprehensive policy framework for national digital identity system. Ready for stakeholder review and public consultation.</p>
                                    <div class="action-progress">
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: 75%"></div>
                                        </div>
                                        <span class="progress-text">75% Complete</span>
                                    </div>
                                    <div class="action-buttons">
                                        <button class="action-btn primary" onclick="initiateConsultation('digital-identity')">
                                            <i class="fas fa-comments"></i>
                                            Start Consultation
                                        </button>
                                        <button class="action-btn secondary" onclick="reviewDraft('digital-identity')">
                                            <i class="fas fa-file-alt"></i>
                                            Review Draft
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="action-card priority-low">
                                <div class="action-header">
                                    <div class="action-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <div class="action-status scheduled">SCHEDULED</div>
                                </div>
                                <div class="action-content">
                                    <h4 data-en="Quarterly Performance Review Meeting" data-bn="ত্রৈমাসিক কর্মক্ষমতা পর্যালোচনা সভা">Quarterly Performance Review Meeting</h4>
                                    <p data-en="Inter-ministerial performance review meeting scheduled for next week. AI-generated performance reports and recommendations prepared." data-bn="আগামী সপ্তাহের জন্য আন্তঃমন্ত্রণালয় কর্মক্ষমতা পর্যালোচনা সভার সময়সূচী। AI-জেনারেটেড কর্মক্ষমতা রিপোর্ট এবং সুপারিশ প্রস্তুত।">Inter-ministerial performance review meeting scheduled for next week. AI-generated performance reports and recommendations prepared.</p>
                                    <div class="action-schedule">
                                        <div class="schedule-item">
                                            <i class="fas fa-calendar"></i>
                                            <span>December 15, 2024</span>
                                        </div>
                                        <div class="schedule-item">
                                            <i class="fas fa-clock"></i>
                                            <span>10:00 AM - 2:00 PM</span>
                                        </div>
                                        <div class="schedule-item">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>Ministry Conference Hall</span>
                                        </div>
                                    </div>
                                    <div class="action-buttons">
                                        <button class="action-btn primary" onclick="prepareReports('quarterly-review')">
                                            <i class="fas fa-file-pdf"></i>
                                            Prepare Reports
                                        </button>
                                        <button class="action-btn secondary" onclick="viewAgenda('quarterly-review')">
                                            <i class="fas fa-list"></i>
                                            View Agenda
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </div>
        </main>
    </div>

    <!-- Feedback Detail Modal -->
    <div class="modal" id="feedback-detail-modal">
        <div class="modal-content large">
            <div class="modal-header">
                <h3 id="feedback-modal-title">Feedback Details</h3>
                <button class="modal-close" onclick="closeModal('feedback-detail-modal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="feedback-detail-content">
                    <div class="feedback-info">
                        <div class="info-section">
                            <h4>Feedback Information</h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>Tracking ID:</label>
                                    <span id="modal-tracking-id">CFPIP-2024-001234</span>
                                </div>
                                <div class="info-item">
                                    <label>Category:</label>
                                    <span id="modal-category">Roads & Highways</span>
                                </div>
                                <div class="info-item">
                                    <label>Priority:</label>
                                    <span id="modal-priority" class="priority-badge high">High</span>
                                </div>
                                <div class="info-item">
                                    <label>Status:</label>
                                    <span id="modal-status" class="status-badge pending">Pending</span>
                                </div>
                                <div class="info-item">
                                    <label>Location:</label>
                                    <span id="modal-location">Chittagong, Bangladesh</span>
                                </div>
                                <div class="info-item">
                                    <label>Submitted:</label>
                                    <span id="modal-date">Dec 7, 2024 10:30 AM</span>
                                </div>
                            </div>
                        </div>

                        <div class="info-section">
                            <h4>Description</h4>
                            <div class="description-content" id="modal-description">
                                The main road connecting our village to the district headquarters has developed multiple large potholes...
                            </div>
                        </div>

                        <div class="info-section">
                            <h4>AI Analysis</h4>
                            <div class="ai-analysis-content">
                                <div class="analysis-item">
                                    <i class="fas fa-brain"></i>
                                    <span>Classification Confidence: 96%</span>
                                </div>
                                <div class="analysis-item">
                                    <i class="fas fa-bullseye"></i>
                                    <span>Urgency Score: 8.5/10</span>
                                </div>
                                <div class="analysis-item">
                                    <i class="fas fa-lightbulb"></i>
                                    <span>Suggested Action: Site inspection within 48 hours</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="response-section">
                        <h4>Officer Response</h4>
                        <div class="response-form">
                            <textarea placeholder="Type your response here..." id="response-textarea"></textarea>
                            <div class="ai-response-section">
                                <h5>AI-Suggested Response</h5>
                                <div class="ai-suggestion">
                                    Thank you for reporting this issue. We have received your complaint about road conditions and have scheduled an inspection team to assess the situation. You can expect initial feedback within 48-72 hours.
                                </div>
                                <button class="use-ai-suggestion" onclick="useAISuggestion()">Use AI Suggestion</button>
                            </div>
                            <div class="response-actions">
                                <select id="status-update">
                                    <option value="pending">Pending</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="resolved">Resolved</option>
                                </select>
                                <button class="btn btn-primary" onclick="sendResponse()">Send Response</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('js/modern-app.js') }}"></script>
    <script src="{{ asset('js/dashboard-app.js') }}"></script>
    <script src="{{ asset('js/executive-app.js') }}"></script>
</body>
</html>
