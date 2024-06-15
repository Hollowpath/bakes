# Macania Bakes - Web Application Security Enhancement

## Team Members
| Name               | Matric No    |
|--------------------|--------------|
| Faizal Akhtar Bin Azhar        | 2124565 |
| Wan Mohd Nazim Bin Wan Muhamad Saidin  | 2114261 |
| Bashir Md Monjur  | 2028113 |

## Title
**Macania Bakes - Secure Online Reservation System**

## Introduction
Macania Bakes is a web application designed to facilitate user registrations, logins, and reservations for a bakery. The primary functionalities include user authentication, session management, and reservation processing. This project involves enhancing the security of the original web application developed in the Web Technologies (INFO 2302) course by applying various web application security best practices.

## Objective of the Enhancements
The objective of these enhancements is to ensure the security and integrity of the Macania Bakes web application by implementing robust security measures. This includes input validation, authentication, authorization, XSS and CSRF prevention, database security, and file security. The goal is to provide a secure service to users and ensure the application's availability when needed.

## Web Application Security Enhancements

### 1. Input Validation
#### Client-Side Validation
- **Elements Validated**: Name, number of people, date and time, message.
- **Technique**: HTML5 attributes such as `required`, `type`, and JavaScript for additional validation.
  
#### Server-Side Validation
- **Elements Validated**: Name, number of people, date and time, message.
- **Technique**: PHP functions like `filter_var()`, `htmlspecialchars()`, `trim()`, and `mysqli_real_escape_string()`.

### 2. Authentication
- **Method Used**: Password hashing using `password_hash()` and verification using `password_verify()`.
- **Enhancements**:
  - Implemented secure session management with `session_start()`, `session_regenerate_id()`, and session encryption.
  - Enforced HTTPS using SSL certificates configured in Apache on XAMPP.

### 3. Authorization
- **Method Used**: Role-based access control.
- **Enhancements**:
  - Users are assigned roles (e.g., user, admin) upon registration.
  - Access to specific pages and functionalities is restricted based on user roles.

### 4. XSS and CSRF Prevention
#### XSS Prevention
- **Method Used**: Escaping output using `htmlspecialchars()`.
- **Enhancements**:
  - Applied `htmlspecialchars()` to all user-generated content before displaying it in the browser.

#### CSRF Prevention
- **Method Used**: CSRF tokens.
- **Enhancements**:
  - Generated CSRF tokens using `bin2hex(random_bytes(32))`.
  - Validated CSRF tokens on form submission.

### 5. Database Security Principles
#### SQL Injection Prevention
- **Method Used**: Prepared statements.
- **Enhancements**:
  - Used `mysqli_prepare()` and `bind_param()` to safely execute SQL queries.

#### Database Connection and Server Enhancements
- **Technique**:
  - Stored database credentials in environment variables to hide passwords from source code.
  - Disabled MySQL error messages to avoid leaking sensitive information.
  - Set strong passwords for MySQL root accounts.
  - Created new privileges and restricted access to only necessary permissions.

### 6. File Security Principles
#### Preventing File Leaks
- **Settings and Configurations**:
  - Restricted file permissions on the server.
  - Configured `.htaccess` to deny access to sensitive directories and files.
  - Disabled directory traversal.
  - Sanitized file uploads and URL parameters.

### 7. Original and Enhanced Source Code Repositories
#### Original Source Code
- **Folder**: old

#### Enhanced Source Code
- **Folder**: new

## References
- OWASP Top Ten: [https://owasp.org/www-project-top-ten/](https://owasp.org/www-project-top-ten/)
- PHP Manual: [https://www.php.net/manual/en/](https://www.php.net/manual/en/)
- MySQLi Documentation: [https://www.php.net/manual/en/book.mysqli.php](https://www.php.net/manual/en/book.mysqli.php)
- W3Schools HTML5 Validation: [https://www.w3schools.com/html/html_form_input_types.asp](https://www.w3schools.com/html/html_form_input_types.asp)