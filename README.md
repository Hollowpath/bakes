# WEB APPLICATION SECURITY ENHANCEMENT

## Team Members
| Name                              | Matric No. |
|-----------------------------------|------------|
| Faizal Akhtar Bin Azhar           | 2124565    |
| Wan Mohd Nazim Bin Wan Muhamad Saidin | 2114261    |
| Bashir Md Monjur                  | 2028113    |

## Title
**Restaurant Reservation System - Enhanced Security**

## Introduction
The Restaurant Reservation System is a web application designed for making online reservations at a restaurant. This project aims to enhance the security of the original web application developed during the Web Technologies (INFO 2302) course by implementing advanced security measures.

## Objective of the Enhancements
The objective is to integrate comprehensive security measures into the Restaurant Reservation System to ensure data confidentiality, integrity, and availability. This includes mitigating common security threats such as SQL injection, XSS, CSRF, and ensuring secure authentication and authorization processes.

## Web Application Security Enhancements

### 1. Input Validation
- **Client-Side Validation**: Implemented HTML5 validation attributes (`required`, `type`, `pattern`) for user inputs.
- **Server-Side Validation**: Used PHP functions like `filter_var()`, `htmlspecialchars()`, and prepared statements (`mysqli_prepare()`, `bind_param()`) to validate and sanitize inputs.

### 2. Authentication
- **Method Used**: Employed secure password hashing with `password_hash()` and verification with `password_verify()`.
- **Enhancements**: Enhanced authentication endpoints and enforced strong password policies to resist brute-force attacks.

### 3. Authorization
- **Method Used**: Implemented role-based access control (RBAC) to restrict access based on user roles (`user`, `admin`).
- **Enhancements**: Strengthened authorization mechanisms to prevent unauthorized access to sensitive functionalities.

### 4. XSS and CSRF Prevention
- **XSS Prevention**: Applied output encoding using `htmlspecialchars()` to prevent XSS attacks.
- **CSRF Prevention**: Implemented CSRF tokens using `bin2hex(random_bytes(32))` to mitigate CSRF attacks.

### 5. Database Security Principles
- **SQL Injection Prevention**: Utilized prepared statements (`mysqli_prepare()`) and parameterized queries (`bind_param()`) to prevent SQL injection attacks.
- **Database Connection Security**: Secured database credentials and disabled MySQL error messages to prevent information leakage.

### 6. File Security Principles
- **File Uploads**: Restricted file types and sizes for uploads, and set secure permissions to prevent unauthorized access.
- **Directory Traversal**: Implemented `.htaccess` rules to restrict access and prevent directory traversal attacks.

### 7. SSL/TLS Configuration
- **SSL Implementation**: Configured SSL/TLS to encrypt data transmission, ensuring data confidentiality between clients and the server.

### 8. Additional Security Measures
- **Regex and Input Sanitization**: Used regular expressions and input sanitization techniques to validate and sanitize user inputs effectively.
- **Session Management**: Implemented encrypted sessions with proper expiration policies to manage user sessions securely.
- **Error Handling**: Implemented robust error handling to provide minimal information in error messages, enhancing security against information leakage.

## References
- OWASP Top Ten: [https://owasp.org/www-project-top-ten/](https://owasp.org/www-project-top-ten/)
- PHP Manual: [https://www.php.net/manual/en/](https://www.php.net/manual/en/)
- MySQL Documentation: [https://dev.mysql.com/doc/](https://dev.mysql.com/doc/)
- W3Schools HTML5 Validation: [https://www.w3schools.com/html/html_form_input_types.asp](https://www.w3schools.com/html/html_form_input_types.asp)
