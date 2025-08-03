# Inventory_Tracker

**ShelfAware – Inventory Tracking System**

ShelfAware (also referred to in the code as  **Inventory\_Tracker**) is a web‑based inventory management

system   aimed   at   small   businesses   such   as   boutiques,   bookstores   and   market   vendors.   Traditional spreadsheet   trackers   are   error‑prone   and   off‑the‑shelf   ERP   modules   are   often   over‑engineered   and expensive, so ShelfAware offers a middle ground: cloud‑hosted, mobile‑friendly inventory tracking with role‑based access and day‑end floating inventory. The system provides real‑time stock updates, low‑stock alerts and user‑friendly controls that help organizations maintain optimal stock levels and reduce mistakes.

**Features**

ShelfAware implements the following functionality out of the box:

**Core inventory features**

- **Day‑end floating inventory:** At the end of each business day the system aggregates sales and inventory changes into an *inventory float*. Employees submit counts per item, and managers approve or modify those counts. Completed floats are stored as historical snapshots, allowing you to audit previous days’ stock levels.
- **Approval workflow:** Inventory changes and restock requests are not applied directly. Employees create change requests and managers or owners must approve them before the database is updated.
- **Restock manager:** The system monitors quantities against configurable reorder thresholds and generates low‑stock warnings and tickets. Managers can review the automatically generated restock list and issue purchase orders. ![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.001.png)
- **Historical snapshots:** Finalized floats are copied into  inventory\_snapshots /

inventory\_snapshot\_entries  tables. These snapshots make it easy to compare current

quantities against past states.

**User management and security**

- **Role‑based access control:** Users may have the role of *admin*, *owner*, *manager* or *employee*. Each role has distinct permissions. For example, only administrators can create or edit users, owners can manage items, and employees can only submit float entries. The dashboard controller redirects users to the correct dashboard based on their role 1 .![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.002.png)
- **User registration and login:** New users can sign up with a name, e‑mail address and password. Passwords are hashed using PHP’s  password\_hash()  function. Session fingerprinting ties the

  session to the user’s IP and user‑agent to mitigate hijacking 2 .![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.003.png)

- **Profile & dark mode:** Users can update their name and toggle between light and dark themes. The dark mode preference is stored per‑user and persisted in the database 3 .![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.004.png)

**Inventory management**

- **Paginated item table:** Inventory items are displayed in a paginated table. The controller accepts a ![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.005.png)![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.006.png)page  parameter and calculates  total\_pages  based on the number of items. It also accepts a ![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.007.png)

filter  parameter which can be one of  low-stock ,  in-stock  or  out-of-stock  to restrict

the result set 4 .![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.008.png)

- **Add/edit/delete items:** Admins and owners can create new products, edit existing ones and remove discontinued items. When editing an item the controller validates SKU, name, threshold and quantity and checks for duplicate SKUs before saving 5 .![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.009.png)
- **Duplicate SKU validation:** Attempts to save an item with an existing SKU for the same tenant will trigger an error message instead of creating a duplicate entry 6 . ![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.010.png)![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.011.png)
- **Filtering and stock warnings:** In the paginated list, items falling below their  threshold\_qty

  show a red warning icon, while out‑of‑stock items are highlighted. Users may filter the list to focus on critical items.

- **Automatic restock list:** When quantities fall below the threshold the system generates a restock ticket. Managers can review and approve these requests, producing a purchase order.

**Additional features**

- **Notifications and tickets:** Restock requests and invalid data entries generate tickets in the ![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.012.png)

tickets  table. Notifications appear in the manager’s dashboard and must be resolved before the

day can be finalized.

- **API keys:** Each tenant can generate API keys to integrate ShelfAware with external systems. Keys are stored in the  api\_keys  table 7 . ![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.013.png)![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.014.png)![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.015.png)
- **Database functions:** A stored procedure ( convert\_float\_to\_snapshot  in  functions.sql )

  converts an open float into a finalized snapshot, copying approved quantities and marking the float as finalized.

**Technology stack**

ShelfAware is built as a classic Model‑View‑Controller (MVC) PHP application with a MySQL backend. The server‑side code is written in PHP using plain PDO. Views are rendered on the server and styled using Tailwind CSS  and  Flowbite. Node and npm are used only to compile Tailwind CSS; there is no client‑side framework. PHP dependencies are managed with Composer (currently only Google’s API client library is required 8 ), and Tailwind/Flowbite are installed via npm 9 .![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.016.png)![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.017.png)

**Getting started**

**Prerequisites**

- **PHP 8.1+** with the PDO MySQL extension enabled.
- **MySQL 8** or compatible database server.
- **Composer** to install PHP dependencies.
- **Node.js** ≥ **18** and **npm** to build Tailwind CSS.
- **Web server** such as Apache, Nginx or the PHP built‑in server.

**Installation**

1. **Clone the repository** (or download a ZIP) into your web server’s document root.
1. **Install PHP dependencies:** From the project root run:

composer install![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.018.png)

1\. **Install Node dependencies:** The frontend uses Tailwind CSS and Flowbite. Run the following to

install them:

npm install![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.019.png)

1\. **Build the Tailwind CSS output:** Tailwind CLI scans the  src  directory and outputs the final![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.020.png)

stylesheet into  public/css . You can build once or run in watch mode during development:

- one‑off build![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.021.png)

npx tailwindcss -i ./src/input.css -o ./public/css/tailwind.css --minify

- or watch for changes

npx tailwindcss -i ./src/input.css -o ./public/css/tailwind.css --watch

