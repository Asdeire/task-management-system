# Task Management System

## Topic

Developing a First Web Application Using PHP

## Objective

To acquire skills in creating websites using PHP, focusing on leveraging the advanced features of PHP 8.3+.

## Short Theoretical Background

This project involves building a simple Task Management System on pure PHP, requiring the use of modern PHP 8.3+ features. The application will include user registration, task management, user-task assignment, and task status updates. This exercise provides practical experience with type declarations, enums, match expressions, Active Record, and advanced PDO usage for database interaction.

## Steps of the Task

### 1. Environment Setup
1. Install **PHP 8.3+** via the official site or using **Scoop**.
2. Install **PostgreSQL** from the official site or using **Scoop**.
3. Use a terminal to create a PostgreSQL database named `task_manager` and set up an initial user.

### 2. Database Schema
- Construct the database schema based on the provided class structures.

### 3. Composer Setup
- Download Composer and configure autoload with **PSR-4**.

### 4. Code Styling
- Configure code styling in **PHPStorm** to PSR-12, and install **CS Fixer** and **Psalm** for code quality and static analysis.

### 5. Task Management System Structure

#### Class Structure
- **User**
  - *Properties*: `id`, `username`, `email`, `password`
  - *Methods*: `register()`, `login()`, `logout()`, `changePassword()`

- **Task**
  - *Properties*: `id`, `title`, `description`, `status`, `creator_id`, `assigned_to_id`, `created_at`, `updated_at`
  - *Methods*: `create()`, `update()`, `delete()`, `assignTo()`, `changeStatus()`

- **TaskManager**
  - *Properties*: `db`, `user`, `task`
  - *Methods*: `addTask()`, `updateTask()`, `deleteTask()`, `getTasksByUser()`, `getTaskById()`

### 6. Program Functionality
- **User** can register, log in, log out, change their password, and manage tasks.
- **Task Management** includes creating, updating, deleting, and assigning tasks to other users.
- **Task Viewing** allows users to see their list of tasks and view details of individual tasks.

### 7. PHP Language Constructs to Use
1. **Strict Typing**: `declare(strict_types=1);`
2. **Match Expression and Enums**: Use for task statuses.
3. **Named Arguments and Default Parameters**: Use throughout methods and class constructors.
4. **Nullsafe Operator**: For nullable fields like `description`.
5. **Union Types**: Apply where appropriate.
6. **Anonymous Functions and Arrow Functions**: For callbacks.

### 8. Database Interaction
- Use **PDO** exclusively for all database interactions.
- Implement the **Active Record** pattern for database operations.

### 9. Page Routing
- Use `.php` files with embedded HTML for page routing. This approach is limited to this exercise.

## Technologies Used

- **PHP 8.3+**
- **PostgreSQL**
- **Composer**: For dependency management
- **PHPStorm**: For PSR-12 setup and CS Fixer integration
- **PDO**: For database interactions
- **Psalm**: For static analysis and type safety

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/first-php-webapp.git
   cd first-php-webapp
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Run the application by starting a local server:
   ```bash
   php -S localhost:8000
   ```

4. Access the application at `http://localhost:8000`.

## Usage

- Register a new user and log in to access task management features.
- Use the interface to add, update, delete, assign tasks, and view task details.
- Experiment with sorting and filtering as per the features provided.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request for improvements or bug fixes.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
