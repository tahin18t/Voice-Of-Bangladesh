<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Feedback - VOBD</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Noto+Sans+Bengali:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/track.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tracking-styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
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
                <a href="{{ url('/index') }}" class="nav-link">
                    <i class="fas fa-home"></i>
                    <span data-en="Home" data-bn="হোম">Home</span>
                </a>
                <a href="{{ url('/submit-feedback') }}" class="nav-link">
                    <i class="fas fa-comment-dots"></i>
                    <span data-en="Submit Feedback" data-bn="মতামত দিন">Submit Feedback</span>
                </a>
                <a href="{{ url('/track') }}" class="nav-link active">
                    <i class="fas fa-search-location"></i>
                    <span data-en="Track Progress" data-bn="অগ্রগতি দেখুন">Track Progress</span>
                </a>
            </div>

            <!-- Government Actions -->
            <div class="nav-actions">
                <button class="lang-switch">
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
        <!-- Track Feedback Section -->
        <section class="track-section">
        <div class="container">
            <div class="track-header">
                <div class="track-visual">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&h=200&q=80" alt="Tracking" class="track-visual-img">
                    <div class="track-icon-overlay">
                        <i class="fas fa-search-location"></i>
                    </div>
                </div>
                <h1 class="track-title" data-en="Track Your Feedback" data-bn="আপনার মতামত ট্র্যাক করুন">Track Your Feedback</h1>
                <p class="track-subtitle" data-en="Enter your tracking ID to see the current status and progress of your feedback." data-bn="আপনার মতামতের বর্তমান স্থিতি এবং অগ্রগতি দেখতে ট্র্যাকিং ID লিখুন।">
                    Enter your tracking ID to see the current status and progress of your feedback.
                </p>
            </div>

            <!-- Search Form -->
            <div class="search-container">
                <form id="track-form" class="track-form">
                    <div class="search-input-group">
                        <input
                            type="text"
                            id="tracking-id"
                            name="tracking-id"
                            class="search-input"
                            placeholder="Enter Tracking ID (e.g., FB-1734098555)"
                            data-placeholder-en="Enter Tracking ID (e.g., FB-1734098555)"
                            data-placeholder-bn="ট্র্যাকিং ID লিখুন (যেমন, FB-1734098555)"
                            required
                        >
                        <button type="submit" class="search-btn" data-en="Track" data-bn="ট্র্যাক করুন">
                            <i class="fas fa-search"></i>
                            Track
                        </button>
                    </div>
                    <small class="search-help" data-en="Tracking ID format: FB-XXXXXXXXXX" data-bn="ট্র্যাকিং ID ফরম্যাট: FB-XXXXXXXXXX">
                        Tracking ID format: FB-XXXXXXXXXX
                    </small>
                </form>
            </div>

            <!-- Results Container -->
            <div id="track-results" class="track-results" style="display: none;">
                <!-- Feedback Details Card -->
                <div class="feedback-details-card">
                    <div class="card-header">
                        <h2 class="feedback-title" id="feedback-title" data-en="Feedback Details" data-bn="মতামতের বিস্তারিত">Feedback Details</h2>
                        <span class="feedback-id" id="feedback-id">CFP-2025-00123</span>
                    </div>
                    <div class="card-body">
                        <div class="feedback-info">
                            <div class="info-item">
                                <label data-en="Category:" data-bn="বিভাগ:">Category:</label>
                                <span id="feedback-category">Roads & Highways</span>
                            </div>
                            <div class="info-item">
                                <label data-en="Submitted:" data-bn="জমা দেওয়া:">Submitted:</label>
                                <span id="feedback-date">January 15, 2025</span>
                            </div>
                            <div class="info-item">
                                <label data-en="Location:" data-bn="স্থান:">Location:</label>
                                <span id="feedback-location">Dhaka, Ward 15</span>
                            </div>
                            <div class="info-item">
                                <label data-en="Assigned Department:" data-bn="বরাদ্দকৃত বিভাগ:">Assigned Department:</label>
                                <span id="feedback-department">Roads & Highways Division</span>
                            </div>
                        </div>
                        <div class="feedback-description">
                            <h4 data-en="Description:" data-bn="বিবরণ:">Description:</h4>
                            <p id="feedback-desc">There are several large potholes on the main road in Ward 15 that are causing difficulties for vehicles and pedestrians. The potholes have been there for over 2 months and are getting worse with each rain.</p>
                        </div>
                    </div>
                </div>

                <!-- Status Timeline -->
                <div class="status-timeline-card">
                    <div class="card-header">
                        <h2 class="timeline-title" data-en="Status Timeline" data-bn="স্ট্যাটাস টাইমলাইন">Status Timeline</h2>
                        <span class="current-status" id="current-status">Under Review</span>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item completed" id="step-received">
                                <div class="timeline-marker">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4 class="timeline-title" data-en="Received" data-bn="গৃহীত">Received</h4>
                                    <p class="timeline-description" data-en="Your feedback has been successfully received and registered in our system." data-bn="আপনার মতামত সফলভাবে গ্রহণ করা হয়েছে এবং আমাদের সিস্টেমে নথিভুক্ত করা হয়েছে।">
                                        Your feedback has been successfully received and registered in our system.
                                    </p>
                                    <span class="timeline-date">January 15, 2025 - 10:30 AM</span>
                                </div>
                            </div>
                            <div class="timeline-item completed" id="step-review">
                                <div class="timeline-marker">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4 class="timeline-title" data-en="Under Review" data-bn="পর্যালোচনাধীন">Under Review</h4>
                                    <p class="timeline-description" data-en="Your feedback is being reviewed by the relevant department for appropriate action." data-bn="উপযুক্ত ব্যবস্থার জন্য সংশ্লিষ্ট বিভাগ আপনার মতামত পর্যালোচনা করছে।">
                                        Your feedback is being reviewed by the relevant department for appropriate action.
                                    </p>
                                    <span class="timeline-date">January 16, 2025 - 2:15 PM</span>
                                </div>
                            </div>
                            <div class="timeline-item active" id="step-action">
                                <div class="timeline-marker">
                                    <i class="fas fa-cog fa-spin"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4 class="timeline-title" data-en="Action Taken" data-bn="ব্যবস্থা গ্রহণ">Action Taken</h4>
                                    <p class="timeline-description" data-en="The department is taking necessary action to address your feedback." data-bn="আপনার মতামত সমাধানের জন্য বিভাগ প্রয়োজনীয় ব্যবস্থা নিচ্ছে।">
                                        The department is taking necessary action to address your feedback.
                                    </p>
                                    <span class="timeline-date" data-en="In Progress" data-bn="চলমান">In Progress</span>
                                </div>
                            </div>
                            <div class="timeline-item pending" id="step-resolved">
                                <div class="timeline-marker">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4 class="timeline-title" data-en="Resolved" data-bn="সমাধানকৃত">Resolved</h4>
                                    <p class="timeline-description" data-en="The issue has been resolved and the case is now closed." data-bn="সমস্যাটি সমাধান হয়েছে এবং কেসটি এখন বন্ধ করা হয়েছে।">
                                        The issue has been resolved and the case is now closed.
                                    </p>
                                    <span class="timeline-date" data-en="Pending" data-bn="অপেক্ষমান">Pending</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Response Section -->
                <div class="response-card" id="response-card" style="display: none;">
                    <div class="card-header">
                        <h2 class="response-title" data-en="Official Response" data-bn="সরকারি জবাব">Official Response</h2>
                        <span class="response-date" id="response-date">January 18, 2025</span>
                    </div>
                    <div class="card-body">
                        <div class="response-content" id="response-content">
                            <p>Dear Citizen,</p>
                            <p>Thank you for bringing this matter to our attention. We have inspected the reported area and scheduled repair work to fix the potholes on the main road in Ward 15.</p>
                            <p>The construction team will begin work on January 22, 2025, and the repairs are expected to be completed within 5 working days, weather permitting.</p>
                            <p>We appreciate your patience and your contribution to improving our city's infrastructure.</p>
                            <p>Best regards,<br>Roads & Highways Division</p>
                        </div>
                    </div>
                </div>

                <!-- Rating Section -->
                <div class="rating-card" id="rating-card" style="display: none;">
                    <div class="card-header">
                        <h2 class="rating-title" data-en="Rate This Response" data-bn="এই জবাবটি রেট করুন">Rate This Response</h2>
                    </div>
                    <div class="card-body">
                        <p class="rating-question" data-en="How satisfied are you with the resolution of your feedback?" data-bn="আপনার মতামতের সমাধানে আপনি কতটা সন্তুষ্ট?">
                            How satisfied are you with the resolution of your feedback?
                        </p>
                        <div class="rating-stars">
                            <button class="star" onclick="rate(1)"><i class="fas fa-star"></i></button>
                            <button class="star" onclick="rate(2)"><i class="fas fa-star"></i></button>
                            <button class="star" onclick="rate(3)"><i class="fas fa-star"></i></button>
                            <button class="star" onclick="rate(4)"><i class="fas fa-star"></i></button>
                            <button class="star" onclick="rate(5)"><i class="fas fa-star"></i></button>
                        </div>
                        <div class="rating-comment">
                            <textarea
                                placeholder="Additional comments (optional)"
                                data-placeholder-en="Additional comments (optional)"
                                data-placeholder-bn="অতিরিক্ত মন্তব্য (ঐচ্ছিক)"
                                class="comment-textarea"
                            ></textarea>
                            <button class="btn btn-primary" data-en="Submit Rating" data-bn="রেটিং জমা দিন">
                                Submit Rating
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="track-actions">
                    <button onclick="printDetails()" class="btn btn-outline" data-en="Print Details" data-bn="বিস্তারিত প্রিন্ট করুন">
                        <i class="fas fa-print"></i>
                        Print Details
                    </button>
                    <a href="{{ url('/submit-feedback') }}" class="btn btn-primary" data-en="Submit New Feedback" data-bn="নতুন মতামত দিন">
                        <i class="fas fa-plus"></i>
                        Submit New Feedback
                    </a>
                </div>
            </div>

            <!-- Error Message -->
            <div id="error-message" class="error-message" style="display: none;">
                <div class="error-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="error-content">
                    <h3 data-en="Feedback Not Found" data-bn="মতামত পাওয়া যায়নি">Feedback Not Found</h3>
                    <p data-en="The tracking ID you entered could not be found in our system. Please check the ID and try again." data-bn="আপনার দেওয়া ট্র্যাকিং ID আমাদের সিস্টেমে পাওয়া যায়নি। দয়া করে ID চেক করে আবার চেষ্টা করুন।">
                        The tracking ID you entered could not be found in our system. Please check the ID and try again.
                    </p>
                    <div class="error-tips">
                        <h4 data-en="Tips:" data-bn="টিপস:">Tips:</h4>
                        <ul>
                            <li data-en="Make sure you've entered the complete tracking ID" data-bn="নিশ্চিত হন যে আপনি সম্পূর্ণ ট্র্যাকিং ID দিয়েছেন">Make sure you've entered the complete tracking ID</li>
                            <li data-en="Check for any typos in the ID" data-bn="ID-তে কোনো ভুল আছে কি না চেক করুন">Check for any typos in the ID</li>
                            <li data-en="Tracking IDs are case-sensitive" data-bn="ট্র্যাকিং ID বড় ছোট অক্ষর সংবেদনশীল">Tracking IDs are case-sensitive</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Sample IDs for Testing -->
            <div class="sample-ids">
                <h3 class="sample-title" data-en="Sample Tracking IDs for Testing" data-bn="পরীক্ষার জন্য নমুনা ট্র্যাকিং ID">Sample Tracking IDs for Testing</h3>
                <div class="sample-grid">
                    <div class="sample-card" onclick="loadSample('CFP-2025-00123')">
                        <strong>CFP-2025-00123</strong>
                        <span data-en="Active Case - Under Review" data-bn="সক্রিয় কেস - পর্যালোচনাধীন">Active Case - Under Review</span>
                    </div>
                    <div class="sample-card" onclick="loadSample('CFP-2025-00124')">
                        <strong>CFP-2025-00124</strong>
                        <span data-en="Resolved Case - With Response" data-bn="সমাধানকৃত কেস - জবাবসহ">Resolved Case - With Response</span>
                    </div>
                    <div class="sample-card" onclick="loadSample('CFP-2025-00125')">
                        <strong>CFP-2025-00125</strong>
                        <span data-en="New Case - Just Received" data-bn="নতুন কেস - এইমাত্র গৃহীত">New Case - Just Received</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <div class="footer-logo-img" style="width: 40px; height: 40px; background: #006747; color: #FFFFFF; display: flex; align-items: center; justify-content: center; border-radius: 4px; font-weight: bold; font-size: 14px;">BD</div>
                        <span class="footer-logo-text">Ministry of Bangladesh</span>
                    </div>
                    <p class="footer-description" data-en="Building a better Bangladesh through citizen engagement and transparent governance." data-bn="নাগরিক অংশগ্রহণ ও স্বচ্ছ শাসনের মাধ্যমে একটি উন্নত বাংলাদেশ গড়া।">
                        Building a better Bangladesh through citizen engagement and transparent governance.
                    </p>
                </div>
                <div class="footer-section">
                    <h4 class="footer-title" data-en="Quick Links" data-bn="দ্রুত লিংক">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/index') }}" data-en="Home" data-bn="হোম">Home</a></li>
                        <li><a href="{{ url('/submit-feedback') }}" data-en="Submit Feedback" data-bn="মতামত দিন">Submit Feedback</a></li>
                        <li><a href="{{ url('/track') }}" data-en="Track Status" data-bn="স্ট্যাটাস দেখুন">Track Status</a></li>
                        <li><a href="{{ url('/index') }}" data-en="About" data-bn="সম্পর্কে">About</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4 class="footer-title" data-en="Support" data-bn="সহায়তা">Support</h4>
                    <ul class="footer-links">
                        <li><a href="#" data-en="Privacy Policy" data-bn="গোপনীয়তা নীতি">Privacy Policy</a></li>
                        <li><a href="#" data-en="Terms of Service" data-bn="সেবার শর্তাবলী">Terms of Service</a></li>
                        <li><a href="#" data-en="Contact Us" data-bn="যোগাযোগ">Contact Us</a></li>
                        <li><a href="#" data-en="Help" data-bn="সাহায্য">Help</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4 class="footer-title" data-en="Contact Info" data-bn="যোগাযোগের তথ্য">Contact Info</h4>
                    <div class="contact-info">
                        <p><i class="fas fa-phone"></i> +880-2-XXXXXXX</p>
                        <p><i class="fas fa-envelope"></i> info@cfpip.gov.bd</p>
                        <p><i class="fas fa-map-marker-alt"></i> Dhaka, Bangladesh</p>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Ministry of Bangladesh. All rights reserved. | Digital Bangladesh Initiative</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('js/track-feedback.js') }}"></script>

</body>
</html>
