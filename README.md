# INFO 4345 Web Application Security | Indigo Hat

## Project Overview
This project aims to enhance the security of the Macania Bakes web application originally developed in the Web Technologies course (INFO 2302). Various security components and best practices were implemented to secure the application.

### Group Members
| Name                            | Matric Number | Assigned Tasks                                            | Participation |
|---------------------------------|---------------|-----------------------------------------------------------|---------------|
| Bashir Md Monjur                | 2028113       |   | 100%          |
| Wan Mohd Nazim Bin Wan Muhamad Saidin | 2114261       | login page, registration page, database for registration, sanitization of registration form, regexes on registration server-side, password hashing, main CSRF | 100%          |
| Faizal Akhtar Bin Azhar (Leader)| 2124565       | Session with encryption and expiration, SSL implementation, setting a database password for root MySQL (phpMyAdmin), hiding database password from source codes, disabling MySQL error messages, disabling directory traversal | 100%          |

### Table of Contents:
- [Title of the Web Application](#title-of-the-web-application)
- [Introduction of Web Application](#introduction-of-web-application)
- [Objective of the Enhancements](#objective-of-the-enhancements)
- [Web Application Security Enhancements](#web-application-security-enhancements)
- [References](#references)
- [GitHub Repository](#github-repository)

### Title of the Web Application
Macania Bakes

### Introduction of Web Application
Macania Bakes is a fictional café website where users can explore the café's menu, place reservations, and learn about the café's history and offerings.

### Objective of the Enhancements
The objective is to implement essential web application security practices to protect user data, prevent unauthorized access, and secure the application against common web threats.

### Web Application Security Enhancements
1. **Input Validation**
   - Implemented validation for user inputs across forms:
     - Client-side using JavaScript.
     - Server-side using PHP's `filter_var` and `mysqli_real_escape_string`.
     - Regular expressions (regex) used to enforce specific input formats.
       Snippet from `register_user.php`:
       ```php 
       $name_pattern = "/^[a-zA-Z]+$/";
       $phone_pattern = "/^\d{10}$/";
       $password_pattern = "/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,}$/";
       ```

2. **Authentication**
   - Implemented secure authentication system:
     - User login/register functionality.
     - Passwords hashed using PHP's `password_hash` and verified with `password_verify`.
     - Sessions managed securely with encryption and expiration to prevent session fixation attacks;
        Snippet from `index.php`:
        ```php
        session_start();

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login page if not logged in
            header("Location: login");
            exit();
        }

        // Set session timeout to 10 minutes (600 seconds)
        $timeout = 600;

        // Check if last activity timestamp is set
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
            // Session expired, log out user
            session_unset();     // Unset all session variables
            session_destroy();   // Destroy the session data
            header("Location: login?timeout=true"); // Redirect to login page with timeout parameter
            exit();
        } else {
            $_SESSION['last_activity'] = time(); // Update last activity timestamp
        }
        ```
        Snippet from `admin.php`:
        ```php
        session_start();

        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            // Redirect to unauthorized page
            header("Location: login");
            exit();
        }

        // Check if session timeout
        $timeout = 600; // 10 minutes
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
            session_unset();     // Unset all session variables
            session_destroy();   // Destroy the session data
            header("Location: login?timeout=true"); // Redirect to login page with timeout parameter
            exit();
        } else {
            $_SESSION['last_activity'] = time(); // Update last activity timestamp
        }
        ```
     - Hashing passwords converts them into fixed-length, irreversible strings.
        Snippet from `register_user.php`:
        ```php
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        ```

3. **Authorization**
   - Role-based access control (RBAC) implemented:
     - Only `user` can access the web and make reservations.
     - Only `admin` can access the admin page and accept or reject pending reservations.

4. **XSS and CSRF Prevention**
   - Implemented CSRF protection:
     - CSRF tokens generated for every form submission using `random_bytes` and stored in session.
        Snippet from `csrf.php`:
        ```php
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // CSRF token generation function
        function generateCSRFToken() {
            if (empty($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            return $_SESSION['csrf_token'];
        }

        // CSRF token validation function
        function validateCSRFToken($token) {
            return hash_equals($_SESSION['csrf_token'], $token);
        }
        ?>
        ```
     - Output escaping with `htmlspecialchars` to prevent XSS attacks.

5. **Database Security Principles**
   - Prevented SQL injection using prepared statements (`mysqli_prepare`).
   - Database credentials securely stored and not exposed in source code;
      Create a `.env` file in the root directory of project:
      `.env`:
      ```env
      DB_HOST=localhost
      DB_USER=manager
      DB_PASSWORD=@Manager1
      DB_NAME=bakes
      ```
      Snippet from `login.php`:
      ```php
      <?php
      include 'csrf.php';

      session_start(); // Start the session at the beginning

      // Fetch database configuration from environment variables
      $db_host = getenv('DB_HOST');
      $db_user = getenv('DB_USER');
      $db_password = getenv('DB_PASSWORD');
      $db_name = getenv('DB_NAME');

      // Create a new MySQLi instance
      $mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

      // Check connection
      if ($mysqli->connect_errno) {
          echo "Failed to connect to MySQL: " . htmlspecialchars($mysqli->connect_error);
          exit();
      }

      // ... REST OF THE CODE FOR HANDLING LOGIN ...

      // Close MySQLi connection
      $mysqli->close();
      ?>
      ```
      
6. **File Security Principles**
   - Applied secure settings and configurations to the XAMPP web server:
     - Disabled MySQL error messages to prevent information leakage;
        1. Navigate to XAMPP installation directory.
        2. Inside `my.ini`, find the `[mysqld]` section.
        3. Add or modify the following lines to disable error messages:
          ```ini
          [mysqld]
          # Other existing configurations...

          # Disable error log warnings
          log_error_suppression=1

          # Disable stack trace on errors
          show_compatibility_56=OFF

          # Disable warning messages
          log_warnings=0
          ```
          * `log_error_suppression=1`: Prevents error log warnings.
          * `show_compatibility_56=OFF`: Disables stack traces on errors (works for MySQL 5.7+).
          * `log_warnings=0`: Disables warning messages.
     - Disabled directory traversal to protect against unauthorized file access;
          1. Navigate to XAMPP installation directory.
          2. Open the httpd.conf file within the Apache directory, usually at `C:\xampp\apache\conf\httpd.conf`.
          3. Search for mod_rewrite in httpd.conf and uncomment the line by removing the `#` at the beginning of the line:
              ```apache
              LoadModule rewrite_module modules/mod_rewrite.so
              ```
          4. Below the `LoadModule` line, add the following directives to configure `mod_rewrite` to prevent directory traversal:
              ```apache
              <IfModule mod_rewrite.c>
                  RewriteEngine On
                  RewriteCond %{REQUEST_FILENAME} -d [OR]
                  RewriteCond %{REQUEST_FILENAME} -f
                  RewriteRule ^.*$ - [L]
                  RewriteRule ^../ / [R=404,L]
              </IfModule>
              ```
              * The above rules check if the requested file or directory exists (`-d` for directory, `-f` for file). If it does, the request proceeds (`RewriteRule ^.*$ - [L]`). Otherwise, it returns a 404 Not Found error for requests containing ../ (`RewriteRule ^../ / [R=404,L]`).

7. **Additional Security Measures**
   - Sanitized and validated input data to ensure data integrity.
      Snippet from `register_user.php`:
      ```php
      $first_name = htmlspecialchars(trim($_POST['first_name']), ENT_QUOTES, 'UTF-8');
      $last_name = htmlspecialchars(trim($_POST['last_name']), ENT_QUOTES, 'UTF-8');
      $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
      $phone = htmlspecialchars(trim($_POST['phone']), ENT_QUOTES, 'UTF-8');
      $password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8');
      ```

   - Implemented clean and pretty URLs to enhance usability and security.
   - Created new privileges `manager` for MySQL (phpMyAdmin) to only performing CRUD.
   - Set strong passwords for MySQL (phpMyAdmin) accounts to prevent unauthorized access;
      1. Open web browser and go to `http://localhost/phpmyadmin` (assuming XAMPP is installed locally and using default settings).
      2. Click on the "User accounts" tab at the top of the phpMyAdmin interface.
      3. Click on the "Edit privileges" icon (a small pencil) next to the root user.
      4. In the "Change password" section, enter new password in the "Password" field.
      5. Scroll down and click on the "Go" button at the bottom to save the changes.

   - Implement SSL;
      1. PHP Configuration (`php.ini`):
      uncomment this line by removing `;` symbol.
      ```ini
      extension=openssl
      ```

      2. Apache Configuration (`httpd.conf`):
      Ensure that `mod_rewrite` module is enabled (no `#` in front of `LoadModule rewrite_module modules/mod_rewrite.so`).
      ```conf
      LoadModule rewrite_module modules/mod_rewrite.so
      ```

      3. Certificate Creation and Configuration:
      creating the `V3.ext` file and modifying the `makecert.bat` script in `C:\xampp\apache\makecert.bat`, ensure the command includes `-extfile v3.ext`:
      ```bat
      bin\openssl x509 -in server.csr -out server.crt -req -signkey server.key -days 365 -extfile v3.ext
      ```
      4. After generating the certificate, import it into the Trusted Root Certification Authorities using `certmgr.msc`.

### References
- **OWASP Top Ten**: Guidance on the top ten critical web application security risks and how to mitigate them effectively.
  - [OWASP Top Ten](https://owasp.org/www-project-top-ten/)

- **PHP Security Guide**: Best practices and guidelines for securing PHP applications, covering authentication, input validation, and more.
  - [PHP Security Guide](https://php.net/manual/en/security.php)

- **XAMPP Documentation**: Documentation on configuring and securing XAMPP, ensuring a secure local development environment.
  - [XAMPP Documentation](https://www.apachefriends.org/docs/)

- **MySQL Documentation**: Comprehensive documentation on securing MySQL databases, covering user management, access controls, and secure connections.
  - [MySQL Documentation](https://dev.mysql.com/doc/)

- **Weekly Progress Report:**
   - [Weekly Progress Report](https://drive.google.com/file/d/1umIIF8qrBesdhwAxblqFnm19tvKMbgoa/view)

### GitHub Repository
- Repository URL: [INFO 4345 Web Application Security | Group Project](https://github.com/Hollowpath/bakes)
- The repository contains:
  - Original: Contains the original web application files (before enhancements).
  - Enhanced: Contains the enhanced web application files with security components.
