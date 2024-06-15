# WEB APPLICATION SECURITY ENHANCEMENT

## Team Members
| Name                              | Matric No. |
|-----------------------------------|------------|
| Faizal Akhtar Bin Azhar           | 2124565    |
| Wan Mohd Nazim Bin Wan Muhamad Saidin | 2114261    |
| Bashir Md Monjur                  | 2028113    |

## Title
**Macania Bakes - Secure Online Reservation System**

## Introduction
Macania Bakes is a web application designed for managing online reservations at a bakery. This project aims to enhance the security of the original web application developed during the Web Technologies (INFO 2302) course by implementing various security measures.

## Objective of the Enhancements
The objective is to integrate advanced security measures into Macania Bakes to ensure the confidentiality, integrity, and availability of data. This includes mitigating common security threats such as SQL injection, XSS, CSRF, and ensuring secure authentication and authorization processes.

## Web Application Security Enhancements

### 1. Input Validation
- **Client-Side Validation**: Validated fields such as name, reservation details, and messages using HTML5 attributes.
- **Server-Side Validation**: Implemented server-side validation using PHP functions like `filter_var()`, `htmlspecialchars()`, and prepared statements.

### 2. Authentication
- **Method Used**: Implemented secure password hashing with `password_hash()` and verification with `password_verify()`.
- **Enhancements**: Secured authentication endpoints and enforced strong password policies.

### 3. Authorization
- **Method Used**: Employed role-based access control (RBAC) to restrict access to specific features based on user roles.
- **Enhancements**: Enhanced authorization mechanisms to prevent unauthorized access to sensitive functionalities.

### 4. XSS and CSRF Prevention
- **XSS Prevention**: Applied output encoding using `htmlspecialchars()` to prevent XSS attacks.
- **CSRF Prevention**: Implemented CSRF tokens in forms using `bin2hex(random_bytes(32))` to mitigate CSRF attacks.

### 5. Database Security Principles
- **SQL Injection Prevention**: Utilized prepared statements and parameterized queries with `mysqli_prepare()` and `bind_param()` to prevent SQL injection attacks.
- **Database Connection Security**: Stored database credentials securely, avoiding hardcoding in source code files.

### 6. File Security Principles
- **Prevention of File Leaks**: Configured server permissions and `.htaccess` files to restrict access to sensitive directories and prevent directory traversal attacks.

### 7. Original and Enhanced Source Code Repositories
- **Original Source Code**: Folder: `old`
- **Enhanced Source Code**: Folder: `new`

## References
- OWASP Top Ten: [https://owasp.org/www-project-top-ten/](https://owasp.org/www-project-top-ten/)
- PHP Manual: [https://www.php.net/manual/en/](https://www.php.net/manual/en/)
- MySQL Documentation: [https://dev.mysql.com/doc/](https://dev.mysql.com/doc/)
- W3Schools HTML5 Validation: [https://www.w3schools.com/html/html_form_input_types.asp](https://www.w3schools.com/html/html_form_input_types.asp)
