# 🚀 Pemira API Backend Setup Guide (Laravel)

Hey there! Welcome to the setup guide for the Pemira API backend, built with Laravel. Follow these steps to get everything running smoothly on your local server.

## 📝 Requirements

Before you begin, make sure your device has the following:

-   **PHP**: Version **8.1** or higher (recommended for this Laravel version)
-   **Composer**: To manage PHP dependencies
-   **MySQL**: Version **5.7** or higher for the database
-   **Node.js** and **npm**: Needed if the app uses frontend assets or Laravel Mix

## ⚙️ Setup Steps

### 1. Clone the Repository

Clone the backend repository from GitHub and navigate to the project directory:

```bash
git clone https://github.com/jstcode-hub/pemira-api.git
cd pemira-api
```

### 2. Install Dependencies

Install all Laravel dependencies using Composer. If you run into any PHP version issues, try the alternative command below.

#### Main Command

```bash
composer install
```

#### Alternative (If You Have PHP Version Issues)

If there’s a PHP version mismatch on your device, add the `--ignore-platform-reqs` flag to skip version checks:

```bash
composer install --ignore-platform-reqs
```

> **Note**: The `--ignore-platform-reqs` flag can be a quick fix, but it’s best to use PHP version 8.1 or higher to fully match Laravel’s requirements.

### 3. Create the `.env` Configuration File

Copy the `.env.example` file to create a new `.env` file to configure the app:

```bash
cp .env.example .env
```

### 4. Update Your `.env` File

Open the `.env` file you just created, and update it with your MySQL database details as shown below:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 5. Generate an Application Key

Laravel needs an application key for encryption. You can generate one with the command:

```bash
php artisan key:generate
```

### 6. Migrate the Database

Now, migrate the required tables to your MySQL database:

```bash
php artisan migrate
```

### 7. Run the Seeder

Populate the database with initial data using the seeder:

```bash
php artisan db:seed
```

### 8. Link Storage

To make public storage accessible, create a symbolic link with the following command:

```bash
php artisan storage:link
```

### 9. Start the Laravel Server

After everything is set up, start the Laravel server locally with:

```bash
php artisan serve
```

The app will be running at [http://localhost:8000](http://localhost:8000).

---

## 🎯 Troubleshooting

-   **Database connection issues?** Double-check your MySQL configuration in the `.env` file.
-   **Composer or PHP errors?** Make sure your PHP version meets the minimum requirement (8.1 or higher).

---

## 🤝 Contributing

If you’ve been added as a collaborator, please follow these contribution guidelines to keep everything organized:

1. **Create a New Branch**  
   Each collaborator should create their own branch for development using the format `[role]-[name]`. For example:

    ```bash
    git checkout -b backend-dev-john
    ```

    or

    ```bash
    git checkout -b backend-feature-ana
    ```

2. **Push to Your Branch**  
   After making changes, push them to your branch:

    ```bash
    git push origin backend-dev-john
    ```

3. **Create a Pull Request**  
   Once your changes are ready, create a pull request from your branch to the main branch. All pull requests will be reviewed before merging.

> **Note**: Be sure to follow the branch naming format above, and make sure your pull request is ready for review so it can be merged into the main branch.

---

Good luck with the setup, and happy coding! If you run into any issues, feel free to reach out. Hope it all goes smoothly! 😄
