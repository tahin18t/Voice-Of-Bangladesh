

class FeedbackFormSystem {
    constructor() {
        this.currentStep = 1;
        this.totalSteps = 4;
        this.formData = {};
        this.uploadedFiles = [];
        this.map = null;
        this.currentLocation = null;
        this.aiAnalysisTimeout = null;

        this.districtData = {
            dhaka: ['Dhaka', 'Faridpur', 'Gazipur', 'Gopalganj', 'Kishoreganj', 'Madaripur', 'Manikganj', 'Munshiganj', 'Narayanganj', 'Narsingdi', 'Rajbari', 'Shariatpur', 'Tangail'],
            chittagong: ['Chittagong', 'Bandarban', 'Brahmanbaria', 'Chandpur', 'Comilla', 'Cox\'s Bazar', 'Feni', 'Khagrachhari', 'Lakshmipur', 'Noakhali', 'Rangamati'],
            rajshahi: ['Rajshahi', 'Bogra', 'Joypurhat', 'Naogaon', 'Natore', 'Chapainawabganj', 'Pabna', 'Sirajganj'],
            khulna: ['Khulna', 'Bagerhat', 'Chuadanga', 'Jessore', 'Jhenaidah', 'Kushtia', 'Magura', 'Meherpur', 'Narail', 'Satkhira'],
            sylhet: ['Sylhet', 'Habiganj', 'Moulvibazar', 'Sunamganj'],
            barisal: ['Barisal', 'Barguna', 'Bhola', 'Jhalokati', 'Patuakhali', 'Pirojpur'],
            rangpur: ['Rangpur', 'Dinajpur', 'Gaibandha', 'Kurigram', 'Lalmonirhat', 'Nilphamari', 'Panchagarh', 'Thakurgaon'],
            mymensingh: ['Mymensingh', 'Jamalpur', 'Netrokona', 'Sherpur']
        };

        this.init();
    }

    init() {
        this.setupFormNavigation();
        this.setupAIFeatures();
        this.setupFileUpload();
        this.setupLocationFeatures();
        this.setupFormValidation();
        this.setupCharacterCounters();
        this.setupDynamicTips();
    }

    /* FORM NAVIGATION */

    setupFormNavigation() {
        this.updateNavigationButtons();
        this.updateStepIndicators();
    }

    nextStep() {
        if (this.validateCurrentStep()) {
            if (this.currentStep < this.totalSteps) {
                this.currentStep++;
                this.showStep(this.currentStep);
                this.updateNavigationButtons();
                this.updateStepIndicators();
                this.updateAITips();

                // Trigger AI analysis on step 2
                if (this.currentStep === 2) {
                    this.triggerAIAnalysis();
                }
            }
        }
    }

    previousStep() {
        if (this.currentStep > 1) {
            this.currentStep--;
            this.showStep(this.currentStep);
            this.updateNavigationButtons();
            this.updateStepIndicators();
            this.updateAITips();
        }
    }

