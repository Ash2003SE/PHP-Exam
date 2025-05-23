# 🔐 PHP OOP Password Manager

A secure, object-oriented PHP application for generating and storing encrypted passwords using AES-256-CBC encryption and MySQL.

## 🧩 Features

- ✅ User registration and login with password hashing
- ✅ Each user gets a unique encryption key (secured with their own password)
- ✅ Save encrypted passwords per service (e.g., Gmail, Facebook)
- ✅ AES-256-CBC used for encryption
- ✅ Custom password generator:
  - Length control
  - Specific number of uppercase, lowercase, numbers, and special characters
- ✅ Responsive dashboard UI
- ✅ Passwords stored securely in MySQL
- ✅ Built with clean OOP architecture

---

## 📁 Project Structure

project-root/
│
├── Classes/ # PHP classes (User, Encryption, PasswordStorage, Generator)
│ ├── User.php
│ ├── Encryption.php
│ ├── PasswordStorage.php
│ └── PasswordGenerator.php
│
├── Config/ # Database connection
│ └── Database.php
│
├── Public/ # Public-facing pages
│ ├── index.php
│ ├── register.php
│ ├── login.php
│ ├── dashboard.php
│ ├── generate.php
│ └── logout.php
│
└── README.md





---

## 🧪 How to Run

### 1. 🛠 Requirements

- PHP 7.4+
- MySQL (e.g. via XAMPP)
- phpMyAdmin (optional for managing DB)
- Git (for pushing to GitHub)

### 2. ⚙️ Setup

1. Clone this repo or copy into `htdocs` in XAMPP.
2. Create the database and tables:

```sql
CREATE DATABASE IF NOT EXISTS password_manager;
USE password_manager;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    encryption_key TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE saved_passwords (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_name VARCHAR(255) NOT NULL,
    password_encrypted TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


Open browser:

bash
Copy
http://localhost/YOUR_PROJECT_FOLDER/public/


 Security Notes
Passwords are hashed using password_hash

Encryption keys are encrypted using AES-256-CBC, using the user's plain password as the key

Passwords saved to DB are fully encrypted per user

Never store plain passwords in production — this is for educational use

🤝 Author
Developed by Ash2003SE

