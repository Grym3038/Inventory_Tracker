# ShelfAware – Inventory Tracking System

ShelfAware (also referred to in the code as **Inventory_Tracker**) is a web-based  
inventory management system aimed at small businesses such as boutiques,  
bookstores, and market vendors. Traditional spreadsheet trackers are  
error-prone and off-the-shelf ERP modules are often over-engineered and  
expensive, so ShelfAware offers a middle ground: cloud-hosted, mobile-friendly,  
tenant-safe (each store on its own subdomain), providing enterprise-grade  
features at a small business price point.

## Features
- Real-time “floating” inventory aggregated at day-end, no manual reconciliation  
- Automated low-stock alerts and one-click restock requests  
- Role-based access (owner, manager, employee)  
- Paginated item listings with stock status filters (low-stock, in-stock, out-of-stock)  
- Duplicate SKU validation to prevent errors  
- Historical inventory snapshots and variance reports  
- Dark mode toggle and user profile display in the dashboard  
- Approval workflows for inventory changes  
- Automated restock list generation  
- Notification center (tickets) for restock and report issues  

## Architecture
**Backend:** PHP 8, MySQL, PDO singleton Database class  
**Frontend:** Tailwind CSS, Flowbite components, vanilla JS  
**Structure:** MVC pattern with Controllers (Home, Dashboard, Admin, Item),  
Models (User, Item, Database, AdminDBAccess), Views, and a front controller  
(`index.php`)

## Getting Started

### Prerequisites
- PHP 8.x  
- MySQL 5.7+ or MariaDB  
- Composer (for PHP dependencies)  
- Node.js & npm (for Tailwind CLI)  

### Installation

1. **Clone the repo**  
   ```bash
   git clone https://github.com/Grym3038/Inventory_Tracker.git
   cd Inventory_Tracker
   ```

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Install Node dependencies & build CSS**

   ```bash
   npm install
   npx tailwindcss -i ./src/input.css -o ./Lib/CSS/output.css --watch
   ```

4. **Configure your database**
   Update the DSN, username, and password in `Models/Database.php` if needed
   (defaults to `mysql:host=localhost;dbname=shelfaware;charset=utf8mb4`,
   user `root`, no password).

5. **Initialize schema & seed data**

   ```bash
   mysql -u root < sql.sql
   mysql -u root < data.sql
   ```

6. **Run the server**

   ```bash
   php -S localhost:8000
   ```

   Navigate to `http://localhost:8000` in your browser.

## Usage

### Account Roles

* **Admin:** Full access to manage clients, users, inventory floats, and view reports.
* **Owner:** Can view and approve floats, manage inventory, view reports.
* **Manager:** Can approve float entries, manage restock requests, generate variance reports.
* **Employee:** Can view inventory and submit float entries (limited access).

### Common Actions

* **View Items:** `index.php?action=items`
* **Edit Item:** `index.php?action=edit_item&id={item_id}`
* **Delete Item:** `index.php?action=confirm_delete&id={item_id}`
* **Dashboard:** `index.php?action=dashboard`
* **Settings:** `index.php?action=settings` (toggle dark mode, update name)
* **User Management (Admin):** `index.php?action=users`, `editUser`, `updateUser`, `add_user`

## Future Enhancements

* Deep analytics & visual dashboards
* Multi-warehouse inventory sync
* Advanced forecasting models
* Mobile app integration
* Role-based client onboarding & API key management

## License

MIT License

## Acknowledgments

* Built using Tailwind CSS & Flowbite
* Based on user stories and DFD/ERD compliant design

```


