/**
 * API Module - Handles all communication with backend API
 * Uses Sanctum token-based authentication
 */

class ApiClient {
    constructor() {
        const metaBase = typeof document !== 'undefined'
            ? document.querySelector('meta[name="api-base-url"]')
            : null;
        const normalizedBase = metaBase && metaBase.content
            ? metaBase.content.replace(/\/+$/, '')
            : `${window.location.origin}/api/v1`;

        this.baseURL = normalizedBase;
        this.token = this.getToken();
    }

    // Token Management
    getToken() {
        return localStorage.getItem('auth_token');
    }

    setToken(token) {
        localStorage.setItem('auth_token', token);
        this.token = token;
    }

    clearToken() {
        localStorage.removeItem('auth_token');
        this.token = null;
    }

    getHeaders(includeAuth = true) {
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        };
        if (includeAuth && this.token) {
            headers['Authorization'] = `Bearer ${this.token}`;
        }
        return headers;
    }

    async request(method, endpoint, data = null, includeAuth = true) {
        const url = `${this.baseURL}${endpoint}`;
        const headers = this.getHeaders(includeAuth);
        const options = {
            method,
            headers,
        };

        // Support FormData (file uploads). If data is FormData, let the
        // browser set the Content-Type (including multipart boundary).
        if (data && (method === 'POST' || method === 'PUT')) {
            if (typeof FormData !== 'undefined' && data instanceof FormData) {
                // remove manual content-type so browser can set boundary
                if (headers['Content-Type']) delete headers['Content-Type'];
                options.body = data;
            } else {
                options.body = JSON.stringify(data);
            }
        }

        try {
            const response = await fetch(url, options);

            if (response.status === 401) {
                this.clearToken();
                window.location.href = '/login';
                throw new Error('Unauthorized - please login again');
            }

            if (response.status === 403) {
                throw new Error('Access denied');
            }

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || `HTTP ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error(`API Error [${method} ${endpoint}]:`, error.message);
            throw error;
        }
    }

    // Auth Endpoints
    async login(email, password) {
        const response = await this.request('POST', '/login', { email, password }, false);
        if (response.token) {
            this.setToken(response.token);
        }
        return response;
    }

    async logout() {
        try {
            await this.request('POST', '/logout');
        } finally {
            this.clearToken();
        }
    }

    // Feedback Endpoints
    async getFeedbacks(filters = {}) {
        const params = new URLSearchParams(filters);
        return this.request('GET', `/feedbacks?${params}`);
    }

    async getFeedbackByTracking(trackingId) {
        return this.request('GET', `/feedbacks/track/${encodeURIComponent(trackingId)}`, null, false);
    }

    async getFeedback(id) {
        return this.request('GET', `/feedbacks/${id}`);
    }

    async createFeedback(data) {
        return this.request('POST', '/feedbacks', data);
    }

    async updateFeedback(id, data) {
        return this.request('PUT', `/feedbacks/${id}`, data);
    }

    async assignFeedback(id, assignedTo, note = '') {
        return this.request('POST', `/feedbacks/${id}/assign`, { assigned_to: assignedTo, note });
    }

    async updateFeedbackStatus(id, status) {
        return this.request('POST', `/feedbacks/${id}/status`, { status });
    }

    // Admin - Users
    async getUsers() {
        return this.request('GET', '/admin/users');
    }

    async getUser(id) {
        return this.request('GET', `/admin/users/${id}`);
    }

    async createUser(data) {
        return this.request('POST', '/admin/users', data);
    }

    async updateUser(id, data) {
        return this.request('PUT', `/admin/users/${id}`, data);
    }

    async deleteUser(id) {
        return this.request('DELETE', `/admin/users/${id}`);
    }

    // Admin - Roles
    async getRoles() {
        return this.request('GET', '/admin/roles');
    }

    async getRole(id) {
        return this.request('GET', `/admin/roles/${id}`);
    }

    async createRole(data) {
        return this.request('POST', '/admin/roles', data);
    }

    async updateRole(id, data) {
        return this.request('PUT', `/admin/roles/${id}`, data);
    }

    async deleteRole(id) {
        return this.request('DELETE', `/admin/roles/${id}`);
    }
}

// Global API client instance
const api = new ApiClient();
