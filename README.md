# PartPurja

PartPurja is a web marketplace specifically created for buy/sell tech components, both brand new and used, in Nepal. The platform enables buyers and sellers to connect seamlessly through an interactive web application. Sellers can list tech products they want to sell, while buyers can browse and purchase available products. Additionally, the platform allows buyers to request specific tech products if they are not available in current listings, giving sellers an opportunity to fulfill those requests.

## Features

- **User Authentication System**: Provides secure login and registration for users.
- **Product Listings**: Users can create and view product listings.
- **Product Categories**: Products are organized into categories such as audio equipment, mobile parts, laptop components, etc.
- **Product Requests**: Buyers can post requests for unavailable products, and sellers can accept them.
- **Product Comments**: Users can comment on product listings and engage with sellers.
- **Direct Communication**: Sellers provide their contact numbers for direct communication with buyers.
- **Search Functionality**: Buyers can quickly search for products using keywords.
- **User Profile Management**: Users can update their profiles and manage their listed products.

## Requirements

- XAMPP (Apache and MySQL)
- PHP 7.4 or higher
- Node.js and npm

## How to Run the App Locally

### 1. Clone the Repository

```sh
git clone https://github.com/kadotaislost/PartPurja.git
```

### 2. Move to the Project Directory

```sh
cd PartPurja
```

### 3. Move the Project to the htdocs Folder

- Copy or move the `PartPurja` folder to the XAMPP `htdocs` directory.

### 4. Start XAMPP Services

- Open the XAMPP Control Panel.
- Start the Apache and MySQL services.

### 5. Create the Database

- Open phpMyAdmin.
- Create a database with the name `partpurja`.

### 6. Import the Database

- In phpMyAdmin, select the `partpurja` database.
- Use the `partpurja.sql` file located in the project folder to import all the necessary tables and data.

### 7. Install Node.js Packages

```sh
npm install
```

### 8. Generate Tailwind CSS

```sh
npm run dev
```

This command runs:

```sh
npx @tailwindcss/cli -i input.css -o style.css --watch
```

to generate the Tailwind output CSS file `style.css`.

### 9. Open the Application in Your Browser

- Open your web browser and go to:

```sh
http://localhost/partpurja/pages/index.php
```

to view the PartPurja web application.
