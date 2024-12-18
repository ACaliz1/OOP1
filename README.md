# 📚 CEFP NUTRIA - School Management System

Welcome to **CEFP NUTRIA**, a comprehensive school management system designed to manage **Teachers**, **Departments**, **Students**, and **Courses**. This project follows the **MVC architecture** and emphasizes professional, clean, and scalable code.

---

## 🚀 **Project Objectives**
The goal of this project is to create an intuitive and organized system to manage the following key entities:

- **Teachers**: Create, update, delete, and assign teachers to departments.
- **Departments**: Create, list, and associate departments with teachers and courses.
- **Students**: Register, manage, and enroll students in courses.
- **Courses**: Manage course information and enroll students.

The application is structured with a focus on maintainability and scalability, following clean architecture and using **OOP principles**.

---

## 🏗️ **Project Structure**
The project follows an **MVC (Model-View-Controller)** structure with a clear separation of concerns.

```
📂 OOP1
├── 📂 src
│   ├── 📂 assets
│   ├── 📂 Controllers
│   ├── 📂 Infrastructure
│   │    ├── 📂 Database
│   │    │    └── DatabaseConnection.php
│   │    ├── 📂 Persistence
│   │    └── 📂 Routing
│   ├── 📂 School
│   │    ├── 📂 Entities
│   │    ├── 📂 Repositories
│   │    ├── 📂 Services
│   │    └── 📂 Trait
│   └── 📂 views
│        ├── 📂 partials
│        │    ├── header.view.php
│        │    └── footer.view.php
│        ├── home.view.php
│        └── teachers.view.php
├── 📂 vendor
├── .env
├── .gitignore
├── .htaccess
├── bootstrap.php
├── composer.json
├── composer.lock
├── index.php
└── README.md
```

---

## 🧪 **Features**

### 🧑‍🏫 **Teachers**
- **Create Teacher**: Register a new teacher with name, email, password, and department assignment.
- **List Teachers**: View a list of all registered teachers.
- **Assign Teacher to Department**: Link teachers to their respective departments.
- **Remove Teacher**: Delete a teacher from the system.

### 🏫 **Departments**
- **List Departments**: View a list of available departments.
- **Create Department**: Add a new department to the system.
- **Assign Teacher to Department**: Link teachers to departments.

### 👩‍🎓 **Students** (Coming Soon)
- **Register Students**: Register new students.
- **List Students**: View and manage student information.
- **Enroll in Courses**: Enroll students in available courses.

### 📘 **Courses** (Coming Soon)
- **Create Course**: Add and manage course details.
- **Assign Students to Courses**: Register students for available courses.
- **View Course Information**: See course schedules, descriptions, and teacher assignments.

---

## ⚙️ **Technologies Used**
- **PHP 8.0+**: Core programming language.
- **MySQL / MariaDB**: Database management system.
- **Composer**: Dependency manager for PHP.
- **Tailwind CSS**: For responsive design and professional UI/UX.
- **PDO**: Database connection for secure SQL queries.

---

## 🛠️ **Project To-Do List**
- [x] **Teachers**: Create, list, and assign departments.
- [x] **Departments**: Create, list, and assign teachers.
- [ ] **Students**: Create, manage, and enroll in courses.
- [ ] **Courses**: Create, manage, and enroll students.

---

Thank you for using **CEFP NUTRIA**! 🚀

