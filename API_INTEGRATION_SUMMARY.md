# API Integration Summary - Voice Of Bangladesh

## Overview
Complete frontend-backend API integration has been implemented across all pages of the Voice of Bangladesh (VoBD) project. The Laravel backend provides RESTful API endpoints secured with Sanctum token-based authentication, and the frontend consumes these APIs through a centralized JavaScript API client.

---

## Architecture

### Backend (Laravel 11)
- **Framework**: Laravel 11 with modern bootstrap-based configuration
- **Authentication**: Laravel Sanctum with personal access tokens
- **API Base URL**: `/api/v1`
- **Authorization**: Role-based middleware (`EnsureRole`) for admin routes

### Frontend (Vanilla JavaScript)
- **API Client**: `public/js/api.js` - Centralized ApiClient class
- **Token Management**: Stored in `localStorage` as `auth_token`
- **Request Method**: Async/await with proper error handling
- **Authentication Header**: `Authorization: Bearer <token>`

---

## Key Integration Points

### 1. Login Page (`resources/views/login.blade.php`)
**Purpose**: User authentication and token acquisition

**Changes Made**:
- Added `api.js` script before form handler
- Updated `handleLogin()` in `public/js/script.js` to call `api.login(email, password)`
- Token is automatically stored in localStorage by API client
- On success: Redirects to `/officer-dashboard`
- On failure: Displays error modal with API error message

**API Endpoint**:
```
POST /api/v1/login
Body: { email, password }
Response: { token, user }
```

**Demo Credentials**:
```
Admin Account: admin@cfpip.gov.bd / admin456
Officer Account: officer@cfpip.gov.bd / password123
```

---

### 2. Officer Dashboard (`resources/views/officer-dashboard.blade.php`)
**Purpose**: Display and manage citizen feedbacks

**Changes Made**:
- Added `api.js` script
- Updated `public/js/dashboard-app.js`:
  - `loadDashboardData()`: Async function that calls `api.getFeedbacks()`
  - `populateFeedbacksTable()`: Renders real API data instead of mock data
  - `viewFeedback(id)`: Fetches full feedback details via `api.getFeedback(id)`
  - `assignFeedback(id)`: Assigns feedback to user via `api.assignFeedback()`
  - `bulkAssign()`: Assigns multiple feedbacks to same user
  - `bulkUpdateStatus()`: Updates status for multiple feedbacks

**API Endpoints Used**:
```
GET /api/v1/feedbacks                    // List all feedbacks
GET /api/v1/feedbacks/{id}               // Get single feedback details
POST /api/v1/feedbacks/{id}/assign       // Assign feedback
POST /api/v1/feedbacks/{id}/status       // Update feedback status
```

**Features**:
- Real-time feedback data from API
- Proper error handling with user notifications
- Loading states during async operations
- Automatic page refresh after bulk operations

---

### 3. Submit Feedback Page (`resources/views/submit-feedback.blade.php`)
**Purpose**: Citizens submit new feedbacks

**Changes Made**:
- Added `api.js` script
- Updated `public/js/feedback-app.js`:
  - `submitForm()`: Collects form data and calls `api.createFeedback()`
  - `showSuccessModal()`: Displays real tracking ID from API response
  - `updateClassificationResults()`: Shows AI classification from backend

**API Endpoint**:
```
POST /api/v1/feedbacks
Body: FormData {
  title, description, category, priority, 
  location, division, district, ward,
  name, phone, email, files[]
}
Response: {
  tracking_id, department, priority,
  created_at, user_id
}
```

**Features**:
- Anonymous and authenticated submissions
- File upload support (images, PDF, video)
- AI-powered classification on backend
- Real tracking ID generation

---

### 4. Track Feedback Page (`resources/views/track.blade.php`)
**Purpose**: Citizens track submitted feedback status

**Changes Made**:
- Added `api.js` script
- Updated `searchFeedback()` in `public/js/script.js`:
  - Calls `api.getFeedbacks({ tracking_id: trackingId })`
  - Displays real feedback status and progress
  - Proper error handling for not-found feedbacks

**API Endpoint**:
```
GET /api/v1/feedbacks?tracking_id={id}
Response: { data: [feedback] }
```

**Features**:
- Search by tracking ID
- Display real-time status updates
- Show assignment and processing history

---

## API Client (`public/js/api.js`)

### Class: ApiClient

#### Properties
```javascript
baseURL: '/api/v1'
token: auth token from localStorage
```

#### Core Methods

**Token Management**:
```javascript
getToken()           // Retrieve token from localStorage
setToken(token)      // Store token in localStorage
clearToken()         // Remove token and redirect to login
```