1. **Configure the database:**
1. Create a new MySQL database named  shelfaware  and a user with appropriate privileges.![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.022.png)
1. Import the schema in  sql.sql  to create the tables. The  items  table, for example, stores an ![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.023.png)![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.024.png)![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.025.png)![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.026.png)sku ,  name ,  threshold\_qty  and  current\_qty  for each product 10 . Other tables handle floats, restock requests, tickets, reports and snapshots![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.027.png) 11 .
1. Execute  functions.sql  to create the  convert\_float\_to\_snapshot  stored procedure.
1. Optionally import  data.sql  to preload a sample tenant, admin account and demo items.
1. **Configure   database   credentials:** The   PDO   DSN,   username   and   password   are   hard‑coded   in ![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.028.png)Models/database.php . Update the   $dsn ,   $username   and   $password   variables to match your local database settings 12 .![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.029.png)
1. **Serve the application:** You can use the built‑in PHP web server during development:

php -S localhost:8000 -t .![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.030.png)

Then open your browser at http://localhost:8000/index.php.

**Default credentials**

If you imported the sample data from  data.sql  you will have the following accounts:

Role Email Password Admin![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.031.png) Admin@email.com password Owner Owner@email.com password Employee employee@email.com password

**Note:** In production you should change these passwords immediately and create your own users via the Admin dashboard.

**Usage**

1. **Sign up or log in.** New users can register via the sign‑up page (enabled by the  signup  action in![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.032.png)

   the  HomeController ).

2. **Set up items and thresholds.** Owners/admins can create items with a SKU, name, reorder threshold and current quantity. SKUs are validated for uniqueness per tenant to prevent duplicates 6 .![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.033.png)
2. **Daily floating inventory.** At the end of each day employees enter counts for each item. These counts are stored in  inventory\_float\_entries  and await managerial approval. Managers

   review and approve or adjust the quantities before the float is finalized. Finalized floats trigger snapshots and variance reports to help identify discrepancies. ![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.034.png)

4. **Restock workflow.** When an item’s  current\_qty  falls below  threshold\_qty  the system

   creates a restock request. Managers review, approve or reject these tickets. Approved requests generate purchase orders and update the quantities accordingly.

5. **Dashboard & settings.** Depending on their role, users are redirected to an appropriate dashboard and may view reports, outstanding restock tickets and their profile. Users can toggle dark mode or update their display name in the settings page 3 .![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.035.png)

**Project structure**

. ![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.036.png)

├── Controllers/      # Request handlers and routing (Home, Dashboard, 

│   ├ ── AdminController.php 

│   ├ ── DashboardController.php 

│   ├ ── HomeController.php 

│   └ ── ItemController.php 

├── Models/           # Domain models interfacing with the MySQL DB 

│   ├ ── database.php  # Provides a PDO connection and wraps credentials │   ├ ── AdminDBAccess.php 

│   ├ ── Item.php 

│   └ ── User.php 

├── Views/            # PHP templates rendered by controllers 

│   ├ ── Dashboard/

│   ├ ── Home/

│   ├ ── Item/

│   └ ── Admin/

├── src/              # Tailwind CSS source and assets

├── sql.sql           # Database schema (DDL) 10![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.037.png)

├── data.sql          # Sample data for testing

├── functions.sql     # Stored procedures (convert\_float\_to\_snapshot)

├── package.json      # NPM dependencies (Tailwind CLI, Flowbite) 9 ![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.038.png)├── composer.json     # PHP dependencies (Google API client) 8![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.039.png)

└── index.php         # Front controller that boots the app

**Future enhancements**

The current release focuses on core inventory management. The following features are intentionally left out but may be considered in future versions:

- **Deep analytics and dashboards** – charts, trend analysis and advanced reporting for long‑term insights.
- **Multi‑warehouse support** – manage inventory across multiple warehouses or store locations.
- **Advanced forecasting** – predictive models based on historical sales, seasonality or AI‑driven demand forecasting.
- **Product images and change logs** – attach images to items and maintain a detailed change history for auditing.

**Contributing**

Contributions are welcome! If you find a bug or would like to implement one of the future enhancements, please fork the repository and open a pull request. For major changes, open an issue first to discuss the proposed change.

Please follow the existing coding style: use PSR‑12 for PHP files, keep functions small and document any new procedures in the SQL files.

**License**

The repository does not currently specify a license. If you plan to use ShelfAware in a proprietary or open‑source   project,   please   review   the   code   and   consult   with   the   original   authors   (Yasin   Sisto   & Bethany Eckert) to determine licensing terms.![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.040.png)

**Resources:**  The project was built using open‑source tools and services including Tailwind CSS, Flowbite, phpMyAdmin and WampServer. Helpful links are listed in the final project report. ![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.041.png)

1  3 raw.githubusercontent.com![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.042.png)

https://raw.githubusercontent.com/Grym3038/Inventory\_Tracker/main/Controllers/DashboardController.php

2  raw.githubusercontent.com![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.043.png)

https://raw.githubusercontent.com/Grym3038/Inventory\_Tracker/main/Controllers/HomeController.php

4 5 6 raw.githubusercontent.com![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.044.png)

https://raw.githubusercontent.com/Grym3038/Inventory\_Tracker/main/Controllers/ItemController.php

7  10 11 raw.githubusercontent.com![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.045.png)

https://raw.githubusercontent.com/Grym3038/Inventory\_Tracker/main/sql.sql

8  raw.githubusercontent.com![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.046.png)

https://raw.githubusercontent.com/Grym3038/Inventory\_Tracker/main/composer.json

9  raw.githubusercontent.com![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.047.png)

https://raw.githubusercontent.com/Grym3038/Inventory\_Tracker/main/package.json

12 raw.githubusercontent.com ![](Aspose.Words.8adccc9c-0b9e-45f3-8da3-618ddedb591b.048.png)https://raw.githubusercontent.com/Grym3038/Inventory\_Tracker/main/Models/database.php
6
