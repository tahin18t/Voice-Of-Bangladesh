# Quick Reference - API Integration

## Files Modified/Created

### New Files
- `public/js/api.js` - Centralized API client (152 lines)
- `API_INTEGRATION_SUMMARY.md` - Full documentation

### Modified Files
- `resources/views/login.blade.php` - Added api.js, changed button
- `resources/views/officer-dashboard.blade.php` - Added api.js
- `resources/views/submit-feedback.blade.php` - Added api.js
- `public/js/script.js` - Updated handleLogin() and searchFeedback()
- `public/js/dashboard-app.js` - Updated 6 methods to use API
- `public/js/feedback-app.js` - Updated submitForm() and showSuccessModal()
- `resources/views/track.blade.php` - Added api.js

---

## API Endpoints

### Authentication
```
POST   /api/v1/login              Login (get token)
POST   /api/v1/logout             Logout
```

### Feedbacks
```
GET    /api/v1/feedbacks          List feedbacks
GET    /api/v1/feedbacks/{id}     Get single feedback
POST   /api/v1/feedbacks          Create feedback
PUT    /api/v1/feedbacks/{id}     Update feedback
POST   /api/v1/feedbacks/{id}/assign    Assign to officer
POST   /api/v1/feedbacks/{id}/status    Update status
```

### Admin - Users
```
GET    /api/v1/admin/users        List users
POST   /api/v1/admin/users        Create user
GET    /api/v1/admin/users/{id}   Get user
PUT    /api/v1/admin/users/{id}   Update user
DELETE /api/v1/admin/users/{id}   Delete user
```

### Admin - Roles
```
GET    /api/v1/admin/roles        List roles
POST   /api/v1/admin/roles        Create role
GET    /api/v1/admin/roles/{id}   Get role
PUT    /api/v1/admin/roles/{id}   Update role
DELETE /api/v1/admin/roles/{id}   Delete role
```

---

## API Client Usage

### Global Instance
```javascript
const api = new ApiClient();  // Already instantiated globally in api.js
```

### Authentication
```javascript
// Login
const response = await api.login('email@example.com', 'password');
// Token auto-stored, user object returned

// Check if logged in
if (api.getToken()) {
  // User is authenticated
}

// Logout
await api.logout();
// Token auto-cleared
```

### Feedbacks
```javascript
// Get all feedbacks
const response = await api.getFeedbacks({ status: 'pending', per_page: 10 });
const feedbacks = response.data;

// Get single feedback
const feedback = await api.getFeedback(feedbackId);

// Create feedback
const newFeedback = await api.createFeedback({
  title: 'Issue title',
  description: 'Detailed description',
  category: 'roads',
  priority: 'high',
  location: 'Dhaka'
});

// Assign feedback
await api.assignFeedback(feedbackId, userId, 'Note about assignment');

// Update status
await api.updateFeedbackStatus(feedbackId, 'resolved');
```

### Admin Operations
```javascript
// Get all users
const users = await api.getUsers();

// Create user
const newUser = await api.createUser({
  name: 'John Doe',
  email: 'john@example.com',
  password: 'secure123',
  role_id: 2
});

// Delete user
await api.deleteUser(userId);
```

---

## Error Handling

### Try-Catch Pattern
```javascript
try {
  const response = await api.getFeedbacks();
  console.log(response.data);
} catch (error) {
  console.error(error.message);
  // Show error to user
  showNotification(error.message, 'error');
}
```

### Common Errors
- **401 Unauthorized**: Token expired, user redirected to login
- **403 Forbidden**: User doesn't have permission for this action
- **404 Not Found**: Resource doesn't exist
- **422 Unprocessable Entity**: Validation errors on request

---

## Token Management

### Stored In
```javascript
localStorage.auth_token = "sanctum_token_here"
```

### Auto-Managed By
```javascript
api.getToken()     // Retrieves token
api.setToken(token)  // Stores token
api.clearToken()   // Removes token (on logout or 401)
```

### Manual Access
```javascript
// Get current token
const token = api.getToken();

// Check if user is logged in
if (api.getToken()) {
  // Show protected content
}

// Logout (clear token)
api.clearToken();
```

---

## Common Patterns

