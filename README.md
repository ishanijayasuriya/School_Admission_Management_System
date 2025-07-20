# Gloveman School Admission System

## 📌 Overview

This is a web-based application designed to automate and digitize the government school admission process in Sri Lanka. It supports applications for Grade 1, Grade 6, Grade 12, and transfers from Grades 2 to 11.

---

## 💡 Features

- 👩‍💻 User Registration & Login (User/Admin)
- 📝 Grade-wise Application Submission
- 📤 Document Upload & Verification
- 📊 Admin Panel to Manage Applications
- 📧 Email Notifications for Status Updates
- 🔐 Session-based Access Control
- 📁 Application History for Users
- 📄 Admin Application Approval/Reject Options

---

## 🔧 Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Server**: XAMPP (Apache, MySQL)
- **Email**: PHPMailer (SMTP via Gmail)

---

## 🚀 How to Run the System

1. **Install XAMPP** (https://www.apachefriends.org)
2. **Start Apache and MySQL**
3. **Place project files** in:
   ```
   C:\xampp\htdocs\GSAMS\
   ```
4. **Import the database**:
   - Open `phpMyAdmin` → Create a database (e.g., `school_admission_db`)
   - Import the `.sql` file from `/database/school_admission_db.sql`

5. **Edit DB Config** (`/backend/db_config.php`):
   ```php
   $host = 'localhost';
   $db = 'school_admission_db';
   $user = 'root';
   $pass = '';
   ```

6. **Run in Browser**:
   ```
   http://localhost/GSAMS/
   ```

---

## 📂 Folder Structure

```
GSAMS/
│
├── Front-end/
│   ├── user/
│   ├── admin/
│   └── css/, js/, images/
│
├── backend/
│   ├── user/
│   ├── admin/
│   └── db_config.php, send_email.php
│
├── database/
│   └── gsams_db.sql
│
└── README.md
```

---

## 🧪 Test Credentials

```text
👤 User
Username: parent
Password: Parent@123

👨‍💼 Admin
Username: admin
Password: admin123
```

---

## 📧 Email Configuration

In `send_email.php` or related files:
```php
$mail->Username = 'glovemansystem@gmail';
$mail->Password = 'bkye vcve rogp ubwr';
```

⚠️ Use Gmail App Password, not your actual Gmail password.

---

## ✅ Future Improvements

- Mobile responsive UI
- All school can use one website
- PDF export of application forms
- Sinhala/Tamil translations

---

## 🧑‍💻 Author

**Ishani Umangika Jayasuriya**  
Software Engineering Final Year Project  

---

## 📃 License

This project is for academic use only.
