# Contact Form Database Integration Setup

## Overview
This implementation adds a contact form submission feature that saves user data to a MySQL database. The form is located in the contact section of the website and sends data to the `contact_messages` table in the `viegrand_admin` database.

## Files Created/Modified

### New Files:
1. `api/submit_contact.php` - Backend API for handling form submissions
2. `api/test_connection.php` - Test file to verify database connection
3. `CONTACT_FORM_SETUP.md` - This setup guide

### Modified Files:
1. `scr/screen/home/contact.html` - Updated form fields and added JavaScript handling

## Database Setup

### 1. Database Configuration
- **Host**: localhost
- **Database**: viegrand_admin
- **Username**: admin
- **Password**: (empty)
- **Table**: contact_messages

### 2. Table Structure
The `contact_messages` table has the following structure:
```sql
CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read','archived') NOT NULL DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## Installation Steps

### 1. Upload Files
Upload the following files to your VPS:
- `api/submit_contact.php`
- `api/test_connection.php`
- Updated `scr/screen/home/contact.html`

### 2. Database Setup
1. Access phpMyAdmin on your VPS
2. Navigate to the `viegrand_admin` database
3. Import the `sql/contact_messages.sql` file or create the table manually using the SQL structure above

### 3. Test Database Connection
Visit `https://viegrand.site/api/test_connection.php` to verify:
- Database connection is working
- Table exists with correct structure
- Permissions are set correctly

### 4. Test Form Submission
1. Go to the contact section of your website
2. Fill out the contact form
3. Submit the form
4. Check the database to verify data was saved

## Features

### Form Validation
- **Client-side**: Real-time validation for required fields and email format
- **Server-side**: Comprehensive validation including data length checks
- **Security**: SQL injection prevention using prepared statements

### User Experience
- **Loading states**: Button shows loading animation during submission
- **Notifications**: Success/error messages appear as notifications
- **Form reset**: Form clears after successful submission
- **Responsive**: Works on all device sizes

### Security Features
- **CORS headers**: Proper cross-origin request handling
- **Input sanitization**: All data is trimmed and validated
- **SQL injection prevention**: Uses PDO prepared statements
- **Error handling**: Graceful error handling without exposing sensitive information

## API Endpoint

### POST `/api/submit_contact.php`

**Request Body (JSON):**
```json
{
  "full_name": "John Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "subject": "General Inquiry",
  "message": "Hello, I have a question..."
}
```

**Success Response:**
```json
{
  "success": true,
  "message": "Message sent successfully!",
  "id": 123
}
```

**Error Response:**
```json
{
  "success": false,
  "message": "Error description"
}
```

## Troubleshooting

### Common Issues:

1. **Database Connection Failed**
   - Verify database credentials in `api/submit_contact.php`
   - Check if MySQL service is running
   - Ensure database `viegrand_admin` exists

2. **Table Not Found**
   - Import the SQL file or create table manually
   - Check table name spelling

3. **Permission Denied**
   - Ensure PHP has write permissions to the database
   - Check user permissions in MySQL

4. **Form Not Submitting**
   - Check browser console for JavaScript errors
   - Verify API endpoint URL is correct
   - Check server error logs

### Testing:
1. Test database connection: `https://viegrand.site/api/test_connection.php`
2. Test form submission with valid data
3. Test form validation with invalid data
4. Check database for saved records

## Maintenance

### Viewing Submissions:
1. Access phpMyAdmin
2. Navigate to `viegrand_admin` database
3. Browse `contact_messages` table
4. Records are marked as 'unread' by default

### Updating Status:
```sql
UPDATE contact_messages SET status = 'read' WHERE id = [message_id];
```

## Security Notes

- The API endpoint is publicly accessible but includes proper validation
- Consider adding rate limiting for production use
- Monitor for spam submissions
- Regularly backup the database
- Consider adding CAPTCHA for additional spam protection

## Support

If you encounter issues:
1. Check the browser console for JavaScript errors
2. Check server error logs
3. Test database connection using the test file
4. Verify all files are uploaded correctly 