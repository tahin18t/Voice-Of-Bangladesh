<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback - AI-Powered Citizen Portal | Voicce of Bangladesh</title>
    <meta name="description" content="Submit intelligent feedback using our AI-powered system. Get real-time suggestions, automatic categorization, and direct routing to relevant government departments.">
    
    <!-- Government Portal Meta Tags -->
    <meta name="keywords" content="Submit Feedback, AI Classification, Bangladesh Government, Citizen Services, Smart Routing">
    <meta name="author" content="Government of Bangladesh">
    <meta property="og:title" content="AI-Powered Feedback Submission | CFPIP">
    <meta property="og:description" content="Revolutionary feedback system with AI classification and smart government routing.">
    
    <!-- Government Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Bengali:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏛️</text></svg>">

    <link rel="stylesheet" href="{{ asset('css/submit-feedback.css') }}">
    <link rel="stylesheet" href="{{ asset('css/feedback-styles.css') }}">
</head>

<body class="loading">
    <!-- Loading Screen -->
    <div id="loader" class="loader-overlay">
        <div class="loader-container">
            <div class="govt-logo">
                <div class="logo-emblem">
                    <i class="fas fa-comment-dots"></i>
                </div>
                <div class="logo-text">
                    <h3 data-en="AI-Powered Feedback System" data-bn="AI-চালিত মতামত সিস্টেম">AI-Powered Feedback System</h3>
                    <p data-en="Initializing Smart Classification..." data-bn="স্মার্ট শ্রেণীবিভাগ চালু হচ্ছে...">Initializing Smart Classification...</p>
                </div>
            </div>
            <div class="loading-progress">
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <p class="loading-text" data-en="Preparing intelligent form interface..." data-bn="বুদ্ধিমান ফর্ম ইন্টারফেস প্রস্তুত হচ্ছে...">Preparing intelligent form interface...</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="main-nav" id="main-nav">
        <div class="nav-container">
            <!-- Government Branding -->
            <div class="nav-brand">
                <div class="brand-logo">
                    <div class="logo-icon">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <div class="brand-info">
                        <h1 class="brand-title">CFPIP</h1>
                        <p class="brand-subtitle" data-en="AI-Powered Governance" data-bn="AI-চালিত শাসন">AI-Powered Governance</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="nav-menu" id="nav-menu">
                <a href="{{ url('/index') }}" class="nav-link">
                    <i class="fas fa-home"></i>
                    <span data-en="Home" data-bn="হোম">Home</span>
                </a>
                <a href="{{ url('/feedback') }}" class="nav-link active">
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

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header Section -->
        <section class="feedback-header">
            <div class="container">
                <div class="header-content" data-aos="fade-up">
                    <div class="breadcrumb">
                        <a href="{{ url('/index') }}" data-en="Home" data-bn="হোম">Home</a>
                        <i class="fas fa-chevron-right"></i>
                        <span data-en="Submit Feedback" data-bn="মতামত দিন">Submit Feedback</span>
                    </div>
                    
                    <h1 class="page-title">
                        <span data-en="AI-Powered Feedback Submission" data-bn="AI-চালিত মতামত প্রদান">AI-Powered Feedback Submission</span>
                    </h1>
                    
                    <p class="page-description" data-en="Our intelligent system automatically categorizes your feedback and routes it to the appropriate ministry department for faster resolution." data-bn="আমাদের বুদ্ধিমান সিস্টেম স্বয়ংক্রিয়ভাবে আপনার মতামত শ্রেণীবদ্ধ করে এবং দ্রুত সমাধানের জন্য উপযুক্ত মন্ত্রণালয় বিভাগে পাঠায়।">
                        Our intelligent system automatically categorizes your feedback and routes it to the appropriate ministry department for faster resolution.
                    </p>
                    
                    <!-- AI Features Banner -->
                    <div class="ai-features-banner">
                        <div class="ai-feature">
                            <i class="fas fa-brain"></i>
                            <span data-en="Smart Classification" data-bn="স্মার্ট শ্রেণীকরণ">Smart Classification</span>
                        </div>
                        <div class="ai-feature">
                            <i class="fas fa-route"></i>
                            <span data-en="Auto-Routing" data-bn="স্বয়ংক্রিয় রাউটিং">Auto-Routing</span>
                        </div>
                        <div class="ai-feature">
                            <i class="fas fa-lightbulb"></i>
                            <span data-en="Smart Suggestions" data-bn="স্মার্ট সুপারিশ">Smart Suggestions</span>
                        </div>
                        <div class="ai-feature">
                            <i class="fas fa-gauge-high"></i>
                            <span data-en="Priority Assessment" data-bn="অগ্রাধিকার মূল্যায়ন">Priority Assessment</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Feedback Form Section -->
        <section class="feedback-form-section">
            <div class="container">
                <div class="form-layout">
                    <!-- Main Form -->
                    <div class="form-container" data-aos="fade-up">
                        <form id="feedbackForm" class="intelligent-form">
                            <!-- Step 1: Category & Topic -->
                            <div class="form-step active" id="step-1">
                                <div class="step-header">
                                    <div class="step-number">1</div>
                                    <div class="step-info">
                                        <h3 data-en="Category Selection" data-bn="বিভাগ নির্বাচন">Category Selection</h3>
                                        <p data-en="AI will help classify your feedback" data-bn="AI আপনার মতামত শ্রেণীবদ্ধ করতে সাহায্য করবে">AI will help classify your feedback</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="category" data-en="Primary Category" data-bn="প্রাথমিক বিভাগ">Primary Category</label>
                                    <select id="category" name="category" required>
                                        <option value="" data-en="Select a category..." data-bn="একটি বিভাগ নির্বাচন করুন...">Select a category...</option>
                                        <option value="roads" data-en="Roads & Highways" data-bn="সড়ক ও মহাসড়ক">Roads & Highways</option>
                                        <option value="water" data-en="Water & Sanitation" data-bn="পানি ও স্যানিটেশন">Water & Sanitation</option>
                                        <option value="health" data-en="Health Services" data-bn="স্বাস্থ্য সেবা">Health Services</option>
                                        <option value="education" data-en="Education" data-bn="শিক্ষা">Education</option>
                                        <option value="urban" data-en="Urban Development" data-bn="নগর উন্নয়ন">Urban Development</option>
                                        <option value="environment" data-en="Environment" data-bn="পরিবেশ">Environment</option>
                                        <option value="agriculture" data-en="Agriculture" data-bn="কৃষি">Agriculture</option>
                                        <option value="transport" data-en="Public Transport" data-bn="গণপরিবহন">Public Transport</option>
                                        <option value="electricity" data-en="Power & Electricity" data-bn="বিদ্যুৎ">Power & Electricity</option>
                                        <option value="other" data-en="Other" data-bn="অন্যান্য">Other</option>
                                    </select>
                                    <div class="ai-suggestion" id="category-suggestion" style="display: none;">
                                        <i class="fas fa-robot"></i>
                                        <span data-en="AI suggests: " data-bn="AI সুপারিশ: ">AI suggests: </span>
                                        <strong id="suggested-category"></strong>
                                        <button type="button" class="accept-suggestion" onclick="acceptCategorySuggestion()" data-en="Accept" data-bn="গ্রহণ করুন">Accept</button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="title" data-en="Issue Title" data-bn="সমস্যার শিরোনাম">Issue Title</label>
                                    <input type="text" id="title" name="title" required 
                                           data-en="Brief description of your issue" 
                                           data-bn="আপনার সমস্যার সংক্ষিপ্ত বিবরণ"
                                           placeholder="Brief description of your issue">
                                    <div class="character-count">
                                        <span id="title-count">0</span>/100 <span data-en="characters" data-bn="অক্ষর">characters</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Details & Description -->
                            <div class="form-step" id="step-2">
                                <div class="step-header">
                                    <div class="step-number">2</div>
                                    <div class="step-info">
                                        <h3 data-en="Issue Details" data-bn="সমস্যার বিবরণ">Issue Details</h3>
                                        <p data-en="Provide comprehensive information" data-bn="বিস্তারিত তথ্য প্রদান করুন">Provide comprehensive information</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" data-en="Detailed Description" data-bn="বিস্তারিত বিবরণ">Detailed Description</label>
                                    <textarea id="description" name="description" rows="6" required
                                              data-en="Describe your issue in detail, including when it occurred, its impact, and any relevant context..."
                                              data-bn="আপনার সমস্যার বিস্তারিত বিবরণ দিন, এটি কখন ঘটেছে, এর প্রভাব এবং প্রাসঙ্গিক প্রসঙ্গ সহ..."
                                              placeholder="Describe your issue in detail, including when it occurred, its impact, and any relevant context..."></textarea>
                                    <div class="character-count">
                                        <span id="description-count">0</span>/2000 <span data-en="characters" data-bn="অক্ষর">characters</span>
                                    </div>
                                    <div class="ai-analysis" id="description-analysis" style="display: none;">
                                        <div class="analysis-item">
                                            <i class="fas fa-tag"></i>
                                            <span data-en="AI detected priority:" data-bn="AI সনাক্ত অগ্রাধিকার:">AI detected priority:</span>
                                            <span class="priority-badge" id="detected-priority">Medium</span>
                                        </div>
                                        <div class="analysis-item">
                                            <i class="fas fa-bullseye"></i>
                                            <span data-en="Suggested department:" data-bn="প্রস্তাবিত বিভাগ:">Suggested department:</span>
                                            <span class="department-tag" id="suggested-department">Roads & Highways</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="urgency" data-en="Urgency Level" data-bn="জরুরি মাত্রা">Urgency Level</label>
                                    <div class="urgency-selector">
                                        <div class="urgency-option">
                                            <input type="radio" id="low" name="urgency" value="low">
                                            <label for="low">
                                                <div class="urgency-indicator low"></div>
                                                <span data-en="Low" data-bn="কম">Low</span>
                                                <small data-en="Can wait" data-bn="অপেক্ষা করতে পারে">Can wait</small>
                                            </label>
                                        </div>
                                        <div class="urgency-option">
                                            <input type="radio" id="medium" name="urgency" value="medium" checked>
                                            <label for="medium">
                                                <div class="urgency-indicator medium"></div>
                                                <span data-en="Medium" data-bn="মধ্যম">Medium</span>
                                                <small data-en="Normal priority" data-bn="সাধারণ অগ্রাধিকার">Normal priority</small>
                                            </label>
                                        </div>
                                        <div class="urgency-option">
                                            <input type="radio" id="high" name="urgency" value="high">
                                            <label for="high">
                                                <div class="urgency-indicator high"></div>
                                                <span data-en="High" data-bn="উচ্চ">High</span>
                                                <small data-en="Urgent" data-bn="জরুরি">Urgent</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Location & Media -->
                            <div class="form-step" id="step-3">
                                <div class="step-header">
                                    <div class="step-number">3</div>
                                    <div class="step-info">
                                        <h3 data-en="Location & Evidence" data-bn="অবস্থান ও প্রমাণ">Location & Evidence</h3>
                                        <p data-en="Help us locate and verify the issue" data-bn="আমাদের সমস্যাটি সনাক্ত ও যাচাই করতে সাহায্য করুন">Help us locate and verify the issue</p>
                                    </div>
                                </div>

                                <div class="location-section">
                                    <div class="form-group">
                                        <label data-en="Location Information" data-bn="অবস্থানের তথ্য">Location Information</label>
                                        <div class="location-inputs">
                                            <select id="division" name="division" required>
                                                <option value="" data-en="Select Division" data-bn="বিভাগ নির্বাচন করুন">Select Division</option>
                                                <option value="dhaka" data-en="Dhaka" data-bn="ঢাকা">Dhaka</option>
                                                <option value="chittagong" data-en="Chittagong" data-bn="চট্টগ্রাম">Chittagong</option>
                                                <option value="rajshahi" data-en="Rajshahi" data-bn="রাজশাহী">Rajshahi</option>
                                                <option value="khulna" data-en="Khulna" data-bn="খুলনা">Khulna</option>
                                                <option value="sylhet" data-en="Sylhet" data-bn="সিলেট">Sylhet</option>
                                                <option value="barisal" data-en="Barisal" data-bn="বরিশাল">Barisal</option>
                                                <option value="rangpur" data-en="Rangpur" data-bn="রংপুর">Rangpur</option>
                                                <option value="mymensingh" data-en="Mymensingh" data-bn="ময়মনসিংহ">Mymensingh</option>
                                            </select>
                                            
                                            <select id="district" name="district" required>
                                                <option value="" data-en="Select District" data-bn="জেলা নির্বাচন করুন">Select District</option>
                                            </select>
                                            
                                            <input type="text" id="ward" name="ward" 
                                                   data-en="Ward/Area (optional)" 
                                                   data-bn="ওয়ার্ড/এলাকা (ঐচ্ছিক)"
                                                   placeholder="Ward/Area (optional)">
                                        </div>
                                    </div>

                                    <div class="map-container">
                                        <div id="location-map"></div>
                                        <button type="button" class="btn-location" onclick="getCurrentLocation()">
                                            <i class="fas fa-location-crosshairs"></i>
                                            <span data-en="Use Current Location" data-bn="বর্তমান অবস্থান ব্যবহার করুন">Use Current Location</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label data-en="Upload Evidence (Optional)" data-bn="প্রমাণ আপলোড করুন (ঐচ্ছিক)">Upload Evidence (Optional)</label>
                                    <div class="file-upload-area" id="file-upload">
                                        <div class="upload-icon">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </div>
                                        <p data-en="Drag and drop files here or click to browse" data-bn="এখানে ফাইল টেনে আনুন বা ব্রাউজ করতে ক্লিক করুন">Drag and drop files here or click to browse</p>
                                        <small data-en="Supports: JPG, PNG, PDF, MP4 (Max 10MB each)" data-bn="সমর্থিত: JPG, PNG, PDF, MP4 (সর্বোচ্চ ১০MB প্রতিটি)">Supports: JPG, PNG, PDF, MP4 (Max 10MB each)</small>
                                        <input type="file" id="files" name="files" multiple accept="image/*,application/pdf,video/mp4" hidden>
                                    </div>
                                    <div class="uploaded-files" id="uploaded-files"></div>
                                </div>
                            </div>

                            <!-- Step 4: Contact & Preferences -->
                            <div class="form-step" id="step-4">
                                <div class="step-header">
                                    <div class="step-number">4</div>
                                    <div class="step-info">
                                        <h3 data-en="Contact Information" data-bn="যোগাযোগের তথ্য">Contact Information</h3>
                                        <p data-en="How can we reach you with updates?" data-bn="আপডেটের জন্য আমরা কীভাবে আপনার সাথে যোগাযোগ করব?">How can we reach you with updates?</p>
                                    </div>
                                </div>

                                <div class="contact-option">
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="anonymous" name="anonymous" onchange="toggleAnonymous()">
                                        <label for="anonymous">
                                            <span data-en="Submit anonymously" data-bn="বেনামে জমা দিন">Submit anonymously</span>
                                            <small data-en="Your identity will not be shared" data-bn="আপনার পরিচয় শেয়ার করা হবে না">Your identity will not be shared</small>
                                        </label>
                                    </div>
                                </div>

                                <div class="contact-fields" id="contact-fields">
                                    <div class="form-group">
                                        <label for="name" data-en="Full Name" data-bn="পূর্ণ নাম">Full Name</label>
                                        <input type="text" id="name" name="name" 
                                               data-en="Your full name" 
                                               data-bn="আপনার পূর্ণ নাম"
                                               placeholder="Your full name">
                                    </div>

                                    <div class="form-group">
                                        <label for="phone" data-en="Phone Number" data-bn="ফোন নম্বর">Phone Number</label>
                                        <input type="tel" id="phone" name="phone" 
                                               data-en="+880 1X XXX XXXXX" 
                                               data-bn="+৮৮০ ১X XXX XXXXX"
                                               placeholder="+880 1X XXX XXXXX">
                                    </div>

                                    <div class="form-group">
                                        <label for="email" data-en="Email Address" data-bn="ইমেইল ঠিকানা">Email Address</label>
                                        <input type="email" id="email" name="email" 
                                               data-en="your.email@example.com" 
                                               data-bn="your.email@example.com"
                                               placeholder="your.email@example.com">
                                    </div>

                                    <div class="notification-preferences">
                                        <h4 data-en="Notification Preferences" data-bn="বিজ্ঞপ্তি পছন্দ">Notification Preferences</h4>
                                        <div class="checkbox-group">
                                            <input type="checkbox" id="sms-updates" name="sms-updates" checked>
                                            <label for="sms-updates" data-en="SMS Updates" data-bn="SMS আপডেট">SMS Updates</label>
                                        </div>
                                        <div class="checkbox-group">
                                            <input type="checkbox" id="email-updates" name="email-updates" checked>
                                            <label for="email-updates" data-en="Email Updates" data-bn="ইমেইল আপডেট">Email Updates</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Navigation -->
                            <div class="form-navigation">
                                <button type="button" class="btn btn-secondary" id="prev-btn" onclick="previousStep()" disabled>
                                    <i class="fas fa-arrow-left"></i>
                                    <span data-en="Previous" data-bn="পূর্ববর্তী">Previous</span>
                                </button>
                                
                                <div class="step-indicators">
                                    <div class="step-dot active" data-step="1"></div>
                                    <div class="step-dot" data-step="2"></div>
                                    <div class="step-dot" data-step="3"></div>
                                    <div class="step-dot" data-step="4"></div>
                                </div>
                                
                                <button type="button" class="btn btn-primary" id="next-btn" onclick="nextStep()">
                                    <span data-en="Next" data-bn="পরবর্তী">Next</span>
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                                
                                <button type="submit" class="btn btn-primary" id="submit-btn" style="display: none;">
                                    <i class="fas fa-paper-plane"></i>
                                    <span data-en="Submit Feedback" data-bn="মতামত জমা দিন">Submit Feedback</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- AI Assistant Sidebar -->
                    <div class="ai-assistant" data-aos="fade-left">
                        <div class="assistant-header">
                            <div class="assistant-avatar">
                                <i class="fas fa-robot"></i>
                            </div>
                            <div class="assistant-info">
                                <h3 data-en="AI Assistant" data-bn="AI সহায়ক">AI Assistant</h3>
                                <p data-en="Smart guidance for your feedback" data-bn="আপনার মতামতের জন্য স্মার্ট নির্দেশনা">Smart guidance for your feedback</p>
                            </div>
                        </div>

                        <div class="assistant-content">
                            <div class="smart-tips">
                                <h4 data-en="Smart Tips" data-bn="স্মার্ট টিপস">Smart Tips</h4>
                                <div class="tip-item active" id="tip-category">
                                    <i class="fas fa-lightbulb"></i>
                                    <p data-en="Choose the most relevant category for faster routing to the right department." data-bn="সঠিক বিভাগে দ্রুত রুট করার জন্য সবচেয়ে প্রাসঙ্গিক বিভাগ বেছে নিন।">Choose the most relevant category for faster routing to the right department.</p>
                                </div>
                                <div class="tip-item" id="tip-details">
                                    <i class="fas fa-edit"></i>
                                    <p data-en="Be specific and detailed. Include dates, times, and exact locations when possible." data-bn="নির্দিষ্ট এবং বিস্তারিত হন। সম্ভব হলে তারিখ, সময় এবং সঠিক অবস্থান অন্তর্ভুক্ত করুন।">Be specific and detailed. Include dates, times, and exact locations when possible.</p>
                                </div>
                                <div class="tip-item" id="tip-evidence">
                                    <i class="fas fa-camera"></i>
                                    <p data-en="Photos and videos help verify issues faster. Upload clear, relevant evidence." data-bn="ফটো এবং ভিডিও সমস্যা দ্রুত যাচাই করতে সাহায্য করে। স্পষ্ট, প্রাসঙ্গিক প্রমাণ আপলোড করুন।">Photos and videos help verify issues faster. Upload clear, relevant evidence.</p>
                                </div>
                                <div class="tip-item" id="tip-contact">
                                    <i class="fas fa-phone"></i>
                                    <p data-en="Provide accurate contact info to receive updates about your feedback progress." data-bn="আপনার মতামতের অগ্রগতি সম্পর্কে আপডেট পেতে সঠিক যোগাযোগের তথ্য প্রদান করুন।">Provide accurate contact info to receive updates about your feedback progress.</p>
                                </div>
                            </div>

                            <div class="processing-status" style="display: none;" id="ai-processing">
                                <div class="processing-animation">
                                    <div class="processing-dots">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                                <p data-en="AI analyzing your feedback..." data-bn="AI আপনার মতামত বিশ্লেষণ করছে...">AI analyzing your feedback...</p>
                            </div>

                            <div class="success-prediction" style="display: none;" id="success-prediction">
                                <div class="prediction-score">
                                    <div class="score-circle">
                                        <span class="score-number">94</span>
                                        <span class="score-percent">%</span>
                                    </div>
                                </div>
                                <h4 data-en="Success Prediction" data-bn="সফলতার পূর্বাভাস">Success Prediction</h4>
                                <p data-en="High probability of quick resolution based on similar cases." data-bn="অনুরূপ মামলার ভিত্তিতে দ্রুত সমাধানের উচ্চ সম্ভাবনা।">High probability of quick resolution based on similar cases.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Success Modal -->
        <div class="modal" id="success-modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h2 data-en="Feedback Submitted Successfully!" data-bn="মতামত সফলভাবে জমা দেওয়া হয়েছে!">Feedback Submitted Successfully!</h2>
                </div>
                <div class="modal-body">
                    <div class="tracking-info">
                        <p data-en="Your tracking ID:" data-bn="আপনার ট্র্যাকিং ID:">Your tracking ID:</p>
                        <div class="tracking-id">
                            <span id="generated-tracking-id">CFPIP-2024-001234</span>
                            <button type="button" onclick="copyTrackingId()" class="copy-btn" data-en="Copy" data-bn="কপি করুন">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="ai-classification-result">
                        <h4 data-en="AI Classification Results" data-bn="AI শ্রেণীকরণ ফলাফল">AI Classification Results</h4>
                        <div class="classification-item">
                            <span data-en="Department:" data-bn="বিভাগ:">Department:</span>
                            <span class="department-badge" id="final-department">Roads & Highways Ministry</span>
                        </div>
                        <div class="classification-item">
                            <span data-en="Priority:" data-bn="অগ্রাধিকার:">Priority:</span>
                            <span class="priority-badge" id="final-priority">High</span>
                        </div>
                        <div class="classification-item">
                            <span data-en="Expected Response:" data-bn="প্রত্যাশিত প্রতিক্রিয়া:">Expected Response:</span>
                            <span class="response-time">2-3 business days</span>
                        </div>
                    </div>

                    <div class="next-steps">
                        <h4 data-en="What happens next?" data-bn="পরবর্তী কী ঘটবে?">What happens next?</h4>
                        <ul>
                            <li data-en="Your feedback will be reviewed by relevant department officers" data-bn="আপনার মতামত প্রাসঙ্গিক বিভাগের কর্মকর্তারা পর্যালোচনা করবেন">Your feedback will be reviewed by relevant department officers</li>
                            <li data-en="You'll receive SMS/email updates on progress" data-bn="আপনি অগ্রগতি সম্পর্কে SMS/ইমেইল আপডেট পাবেন">You'll receive SMS/email updates on progress</li>
                            <li data-en="Track status anytime using your tracking ID" data-bn="আপনার ট্র্যাকিং ID ব্যবহার করে যে কোনো সময় স্ট্যাটাস ট্র্যাক করুন">Track status anytime using your tracking ID</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-actions">
                    <a href="{{ url('/track') }}" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        <span data-en="Track Status" data-bn="স্ট্যাটাস ট্র্যাক করুন">Track Status</span>
                    </a>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('success-modal')">
                        <span data-en="Submit Another" data-bn="আরেকটি জমা দিন">Submit Another</span>
                    </button>
                </div>
            </div>
        </div>
    </main>

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
                        <p data-en="AI-powered citizen feedback platform transforming governance in Bangladesh." data-bn="বাংলাদেশে শাসন পরিবর্তনকারী AI-চালিত নাগরিক মতামত প্ল্যাটফর্ম।">AI-powered citizen feedback platform transforming governance in Bangladesh.</p>
                    </div>
                </div>

                <div class="footer-section">
                    <h3 data-en="Quick Links" data-bn="দ্রুত লিংক">Quick Links</h3>
                    <ul>
                        <li><a href="{{ url('/index') }}" data-en="Home" data-bn="হোম">Home</a></li>
                        <li><a href="{{ url('/track') }}" data-en="Track Status" data-bn="স্ট্যাটাস ট্র্যাক করুন">Track Status</a></li>
                        <li><a href="{{ url('/public-insights') }}" data-en="Public Insights" data-bn="জনগণের অন্তর্দৃষ্টি">Public Insights</a></li>
                        <li><a href="{{ url('/login') }}" data-en="Officer Portal" data-bn="কর্মকর্তা পোর্টাল">Officer Portal</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3 data-en="Support" data-bn="সহায়তা">Support</h3>
                    <div class="contact-info">
                        <p><i class="fas fa-envelope"></i> support@cfpip.gov.bd</p>
                        <p><i class="fas fa-phone"></i> +880-2-XXXXXXX</p>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p data-en="© 2024 Government of Bangladesh. All rights reserved. | Powered by AI for the People" data-bn="© ২০২৪ গণপ্রজাতন্ত্রী বাংলাদেশ সরকার। সকল অধিকার সংরক্ষিত। | জনগণের জন্য AI দ্বারা চালিত">&copy; 2024 Government of Bangladesh. All rights reserved. | Powered by AI for the People</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('js/submit-feedback.js') }}"></script>
    <script src="{{ asset('js/feedback-app.js') }}"></script>

</body>
</html>