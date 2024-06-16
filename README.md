# INFO 4345 Web Application Security | Group Project

## Project Overview
This project aims to enhance the security of the Macania Bakes web application originally developed in the Web Technologies course (INFO 2302). Various security components and best practices were implemented to secure the application.

### Group Members
| Name                 | Matric No.     |
|----------------------|----------------|
| Faizal Akhtar Bin Azhar             | 2124565     |
| Wan Mohd Nazim Bin Wan Muhamad Saidin           | 2114261     |
| Bashir Md Monjur      | 2028113     |

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
     - Different access levels `user` based on user roles stored in the database.

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
   - Created new privileges for MySQL (phpMyAdmin) to restrict access based on roles.
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


### GitHub Repository
- Repository URL: [INFO 4345 Web Application Security | Group Project](https://github.com/Hollowpath/bakes)
- The repository contains:
  - Original: Contains the original web application files (before enhancements).
  - Enhanced: Contains the enhanced web application files with security components.
