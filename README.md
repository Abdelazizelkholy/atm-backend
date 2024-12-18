# Laravel Project

This is a Laravel project that implements basic banking operations such as depositing and withdrawing money, checking balances, and tracking transactions.

## Setup Instructions

Follow the steps below to set up the project locally.

### Prerequisites

Make sure you have the following installed:

1. **PHP**: Version 8.x or higher. You can check your PHP version by running:

    ```bash
    php -v
    ```

2. **Composer**: Dependency manager for PHP. If you don't have Composer installed, follow the instructions here: [Install Composer](https://getcomposer.org/download/).

3. **MySQL** (or another compatible database): Laravel supports MySQL, PostgreSQL, SQLite, and SQL Server. You can download MySQL from [here](https://dev.mysql.com/downloads/).


### Steps to Set Up Locally

1. **Clone the Repository**

   Clone the repository to your local machine using the following command:

    ```bash
    git clone git@github.com:Abdelazizelkholy/atm-backend.git
    cd your-repository
    ```

2. **Install Project Dependencies**

   Install all PHP dependencies using Composer:

    ```bash
    composer install
    ```

   If you are using any front-end dependencies (like Vue.js, React, etc.), run the following to install Node.js dependencies:

    ```bash
    npm install
    ```

3. **Set Up `.env` File**

   Copy the example environment configuration file to create a new `.env` file:

    ```bash
    cp .env.example .env
    ```

   Open the `.env` file and configure your environment variables. You will need to set up the database credentials and other settings. Here’s an example for a MySQL database:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

4. **Generate Application Key**

   Run the following command to generate the application key:

    ```bash
    php artisan key:generate
    ```

   This key is used for encryption and session handling.

5. **Run Migrations**

   To create the database tables for the application, run:

    ```bash
    php artisan migrate
    ```

   This will execute the migration files located in `database/migrations` to create the necessary tables in your database.

6. **Seed the Database**

   Optionally, you can populate your database with some initial data by running:

    ```bash
    php artisan db:seed
    ```

  

7. **Run Development Server**

   After setting up the database, run the Laravel development server:

    ```bash
    php artisan serve
    ```

   The application should now be running at `http://127.0.0.1:8000`. You can access it in your web browser.

8. **Optional: Compile Assets**

   If you're using front-end assets like CSS and JavaScript, you can compile them using Laravel Mix by running:

    ```bash
    npm run dev
    ```

   For production builds, you can run:

    ```bash
    npm run production
    ```

### Testing the Application

To test the API, use a tool like **Postman** or **Insomnia** to interact with the API endpoints. Below are some examples of the available API routes:

- **POST /login** - Log in using the card number and PIN
- **POST /deposit** - Deposit money into the account
- **POST /withdraw** - Withdraw money from the account
- **GET /balance** - Get the user's balance
- **GET /transactions** - Get a list of transactions for the user

---

### Additional Notes

- If you're working with the database and need to reset everything, you can roll back all migrations with:

    ```bash
    php artisan migrate:rollback
    ```

- If you want to clear the cache, config, or routes:

    ```bash
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    ```

---

### Troubleshooting

- If you encounter a `class not found` error, make sure you run:

    ```bash
    composer dump-autoload
    ```

- If you're having issues with migrations, check if your database connection is properly configured in the `.env` file and that your MySQL service is running.

---

This `README.md` file includes detailed instructions for setting up the project locally, as well as important Laravel commands like migrations, seeding, and running the development server. Make sure to replace placeholders like `your-username` and `your-repository` with the actual GitHub username and repository name when sharing the project.

