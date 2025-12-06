# API Integration - Quick Start Guide

## 🚀 Getting Started in 5 Minutes

### Step 1: Run the Application
```bash
cd "d:\PHP\Project\Voice Of BD"
php artisan serve
```
Navigate to: `http://localhost:8000`

### Step 2: Login with Demo Account
```
Email: admin@cfpip.gov.bd
Password: admin456
```

### Step 3: You're In!
Dashboard will load real feedbacks from the API.

---

## 📁 Key Files

| File | Purpose |
|------|---------|
| `public/js/api.js` | API client - the heart of integration |
| `public/js/dashboard-app.js` | Dashboard logic using API |
| `public/js/feedback-app.js` | Feedback form using API |
| `resources/views/login.blade.php` | Login page with API auth |
| `routes/api.php` | Backend API endpoints |

---

## 🔄 How It Works

```
User Action (Click Button)
        ↓
Frontend JavaScript (api.getFeedbacks())
        ↓
HTTP Request to Backend (/api/v1/feedbacks)
        ↓
Backend Validates Token & Returns Data
        ↓
Frontend Renders Data
```

---

## 💻 Using the API in Code

### Get Feedbacks
```javascript
// On any page (if api.js is loaded):
const feedbacks = await api.getFeedbacks();
console.log(feedbacks.data);  // Array of feedback objects
```

### Create Feedback
```javascript
const feedback = await api.createFeedback({
  title: 'Road needs repair',
  description: 'Big pothole at intersection',
  category: 'roads',
  priority: 'high'
});
console.log(feedback.tracking_id);  // Use to track
```

### Check Authentication
```javascript
if (api.getToken()) {
  // User is logged in
  console.log('Authenticated!');
} else {
  // Not logged in
  window.location.href = '/login';
}
```

---

## 📊 Available Methods

| Method | Params | Returns |
|--------|--------|---------|
| `api.login(email, password)` | string, string | { token, user } |
| `api.logout()` | - | - |
| `api.getFeedbacks(filters)` | object | { data: [...] } |
| `api.getFeedback(id)` | number | feedback object |
| `api.createFeedback(data)` | object | created feedback |
| `api.assignFeedback(id, userId, note)` | number, number, string | assignment object |
| `api.updateFeedbackStatus(id, status)` | number, string | updated feedback |
| `api.getUsers()` | - | { data: [...] } |
| `api.createUser(data)` | object | created user |

---

## 🔐 Authentication

### Token Automatically Handled
```javascript
// Login stores token:
await api.login('admin@cfpip.gov.bd', 'admin456');
// localStorage.auth_token is set automatically

// Subsequent requests include token:
// Authorization: Bearer {token}

// Logout clears token:
await api.logout();
// localStorage.auth_token is removed
```

### Manual Token Check
```javascript
const token = api.getToken();
if (token) {
  console.log('Token exists:', token);
}
```

---

## 🐛 Debugging

### Check Network Requests
1. Open DevTools (F12)
2. Go to Network tab
3. Perform action (login, load dashboard, etc.)
4. See API requests to `/api/v1/*`
5. Click request → Headers tab → See Authorization header

### Check Token
```javascript
// In browser console:
console.log(api.getToken());  // Shows current token
console.log(localStorage);     // Shows all localStorage items
```

### Check Errors
```javascript
// Wrap API calls in try-catch:
try {
  await api.getFeedbacks();
} catch (error) {
  console.error('Error:', error.message);  // See what went wrong
}
```

---

## ✅ Testing Checklist

- [ ] Can you login with admin account?
- [ ] Does dashboard show feedbacks?
- [ ] Can you view a feedback (modal opens)?
- [ ] Can you click "Assign" button?
- [ ] Can you submit a new feedback?
- [ ] Does track page find feedback by ID?
- [ ] Does logout clear token?

---

## 🚨 Common Issues

### Issue: "Token not found" or 401 errors
**Solution**: User not logged in. Check:
```javascript
if (!api.getToken()) {
  window.location.href = '/login';  // Redirect to login
}
```

### Issue: API returns 404
**Solution**: Endpoint doesn't exist. Check:
```
routes/api.php - Is the route defined?
Controller - Does the method exist?
Check typo in URL
```

### Issue: "Failed to fetch" error
**Solution**: Network problem. Check:
```
Is server running? (php artisan serve)
Is API accessible? (http://localhost/api/v1/feedbacks)
Are CORS headers correct?
```

---

## 📈 Performance Tips

1. **Cache data** to avoid repeated API calls
2. **Use pagination** to limit results
3. **Debounce** search/filter inputs
4. **Lazy load** large lists

Example:
```javascript
class Dashboard {
  constructor() {
    this.feedbacks = null;  // Cache
  }

  async getFeedbacks() {
    if (!this.feedbacks) {
      this.feedbacks = await api.getFeedbacks();
    }
    return this.feedbacks;
  }

  refresh() {
    this.feedbacks = null;  // Clear cache
    return this.getFeedbacks();
  }
}
```

---

## 🔧 Configuration

### Default Settings (in api.js)
```javascript
baseURL: '/api/v1'              // API base URL
token stored in localStorage    // Token storage
Authorization: Bearer {token}   // Auth header format
```

### To Change API URL
Edit `public/js/api.js`:
```javascript
this.baseURL = '/api/v2';  // Change to v2 (if available)
```

---

## 📚 More Documentation

- **Full Details**: `API_INTEGRATION_SUMMARY.md`
- **Reference**: `API_QUICK_REFERENCE.md`
- **Status Report**: `INTEGRATION_STATUS_REPORT.md`

---

## 🎯 Next Steps

1. ✅ Login with demo account
2. ✅ Explore the dashboard
3. ✅ Submit test feedback
4. ✅ Track the feedback
5. ✅ Read the full documentation
6. ✅ Start building features!

---

## 🆘 Need Help?

### Check These Files
1. `public/js/api.js` - See available methods
2. `routes/api.php` - See API endpoints
3. `app/Http/Controllers/Api/` - See controller logic
4. `browser console` - Check for error messages

### Debug Steps
1. Open DevTools (F12)
2. Go to Console tab
3. Check for red error messages
4. Go to Network tab
5. Look for failed requests (red X)
6. Click request to see details

---

## 📞 Quick Reference

| Action | Code |
|--------|------|
| Login | `await api.login(email, pass)` |
| Check logged in | `if (api.getToken())` |
| Load feedbacks | `await api.getFeedbacks()` |
| Create feedback | `await api.createFeedback(data)` |
| Assign feedback | `await api.assignFeedback(id, userId)` |
| Logout | `await api.logout()` |

---

## 🚀 You're Ready!

The API is fully integrated and ready to use. Start building and have fun! 🎉

For detailed technical information, see the full documentation files.

---

**Last Updated**: December 3, 2025
**Status**: ✅ Production Ready
**API Version**: v1
