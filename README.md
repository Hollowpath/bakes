# INFO 4345 Web Application Security | Indigo Hat

## Project Overview
This project aims to enhance the security of the Macania Bakes web application originally developed in the Web Technologies course (INFO 2302). Various security components and best practices were implemented to secure the application.

### Group Members
| Name                            | Matric Number | Assigned Tasks                                            | Participation |
|---------------------------------|---------------|-----------------------------------------------------------|---------------|
| Bashir Md Monjur               | 2028113       |   | 100%          |
| Wan Mohd Nazim Bin Wan Muhamad Saidin | 2114261       | login page, registration page,  | 100%          |
| Faizal Akhtar Bin Azhar (Leader)       | 2124565       |  | 100%          |

### Table of Contents:
- [Title of the Web Application](#title-of-the-web-application)
- [Introduction of Web Application](#introduction-of-web-application)
- [Features and Functionalities](#features-and-functionalities)
- [Objective of the Enhancements](#objective-of-the-enhancements)
- [Web Application Security Enhancements](#web-application-security-enhancements)
- [References](#references)

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

2. **Authentication**
   - Implemented secure authentication system:
     - User login/register functionality.
     - Passwords hashed using PHP's `password_hash` and verified with `password_verify`.
     - Sessions managed securely with encryption and expiration to prevent session fixation attacks.

3. **Authorization**
   - Role-based access control (RBAC) implemented:
     - Only `user` can access the web and make reservations.
     - Only `admin` can access the admin page and accept or reject pending reservations.

4. **XSS and CSRF Prevention**
   - Implemented CSRF protection:
     - CSRF tokens generated for every form submission using `random_bytes` and stored in session.
     - Output escaping with `htmlspecialchars` to prevent XSS attacks.

5. **Database Security Principles**
   - Prevented SQL injection using prepared statements (`mysqli_prepare`).
   - Database credentials securely stored and not exposed in source code.

6. **File Security Principles**
   - Applied secure settings and configurations to the XAMPP web server:
     - Disabled MySQL error messages to prevent information leakage.
     - Disabled directory traversal to protect against unauthorized file access.

7. **Additional Security Measures**
   - Sanitized and validated input data to ensure data integrity.
   - Implemented clean and pretty URLs to enhance usability and security.
   - Created new privileges `manager` for MySQL (phpMyAdmin) to only performing CRUD.
   - Set strong passwords for MySQL (phpMyAdmin) accounts to prevent unauthorized access.

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
   - [Weekly Progress Report](https://drive.google.com/drive/folders/1qwGULt8k9e0URn2TiRkVQ1wK0_umDy9K)


### GitHub Repository
- Repository URL: [INFO 4345 Web Application Security | Group Project](https://github.com/Hollowpath/bakes)
- The repository contains:
  - Original: Contains the original web application files (before enhancements).
  - Enhanced: Contains the enhanced web application files with security components.
