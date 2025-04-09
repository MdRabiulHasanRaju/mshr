Task Management System - Admin Panel
====================================

This is a web-based Task Management System built with **CodeIgniter 3**, where admins can manage tasks, assign them to users, and communicate task updates via email. This project is designed to allow an admin to create, view, edit, and delete tasks, as well as assign tasks to specific users.

Features
--------

- **Admin Panel**: Admin can manage tasks and users.
- **CRUD Operations**: Admin can create, read, update, and delete tasks.
- **Email Notifications**: Users are notified by email when a task is assigned.
- **User Management**: Admin can view, add, edit, and delete users.
- **Task Assignment**: Admin can assign tasks to users and track the status of tasks.

Technologies Used
-----------------

- **Backend**: CodeIgniter 3 (PHP framework)
- **Frontend**: HTML, CSS, JavaScript (jQuery, Bootstrap)
- **Database**: MySQL/PostgreSQL (depending on your setup)
- **Email**: SMTP / PHP `mail()` function
- **Authentication**: CodeIgniter session management for user login

Installation
------------

Follow these steps to get your environment up and running:

### Prerequisites

1. **PHP 7.4+** (Recommended version)
2. **Apache or Nginx** web server
3. **MySQL / PostgreSQL** database server
4. **Composer** for managing PHP dependencies (optional, if using external packages)
5. **SMTP Email Service** (such as Gmail or a custom SMTP server)

### Steps to Install

1. **Clone the Repository**:

   ```bash
   git clone https://github.com/yourusername/yourproject.git
   cd yourproject

2. **Set Up the Database:**

- Create a new database (e.g., task_management).

- Import the SQL schema provided in the database/ folder (or create the necessary tables manually).

3. **Configuration:**

- Update your email configuration in application/config/email.php with the SMTP settings for your email provider.

- Set your base URL and database credentials in application/config/config.php and application/config/database.php.

4. **Set Permissions:**

- Ensure that the application/cache and application/logs folders are writable by the web server.

5. **Start Your Web Server:**

- If you're using XAMPP, start Apache and MySQL.

- If using Nginx, make sure to configure the web server to serve the CodeIgniter app.

6. **Access the Admin Panel:**

Open your browser and go to http://localhost/yourproject (or your domain if deployed).

Log in as the admin user (credentials can be configured in the database).

Folder Structure
rust
Copy
Edit
/application
    /config           -> Configuration files (email, database, etc.)
    /controllers      -> PHP files for handling requests
    /models           -> Models for interacting with the database
    /views            -> Frontend files (HTML, CSS, JavaScript)
    /libraries        -> Custom libraries (if any)
    /helpers          -> Helper functions (if any)
    /language         -> Language files
    /logs             -> Application log files
    /cache            -> Cache files
/application/controllers
    /AdminController  -> Controller for handling admin tasks (tasks, users)
    /UserController   -> Controller for handling user-related actions
/application/models
    /Task_model       -> Model for task-related database interactions
    /User_model       -> Model for user-related database interactions
**Usage**
====================================

**Admin Panel**
-----------------
1. **Login:** Navigate to the login page, where the admin can enter their credentials.

2. **Dashboard:** Once logged in, the admin will be redirected to the admin dashboard.

3. **Manage Tasks:**

- Admin can view, add, edit, and delete tasks.

- Admin can assign tasks to specific users.

4. **Manage Users:**

- Admin can view, add, edit, and delete users.

5. **Email Notifications:** When a task is assigned to a user, they will receive an email notification.

**Email Notification**
-----------------
Once a task is assigned to a user, they will receive an email with the task details, including:

- Title
- Description
- Priority
- Due date

The email is sent using either the PHP mail() function or via SMTP (configured in application/config/email.php).

**Task Assignment**
-----------------
- Admin can assign tasks to users by selecting the user from a dropdown list while creating or editing a task.

- Users will be notified via email when a new task is assigned.

**Troubleshooting**
-----------------
**Common Issues**
1. **Email Not Sending:**

- Check $autoload['libraries'] = array('email'); in application/config/autoload.php.


2. **Database Connection Issues:**

- Double-check the database credentials in application/config/database.php.

- Ensure the database is running and accessible.

3. **File Permissions:**

- Ensure the application/cache and application/logs directories are writable.

**Contributing**
-----------------
If you wish to contribute to this project, feel free to fork it and create a pull request. Here are a few guidelines to follow:

- Ensure that your code follows the project's coding standards.

- Write clear and concise commit messages.

- If adding a new feature, ensure that you provide adequate documentation.

**License**
-----------------
This project is open-source and available under the MIT License.