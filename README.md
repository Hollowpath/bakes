# Web Application Security Enhancement

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

2. **Authentication**
   - Implemented authentication with hashed passwords using PHP's `password_hash` and `password_verify`.
   - Sessions managed securely to prevent session fixation attacks.

3. **Authorization**
   - Role-based access control (RBAC) implemented:
     - Different access levels (`user`, `admin`) based on user roles stored in the database.

4. **XSS and CSRF Prevention**
   - Implemented CSRF protection using a token generated with `random_bytes` and stored in session.
   - Output escaping with `htmlspecialchars` to prevent XSS attacks.

5. **Database Security Principles**
   - Prevented SQL injection using prepared statements (`mysqli_prepare`).

6. **File Security Principles**
   - Applied secure settings and configurations to the web server to protect sensitive files and directories.

### References
- [PHP Manual](https://www.php.net/manual/en/)
- [OWASP Cheat Sheet Series](https://cheatsheetseries.owasp.org/)

### GitHub Repository
- Repository URL: [Insert GitHub Repository URL]
- The repository contains:
  - Original: Contains the original web application files (before enhancements).
  - Enhanced: Contains the enhanced web application files with security components.