    showStep(stepNumber) {
        // Hide all steps
        document.querySelectorAll('.form-step').forEach(step => {
            step.classList.remove('active');
        });

        // Show current step
        document.getElementById(`step-${stepNumber}`).classList.add('active');

        // Scroll to top of form
        document.querySelector('.form-container').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    updateNavigationButtons() {
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const submitBtn = document.getElementById('submit-btn');

        prevBtn.disabled = this.currentStep === 1;

        if (this.currentStep === this.totalSteps) {
            nextBtn.style.display = 'none';
            submitBtn.style.display = 'flex';
        } else {
            nextBtn.style.display = 'flex';
            submitBtn.style.display = 'none';
        }
    }

    updateStepIndicators() {
        document.querySelectorAll('.step-dot').forEach((dot, index) => {
            const stepNumber = index + 1;
            dot.classList.remove('active', 'completed');

            if (stepNumber === this.currentStep) {
                dot.classList.add('active');
            } else if (stepNumber < this.currentStep) {
                dot.classList.add('completed');
            }
        });
    }

    validateCurrentStep() {
        const currentStepElement = document.getElementById(`step-${this.currentStep}`);
        const requiredFields = currentStepElement.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('error');
                isValid = false;
            } else {
                field.classList.remove('error');
            }
        });

        if (!isValid) {
            this.showNotification('Please fill in all required fields', 'error');
        }

        return isValid;
    }

    /*  AI FEATURES */

    setupAIFeatures() {
        // Setup AI-powered category suggestion
        document.getElementById('title').addEventListener('input', (e) => {
            this.debounce(() => this.suggestCategory(e.target.value), 500);
        });

        document.getElementById('description').addEventListener('input', (e) => {
            this.debounce(() => this.analyzeDescription(e.target.value), 1000);
        });
    }

    suggestCategory(title) {
        if (title.length < 10) return;

        // Simple AI simulation based on keywords
        const keywords = {
            roads: ['road', 'highway', 'street', 'traffic', 'pothole', 'bridge'],
            water: ['water', 'pipe', 'tap', 'supply', 'sewage', 'drainage'],
            health: ['hospital', 'doctor', 'medicine', 'health', 'clinic', 'treatment'],
            education: ['school', 'teacher', 'student', 'education', 'class', 'book'],
            urban: ['city', 'urban', 'building', 'park', 'development', 'planning'],
            environment: ['pollution', 'waste', 'garbage', 'tree', 'air', 'environment'],
            agriculture: ['farm', 'crop', 'agriculture', 'farmer', 'irrigation', 'seed'],
            transport: ['bus', 'train', 'transport', 'station', 'ticket', 'vehicle'],
            electricity: ['power', 'electricity', 'electric', 'light', 'outage', 'billing']
        };

        const titleLower = title.toLowerCase();
        let bestMatch = null;
        let maxMatches = 0;

        for (const [category, words] of Object.entries(keywords)) {
            const matches = words.filter(word => titleLower.includes(word)).length;
            if (matches > maxMatches) {
                maxMatches = matches;
                bestMatch = category;
            }
        }

        if (bestMatch && maxMatches > 0) {
            this.showCategorySuggestion(bestMatch);
        }
    }

    showCategorySuggestion(category) {
        const suggestion = document.getElementById('category-suggestion');
        const suggestedCategory = document.getElementById('suggested-category');
        const categorySelect = document.getElementById('category');

        // Don't show if already selected
        if (categorySelect.value === category) return;

        const categoryText = categorySelect.querySelector(`option[value="${category}"]`).textContent;
        suggestedCategory.textContent = categoryText;
        suggestion.style.display = 'flex';

        // Store the suggestion
        suggestion.dataset.suggestedValue = category;
    }

    acceptCategorySuggestion() {
        const suggestion = document.getElementById('category-suggestion');
        const categorySelect = document.getElementById('category');
        const suggestedValue = suggestion.dataset.suggestedValue;

        categorySelect.value = suggestedValue;
        suggestion.style.display = 'none';

        this.showNotification('Category suggestion accepted!', 'success');
    }

    analyzeDescription(description) {
        if (description.length < 50) return;

        this.showAIProcessing();

        // Simulate AI analysis
        setTimeout(() => {
            const analysis = this.performAIAnalysis(description);
            this.showAIAnalysis(analysis);
            this.hideAIProcessing();
        }, 2000);
    }

    performAIAnalysis(text) {
        const textLower = text.toLowerCase();

        // Determine priority based on keywords
        let priority = 'medium';
        const urgentKeywords = ['urgent', 'emergency', 'immediate', 'critical', 'dangerous', 'serious'];
        const highKeywords = ['problem', 'issue', 'broken', 'damaged', 'not working', 'failed'];

        if (urgentKeywords.some(word => textLower.includes(word))) {
            priority = 'high';
        } else if (highKeywords.some(word => textLower.includes(word))) {
            priority = 'medium';
        } else {
            priority = 'low';
        }

        // Suggest department based on content
        const departmentKeywords = {
            'Roads & Highways': ['road', 'street', 'highway', 'traffic', 'bridge'],
            'Water Resources': ['water', 'pipe', 'drainage', 'sewage', 'supply'],
            'Health Services': ['hospital', 'health', 'medical', 'doctor', 'clinic'],
            'Education': ['school', 'education', 'teacher', 'student', 'class'],
            'Urban Development': ['city', 'building', 'park', 'development', 'urban'],
            'Environment': ['pollution', 'waste', 'garbage', 'environment', 'air']
        };

        let suggestedDepartment = 'General Services';
        for (const [dept, keywords] of Object.entries(departmentKeywords)) {
            if (keywords.some(word => textLower.includes(word))) {
                suggestedDepartment = dept;
                break;
            }
        }

        return { priority, department: suggestedDepartment };
    }

    showAIAnalysis(analysis) {
        const analysisElement = document.getElementById('description-analysis');
        const priorityElement = document.getElementById('detected-priority');
        const departmentElement = document.getElementById('suggested-department');

        priorityElement.textContent = analysis.priority;
        priorityElement.className = `priority-badge ${analysis.priority}`;
        departmentElement.textContent = analysis.department;

        analysisElement.style.display = 'block';
    }

    showAIProcessing() {
        document.getElementById('ai-processing').style.display = 'block';
    }

    hideAIProcessing() {
        document.getElementById('ai-processing').style.display = 'none';
    }

    triggerAIAnalysis() {
        setTimeout(() => {
            this.showSuccessPrediction();
        }, 3000);
    }

    showSuccessPrediction() {
        document.getElementById('success-prediction').style.display = 'block';
    }

    /*  DYNAMIC TIPS SYSTEM */

    setupDynamicTips() {
        this.updateAITips();
    }

    updateAITips() {
        // Hide all tips
        document.querySelectorAll('.tip-item').forEach(tip => {
            tip.classList.remove('active');
        });

        // Show relevant tip based on current step
        const tipIds = ['tip-category', 'tip-details', 'tip-evidence', 'tip-contact'];
        const currentTipId = tipIds[this.currentStep - 1];

        if (currentTipId) {
            document.getElementById(currentTipId).classList.add('active');
        }
    }

    /* FILE UPLOAD SYSTEM */

    setupFileUpload() {
        const uploadArea = document.getElementById('file-upload');
        const fileInput = document.getElementById('files');

        // Click to upload
        uploadArea.addEventListener('click', () => {
            fileInput.click();
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            this.handleFiles(e.dataTransfer.files);
        });

        // File input change
        fileInput.addEventListener('change', (e) => {
            this.handleFiles(e.target.files);
        });
    }

    handleFiles(files) {
        Array.from(files).forEach(file => {
            if (this.validateFile(file)) {
                this.uploadedFiles.push(file);
                this.displayUploadedFile(file);
            }
        });
    }

    validateFile(file) {
        const maxSize = 10 * 1024 * 1024; // 10MB
        const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf', 'video/mp4'];

        if (file.size > maxSize) {
            this.showNotification(`File "${file.name}" is too large. Maximum size is 10MB.`, 'error');
            return false;
        }

        if (!allowedTypes.includes(file.type)) {
            this.showNotification(`File type "${file.type}" is not supported.`, 'error');
            return false;
        }

        return true;
    }

    displayUploadedFile(file) {
        const uploadedFilesContainer = document.getElementById('uploaded-files');
        const fileElement = document.createElement('div');
        fileElement.className = 'uploaded-file';
        fileElement.dataset.fileName = file.name;

        const icon = this.getFileIcon(file.type);

        fileElement.innerHTML = `
            <i class="${icon} file-icon"></i>
            <span>${file.name}</span>
            <button type="button" class="remove-file" onclick="feedbackSystem.removeFile('${file.name}')">
                <i class="fas fa-times"></i>
            </button>
        `;

        uploadedFilesContainer.appendChild(fileElement);
    }

    getFileIcon(mimeType) {
        const iconMap = {
            'image/jpeg': 'fas fa-image',
            'image/png': 'fas fa-image',
            'application/pdf': 'fas fa-file-pdf',
            'video/mp4': 'fas fa-video'
        };

        return iconMap[mimeType] || 'fas fa-file';
    }

    removeFile(fileName) {
        // Remove from uploaded files array
        this.uploadedFiles = this.uploadedFiles.filter(file => file.name !== fileName);

        // Remove from DOM
        const fileElement = document.querySelector(`[data-file-name="${fileName}"]`);
        if (fileElement) {
            fileElement.remove();
        }
    }

    /* =========================================================================
       LOCATION FEATURES
       ========================================================================= */

    setupLocationFeatures() {
        this.initializeMap();
        this.setupLocationDropdowns();
    }

    initializeMap() {
        // Initialize Leaflet map centered on Bangladesh
        this.map = L.map('location-map').setView([23.8859, 90.3967], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(this.map);

        // Add click handler
        this.map.on('click', (e) => {
            this.setLocationMarker(e.latlng);
        });
    }

    setupLocationDropdowns() {
        const divisionSelect = document.getElementById('division');
        const districtSelect = document.getElementById('district');

        divisionSelect.addEventListener('change', (e) => {
            const division = e.target.value;
            this.updateDistrictOptions(division);
        });
    }

    updateDistrictOptions(division) {
        const districtSelect = document.getElementById('district');
        districtSelect.innerHTML = '<option value="">Select District</option>';

        if (division && this.districtData[division]) {
            this.districtData[division].forEach(district => {
                const option = document.createElement('option');
                option.value = district.toLowerCase().replace(/\s+/g, '-');
                option.textContent = district;
                districtSelect.appendChild(option);
            });
        }
    }

    getCurrentLocation() {
        if (!navigator.geolocation) {
            this.showNotification('Geolocation is not supported by this browser.', 'error');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (position) => {
                const latlng = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                this.setLocationMarker(latlng);
                this.map.setView(latlng, 15);
            },
            (error) => {
                this.showNotification('Unable to retrieve your location.', 'error');
            }
        );
    }

    setLocationMarker(latlng) {
        // Remove existing marker
        if (this.currentLocation) {
            this.map.removeLayer(this.currentLocation);
        }

        // Add new marker
        this.currentLocation = L.marker([latlng.lat, latlng.lng]).addTo(this.map);
        this.currentLocation.bindPopup('Selected Location').openPopup();
    }

    /* =========================================================================
       FORM UTILITIES
       ========================================================================= */

    setupCharacterCounters() {
        const titleInput = document.getElementById('title');
        const descriptionInput = document.getElementById('description');

        titleInput.addEventListener('input', () => {
            this.updateCharacterCount('title', 100);
        });

        descriptionInput.addEventListener('input', () => {
            this.updateCharacterCount('description', 2000);
        });
    }

    updateCharacterCount(fieldId, maxLength) {
        const field = document.getElementById(fieldId);
        const counter = document.getElementById(`${fieldId}-count`);
        const currentLength = field.value.length;

        counter.textContent = currentLength;

        if (currentLength > maxLength * 0.9) {
            counter.style.color = 'var(--warning)';
        } else if (currentLength === maxLength) {
            counter.style.color = 'var(--danger)';
        } else {
            counter.style.color = 'var(--gray-500)';
        }
    }

    setupFormValidation() {
        const form = document.getElementById('feedbackForm');

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.submitForm();
        });
    }

    /* FORM SUBMISSION */

    async submitForm() {
        try {
            // Collect all form data
            const formData = this.collectFormData();

            // Frontend validation - ensure title is present
            if (!formData.title || formData.title.trim() === '') {
                this.showNotification('Please enter a title for your feedback', 'error');
                return;
            }

            // Show processing
            this.showProcessingModal();

            // Check if user is authenticated
            if (api && api.getToken()) {
                // Send to API
                const response = await api.createFeedback(formData);

                // Store tracking ID for success modal
                this.lastTrackingId = response.data?.tracking_id || response.tracking_id || 'CFPIP-' + Date.now();
                this.lastDepartment = response.data?.department || 'Government Department';
                this.lastPriority = response.data?.priority || 'medium';
            } else {
                // For anonymous submissions, still send to API (backend will handle)
                const response = await api.createFeedback(formData);
                this.lastTrackingId = response.data?.tracking_id || response.tracking_id || 'CFPIP-' + Date.now();
                this.lastDepartment = response.data?.department || 'Government Department';
                this.lastPriority = response.data?.priority || 'medium';
            }

            // Hide processing and show success
            this.hideProcessingModal();
            this.showSuccessModal();

        } catch (error) {
            console.error('Submission error:', error);
            this.hideProcessingModal();

            // Handle validation errors
            if (error.message && error.message.includes('title')) {
                this.showNotification('Please ensure the title field is filled in', 'error');
            } else {
                this.showNotification(error.message || 'Failed to submit feedback. Please try again.', 'error');
            }
        }
    }

    collectFormData() {
        const form = document.getElementById('feedbackForm');
        const formData = new FormData(form);

        // Convert FormData to plain object for JSON serialization
        const data = {};

        // Get all form fields
        for (let [key, value] of formData.entries()) {
            // Skip empty values except for required fields
            if (value !== '' || key === 'title') {
                data[key] = value;
            }
        }

        // Add uploaded files as array of file names (for now)
        // TODO: Implement actual file upload handling
        if (this.uploadedFiles.length > 0) {
            data.attachments = this.uploadedFiles.map(file => file.name);
        }

        // Add location if selected
        if (this.currentLocation) {
            data.latitude = this.currentLocation.getLatLng().lat;
            data.longitude = this.currentLocation.getLatLng().lng;
            data.location = `${data.latitude}, ${data.longitude}`;
        }

        return data;
    }

    async simulateSubmission(formData) {
        // Simulate AI processing time
        return new Promise(resolve => {
            setTimeout(() => {
                resolve();
            }, 3000);
        });
    }

    showProcessingModal() {
        const processing = document.createElement('div');
        processing.id = 'processing-modal';
        processing.className = 'modal show';
        processing.innerHTML = `
            <div class="modal-content" style="text-align: center; padding: 3rem;">
                <div class="processing-animation">
                    <div class="processing-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <h3>AI Processing Your Feedback...</h3>
                <p>Please wait while we analyze and route your submission.</p>
            </div>
        `;

        document.body.appendChild(processing);
    }

    hideProcessingModal() {
        const processing = document.getElementById('processing-modal');
        if (processing) {
            processing.remove();
        }
    }

    showSuccessModal() {
        const modal = document.getElementById('success-modal');

        // Update tracking ID with real API response
        const trackingId = this.lastTrackingId || this.generateTrackingId();
        document.getElementById('generated-tracking-id').textContent = trackingId;

        // Update AI classification results with real data
        this.updateClassificationResults();

        // Show modal
        modal.classList.add('show');
        modal.style.display = 'flex';
    }

    generateTrackingId() {
        const year = new Date().getFullYear();
        const randomNum = Math.floor(Math.random() * 999999).toString().padStart(6, '0');
        return `CFPIP-${year}-${randomNum}`;
    }

    updateClassificationResults() {
        // Use real data from API if available
        if (this.lastDepartment && this.lastPriority) {
            document.getElementById('final-department').textContent = this.lastDepartment;
            document.getElementById('final-priority').textContent = this.lastPriority.charAt(0).toUpperCase() + this.lastPriority.slice(1);
            document.getElementById('final-priority').className = `priority-badge ${this.lastPriority.toLowerCase()}`;
        } else {
            // Fallback to form data if API data not available
            const category = document.getElementById('category').value;

            // Map category to department
            const categoryDepartmentMap = {
                roads: 'Roads & Highways Ministry',
                water: 'Water Resources Ministry',
                health: 'Health & Family Welfare Ministry',
                education: 'Education Ministry',
                urban: 'Housing & Public Works Ministry',
                environment: 'Environment Ministry',
                agriculture: 'Agriculture Ministry',
                transport: 'Road Transport Ministry',
                electricity: 'Power Division'
            };

            const department = categoryDepartmentMap[category] || 'General Administration';
            const urgency = document.querySelector('input[name="urgency"]:checked')?.value || 'medium';
            const priority = urgency.charAt(0).toUpperCase() + urgency.slice(1);

            document.getElementById('final-department').textContent = department;
            document.getElementById('final-priority').textContent = priority;
            document.getElementById('final-priority').className = `priority-badge ${urgency.toLowerCase()}`;
        }
    }

    /*  UTILITY FUNCTIONS */

    debounce(func, wait) {
        clearTimeout(this.aiAnalysisTimeout);
        this.aiAnalysisTimeout = setTimeout(func, wait);
    }

    showNotification(message, type = 'info') {
        if (window.CFPIPPortal && window.CFPIPPortal.showNotification) {
            window.CFPIPPortal.showNotification(message, type);
        } else {
            alert(message); // Fallback
        }
    }
}