**Request Handling**:
```javascript
request(method, endpoint, data, includeAuth)
// Handles all HTTP requests with:
// - Automatic auth headers
// - 401/403 error handling
// - JSON response parsing
// - Error logging
```

**Authentication**:
```javascript
login(email, password)     // POST /login
logout()                   // POST /logout
```

**Feedback Management**:
```javascript
getFeedbacks(filters)      // GET /feedbacks with query params
getFeedback(id)            // GET /feedbacks/{id}
createFeedback(data)       // POST /feedbacks
updateFeedback(id, data)   // PUT /feedbacks/{id}
assignFeedback(id, assignedTo, note)  // POST /feedbacks/{id}/assign
updateFeedbackStatus(id, status)      // POST /feedbacks/{id}/status
```

**Admin Operations**:
```javascript
// Users
getUsers()                 // GET /admin/users
getUser(id)                // GET /admin/users/{id}
createUser(data)           // POST /admin/users
updateUser(id, data)       // PUT /admin/users/{id}
deleteUser(id)             // DELETE /admin/users/{id}

// Roles
getRoles()                 // GET /admin/roles
getRole(id)                // GET /admin/roles/{id}
createRole(data)           // POST /admin/roles
updateRole(id, data)       // PUT /admin/roles/{id}
deleteRole(id)             // DELETE /admin/roles/{id}
```

---

## Error Handling

### Global API Client Error Handling
```javascript
// 401 Unauthorized
-> Clears token
-> Redirects to /login
-> Shows "please login again" message

// 403 Forbidden
-> Shows "Access denied" error
-> User remains on page

// Other HTTP errors
-> Returns JSON error response
-> Frontend handles specific messages
```

### Frontend Error Display
```javascript
// Uses showNotification() or showModal() for user feedback
// Catches all async errors and displays meaningful messages
// Logs errors to console for debugging
```

---

## Data Flow

### Login Flow
```
User enters credentials
    ↓
handleLogin() prevents default form submission
    ↓
api.login(email, password)
    ↓
POST /api/v1/login
    ↓
Backend validates & returns token
    ↓
api.setToken(token) - stored in localStorage
    ↓
showSuccessModal() → Redirect to /officer-dashboard
```

### Dashboard Data Flow
```
Page loads
    ↓
Check if auth token exists: api.getToken()
    ↓
If authenticated:
  - Call api.getFeedbacks({ status: 'all', per_page: 10 })
  ↓
  GET /api/v1/feedbacks
  ↓
  Backend returns paginated feedback list with Sanctum auth
  ↓
  populateFeedbacksTable() renders real data
```

### Feedback Submission Flow
```
User fills form (4 steps)
    ↓
User clicks "Submit Feedback"
    ↓
submitForm() collects FormData
    ↓
api.createFeedback(formData)
    ↓
POST /api/v1/feedbacks (multipart/form-data)
    ↓
Backend:
  - Validates input (StoreFeedbackRequest)
  - Generates tracking ID
  - Stores in database
  - Triggers AI analysis (AnalyzeFeedbackJob)
  ↓
Response: { tracking_id, department, priority }
    ↓
showSuccessModal() displays tracking ID
```

---

## Authentication Flow

### Token-Based Authentication (Sanctum)

1. **Initial Login**
   ```
   POST /api/v1/login { email, password }
   Response: { token: "xxxx|yyyy" }
   ```

2. **Subsequent Requests**
   ```
   Headers: {
     Authorization: "Bearer xxxx|yyyy"
     Content-Type: application/json
     Accept: application/json
   }
   ```

3. **Token Expiration**
   - If 401 returned → token expired or invalid
   - api.clearToken() removes token
   - Redirect to login page
   - User must re-authenticate

4. **Logout**
   ```
   POST /api/v1/logout { with token }
   Response: { message: "logged out" }
   api.clearToken() → localStorage cleared
   Redirect to login
   ```

---

## Database Integration

### Tables Used

1. **users** - Officer/admin accounts
   - Sanctum personal_access_tokens foreign key
   - role_id for role-based access

2. **feedbacks** - Citizen feedback submissions
   - tracking_id (unique)
   - user_id (nullable for anonymous)
   - ai_insight_id (after processing)
   - assigned_to (officer ID)

3. **ai_insights** - AI analysis results
   - feedback_id
   - summary, confidence_score, urgency_score
   - processed_at timestamp

4. **roles** - Role definitions
   - admin, officer roles for RBAC

5. **activity_logs** - Audit trail
   - Track all officer actions

---

## Testing

### PHPUnit Feature Test
**File**: `tests/Feature/UserRoleApiTest.php`
**Status**: ✅ PASSING

**Test Scenarios**:
1. Admin user can list all users with valid token
2. Route properly registered and accessible
3. Middleware properly validates Sanctum token
4. Role-based access control enforced

