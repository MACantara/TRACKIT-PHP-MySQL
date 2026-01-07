# TRACKIT - Tracking Real-time Accounts, Costs, and Keeping It Tidy

A comprehensive PHP/MySQL web application designed for managing events, transactions, and organizational activities. Built for educational institutions to track event budgets, documentation, and user management.

## 📋 Overview

TRACKIT is an event management system that allows organizations to:
- Plan and organize events with detailed information
- Track financial transactions and budgets
- Manage user roles and departments
- Generate comprehensive reports and documentation
- Handle event invitations and email notifications

## ✨ Features

### Event Management
- Create, update, and manage events with detailed information
- Track event status (Upcoming, Done, Canceled)
- Set event dates, venues, budgets, and descriptions
- Link events to specific departments
- Document objectives, problems encountered, and recommendations
- Upload and manage event documentation pictures

### Financial Tracking
- Record income and expenses for each event
- Track transaction history with categories
- Generate summary reports
- Monitor budget utilization
- Automated budget calculations

### User Management
- User registration with email verification
- Role-based access control (Student-Council-Officer, Faculty)
- Department assignments
- Profile information management
- Password reset functionality
- Login attempt tracking and security

### Reporting & Documentation
- PDF report generation using TCPDF
- Summary reports for events
- Transaction history reports
- Event documentation with pictures
- Performance tracking

### Email Notifications
- Account verification emails
- Event invitations via secure tokens
- Password reset emails
- Automated notifications using PHPMailer

## 🛠️ Technologies Used

- **Backend**: PHP 8.2+
- **Database**: MySQL/MariaDB 10.4+
- **Email**: PHPMailer 6.9
- **PDF Generation**: TCPDF 6.7
- **Frontend**: HTML5, CSS3, JavaScript
- **Server**: Apache/Nginx (Development: PHP Built-in Server)

## 📁 Project Structure

```
TRACKIT-PHP-MySQL/
├── includes/               # Backend logic and functions
│   ├── add-transaction.inc.php
│   ├── db-connection.inc.php
│   ├── email-functions.inc.php
│   ├── event-functions.inc.php
│   ├── user-functions.inc.php
│   └── ...
├── static/                 # Static assets
│   ├── css/               # Stylesheets
│   └── img/               # Images and logos
├── templates/             # Reusable template files
│   ├── header.tpl.php
│   ├── footer.tpl.php
│   └── ...
├── vendor/                # Composer dependencies
├── config.php             # Application configuration
├── composer.json          # Dependency management
├── trackit.sql           # Database schema and seed data
└── *.php                 # Main application pages
```

## 🚀 Installation

### Prerequisites

- PHP 8.2 or higher
- MySQL/MariaDB 10.4 or higher
- Composer
- Web server (Apache/Nginx) or PHP built-in server

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd TRACKIT-PHP-MySQL
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure database**
   - Create a MySQL database named `trackit`
   - Update database credentials in `includes/db-connection.inc.php`:
     ```php
     $serverName = "localhost";
     $dBUserName = "your_username";
     $dBPassword = "your_password";
     $dBName = "trackit";
     ```

4. **Import database schema**
   ```bash
   mysql -u your_username -p trackit < trackit.sql
   ```

5. **Configure email settings**
   - Update SMTP credentials in `includes/email-functions.inc.php`
   - Set your SMTP host, username, password, and port

6. **Update base URL**
   - Edit `config.php` to set your application URL:
     ```php
     $base_url = 'http://localhost/TRACKIT-PHP-MySQL/';
     ```

7. **Set file permissions** (Linux/Mac)
   ```bash
   chmod -R 755 static/img/
   ```

8. **Start the development server**
   ```bash
   php -S localhost:8000
   ```

9. **Access the application**
   - Open your browser and navigate to `http://localhost:8000`

## 📊 Database Schema

### Core Tables

- **users**: User accounts with authentication
- **departments**: Organizational departments
- **events**: Event information and details
- **transaction_history**: Financial transactions
- **objectives**: Event objectives
- **problems_encountered**: Issues during events
- **recommendations**: Suggested improvements
- **actions_taken**: Corrective actions
- **documentation_pictures**: Event photos

### Junction Tables

- **department_users**: User-department relationships
- **department_events**: Event-department relationships
- **event_objectives**: Event objectives mapping
- **event_problems_encountered**: Event problems mapping
- **event_recommendations**: Event recommendations mapping
- **event_actions_taken**: Event actions mapping
- **event_documentation_pictures**: Event photos mapping

### Security Tables

- **email_verification**: Email verification tokens
- **event_invitations**: Event invitation tokens
- **password_reset**: Password reset tokens
- **login_attempts**: Login attempt tracking

## 👥 User Roles

1. **Student-Council-Officer**: Can manage events, transactions, and generate reports
2. **Faculty**: Can view and participate in events, limited administrative access

## 🔐 Security Features

- Password hashing using bcrypt
- Secure token generation for email verification
- Session timeout management
- Login attempt rate limiting
- SQL injection prevention using prepared statements
- XSS protection
- CSRF token validation

## 📧 Email Configuration

The application uses PHPMailer for sending emails. Configure SMTP settings in `includes/email-functions.inc.php`:

- **Email Verification**: Sent upon user registration
- **Event Invitations**: Secure token-based invitations
- **Password Reset**: Secure password recovery

## 🎨 Main Application Pages

- `index.php` - Landing page
- `log-in.php` - User authentication
- `sign-up.php` - User registration
- `events-overview.php` - List all events
- `event-dashboard.php` - Detailed event view
- `create-event.php` - Create new events
- `update-event.php` - Edit existing events
- `add-transaction.php` - Add financial transactions
- `profile-information.php` - User profile management
- `invite-user.php` - Send event invitations

## 🧪 Development

### Running the Application

**Using PHP Built-in Server:**
```bash
php -S localhost:8000
```

**Using Apache/Nginx:**
- Configure virtual host to point to the project directory
- Ensure mod_rewrite is enabled for Apache

### Code Organization

- **Business Logic**: Located in `includes/` directory
- **Templates**: Reusable components in `templates/` directory
- **Assets**: Static files in `static/` directory
- **Views**: Main PHP files in root directory

## 📝 License

[Add your license information here]

## 👨‍💻 Author

Michael Angelo Cantara

## 🤝 Contributing

[Add contribution guidelines if applicable]

## 📞 Support

For issues and questions, please open an issue in the repository or contact the development team.

---

**Note**: This application is designed for educational purposes and internal organizational use. Ensure proper security configurations before deploying to production environments.