### Load Data on Page
```javascript
async loadPageData() {
  try {
    if (api.getToken()) {
      const feedbacks = await api.getFeedbacks();
      this.feedbackData = feedbacks.data || [];
      this.render();
    } else {
      window.location.href = '/login';
    }
  } catch (error) {
    console.error('Error loading data:', error);
  }
}
```

### Handle Form Submission
```javascript
async handleSubmit(e) {
  e.preventDefault();
  try {
    const formData = new FormData(e.target);
    const response = await api.createFeedback(formData);
    showNotification('Success!', 'success');
    this.reset();
  } catch (error) {
    showNotification(error.message, 'error');
  }
}
```

### Bulk Operations
```javascript
async bulkUpdate() {
  const ids = [1, 2, 3, 4, 5];
  for (const id of ids) {
    await api.updateFeedbackStatus(id, 'resolved');
  }
  showNotification('All updated!', 'success');
}
```

---

## Headers Sent by API Client

### All Requests Include
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}  (if authenticated)
```

### Server Responds With
```
Content-Type: application/json
```

---

## Response Format

### Success Response
```json
{
  "data": { /* resource or array */ },
  "message": "Operation successful"
}
```

### Error Response
```json
{
  "message": "Error message here",
  "errors": { /* validation errors if applicable */ }
}
```

---

## Testing Login

### Test Admin Account
```
Email: admin@cfpip.gov.bd
Password: admin456
```

### Test Officer Account
```
Email: officer@cfpip.gov.bd
Password: password123
```

### Using API Directly
```bash
curl -X POST http://localhost/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@cfpip.gov.bd","password":"admin456"}'
```

---

## Debugging Tips

### Check Token
```javascript
console.log('Current token:', api.getToken());
```

### Test API Endpoint
```javascript
// Open browser console and run:
api.getFeedbacks().then(r => console.log(r)).catch(e => console.error(e));
```

### Monitor Network Traffic
```
Open DevTools → Network tab
All API calls appear under /api/v1/* URLs
```

### Check Headers
```
DevTools → Network → Click request → Headers tab
Authorization header should be: Bearer {token}
```

---

## Performance Tips

1. **Avoid N+1 Queries**: Load related data in single API call
2. **Pagination**: Use per_page parameter to limit results
3. **Caching**: Store frequently accessed data in component state
4. **Lazy Loading**: Load data only when needed
5. **Debouncing**: Debounce search/filter API calls

---

## Security Best Practices

1. ✅ Never log sensitive data
2. ✅ Always validate input on frontend
3. ✅ Use HTTPS in production
4. ✅ Keep token secure (not in URLs)
5. ✅ Implement CSRF protection
6. ✅ Validate server responses

---

## Troubleshooting Checklist

- [ ] Is api.js loaded before other scripts?
- [ ] Is user logged in? `api.getToken()` returns value?
- [ ] Check browser console for errors
- [ ] Check Network tab for failed requests
- [ ] Verify API endpoint exists in routes/api.php
- [ ] Check backend logs: `storage/logs/laravel.log`
- [ ] Is token valid and not expired?
- [ ] Is role authorized for endpoint?

---

## Related Files

- **Backend API**: `routes/api.php`
- **Controllers**: `app/Http/Controllers/Api/*.php`
- **Requests**: `app/Http/Requests/*.php`
- **Models**: `app/Models/*.php`
- **Migrations**: `database/migrations/*.php`
- **Frontend Client**: `public/js/api.js`
- **Tests**: `tests/Feature/UserRoleApiTest.php`

---

## Integration Summary

| Page | Status | API Calls | Notes |
|------|--------|-----------|-------|
| Login | ✅ | `api.login()` | Token auth implemented |
| Dashboard | ✅ | `api.getFeedbacks()`, `api.getFeedback()`, `api.assignFeedback()`, `api.updateFeedbackStatus()` | Real data from API |
| Submit Feedback | ✅ | `api.createFeedback()` | Creates feedback with AI analysis |
| Track Feedback | ✅ | `api.getFeedbacks()` | Track by ID |
| Logout | ✅ | `api.logout()` | Token cleared |

---

## Version Info
- Laravel: 11.x
- PHP: 8.4
- Node: Latest
- Browser Support: Modern browsers (ES6+)

---

Last Updated: 2025-12-03
API Version: v1
Integration Status: Complete ✅
