# 1TXT – Better Ratings for Your Business

A sales website and web application that helps small businesses reduce negative reviews by collecting customer ratings via QR codes. Built with **PHP + MySQL** only.

## Folder structure

- **`/frontend`** – Website UI (10 pages), CSS, JS
  - `index.php` – Home page
  - `dashboard.php` – Logged-in dashboard (placeholder)
  - `css/main.css` – Global styles
  - `pages/` – Sign In/Up, Data Security, Pricing, Case Studies, Articles, Contact, Privacy, About, Terms
- **`/backend`** – PHP API and includes
  - `includes/header.php`, `footer.php`, `db.php`, `config.php`
  - `api/auth.php` – Login, signup, forgot password
  - `api/contact.php` – Contact form submission
- **`/data`** – Data and SQL
  - `sql/schema.sql` – MySQL schema (users, business_settings, ratings, responses, leads, sessions, contact_submissions)
- **`/images`** – All images (homepage, data security, case studies, sign.png reference)

## Requirements

- PHP 7.4+ with PDO MySQL
- MySQL 5.7+ or MariaDB
- Web server (Apache/Nginx) with document root set to the **project root** (this folder), so that:
  - `http://yoursite/frontend/index.php` – Home
  - `http://yoursite/images/ImagesForHomepage.png` – Images

## Setup

1. **Database**
   - Create database and user, then run:
   - `mysql -u user -p < data/sql/schema.sql`
   - Or import `data/sql/schema.sql` via phpMyAdmin.

2. **Config**
   - Set environment variables or edit `backend/includes/db.php`:
   - `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` (defaults: localhost, onetxt, root, '').

3. **Web server**
   - Point document root to this project folder.
   - Ensure `frontend/`, `backend/`, `images/` are under the same root.

---

## Running with cPanel

### 1. Upload the project

- **Option A – Main site (domain’s root)**  
  Upload the whole project so that your **document root** (usually `public_html`) contains these folders and files:
  - `frontend/`
  - `backend/`
  - `data/`
  - `images/`
  - (optional) `README.md`

  Your home page will be: `https://yourdomain.com/frontend/index.php`

- **Option B – Subdomain or subfolder**  
  Upload the project into a subfolder, e.g. `public_html/1txt/`.  
  Then the home page is: `https://yourdomain.com/1txt/frontend/index.php`  
  The app detects the path automatically.

Use **File Manager** (File Manager → Upload) or **FTP** (e.g. FileZilla) to upload. Keep the folder structure intact.

### 2. Create the database in cPanel

1. In cPanel, open **MySQL® Databases**.
2. **Create a database**  
   - Name it e.g. `youruser_onetxt` (cPanel often adds your username as prefix).
3. **Create a MySQL user**  
   - Username e.g. `youruser_onetxt`, set a strong password and save it.
4. **Add the user to the database**  
   - Under “Add User To Database”, select the user and the database, then **Add**.
   - On the next screen, tick **ALL PRIVILEGES** and **Make Changes**.

### 3. Import the schema

1. In cPanel, open **phpMyAdmin**.
2. Select the database you created (e.g. `youruser_onetxt`).
3. Go to the **Import** tab.
4. Choose file: `data/sql/schema.sql` from your project.
5. Click **Go**.  
   If your host doesn’t allow `CREATE DATABASE`, open `data/sql/schema.sql` in a text editor, remove or comment out the first two lines (`CREATE DATABASE ...` and `USE onetxt;`), then import again. The database is already created in cPanel; the rest of the file creates the tables.

### 4. Set database credentials

cPanel usually doesn’t use environment variables. Edit the config file:

1. In **File Manager**, go to `backend/`.
2. Copy `config.cpanel-sample.php` to `config.cpanel.php` (or create `config.cpanel.php` with the contents below).
3. Edit `config.cpanel.php` and set your cPanel MySQL details:

```php
<?php
// Database (use the names cPanel shows in MySQL Databases)
define('DB_HOST', 'localhost');
define('DB_NAME', 'youruser_onetxt');   // e.g. cpaneluser_onetxt
define('DB_USER', 'youruser_onetxt');   // e.g. cpaneluser_onetxt
define('DB_PASS', 'your_mysql_password');
```

4. Save the file.

The app will use these values when `config.cpanel.php` exists (see `backend/includes/db.php`).

### 5. Optional: set the home page URL

If you want the site to be at `https://yourdomain.com/` (without `/frontend/index.php`):

1. In cPanel, open **Domains** → **Domains** (or **Addon Domains** / **Subdomains**).
2. Set the **Document Root** for the domain to the folder that contains `frontend`, `backend`, `images` (e.g. `public_html` if you uploaded there).
3. In **File Manager**, inside the document root, create or edit `.htaccess` with:

```apache
DirectoryIndex frontend/index.php
RewriteEngine On
RewriteRule ^$ frontend/index.php [L]
```

Then `https://yourdomain.com/` will show the home page. Links in the site already use relative paths, so they will work.

### 6. PHP version

- In cPanel go to **Select PHP Version** (or **MultiPHP INI Editor**).
- Choose **PHP 7.4** or **8.x** and enable **PDO** and **pdo_mysql** if they aren’t already.

### 7. Test

- Open: `https://yourdomain.com/frontend/index.php` (or `https://yourdomain.com/` if you set the redirect).
- Try **Sign Up** and **Contact** to confirm the database and contact form work.

## Website pages (10)

| Page        | Path                          |
|------------|--------------------------------|
| Home       | `/frontend/index.php`          |
| Sign In/Up | `/frontend/pages/sign.php`    |
| Data Security | `/frontend/pages/data-security.php` |
| Pricing    | `/frontend/pages/pricing.php`  |
| Case Studies | `/frontend/pages/case-studies.php` |
| Articles   | `/frontend/pages/articles.php` |
| Contact    | `/frontend/pages/contact.php`  |
| Privacy    | `/frontend/pages/privacy.php`  |
| About Us   | `/frontend/pages/about.php`   |
| Terms      | `/frontend/pages/terms.php`    |

Footer links: Articles (with anchors), Contact, Privacy, About, Terms.

## Payment (Stripe)

Pricing page has “Buy Now” buttons. Replace placeholders with your Stripe payment links:

- Monthly: `https://buy.stripe.com/your-monthly-link`
- Yearly: `https://buy.stripe.com/your-annual-link`

## Reference

- UI/skeleton inspiration: [Kontakkt](https://kontakkt.com/), [Cervei Features](https://cervei.com/features)
- Sign In layout: `images/sign.png`
- Article content: Baboost blog posts (as per requirement)
