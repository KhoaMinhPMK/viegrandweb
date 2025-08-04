# VieGrand Backend Setup Instructions

## 📋 Overview
This document provides step-by-step instructions to set up the backend for the VieGrand contact form on your VPS hosting.

## 🔧 Prerequisites
- VPS with PHP 7.4+ and MySQL/MariaDB
- phpMyAdmin access
- Domain: viegrand.site
- Database: viegrand_admin

## 📁 File Structure
After setup, your server should have these files:
```
/home/your-user/public_html/ (or web root)
├── index.html
├── contact-handler.php
├── admin.php
├── .htaccess
├── config/
│   └── database.php
├── scr/
│   └── (all your existing files)
├── assets/
│   └── (all your existing files)
└── sql/
    └── contact_messages.sql
```

## 🚀 Installation Steps

### Step 1: Update Database Configuration
1. Open `config/database.php`
2. Update the database credentials:
```php
define('DB_HOST', 'localhost'); // Usually localhost on VPS
define('DB_NAME', 'viegrand_admin'); // Your database name
define('DB_USER', 'your_db_username'); // Your database username
define('DB_PASS', 'your_db_password'); // Your database password
define('SECURE_KEY', 'your_random_secure_key_here'); // Generate a random string
```

### Step 2: Verify Database Table
1. Access phpMyAdmin at: https://viegrand.site/phpmyadmin/
2. Select database: `viegrand_admin`
3. Verify the `contact_messages` table exists with these columns:
   - id (int, auto-increment, primary key)
   - full_name (varchar 100)
   - email (varchar 100)
   - phone (varchar 20, nullable)
   - subject (varchar 255)
   - message (text)
   - status (enum: unread, read, archived)
   - created_at (timestamp)

### Step 3: Set File Permissions
Run these commands on your VPS:
```bash
chmod 644 *.php
chmod 644 .htaccess
chmod 755 config/
chmod 644 config/database.php
chmod 755 scr/
chmod 644 scr/**/*
```

### Step 4: Test the Setup
1. Visit: https://viegrand.site/scr/screen/home/contact.html
2. Fill out the contact form
3. Submit the form
4. Check if data appears in phpMyAdmin
5. Access admin panel: https://viegrand.site/admin.php

### Step 5: Admin Panel Access
- URL: https://viegrand.site/admin.php
- Default credentials:
  - Username: `admin`
  - Password: `viegrand2025`
  
**⚠️ IMPORTANT: Change the admin password in `admin.php` immediately!**

## 🔒 Security Recommendations

### 1. Change Admin Credentials
In `admin.php`, update these lines:
```php
define('ADMIN_USERNAME', 'your_new_username');
define('ADMIN_PASSWORD', 'your_strong_password');
```

### 2. Enable HTTPS
Uncomment these lines in `.htaccess`:
```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 3. Secure Database Configuration
- Use strong database passwords
- Limit database user permissions
- Consider using environment variables for credentials

### 4. Regular Updates
- Keep PHP and MySQL updated
- Monitor error logs regularly
- Backup database periodically

## 🧪 Testing Checklist

- [ ] Contact form submits successfully
- [ ] Data appears in phpMyAdmin
- [ ] Admin panel loads and shows messages
- [ ] Email validation works
- [ ] Phone validation works (optional field)
- [ ] Status updates work in admin panel
- [ ] Message deletion works
- [ ] Error handling works (try invalid data)
- [ ] Rate limiting works (submit multiple times quickly)

## 🐛 Troubleshooting

### Common Issues:

1. **Database Connection Failed**
   - Check database credentials in `config/database.php`
   - Verify database exists and user has access
   - Check if MySQL service is running

2. **Permission Denied Errors**
   - Check file permissions (644 for files, 755 for directories)
   - Ensure web server can read files

3. **Form Not Submitting**
   - Check browser console for JavaScript errors
   - Verify `contact-handler.php` path is correct
   - Check if PHP is enabled on server

4. **Admin Panel Login Issues**
   - Verify credentials in `admin.php`
   - Check if sessions are enabled in PHP

5. **CORS Errors**
   - Update allowed origins in `contact-handler.php`
   - Ensure all files are on the same domain

## 📞 Support
If you encounter issues:
1. Check PHP error logs
2. Check browser console for JavaScript errors
3. Test database connection manually
4. Verify all files are uploaded correctly

## 📊 Features Included

### Contact Form:
- ✅ Client-side validation
- ✅ Server-side validation
- ✅ Spam protection
- ✅ Rate limiting
- ✅ Vietnamese phone validation
- ✅ Email validation
- ✅ XSS protection
- ✅ SQL injection protection

### Admin Panel:
- ✅ Simple authentication
- ✅ Message statistics
- ✅ Status management (unread/read/archived)
- ✅ Message deletion
- ✅ Responsive design
- ✅ Vietnamese language support

### Security:
- ✅ CSRF protection
- ✅ Input sanitization
- ✅ Rate limiting
- ✅ Security headers
- ✅ File access restrictions

## 🔄 Future Enhancements
Consider implementing:
- Email notifications for new messages
- Advanced admin authentication (JWT/OAuth)
- Message reply functionality
- Export functionality
- Advanced spam filtering
- API endpoints for mobile apps
