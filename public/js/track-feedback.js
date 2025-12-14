/**
 * Feedback Tracking System - Real API Integration
 */

class FeedbackTracker {
    constructor() {
        this.api = new ApiClient();
        this.init();
    }

    init() {
        this.setupFormListener();
    }

    setupFormListener() {
        const form = document.getElementById('track-form');
        if (!form) return;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            await this.trackFeedback();
        });
    }

    async trackFeedback() {
        const trackingInput = document.getElementById('tracking-id');
        const trackingId = trackingInput?.value.trim();

        if (!trackingId) {
            this.showError('Please enter a tracking ID');
            return;
        }

        try {
            this.showLoading();
            const response = await this.api.trackFeedback(trackingId);
            this.displayResults(response);
        } catch (error) {
            if (error.message.includes('404') || error.message.includes('not found')) {
                this.showNotFound(trackingId);
            } else {
                this.showError(error.message || 'Failed to track feedback');
            }
        } finally {
            this.hideLoading();
        }
    }

    showLoading() {
        const btn = document.querySelector('.search-btn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Tracking...';
        }
    }

    hideLoading() {
        const btn = document.querySelector('.search-btn');
        if (btn) {
            btn.disabled = false;
            const isEnglish = localStorage.getItem('cfpip-language') === 'en';
            btn.innerHTML = `<i class="fas fa-search"></i> ${isEnglish ? 'Track' : 'ট্র্যাক করুন'}`;
        }
    }

    displayResults(feedback) {
        const resultsContainer = document.getElementById('track-results');
        if (!resultsContainer) return;

        // Update feedback details
        document.getElementById('feedback-id').textContent = feedback.tracking_id;
        document.getElementById('feedback-category').textContent = this.formatCategory(feedback.category);
        document.getElementById('feedback-date').textContent = this.formatDate(feedback.created_at);
        document.getElementById('feedback-location').textContent = feedback.location || 'Not specified';
        document.getElementById('feedback-department').textContent = this.getDepartment(feedback.category);
        document.getElementById('feedback-desc').textContent = feedback.description;

        // Update current status
        const statusElement = document.getElementById('current-status');
        if (statusElement) {
            statusElement.textContent = this.formatStatus(feedback.status);
            statusElement.className = `current-status status-${feedback.status}`;
        }

        // Update timeline
        this.updateTimeline(feedback);

        // Show results
        resultsContainer.style.display = 'block';
        resultsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    updateTimeline(feedback) {
        const statusMap = {
            'pending': ['received'],
            'in-progress': ['received', 'review'],
            'resolved': ['received', 'review', 'action'],
            'closed': ['received', 'review', 'action', 'resolved']
        };

        const activeSteps = statusMap[feedback.status] || ['received'];

        // Reset all steps
        const allSteps = ['received', 'review', 'action', 'resolved'];
        allSteps.forEach(step => {
            const element = document.getElementById(`step-${step}`);
            if (element) {
                element.classList.remove('completed', 'active');
            }
        });

        // Activate appropriate steps
        activeSteps.forEach((step, index) => {
            const element = document.getElementById(`step-${step}`);
            if (element) {
                if (index < activeSteps.length - 1) {
                    element.classList.add('completed');
                } else {
                    element.classList.add('active');
                }
            }
        });

        // Update dates
        if (feedback.created_at) {
            const receivedDate = document.querySelector('#step-received .step-date');
            if (receivedDate) receivedDate.textContent = this.formatDate(feedback.created_at);
        }

        if (feedback.updated_at && feedback.status !== 'pending') {
            const reviewDate = document.querySelector('#step-review .step-date');
            if (reviewDate) reviewDate.textContent = this.formatDate(feedback.updated_at);
        }
    }

    showNotFound(trackingId) {
        const resultsContainer = document.getElementById('track-results');
        if (!resultsContainer) return;

        resultsContainer.innerHTML = `
            <div class="not-found-message">
                <div class="not-found-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>Feedback Not Found</h3>
                <p>No feedback found with tracking ID: <strong>${trackingId}</strong></p>
                <p class="help-text">Please check your tracking ID and try again.</p>
                <button onclick="location.reload()" class="btn-retry">
                    <i class="fas fa-redo"></i> Try Again
                </button>
            </div>
        `;
        resultsContainer.style.display = 'block';
    }

    showError(message) {
        alert(`Error: ${message}`);
    }

    formatCategory(category) {
        const categoryMap = {
            'roads': 'Roads & Highways',
            'water': 'Water Supply',
            'health': 'Healthcare',
            'education': 'Education',
            'urban': 'Urban Development',
            'environment': 'Environment',
            'agriculture': 'Agriculture',
            'transport': 'Transportation',
            'electricity': 'Electricity'
        };
        return categoryMap[category] || category;
    }

    formatStatus(status) {
        const statusMap = {
            'pending': 'Pending Review',
            'in-progress': 'Under Review',
            'resolved': 'Action Taken',
            'closed': 'Resolved'
        };
        return statusMap[status] || status;
    }

    getDepartment(category) {
        const departmentMap = {
            'roads': 'Roads & Highways Division',
            'water': 'Water Resources Ministry',
            'health': 'Health & Family Welfare Ministry',
            'education': 'Education Ministry',
            'urban': 'Housing & Public Works Ministry',
            'environment': 'Environment Ministry',
            'agriculture': 'Agriculture Ministry',
            'transport': 'Road Transport Ministry',
            'electricity': 'Power Division'
        };
        return departmentMap[category] || 'General Administration';
    }

    formatDate(dateString) {
        const date = new Date(dateString);
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new FeedbackTracker();
});
