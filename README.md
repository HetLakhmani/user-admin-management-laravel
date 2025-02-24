### **📌 User-Admin Management System (Laravel 10 + Breeze + Tailwind CSS)**
🚀 A role-based authentication system built with **Laravel 10**, featuring **Admin & User dashboards**, **DataTables integration**, **CRUD operations**, and more.

---

## **📜 Features**
✅ **Role-Based Authentication** – Admin & User dashboards  
✅ **Admin Panel** – Manage users dynamically  
✅ **User Management** – List, edit, delete users with **DataTables**  
✅ **Search & Filter Users** – Using AJAX-powered search  
✅ **Export Data** – Export users list as **Excel**  
✅ **Modern UI** – Styled with **Tailwind CSS**  
✅ **Secure Authentication** – Powered by **Laravel Breeze**

---

## **🚀 Installation & Setup**
Follow these steps to set up the project on your local machine:

### **1️⃣ Clone the Repository**
```sh
git clone https://github.com/your-github-username/user-admin-management-laravel.git
cd user-admin-management-laravel
```

### **2️⃣ Install Dependencies**
```sh
composer install
npm install
```

### **3️⃣ Set Up Environment**
```sh
cp .env.example .env
php artisan key:generate
```
🔹 **Configure Database** in `.env`:  
```
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### **4️⃣ Run Migrations & Seeders**
```sh
php artisan migrate --seed
```
📌 This will create tables and seed **admin & user accounts**.

### **5️⃣ Start Development Server**
```sh
php artisan serve
```
Now, open **http://127.0.0.1:8000** in your browser.

---

## **👤 Default Credentials**
| Role  | Email | Password  |
|--------|----------------|-----------|
| **Admin** | `admin@example.com` | `password` |
| **User**  | `user@example.com` | `password` |

---

## **📂 Project Structure**
```
📦 user-admin-management-laravel
 ┣ 📂 app/Http/Controllers
 ┣ 📂 database/migrations
 ┣ 📂 resources/views
 ┣ 📂 public
 ┣ 📜 routes/web.php
 ┣ 📜 package.json
 ┣ 📜 tailwind.config.js
 ┣ 📜 README.md
```

---

## **📌 Additional Commands**
💡 **To compile assets:**
```sh
npm run dev
```

💡 **To create a new admin manually:**
```sh
php artisan tinker
```
```php
User::create(['name' => 'Super Admin', 'email' => 'admin2@example.com', 'password' => Hash::make('password'), 'role' => 'admin']);
```

💡 **To refresh database (if needed):**
```sh
php artisan migrate:fresh --seed
```

---

## **📜 License**
This project is **open-source** and free to use.

---

### **🌟 Show Support**
💙 If you find this project helpful, consider giving it a **⭐ Star** on GitHub!
