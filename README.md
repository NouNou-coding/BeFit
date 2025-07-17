# **BeFit AI**

This guide explains how to set up both the PHP dependencies and `befit_db` database for the BeFit AI project using XAMPP.  
Follow these steps to prepare your complete local development environment.

---

## **Prerequisites**
1. **XAMPP Installed**  
   - Must include Apache and MySQL  
   - [Download XAMPP](https://www.apachefriends.org/download.html)  

### **PHP Version Requirements**
BeFit AI requires **PHP 8.2 or higher**. Verify your version:
```bash
php -v

   - **How to Upgrade PHP**:  
     - Windows (XAMPP): Download the latest PHP 8.2+ binaries and replace the `php` folder in your XAMPP installation.  
       [Download PHP 8.2+ for Windows](https://windows.php.net/download/)  
     - Linux (Debian/Ubuntu):  
       ```bash
       sudo apt install php8.2
       ```
     - macOS (Homebrew):  
       ```bash
       brew install php@8.2
       ```

2. **XAMPP Installed**  
   - Must include Apache and MySQL.  
   - [Download XAMPP](https://www.apachefriends.org/download.html)  

3. **Project Setup**  
   ```bash
   git clone https://github.com/your-repo/BeFit-AI.git
   cd BeFit-AI
   ```

---

### **Troubleshooting: PHP Version Issues**
- **Error: "Unsupported PHP Version"**  
  - Ensure you’re running **PHP 8.2 or later**.  
  - If using XAMPP:  
    1. Download the correct PHP version.  
    2. Replace the `php` folder in `xampp/` directory.  
    3. Restart Apache in XAMPP.  
  - Verify the change:  
    ```bash
    php -v  # Should show 8.2.x or higher.
    ```

---

2. **Project Setup**  
   ```bash
   git clone https://github.com/your-repo/BeFit-AI.git
   cd BeFit-AI

## **1. First-Time Setup**  
### **Option A: Automated Setup (Recommended)**  
Run the `setup.bat` script to automatically create and populate the database:  

1. **Navigate to the `scripts` folder**:  
2. **Run `setup.bat`**:  
   - Double-click the file or execute in Command Prompt:  
     ```bash
     setup.bat
     ```
   - If MySQL has a **password**, edit `setup.bat` first (see [Troubleshooting](#troubleshooting)).  

3. **Verify Setup**:  
   - Open **phpMyAdmin** ([http://localhost/phpmyadmin](http://localhost/phpmyadmin)).  
   - Check if the `befit_db` database and tables (e.g., `users`, `products`) exist.  

---

### **Option B: Manual Setup (Fallback)**  
If the script fails, manually create the database:  
1. Open **phpMyAdmin**.  
2. Click **New** → Name: `befit_db` → Click **Create**.  
3. Import `database/dump.sql`:  
   - Select `befit_db` → Click **Import** → Upload `dump.sql`.  

---

## **2. For Developers: Publishing Database Changes**  
If you modify the database (e.g., add tables), update the shared `dump.sql` for others:  

1. **Run `publish.bat`**:  
   ```bash
   cd scripts
   publish.bat
   ```
   - This exports the current `befit_db` to `database/dump.sql`.  

2. **Commit Changes**:  
   - Push the updated `dump.sql` to Git so others can sync.  

---

## **3. Troubleshooting**  
### **Issue: `setup.bat` or `publish.bat` Fails**  
- **Error: "Access denied for user 'root'"**  
  - **Solution**: Edit the `.bat` files:  
    1. Open `setup.bat` and `publish.bat` in a text editor.  
    2. add `-pYOUR_MYSQL_PASSWORD` with your MySQL password (or remove `-p` if no password).  

- **Error: "Can’t connect to MySQL server"**  
  - **Solution**: Ensure **MySQL** is running in XAMPP.  

---

## **4. Workflow Summary**  
| Role          | Action                                                                 | Command/File               |  
|---------------|-----------------------------------------------------------------------|----------------------------|  
| **User**      | Set up the database for the first time                                | `setup.bat`                |  
| **Developer** | Publish database changes (e.g., new tables)                          | `publish.bat` → Commit `dump.sql` |  

---