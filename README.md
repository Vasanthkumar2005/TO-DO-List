# TO-DO-List
Here’s a suggested **README.md** for your “TO-DO-List” project repository. Feel free to adjust sections (especially setup & features) to reflect your actual implementation.

---

# TO-DO List

A simple web-based to-do list application built with PHP & MySQL to help users manage tasks: add, edit, delete, mark complete, and view task history.

---

## Table of Contents

* [About](#about)
* [Features](#features)
* [Technologies Used](#technologies-used)
* [Installation & Setup](#installation-&-setup)
* [Usage](#usage)
* [Folder Structure](#folder-structure)
* [How to Contribute](#how-to-contribute)
* [License](#license)
* [Contact](#contact)

---

## About

This project provides a minimal but functional to-do list web application.
It allows users to register/login, create tasks, view them in a dashboard, mark tasks as completed or delete them. Styles are applied via CSS, and the backend logic is handled in PHP using a MySQL (or compatible) database.

---

## Features

* User authentication (signup, login, logout)
* Dashboard to view active tasks and completed tasks
* Add a new task
* Edit an existing task
* Mark tasks as completed
* Delete tasks
* View profile / settings
* Responsive layout with CSS styling

---

## Technologies Used

* **Server-Side**: PHP
* **Database**: MySQL (or MariaDB)
* **Client-Side**: HTML5, CSS3
* **Styling**: custom CSS files (dashboard.css, edit_task.css, etc.)
* **Architecture**: Simple MVC-style separation (PHP scripts for logic, CSS for styling)
* **Other**: Plain PHP without heavy frameworks to keep things lightweight

---

## Installation & Setup

1. Clone the repository:

   ```bash
   git clone https://github.com/Vasanthkumar2005/TO-DO-List.git  
   ```
2. Create a MySQL database (e.g., `todo_db`).
3. Import the provided SQL schema (if available) or create your table(s). Example:

   ```sql
   CREATE TABLE users (  
     id INT AUTO_INCREMENT PRIMARY KEY,  
     username VARCHAR(100) NOT NULL,  
     password VARCHAR(255) NOT NULL  
   );  
   CREATE TABLE tasks (  
     id INT AUTO_INCREMENT PRIMARY KEY,  
     user_id INT NOT NULL,  
     description TEXT NOT NULL,  
     is_completed TINYINT(1) DEFAULT 0,  
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
   );  
   ```
4. Configure the database connection in `db.php` (set host, username, password, database name).
5. Upload the project to your PHP-supported web server (e.g., XAMPP, WAMP, LAMP).
6. Navigate to `index.php` in your browser to begin.

---

## Usage

* Sign up for a new account (via `signup.php`).
* Login via `login.php`.
* You’ll arrive at the dashboard (`dashboard.php`) showing your tasks.
* Add a task through `add_task.php`.
* Edit a task with `edit_task.php`.
* Mark as completed or delete via the corresponding actions (`completed_task.php`, `delete_task.php`).
* View settings or help pages (`settings.php`, `help.php`) as needed.

---

## Folder Structure

```
TO-DO-List/
├─ add_task.php
├─ addtask.css
├─ auth.php
├─ completed_task.php
├─ completed_task.css
├─ dashboard.php
├─ dashboard.css
├─ db.php
├─ delete_task.php
├─ delete_task.css
├─ edit_task.php
├─ edit_task.css
├─ editprofile.php
├─ editprofile.css
├─ help.php
├─ help.css
├─ index.php
├─ login.php
├─ logout.php
├─ logout.css
├─ profile.php
├─ profile.css
├─ remainder.php
├─ remainder.css
├─ settings.php
├─ settings.css
├─ signup.php
├─ style.css
└─ README.md
```

---

## How to Contribute

Contributions are welcome! To contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/my-enhancement`).
3. Make your changes & commit (`git commit -m 'Add some feature'`).
4. Push to your branch (`git push origin feature/my-enhancement`).
5. Open a Pull Request explaining your changes.

Some ideas for future enhancements:

* Add due-dates and reminders for tasks
* Implement task categories or priorities
* Use AJAX for smoother user experience
* Incorporate a more modern front-end framework (e.g., Vue.js, React)
* Add unit tests or automated deployment

---

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

## Contact

Created by **Vasanth Kumar** – feel free to reach out via GitHub.
If you have suggestions, issues, or ideas, please open an issue in the repository.

---

Thanks for checking out this project!
Happy task-managing 😊
