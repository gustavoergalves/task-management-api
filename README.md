# Task Management API

This is a **Task Management API** that allows you to create, update, list, and delete tasks, as well as retrieve task statistics.

GitLab Repository: [https://gitlab.com/gustavoergalves/task-management-api](https://gitlab.com/gustavoergalves/task-management-api)

---

## ✅ Requirements

Before running the project, make sure you have the following installed:

* **Docker** (and Docker Compose)
* **Make** (for running Makefile commands)
* **Git**
* PHP 8.x (if running outside Docker)
* Composer (if running outside Docker)

Optional but recommended:

* A modern browser to interact with API testing tools (Postman, Insomnia, or curl)

---

## 🛠 Setup

### 1. Clone the repository

```bash
git clone https://gitlab.com/gustavoergalves/task-management-api.git
cd task-management-api
```

### 2. Create environment file

```bash
cp .env.example .env
```

Update `.env` if needed.

### 3. Build the project

```bash
make build
```

### 4. Start the containers

```bash
make up
```

### 5. Initialize the application

```bash
make init
```

The API will be available at: `http://localhost:8080`

---

## 📑 API Contracts

### **List Tasks**

Retrieve tasks with optional filters, pagination, and sorting:

```bash
curl --request GET \
  --url 'http://localhost:8080/api/tasks?status=completed&priority=high&itemsPerPage=10&sortBy=id&sortDirection=asc'
```

**HTTP Code:** 200

**Response Example:**

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 2,
            "title": "Task 2",
            "description": null,
            "status": "completed",
            "priority": "high",
            "dueDate": "2025-12-27"
        }
    ],
    "first_page_url": "http://localhost:8080/api/tasks?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://localhost:8080/api/tasks?page=1",
    "links": [
        {"url": null, "label": "&laquo; Previous", "active": false},
        {"url": "http://localhost:8080/api/tasks?page=1", "label": "1", "active": true},
        {"url": null, "label": "Next &raquo;", "active": false}
    ],
    "next_page_url": null,
    "path": "http://localhost:8080/api/tasks",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

---

### **Get Task Statistics**

Retrieve statistics for tasks:

```bash
curl --request GET \
  --url 'http://localhost:8080/api/tasks/statistics'
```

**HTTP Code:** 200

**Response Example:**

```json
{
    "data": {
        "totalTasks": 5,
        "byStatus": {
            "pending": 1,
            "in_progress": 3,
            "completed": 1
        },
        "byPriority": {
            "low": 1,
            "medium": 1,
            "high": 3
        }
    }
}
```

---

### **Create Task**

Create a new task:

```bash
curl --request POST \
  --url http://localhost:8080/api/tasks \
  --header 'Content-Type: application/json' \
  --data '{
    "title": "Title 1",
    "description": "Descrition 1",
    "status": "in_progress",
    "priority": "high",
    "dueDate": "2020-12-01"
}'
```

**HTTP Code:** 201

**Response Example:**

```json
{
    "data": {
        "id": 5,
        "title": "Title 1",
        "description": "Descrition 1",
        "status": "in_progress",
        "priority": "high",
        "dueDate": "2020-12-01"
    }
}
```

---

### **Find Task By Id**

Retrieve a task by its ID:

```bash
curl --request GET \
  --url http://localhost:8080/api/tasks/{id}
```

**HTTP Code:** 200

**Response Example:**

```json
{
    "data": {
        "id": 11,
        "title": "Task #11",
        "description": "Description for task #11",
        "status": "completed",
        "priority": "high",
        "dueDate": "2026-10-08"
    }
}
```

---

### **Update Task**

Update an existing task:

```bash
curl --request PATCH \
  --url http://localhost:8080/api/tasks/{id} \
  --header 'Content-Type: application/json' \
  --data '{
    "title": "Test 2",
    "description": "Description 2",
    "status": "in_progress",
    "priority": "high",
    "dueDate": "2026-03-02"
}'
```

**HTTP Code:** 200

**Response Example:**

```json
{
    "data": {
        "id": 4,
        "title": "Test 2",
        "description": "Description 2",
        "status": "in_progress",
        "priority": "high",
        "dueDate": "2026-03-02"
    }
}
```

---

### **Delete Task**

Delete a task by ID:

```bash
curl --request DELETE \
  --url http://localhost:8080/api/tasks/{id}
```

**HTTP Code:** 204

No response body.

---

## ⚡ Notes

* This project uses **Docker** and **Makefile commands** for setup.
* API supports filtering, pagination, and sorting for listing tasks.
* Task `status` can be: `pending`, `in_progress`, `completed`.
* Task `priority` can be: `low`, `medium`, `high`.

---

## 🧪 Testing

To run tests:

```bash
make test
```

---

> Developed by Gustavo E. R. G. Alves
