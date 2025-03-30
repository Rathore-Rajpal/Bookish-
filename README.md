
# Bookish! 📚

**Bookish** is an online platform that allows users to buy, sell, rent, and discover books. It offers physical books, e-books, audiobooks, poetry promotion, and custom orders, making it the perfect destination for book lovers.

## Features 🎯

### 1. **Book Purchasing**
   - Browse and purchase books from a vast collection.
   - Secure payment options for a smooth transaction experience.

### 2. **Book Renting**
   - Rent books for a specified time period with flexible options.
   - View and manage rentals through the user account dashboard.

### 3. **Audiobooks & E-books**
   - Download or stream a wide range of audiobooks and e-books.

### 4. **Promote Poetry**
   - A dedicated section for poets and poetry enthusiasts.
   - Users can publish and explore poetry content.

### 5. **Custom Orders**
   - Users can place custom orders for unavailable books.
   - Track the progress of custom orders through the account dashboard.

### 6. **Admin Dashboard**
   - Manage users, book inventories, sales, rentals, and custom orders.
   - Comprehensive statistics on total users, books bought, rented, sales, orders, e-books, and audiobooks.

## Tech Stack 💻

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Server**: XAMPP (Apache, MySQL, PHP, Perl)

## Database Structure 🗄️

1. **Users Table**
   - `id`, `fname`, `lname`, `username`, `email`, `password`, `dt`, `image`

2. **Buy Items Table**
   - Contains details of books purchased by users.

3. **Rent Items Table**
   - Contains details of books rented by users.

4. **Sales Table**
   - Records all sales transactions.

5. **Orders Table**
   - Custom orders placed by users.

6. **Ebooks Table**
   - List of e-books available for purchase or rent.

7. **Audiobooks Table**
   - List of audiobooks available for streaming or purchase.

## Installation & Setup 🛠️

### Prerequisites

- **XAMPP Server** (Apache, MySQL, PHP, Perl)  
  Download and install [XAMPP](https://www.apachefriends.org/index.html) to run the local server for the project.

### Steps to Install:

1. **Clone the repository**:

   ```bash
   git clone https://github.com/YourUsername/Bookish.git
   ```

2. **Move the project to the XAMPP `htdocs` folder**:

   Move the cloned project folder to your XAMPP installation directory under the `htdocs` folder (typically located at `C:/xampp/htdocs/`).

   ```bash
   C:/xampp/htdocs/Bookish
   ```

3. **Start XAMPP Server**:

   - Open the XAMPP Control Panel.
   - Start the **Apache** and **MySQL** modules.

4. **Set up the database**:

   - Open **phpMyAdmin** by going to `http://localhost/phpmyadmin/` in your browser.
   - Create a new database called `bookish_db`.
   - Import the `bookish_db.sql` file located in the `database/` folder of the project.

5. **Configure the database connection**:

   - Open the `config.php` file in the project directory.
   - Update the following values with your MySQL credentials:
     ```php
     $dbHost = 'localhost';
     $dbUsername = 'root'; // Change if you have a different username
     $dbPassword = '';     // Change if you have a MySQL password
     $dbName = 'bookish_db';
     ```

6. **Run the application**:

   - Open your browser and go to `http://localhost/Bookish` to access the **Bookish!** platform.

## Contributing 🤝

We welcome contributions! Feel free to fork the repository, work on a feature, and submit a pull request. Here's how you can contribute:

1. Fork the repo.
2. Create a new branch (`git checkout -b feature-name`).
3. Commit your changes (`git commit -m 'Add new feature'`).
4. Push to the branch (`git push origin feature-name`).
5. Open a pull request.

## License 📜

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

This version of the README includes instructions on how to use **XAMPP** for running the project. It also provides detailed steps for setting up the environment and database. Feel free to modify or expand upon it as needed!
