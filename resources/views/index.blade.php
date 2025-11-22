<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CFPIP - Citizen Feedback & Policy Insight Portal | Government of Bangladesh</title>
    <meta name="description" content="AI-powered citizen feedback platform for the Government of Bangladesh. Submit complaints, track progress, and help shape better governance through data-driven insights.">
    
    <!-- Government Portal Meta Tags -->
    <meta name="keywords" content="Bangladesh Government, Citizen Feedback, AI Policy Insights, Digital Bangladesh, E-governance">
    <meta name="author" content="Government of Bangladesh">
    <meta property="og:title" content="CFPIP - Transforming Governance Through AI">
    <meta property="og:description" content="Revolutionary AI-powered platform connecting citizens with government for transparent, efficient public service delivery.">
    <meta property="og:type" content="website">
    
    <!-- Government Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Bengali:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏛️</text></svg>">
    
    <link rel="stylesheet" href="{{ asset('css/index-styles.css') }}">
</head>

<body class="loading">
    <!-- Advanced Loading Screen -->
    <div id="loader" class="loader-overlay">
        <div class="loader-container">
            <div class="govt-logo">
                <div class="logo-emblem">
                    <i class="fas fa-landmark"></i>
                </div>
                <div class="logo-text">
                    <h3 data-en="Government of Bangladesh" data-bn="গণপ্রজাতন্ত্রী বাংলাদেশ সরকার">Government of Bangladesh</h3>
                    <p data-en="CFPIP Portal" data-bn="CFPIP পোর্টাল">CFPIP Portal</p>
                </div>
            </div>
            <div class="loading-progress">
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <p class="loading-text" data-en="Initializing AI-Powered Governance Platform..." data-bn="AI-চালিত শাসন প্ল্যাটফর্ম চালু হচ্ছে...">Initializing AI-Powered Governance Platform...</p>
            </div>
        </div>
    </div>

    <!-- Modern Navigation -->
    <nav class="main-nav" id="main-nav">
        <div class="nav-container">
            <!-- Government Branding -->
            <div class="nav-brand">
                <div class="brand-logo">
                    <div class="logo-icon">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <div class="brand-info">
                        <h1 class="brand-title">VOBD</h1>
                        <p class="brand-subtitle" data-en="AI-Powered Governance" data-bn="AI-চালিত শাসন">AI-Powered Governance</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="nav-menu" id="nav-menu">
                <a href="#home" class="nav-link active">
                    <i class="fas fa-home"></i>
                    <span data-en="Home" data-bn="হোম">Home</span>
                </a>
                <a href="{{ url('/submit-feedback') }}" class="nav-link">
                    <i class="fas fa-comment-dots"></i>
                    <span data-en="Submit Feedback" data-bn="মতামত দিন">Submit Feedback</span>
                </a>
                <a href="{{ url('/track') }}" class="nav-link">
                    <i class="fas fa-search-location"></i>
                    <span data-en="Track Progress" data-bn="অগ্রগতি দেখুন">Track Progress</span>
                </a>
            </div>

            <!-- Government Actions -->
            <div class="nav-actions">
                <button class="lang-switch" onclick="toggleLanguage()">
                    <span class="flag-icon">🇧🇩</span>
                    <span class="lang-text" id="lang-display">বাংলা</span>
                </button>
                <a href="{{ url('/login') }}" class="officer-login">
                    <i class="fas fa-shield-alt"></i>
                    <span data-en="Officer Portal" data-bn="কর্মকর্তা পোর্টাল">Officer Portal</span>
                </a>
                <button class="mobile-toggle" id="mobile-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section - World Class Government Portal -->
    <section id="home" class="hero-section">
        <div class="hero-background">
            <div class="hero-pattern"></div>
            <div class="hero-gradient"></div>
        </div>
        
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge" data-aos="fade-up">
                    <i class="fas fa-robot"></i>
                    <span data-en="AI-Powered Governance Platform" data-bn="AI-চালিত শাসন প্ল্যাটফর্ম">AI-Powered Governance Platform</span>
                </div>
                
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">
                    <span class="title-main" data-en="Transforming Bangladesh" data-bn="বাংলাদেশকে রূপান্তরিত করা">Transforming Bangladesh</span>
                    <span class="title-sub" data-en="Through Intelligent Citizen Engagement" data-bn="বুদ্ধিমান নাগরিক সম্পৃক্ততার মাধ্যমে">Through Intelligent Citizen Engagement</span>
                </h1>
                
                <p class="hero-description" data-aos="fade-up" data-aos-delay="200" data-en="Revolutionary AI-driven platform that processes citizen feedback in real-time, generates actionable policy insights, and creates transparent governance channels between communities and ministries across Bangladesh." data-bn="বিপ্লবী AI-চালিত প্ল্যাটফর্ম যা রিয়েল-টাইমে নাগরিকদের মতামত প্রক্রিয়া করে, কার্যকর নীতিগত অন্তর্দৃষ্টি তৈরি করে এবং বাংলাদেশ জুড়ে সম্প্রদায় ও মন্ত্রণালয়ের মধ্যে স্বচ্ছ শাসন চ্যানেল তৈরি করে।">
                    Revolutionary AI-driven platform that processes citizen feedback in real-time, 
                    generates actionable policy insights, and creates transparent governance channels 
                    between communities and ministries across Bangladesh.
                </p>

                <!-- Key Value Propositions -->
                <div class="value-props" data-aos="fade-up" data-aos-delay="300">
                    <div class="prop-item">
                        <i class="fas fa-brain"></i>
                        <span data-en="AI Classification & Routing" data-bn="AI শ্রেণীকরণ ও রুটিং">AI Classification & Routing</span>
                    </div>
                    <div class="prop-item">
                        <i class="fas fa-chart-network"></i>
                        <span data-en="Real-time Policy Insights" data-bn="রিয়েল-টাইম নীতি অন্তর্দৃষ্টি">Real-time Policy Insights</span>
                    </div>
                    <div class="prop-item">
                        <i class="fas fa-shield-check"></i>
                        <span data-en="Transparent Accountability" data-bn="স্বচ্ছ জবাবদিহিতা">Transparent Accountability</span>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="hero-actions" data-aos="fade-up" data-aos-delay="400">
                    <a href="{{ url('/submit-feedback') }}" class="btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        <span data-en="Submit Your Feedback" data-bn="আপনার মতামত দিন">Submit Your Feedback</span>
                        <div class="btn-shine"></div>
                    </a>
                    <a href="{{ url('/track') }}" class="btn-secondary">
                        <i class="fas fa-search"></i>
                        <span data-en="Track Your Issue" data-bn="আপনার সমস্যা ট্র্যাক করুন">Track Your Issue</span>
                    </a>
                </div>

                <!-- Live Stats -->
                <div class="live-stats" data-aos="fade-up" data-aos-delay="500">
                    <div class="stat-item">
                        <div class="stat-number" data-count="47891">0</div>
                        <div class="stat-label" data-en="Active Cases" data-bn="সক্রিয় মামলা">Active Cases</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-count="89">0%</div>
                        <div class="stat-label" data-en="Resolution Rate" data-bn="সমাধানের হার">Resolution Rate</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-count="156">0</div>
                        <div class="stat-label" data-en="AI Insights Today" data-bn="আজকের AI অন্তর্দৃষ্টি">AI Insights Today</div>
                    </div>
                </div>
            </div>

            <div class="hero-visual" data-aos="fade-left" data-aos-delay="300">
                <div class="dashboard-preview">
                    <div class="preview-header">
                        <div class="header-controls">
                            <span class="control red"></span>
                            <span class="control yellow"></span>
                            <span class="control green"></span>
                        </div>
                        <div class="header-title" data-en="AI Policy Intelligence Dashboard" data-bn="AI নীতি বুদ্ধিমত্তা ড্যাশবোর্ড">AI Policy Intelligence Dashboard</div>
                    </div>
                    <div class="preview-content">
                        <!-- Real-time AI Insights Simulation -->
                        <div class="insight-card">
                            <div class="insight-icon">
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                            </div>
                            <div class="insight-text">
                                <h4 data-en="High Priority Alert" data-bn="উচ্চ অগ্রাধিকার সতর্কতা">High Priority Alert</h4>
                                <p data-en="342% increase in water quality complaints detected in Chittagong division" data-bn="চট্টগ্রাম বিভাগে পানির মানের অভিযোগ ৩৪২% বৃদ্ধি পেয়েছে">342% increase in water quality complaints detected in Chittagong division</p>
                            </div>
                        </div>
                        
                        <div class="insight-card">
                            <div class="insight-icon">
                                <i class="fas fa-lightbulb text-success"></i>
                            </div>
                            <div class="insight-text">
                                <h4 data-en="AI Policy Suggestion" data-bn="AI নীতি পরামর্শ">AI Policy Suggestion</h4>
                                <p data-en="Recommend mobile health clinics for 15 rural areas based on feedback patterns" data-bn="মতামত প্যাটার্নের ভিত্তিতে ১৫টি গ্রামীণ এলাকার জন্য মোবাইল স্বাস্থ্য ক্লিনিক সুপারিশ">Recommend mobile health clinics for 15 rural areas based on feedback patterns</p>
                            </div>
                        </div>

                        <div class="mini-chart">
                            <canvas id="heroChart" width="200" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- AI Capabilities Section -->
    <section class="ai-capabilities">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 data-en="Powered by Advanced AI Intelligence" data-bn="উন্নত AI বুদ্ধিমত্তা দ্বারা চালিত">Powered by Advanced AI Intelligence</h2>
                <p data-en="Our platform uses cutting-edge artificial intelligence to transform citizen feedback into actionable governance insights" data-bn="আমাদের প্ল্যাটফর্ম অত্যাধুনিক কৃত্রিম বুদ্ধিমত্তা ব্যবহার করে নাগরিকদের মতামতকে কার্যকর শাসন অন্তর্দৃষ্টিতে রূপান্তরিত করে">Our platform uses cutting-edge artificial intelligence to transform citizen feedback into actionable governance insights</p>
            </div>

            <div class="capabilities-grid">
                <div class="capability-card" data-aos="fade-up">
                    <div class="card-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3 data-en="Smart Classification" data-bn="স্মার্ট শ্রেণীকরণ">Smart Classification</h3>
                    <p data-en="AI automatically categorizes and routes feedback to the appropriate ministry departments with 94% accuracy" data-bn="AI স্বয়ংক্রিয়ভাবে ৯৪% নির্ভুলতার সাথে যথাযথ মন্ত্রণালয় বিভাগে মতামত শ্রেণীকরণ ও রুট করে">AI automatically categorizes and routes feedback to the appropriate ministry departments with 94% accuracy</p>
                    <div class="feature-list">
                        <span class="feature-tag">Natural Language Processing</span>
                        <span class="feature-tag">Multi-language Support</span>
                    </div>
                </div>

                <div class="capability-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h3 data-en="Pattern Recognition" data-bn="প্যাটার্ন স্বীকৃতি">Pattern Recognition</h3>
                    <p data-en="Advanced clustering algorithms identify emerging issues and trends across different regions and departments" data-bn="উন্নত ক্লাস্টারিং অ্যালগরিদম বিভিন্ন অঞ্চল ও বিভাগে উদীয়মান সমস্যা ও প্রবণতা চিহ্নিত করে">Advanced clustering algorithms identify emerging issues and trends across different regions and departments</p>
                    <div class="feature-list">
                        <span class="feature-tag">Sentiment Analysis</span>
                        <span class="feature-tag">Trend Detection</span>
                    </div>
                </div>

                <div class="capability-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 data-en="Policy Intelligence" data-bn="নীতি বুদ্ধিমত্তা">Policy Intelligence</h3>
                    <p data-en="Generate comprehensive policy briefs and recommendations based on citizen feedback patterns and government data" data-bn="নাগরিক মতামত প্যাটার্ন এবং সরকারি তথ্যের ভিত্তিতে ব্যাপক নীতি সংক্ষিপ্ত বিবরণ ও সুপারিশ তৈরি করুন">Generate comprehensive policy briefs and recommendations based on citizen feedback patterns and government data</p>
                    <div class="feature-list">
                        <span class="feature-tag">Predictive Analytics</span>
                        <span class="feature-tag">Impact Assessment</span>
                    </div>
                </div>

                <div class="capability-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3 data-en="Response Assistance" data-bn="প্রতিক্রিয়া সহায়তা">Response Assistance</h3>
                    <p data-en="AI-powered response suggestions help government officers provide consistent, helpful replies to citizen concerns" data-bn="AI-চালিত প্রতিক্রিয়া পরামর্শ সরকারি কর্মকর্তাদের নাগরিকদের উদ্বেগের জন্য সামঞ্জস্যপূর্ণ, সহায়ক উত্তর প্রদান করতে সহায়তা করে">AI-powered response suggestions help government officers provide consistent, helpful replies to citizen concerns</p>
                    <div class="feature-list">
                        <span class="feature-tag">Auto-draft Responses</span>
                        <span class="feature-tag">Quality Assurance</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Real-time Dashboard Preview -->
    <section class="dashboard-section">
        <div class="container">
            <div class="dashboard-preview-full" data-aos="fade-up">
                <div class="preview-header">
                    <h2 data-en="Live Government Intelligence Dashboard" data-bn="লাইভ সরকার বুদ্ধিমত্তা ড্যাশবোর্ড">Live Government Intelligence Dashboard</h2>
                    <p data-en="Real-time insights from citizen feedback across all ministries" data-bn="সমস্ত মন্ত্রণালয়ের নাগরিক মতামত থেকে রিয়েল-টাইম অন্তর্দৃষ্টি">Real-time insights from citizen feedback across all ministries</p>
                </div>

                <div class="dashboard-grid">
                    <!-- KPI Cards -->
                    <div class="kpi-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="kpi-icon">
                            <i class="fas fa-comments text-primary"></i>
                        </div>
                        <div class="kpi-content">
                            <div class="kpi-number" data-count="12547">0</div>
                            <div class="kpi-label" data-en="Total Feedback Processed" data-bn="মোট মতামত প্রক্রিয়াকৃত">Total Feedback Processed</div>
                            <div class="kpi-trend positive">
                                <i class="fas fa-arrow-up"></i> <span data-en="+12% this week" data-bn="+১২% এই সপ্তাহে">+12% this week</span>
                            </div>
                        </div>
                    </div>

                    <div class="kpi-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="kpi-icon">
                            <i class="fas fa-clock text-warning"></i>
                        </div>
                        <div class="kpi-content">
                            <div class="kpi-number">2.4</div>
                            <div class="kpi-label" data-en="Avg Response Time (days)" data-bn="গড় প্রতিক্রিয়া সময় (দিন)">Avg Response Time (days)</div>
                            <div class="kpi-trend positive">
                                <i class="fas fa-arrow-down"></i> <span data-en="-18% improvement" data-bn="-১৮% উন্নতি">-18% improvement</span>
                            </div>
                        </div>
                    </div>

                    <div class="kpi-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="kpi-icon">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <div class="kpi-content">
                            <div class="kpi-number" data-count="89">0%</div>
                            <div class="kpi-label" data-en="Citizen Satisfaction" data-bn="নাগরিক সন্তুষ্টি">Citizen Satisfaction</div>
                            <div class="kpi-trend positive">
                                <i class="fas fa-arrow-up"></i> <span data-en="+5% this month" data-bn="+৫% এই মাসে">+5% this month</span>
                            </div>
                        </div>
                    </div>

                    <!-- AI Insights Panel -->
                    <div class="insights-panel" data-aos="fade-up" data-aos-delay="400">
                        <h3 data-en="AI-Generated Insights" data-bn="AI-উৎপন্ন অন্তর্দৃষ্টি">AI-Generated Insights</h3>
                        <div class="insights-list">
                            <div class="insight-item priority-high">
                                <div class="insight-priority"></div>
                                <div class="insight-content">
                                    <h4 data-en="Water Quality Crisis Detected" data-bn="পানির মানের সংকট শনাক্ত">Water Quality Crisis Detected</h4>
                                    <p data-en="AI identified 342% spike in water-related complaints in Chittagong. Recommend immediate intervention." data-bn="AI চট্টগ্রামে পানি-সম্পর্কিত অভিযোগ ৩৪২% বৃদ্ধি চিহ্নিত করেছে। তাৎক্ষণিক হস্তক্ষেপের সুপারিশ।">AI identified 342% spike in water-related complaints in Chittagong. Recommend immediate intervention.</p>
                                    <span class="insight-time" data-en="2 hours ago" data-bn="২ ঘন্টা আগে">2 hours ago</span>
                                </div>
                            </div>

                            <div class="insight-item priority-medium">
                                <div class="insight-priority"></div>
                                <div class="insight-content">
                                    <h4 data-en="Road Infrastructure Pattern" data-bn="সড়ক অবকাঠামো প্যাটার্ন">Road Infrastructure Pattern</h4>
                                    <p data-en="Clustering analysis shows 15 districts need coordinated road maintenance program." data-bn="ক্লাস্টারিং বিশ্লেষণ দেখায় ১৫টি জেলার সমন্বিত সড়ক রক্ষণাবেক্ষণ প্রোগ্রাম প্রয়োজন।">Clustering analysis shows 15 districts need coordinated road maintenance program.</p>
                                    <span class="insight-time" data-en="4 hours ago" data-bn="৪ ঘন্টা আগে">4 hours ago</span>
                                </div>
                            </div>

                            <div class="insight-item priority-low">
                                <div class="insight-priority"></div>
                                <div class="insight-content">
                                    <h4 data-en="Positive Feedback Trend" data-bn="ইতিবাচক মতামত প্রবণতা">Positive Feedback Trend</h4>
                                    <p data-en="Education ministry shows 23% improvement in citizen satisfaction scores." data-bn="শিক্ষা মন্ত্রণালয় নাগরিক সন্তুষ্টি স্কোরে ২৩% উন্নতি দেখাচ্ছে।">Education ministry shows 23% improvement in citizen satisfaction scores.</p>
                                    <span class="insight-time" data-en="6 hours ago" data-bn="৬ ঘন্টা আগে">6 hours ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Government Ministries Integration -->
    <section class="ministries-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 data-en="Connected Government Ministries" data-bn="সংযুক্ত সরকারি মন্ত্রণালয়">Connected Government Ministries</h2>
                <p data-en="Seamlessly integrated with key government departments for efficient service delivery" data-bn="দক্ষ সেবা প্রদানের জন্য প্রধান সরকারি বিভাগসমূহের সাথে নিরবচ্ছিন্ন একীকরণ">Seamlessly integrated with key government departments for efficient service delivery</p>
            </div>

            <div class="ministries-grid">
                <div class="ministry-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="ministry-logo">
                        <i class="fas fa-road"></i>
                    </div>
                    <h3 data-en="Roads & Highways" data-bn="সড়ক ও মহাসড়ক">Roads & Highways</h3>
                    <div class="ministry-stats">
                        <span class="stat">2,847 cases</span>
                        <span class="stat">92% resolved</span>
                    </div>
                </div>

                <div class="ministry-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="ministry-logo">
                        <i class="fas fa-tint"></i>
                    </div>
                    <h3 data-en="Water Resources" data-bn="পানি সম্পদ">Water Resources</h3>
                    <div class="ministry-stats">
                        <span class="stat">1,923 cases</span>
                        <span class="stat">87% resolved</span>
                    </div>
                </div>

                <div class="ministry-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="ministry-logo">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 data-en="Education" data-bn="শিক্ষা">Education</h3>
                    <div class="ministry-stats">
                        <span class="stat">3,156 cases</span>
                        <span class="stat">94% resolved</span>
                    </div>
                </div>

                <div class="ministry-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="ministry-logo">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3 data-en="Health Services" data-bn="স্বাস্থ্য সেবা">Health Services</h3>
                    <div class="ministry-stats">
                        <span class="stat">4,201 cases</span>
                        <span class="stat">91% resolved</span>
                    </div>
                </div>

                <div class="ministry-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="ministry-logo">
                        <i class="fas fa-city"></i>
                    </div>
                    <h3 data-en="Urban Development" data-bn="নগর উন্নয়ন">Urban Development</h3>
                    <div class="ministry-stats">
                        <span class="stat">1,634 cases</span>
                        <span class="stat">89% resolved</span>
                    </div>
                </div>

                <div class="ministry-card" data-aos="fade-up" data-aos-delay="600">
                    <div class="ministry-logo">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3 data-en="Environment" data-bn="পরিবেশ">Environment</h3>
                    <div class="ministry-stats">
                        <span class="stat">987 cases</span>
                        <span class="stat">86% resolved</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Stories -->
    <section class="success-stories">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 data-en="Citizen Success Stories" data-bn="নাগরিক সাফল্যের গল্প">Citizen Success Stories</h2>
                <p data-en="Real impact on communities across Bangladesh" data-bn="সমগ্র বাংলাদেশের সম্প্রদায়ের উপর প্রকৃত প্রভাব">Real impact on communities across Bangladesh</p>
            </div>

            <div class="stories-carousel" data-aos="fade-up">
                <div class="story-card active">
                    <div class="story-content">
                        <div class="story-quote">
                            <i class="fas fa-quote-left"></i>
                            <p data-en="Within 48 hours of reporting the water contamination issue through CFPIP, our entire village got access to clean drinking water. The AI system immediately identified it as high priority and connected us with the right officials." data-bn="CFPIP এর মাধ্যমে পানি দূষণের সমস্যা রিপোর্ট করার ৪৮ ঘন্টার মধ্যে আমাদের সমগ্র গ্রাম পরিষ্কার পানীয় জল পেয়েছে। AI সিস্টেম তাৎক্ষণিকভাবে এটিকে উচ্চ অগ্রাধিকার হিসাবে চিহ্নিত করেছে এবং আমাদের সঠিক কর্মকর্তাদের সাথে সংযুক্ত করেছে।">"Within 48 hours of reporting the water contamination issue through CFPIP, our entire village got access to clean drinking water. The AI system immediately identified it as high priority and connected us with the right officials."</p>
                        </div>
                        <div class="story-author">
                            <div class="author-info">
                                <h4>Rashida Begum</h4>
                                <p data-en="Farmer, Rangpur Division" data-bn="কৃষক, রংপুর বিভাগ">Farmer, Rangpur Division</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="story-card">
                    <div class="story-content">
                        <div class="story-quote">
                            <i class="fas fa-quote-left"></i>
                            <p data-en="The platform's AI insights helped us identify and fix a systemic issue affecting 15 schools in our district. What used to take months of bureaucracy now happens in days through intelligent routing." data-bn="প্ল্যাটফর্মের AI অন্তর্দৃষ্টি আমাদের জেলার ১৫টি স্কুলকে প্রভাবিত করে এমন একটি পদ্ধতিগত সমস্যা চিহ্নিত ও সমাধান করতে সাহায্য করেছে। যা আগে মাসের পর মাস আমলাতন্ত্রের দরকার হত এখন বুদ্ধিমান রাউটিংয়ের মাধ্যমে দিনেই ঘটে।">"The platform's AI insights helped us identify and fix a systemic issue affecting 15 schools in our district. What used to take months of bureaucracy now happens in days through intelligent routing."</p>
                        </div>
                        <div class="story-author">
                            <div class="author-info">
                                <h4>Md. Karim Uddin</h4>
                                <p data-en="District Education Officer, Sylhet" data-bn="জেলা শিক্ষা কর্মকর্তা, সিলেট">District Education Officer, Sylhet</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="about-content" data-aos="fade-up">
                <div class="about-text">
                    <h2 data-en="Building Digital Bangladesh Together" data-bn="একসাথে ডিজিটাল বাংলাদেশ গড়া">Building Digital Bangladesh Together</h2>
                    <p data-en="CFPIP represents the future of citizen-government interaction in Bangladesh. By harnessing the power of artificial intelligence, we're creating a more responsive, transparent, and efficient public service ecosystem that serves every citizen fairly and effectively." data-bn="CFPIP বাংলাদেশে নাগরিক-সরকার মিথস্ক্রিয়ার ভবিষ্যৎ প্রতিনিধিত্ব করে। কৃত্রিম বুদ্ধিমত্তার শক্তি ব্যবহার করে, আমরা আরও প্রতিক্রিয়াশীল, স্বচ্ছ এবং দক্ষ পাবলিক সার্ভিস ইকোসিস্টেম তৈরি করছি যা প্রতিটি নাগরিককে ন্যায্য এবং কার্যকরভাবে সেবা করে।">
                        CFPIP represents the future of citizen-government interaction in Bangladesh. 
                        By harnessing the power of artificial intelligence, we're creating a more responsive, 
                        transparent, and efficient public service ecosystem that serves every citizen fairly and effectively.
                    </p>
                    
                    <div class="about-features">
                        <div class="feature">
                            <i class="fas fa-users"></i>
                            <span data-en="Citizen-Centric Design" data-bn="নাগরিক-কেন্দ্রিক ডিজাইন">Citizen-Centric Design</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-lock"></i>
                            <span data-en="Secure & Private" data-bn="নিরাপদ ও গোপনীয়">Secure & Private</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-mobile-alt"></i>
                            <span data-en="Mobile-First Approach" data-bn="মোবাইল-ফার্স্ট পদ্ধতি">Mobile-First Approach</span>
                        </div>
                    </div>
                </div>
                
                <div class="about-stats">
                    <div class="stat-group">
                        <div class="stat-number" data-count="64">0</div>
                        <div class="stat-desc" data-en="Districts Connected" data-bn="জেলা সংযুক্ত">Districts Connected</div>
                    </div>
                    <div class="stat-group">
                        <div class="stat-number" data-count="28">0</div>
                        <div class="stat-desc" data-en="Ministries Integrated" data-bn="মন্ত্রণালয় একীভূত">Ministries Integrated</div>
                    </div>
                    <div class="stat-group">
                        <div class="stat-number" data-count="1.2">0M+</div>
                        <div class="stat-desc" data-en="Citizens Served" data-bn="নাগরিক সেবা প্রদান">Citizens Served</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-brand">
                        <div class="brand-logo">
                            <i class="fas fa-landmark"></i>
                            <span>CFPIP</span>
                        </div>
                        <p data-en="Transforming Bangladesh through AI-powered citizen engagement and data-driven governance." data-bn="AI-চালিত নাগরিক সম্পৃক্ততা এবং তথ্য-চালিত শাসনের মাধ্যমে বাংলাদেশকে রূপান্তরিত করা।">Transforming Bangladesh through AI-powered citizen engagement and data-driven governance.</p>
                    </div>
                </div>

                <div class="footer-section">
                    <h3 data-en="Quick Links" data-bn="দ্রুত লিংক">Quick Links</h3>
                    <ul>
                        <li><a href="{{ url('/submit-feedback') }}" data-en="Submit Feedback" data-bn="মতামত দিন">Submit Feedback</a></li>
                        <li><a href="{{ url('/track') }}" data-en="Track Status" data-bn="স্ট্যাটাস ট্র্যাক করুন">Track Status</a></li>
                        <li><a href="{{ url('/login') }}" data-en="Officer Portal" data-bn="কর্মকর্তা পোর্টাল">Officer Portal</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3 data-en="Government" data-bn="সরকার">Government</h3>
                    <ul>
                        <li><a href="#" target="_blank" data-en="Digital Bangladesh" data-bn="ডিজিটাল বাংলাদেশ">Digital Bangladesh</a></li>
                        <li><a href="#" target="_blank">Bangladesh.gov.bd</a></li>
                        <li><a href="#" data-en="Privacy Policy" data-bn="গোপনীয়তা নীতি">Privacy Policy</a></li>
                        <li><a href="#" data-en="Terms of Service" data-bn="সেবার শর্তাবলী">Terms of Service</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3 data-en="Connect" data-bn="যোগাযোগ">Connect</h3>
                    <div class="contact-info">
                        <p><i class="fas fa-envelope"></i> support@cfpip.gov.bd</p>
                        <p><i class="fas fa-phone"></i> +880-2-XXXXXXX</p>
                    </div>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p data-en="© 2024 Government of Bangladesh. All rights reserved. | Powered by AI for the People" data-bn="© ২০২৪ গণপ্রজাতন্ত্রী বাংলাদেশ সরকার। সকল অধিকার সংরক্ষিত। | জনগণের জন্য AI দ্বারা চালিত">&copy; 2024 Government of Bangladesh. All rights reserved. | Powered by AI for the People</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('js/index-app.js') }}"></script>
</body>
</html>