**Run Test**:
```bash
vendor/bin/phpunit --filter UserRoleApiTest
```

---

## Security Considerations

1. **Token Security**
   - Stored in localStorage (accessible to XSS, but necessary for SPA)
   - Consider moving to httpOnly cookie in production
   - Token expires with server session

2. **CORS (if needed)**
   - Configure in `config/cors.php` for cross-origin requests

3. **Rate Limiting**
   - Configure in `app/Http/Kernel.php` under middleware

4. **Input Validation**
   - All endpoints use Form Requests for validation
   - StoreFeedbackRequest, UpdateFeedbackRequest, etc.

5. **SQL Injection Prevention**
   - All Eloquent queries use parameter binding

---

## File Summary

### Modified Files
```
resources/views/
  ├── login.blade.php                    // Added api.js script, changed button to submit type
  ├── officer-dashboard.blade.php        // Added api.js script
  ├── submit-feedback.blade.php          // Added api.js script
  └── track.blade.php                    // Added api.js script

public/js/
  ├── api.js                             // NEW - Complete ApiClient class
  ├── script.js                          // Updated handleLogin() and searchFeedback()
  ├── dashboard-app.js                   // Updated loadDashboardData(), populateFeedbacksTable(), viewFeedback(), assignFeedback(), bulkAssign(), bulkUpdateStatus()
  └── feedback-app.js                    // Updated submitForm() and showSuccessModal()
```

### Created Files
```
public/js/api.js                         // 152 lines - Full API client implementation
```

---

## Usage Examples

### Example 1: Login
```javascript
// User submits form
const email = 'admin@cfpip.gov.bd';
const password = 'admin456';

const response = await api.login(email, password);
// Token automatically stored: localStorage.auth_token = "xxxx|yyyy"
// User redirected to dashboard
```

### Example 2: Get Feedbacks
```javascript
// On dashboard load
if (api.getToken()) {
  const response = await api.getFeedbacks({ 
    status: 'all', 
    per_page: 10 
  });
  const feedbacks = response.data; // Array of feedback objects
  
  feedbacks.forEach(feedback => {
    // Render in table
  });
}
```

### Example 3: Create Feedback
```javascript
// On feedback form submission
const formData = new FormData(document.getElementById('feedbackForm'));

const response = await api.createFeedback(formData);
const trackingId = response.data.tracking_id;

// Display success with tracking ID
showSuccessModal(trackingId);
```

### Example 4: Assign Feedback
```javascript
// Officer clicks assign button
const feedbackId = 123;
const assigneeId = 456;
const note = 'Please handle this urgently';

await api.assignFeedback(feedbackId, assigneeId, note);

// Feedback reassigned, refresh list
await dashboardApp.loadDashboardData();
```

---

## Troubleshooting

### Issue: Token not persisting
**Solution**: Check localStorage settings, browser's private mode may block it

### Issue: 401 Unauthorized on requests
**Solution**: User token expired, login again with api.login()

### Issue: CORS errors
**Solution**: Configure CORS in Laravel `config/cors.php`

### Issue: File upload fails
**Solution**: Ensure `config/filesystems.php` configured, check file size limits

### Issue: API returns 404
**Solution**: Verify route registered in `routes/api.php`, check controller exists

---

## Next Steps (Optional Enhancements)

1. **Token Refresh Logic**
   - Implement automatic token refresh before expiry
   - Add refresh token support

2. **Offline Support**
   - Implement Service Workers for offline caching
   - Queue requests while offline, sync when online

3. **Real-time Updates**
   - Add WebSocket support for live notifications
   - Update feedback status in real-time

4. **Advanced Filtering**
   - Add date range filtering
   - Add priority-based filtering
   - Add department-based filtering

5. **Pagination Optimization**
   - Implement cursor-based pagination
   - Lazy load table rows on scroll

6. **Analytics Integration**
   - Track page views and user actions
   - Monitor API response times
   - Log errors for debugging

---

## Deployment Checklist

- [ ] Test all API endpoints in production environment
- [ ] Verify token expiration and refresh logic
- [ ] Configure CORS for frontend domain
- [ ] Set up SSL/TLS for HTTPS
- [ ] Configure rate limiting on API endpoints
- [ ] Set up error logging and monitoring
- [ ] Test file upload size limits
- [ ] Verify database backups
- [ ] Configure environment variables (.env)
- [ ] Test with multiple users simultaneously
- [ ] Monitor API performance metrics

---

## Support & Documentation

**API Endpoint Documentation**: See `routes/api.php` for all endpoints
**Controller Code**: See `app/Http/Controllers/Api/` for business logic
**Frontend Code**: See `public/js/api.js` for client implementation
**Database Schema**: See `database/migrations/` for data structure

**Contact**: support@cfpip.gov.bd
