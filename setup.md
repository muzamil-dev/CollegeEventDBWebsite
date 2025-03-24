# 🚀 CampusConnect — College Events Website Setup (MacOS + VS Code)

Welcome to the **CampusConnect** event web app! This guide walks you through getting the site running on your **Mac** using **VS Code** and the **PHP Server extension**.

---

## ✅ Requirements

- macOS (Intel or Apple Silicon)
- [Homebrew](https://brew.sh/)
- [VS Code](https://code.visualstudio.com/)
- [PHP Server Extension (by brapifra)](https://marketplace.visualstudio.com/items?itemName=brapifra.phpserver)
- PHP (v8+): `brew install php`
- MySQL: `brew install mysql`

---

## 1️⃣ Install MySQL

```bash
brew install mysql
brew services start mysql
```

### (Optional) Secure it:

```bash
mysql_secure_installation
```

Then log in:

```bash
mysql -u root
```

---

## 2️⃣ Create the Database

Inside MySQL prompt:

```sql
CREATE DATABASE college_events;
USE college_events;
```

---

## 3️⃣ Create the Tables

Paste the following schema:

```sql
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('student', 'admin', 'super_admin') DEFAULT 'student'
);

CREATE TABLE universities (
    university_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255),
    description TEXT,
    student_count INT,
    image_url VARCHAR(255)
);

CREATE TABLE rsos (
    rso_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    university_id INT NOT NULL,
    admin_id INT NOT NULL,
    is_active BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (university_id) REFERENCES universities(university_id),
    FOREIGN KEY (admin_id) REFERENCES users(user_id)
);

CREATE TABLE rso_members (
    rso_id INT,
    user_id INT,
    PRIMARY KEY (rso_id, user_id),
    FOREIGN KEY (rso_id) REFERENCES rsos(rso_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    description TEXT,
    date DATE,
    time TIME,
    location VARCHAR(255),
    latitude DECIMAL(10, 6),
    longitude DECIMAL(10, 6),
    contact_phone VARCHAR(20),
    contact_email VARCHAR(255),
    visibility ENUM('public', 'private', 'rso') NOT NULL,
    university_id INT,
    rso_id INT,
    approved_by INT,
    FOREIGN KEY (university_id) REFERENCES universities(university_id),
    FOREIGN KEY (rso_id) REFERENCES rsos(rso_id),
    FOREIGN KEY (approved_by) REFERENCES users(user_id)
);

CREATE TABLE comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    comment_text TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(event_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE ratings (
    rating_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    stars INT CHECK (stars BETWEEN 1 AND 5),
    UNIQUE (event_id, user_id),
    FOREIGN KEY (event_id) REFERENCES events(event_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
```

---

## 4️⃣ Setup PHP Server in VS Code

1. Open your project folder in **VS Code**
2. Install **PHP Server** extension by _brapifra_
   - Marketplace: [PHP Server Extension](https://marketplace.visualstudio.com/items?itemName=brapifra.phpserver)
3. Right-click on `frontend/login.html` → **"PHP Server: Serve Project"**
4. It will launch your default browser to something like:
   ```
   http://127.0.0.1:3000/frontend/login.html
   ```

---

## 5️⃣ Set DB Credentials in PHP

Open the following files and edit DB login info:

- `backend/login.php`
- `backend/register.php`
- `backend/submit_comment.php`

Update these variables:

```php
$host = 'localhost';
$db   = 'college_events';
$user = 'your_db_user';
$pass = 'your_password';
```

Create that DB user in MySQL:

```sql
CREATE USER 'your_db_user'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON college_events.* TO 'your_db_user'@'localhost';
FLUSH PRIVILEGES;
```