/* GLOBAL FUNCTIONS */

// Initialize feedback system
let feedbackSystem;
document.addEventListener('DOMContentLoaded', () => {
    feedbackSystem = new FeedbackFormSystem();
});

// Global functions for HTML onclick handlers
function nextStep() {
    feedbackSystem.nextStep();
}

function previousStep() {
    feedbackSystem.previousStep();
}

function acceptCategorySuggestion() {
    feedbackSystem.acceptCategorySuggestion();
}

function getCurrentLocation() {
    feedbackSystem.getCurrentLocation();
}

function toggleAnonymous() {
    const checkbox = document.getElementById('anonymous');
    const contactFields = document.getElementById('contact-fields');

    if (checkbox.checked) {
        contactFields.classList.add('disabled');
        contactFields.querySelectorAll('input').forEach(input => {
            input.required = false;
        });
    } else {
        contactFields.classList.remove('disabled');
        contactFields.querySelectorAll('input[data-required="true"]').forEach(input => {
            input.required = true;
        });
    }
}

function copyTrackingId() {
    const trackingId = document.getElementById('generated-tracking-id').textContent;

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(trackingId).then(() => {
            feedbackSystem.showNotification('Tracking ID copied to clipboard!', 'success');
        });
    } else {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = trackingId;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        feedbackSystem.showNotification('Tracking ID copied to clipboard!', 'success');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('show');
    modal.style.display = 'none';

    // Reset form if closing success modal
    if (modalId === 'success-modal') {
        document.getElementById('feedbackForm').reset();
        feedbackSystem.currentStep = 1;
        feedbackSystem.showStep(1);
        feedbackSystem.updateNavigationButtons();
        feedbackSystem.updateStepIndicators();
        feedbackSystem.uploadedFiles = [];
        document.getElementById('uploaded-files').innerHTML = '';
    }
}
