```text
 ___ _   ___     _______ _   _ _____ ___  ______   __

|_ _| \ | \ \   / / ____| \ | |_   _/ _ \|  _ \ \ / /
 | ||  \| |\ \ / /|  _| |  \| | | || | | | |_) \ V / 
 | || |\  | \ V / | |___| |\  | | || |_| |  _ < | |  
|___|_| \_|  \_/  |_____|_| \_| |_| \___/|_| \_\|_|  
      M A N A G E M E N T   S Y S T E M   ( I M S )
```

> **Updated & Clean Repository** — Web-based Inventory Management System built with PHP and MySQL.

---

## ✨ Features
- **Product & Category Management** (`product_record`, `category_record`)
- **Stock In & Stock Out Tracking** (`stock_in`, `stock_out`)
- **Supplier & Employee Records** (`supplier_record`, `employee_record`)
- **Inventory Reporting & User Access** (`inventory_report`, `user_record`)

---

## 🛠️ Tech Stack
- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** MySQL (`phpMyAdmin`)

---

## ⚙️ Local Setup Instructions
1. Clone this repository into your `htdocs` (XAMPP) or `www` (Laragon) folder:
   ```bash
   git clone https://github.com
   ```
2. Open **phpMyAdmin** and create a new database named:
   ```text
   inventorymanagementsystem
   ```
3. Import the included `.sql` file into the `inventorymanagementsystem` database.
4. Check `db_connect.php` and make sure the database credentials match your local server setup.
5. Run the project in your browser via `http://localhost:8080/Inventory-Management-System`.
