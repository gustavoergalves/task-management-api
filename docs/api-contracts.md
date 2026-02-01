# Task Management API - Contracts

Base URL: `http://localhost:8080/api`

All requests and responses use `Content-Type: application/json`.

---

## Tasks

### Create Task

```
POST /api/tasks
```

**Request Body:**

| Field       | Type   | Required | Constraints                                     |
|-------------|--------|----------|-------------------------------------------------|
| title       | string | yes      | max 100 characters                              |
| description | string | no       | max 500 characters, nullable                    |
| status      | string | yes      | `pending` \| `in_progress` \| `completed`       |
| priority    | string | yes      | `low` \| `medium` \| `high`                     |
| dueDate     | string | no       | format `YYYY-MM-DD`, nullable                   |

**Example Request:**

```json
{
  "title": "Implement login page",
  "description": "Create the login page with email and password fields",
  "status": "pending",
  "priority": "high",
  "dueDate": "2026-03-15"
}
```

**Response: `201 Created`**

```json
{
  "data": {
    "id": 1,
    "title": "Implement login page",
    "description": "Create the login page with email and password fields",
    "status": "pending",
    "priority": "high",
    "dueDate": "2026-03-15"
  }
}
```

---

### List Tasks

```
GET /api/tasks
```

**Query Parameters:**

| Parameter     | Type   | Required | Default      | Description                                 |
|---------------|--------|----------|--------------|---------------------------------------------|
| status        | string | no       | —            | Filter: `pending` \| `in_progress` \| `completed` |
| priority      | string | no       | —            | Filter: `low` \| `medium` \| `high`        |
| page          | int    | no       | 1            | Current page number                         |
| itemsPerPage  | int    | no       | 10           | Items per page                              |
| sortBy        | string | no       | `created_at` | Column to sort by                           |
| sortDirection | string | no       | `asc`        | `asc` \| `desc`                             |

**Response: `200 OK`**

```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "title": "Implement login page",
      "description": "Create the login page",
      "status": "pending",
      "priority": "high",
      "dueDate": "2026-03-15"
    }
  ],
  "first_page_url": "http://localhost:8080/api/tasks?page=1",
  "from": 1,
  "last_page": 1,
  "last_page_url": "http://localhost:8080/api/tasks?page=1",
  "links": [
    { "url": null, "label": "&laquo; Previous", "active": false },
    { "url": "http://localhost:8080/api/tasks?page=1", "label": "1", "active": true },
    { "url": null, "label": "Next &raquo;", "active": false }
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

### Get Task by ID

```
GET /api/tasks/{id}
```

**Response: `200 OK`**

```json
{
  "data": {
    "id": 1,
    "title": "Implement login page",
    "description": "Create the login page",
    "status": "pending",
    "priority": "high",
    "dueDate": "2026-03-15"
  }
}
```

**Response: `404 Not Found`**

```json
{
  "error": "Task not found"
}
```

---

### Update Task

```
PATCH /api/tasks/{id}
```

**Request Body:** Same fields as Create Task (all required).

**Response: `200 OK`**

```json
{
  "data": {
    "id": 1,
    "title": "Updated title",
    "description": "Updated description",
    "status": "in_progress",
    "priority": "medium",
    "dueDate": "2026-04-01"
  }
}
```

**Response: `404 Not Found`**

```json
{
  "error": "Task not found"
}
```

---

### Delete Task

```
DELETE /api/tasks/{id}
```

**Response: `204 No Content`** — empty body.

**Response: `404 Not Found`**

```json
{
  "error": "Task not found"
}
```

---

### Get Task Statistics

```
GET /api/tasks/statistics
```

**Response: `200 OK`**

```json
{
  "data": {
    "totalTasks": 50,
    "byStatus": {
      "pending": 10,
      "in_progress": 25,
      "completed": 15
    },
    "byPriority": {
      "low": 10,
      "medium": 20,
      "high": 20
    }
  }
}
```

---

## Employees

### Create Employee

```
POST /api/employees
```

**Request Body:**

| Field      | Type   | Required | Constraints                    |
|------------|--------|----------|--------------------------------|
| name       | string | yes      | max 100 characters             |
| email      | string | yes      | valid email, max 255, unique   |
| position   | string | no       | max 100 characters, nullable   |
| department | string | no       | max 100 characters, nullable   |

**Example Request:**

```json
{
  "name": "John Doe",
  "email": "john.doe@company.com",
  "position": "Software Engineer",
  "department": "Engineering"
}
```

**Response: `201 Created`**

```json
{
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john.doe@company.com",
    "position": "Software Engineer",
    "department": "Engineering"
  }
}
```

---

### List Employees

```
GET /api/employees
```

**Query Parameters:**

| Parameter     | Type   | Required | Default      | Description                        |
|---------------|--------|----------|--------------|------------------------------------|
| department    | string | no       | —            | Filter by exact department name    |
| name          | string | no       | —            | Filter by name (partial match)     |
| page          | int    | no       | 1            | Current page number                |
| itemsPerPage  | int    | no       | 10           | Items per page                     |
| sortBy        | string | no       | `created_at` | Column to sort by                  |
| sortDirection | string | no       | `asc`        | `asc` \| `desc`                    |

**Response: `200 OK`**

```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "email": "john.doe@company.com",
      "position": "Software Engineer",
      "department": "Engineering"
    }
  ],
  "first_page_url": "http://localhost:8080/api/employees?page=1",
  "from": 1,
  "last_page": 1,
  "last_page_url": "http://localhost:8080/api/employees?page=1",
  "links": [
    { "url": null, "label": "&laquo; Previous", "active": false },
    { "url": "http://localhost:8080/api/employees?page=1", "label": "1", "active": true },
    { "url": null, "label": "Next &raquo;", "active": false }
  ],
  "next_page_url": null,
  "path": "http://localhost:8080/api/employees",
  "per_page": 10,
  "prev_page_url": null,
  "to": 1,
  "total": 1
}
```

---

### Get Employee by ID

```
GET /api/employees/{id}
```

**Response: `200 OK`**

```json
{
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john.doe@company.com",
    "position": "Software Engineer",
    "department": "Engineering"
  }
}
```

**Response: `404 Not Found`**

```json
{
  "error": "Employee not found"
}
```

---

### Update Employee

```
PATCH /api/employees/{id}
```

**Request Body:** Same fields as Create Employee (name and email required, email must be unique excluding current record).

**Response: `200 OK`**

```json
{
  "data": {
    "id": 1,
    "name": "John Updated",
    "email": "john.updated@company.com",
    "position": "Senior Engineer",
    "department": "Engineering"
  }
}
```

**Response: `404 Not Found`**

```json
{
  "error": "Employee not found"
}
```

---

### Delete Employee

```
DELETE /api/employees/{id}
```

**Response: `204 No Content`** — empty body.

**Response: `404 Not Found`**

```json
{
  "error": "Employee not found"
}
```

---

## Task Assignments

### Assign Task to Employee

```
POST /api/assignments
```

**Request Body:**

| Field      | Type | Required | Description     |
|------------|------|----------|-----------------|
| employeeId | int  | yes      | Employee ID     |
| taskId     | int  | yes      | Task ID         |

**Example Request:**

```json
{
  "employeeId": 1,
  "taskId": 3
}
```

**Response: `201 Created`**

```json
{
  "data": {
    "id": 1,
    "employeeId": 1,
    "taskId": 3,
    "employee": {
      "id": 1,
      "name": "John Doe",
      "email": "john.doe@company.com",
      "position": "Software Engineer",
      "department": "Engineering"
    },
    "task": {
      "id": 3,
      "title": "Implement login page",
      "description": "Create the login page",
      "status": "pending",
      "priority": "high",
      "dueDate": "2026-03-15"
    }
  }
}
```

**Response: `404 Not Found`** — when employee or task does not exist.

```json
{
  "error": "Employee not found"
}
```

**Note:** A task can only be assigned to the same employee once (unique constraint on `employeeId` + `taskId`).

---

### Unassign Task from Employee

```
DELETE /api/assignments/employee/{employeeId}/task/{taskId}
```

**Response: `204 No Content`** — empty body.

**Response: `404 Not Found`**

```json
{
  "error": "Assignment not found"
}
```

---

### List Assignments by Employee

Returns all tasks assigned to a specific employee.

```
GET /api/assignments/employee/{employeeId}
```

**Response: `200 OK`**

```json
{
  "data": [
    {
      "id": 1,
      "employeeId": 1,
      "taskId": 3,
      "employee": null,
      "task": {
        "id": 3,
        "title": "Implement login page",
        "description": "Create the login page",
        "status": "pending",
        "priority": "high",
        "dueDate": "2026-03-15"
      }
    },
    {
      "id": 2,
      "employeeId": 1,
      "taskId": 5,
      "employee": null,
      "task": {
        "id": 5,
        "title": "Write unit tests",
        "description": null,
        "status": "in_progress",
        "priority": "medium",
        "dueDate": null
      }
    }
  ]
}
```

Returns an empty array if the employee has no assignments.

---

### List Assignments by Task

Returns all employees assigned to a specific task.

```
GET /api/assignments/task/{taskId}
```

**Response: `200 OK`**

```json
{
  "data": [
    {
      "id": 1,
      "employeeId": 1,
      "taskId": 3,
      "employee": {
        "id": 1,
        "name": "John Doe",
        "email": "john.doe@company.com",
        "position": "Software Engineer",
        "department": "Engineering"
      },
      "task": null
    }
  ]
}
```

Returns an empty array if the task has no assignments.

---

## Error Responses

### Validation Error — `422 Unprocessable Entity`

Returned when request body fails validation.

```json
{
  "error": {
    "details": {
      "title": ["The title field is required."],
      "status": ["The selected status is invalid."]
    }
  }
}
```

### Not Found — `404 Not Found`

```json
{
  "error": "Task not found"
}
```

### Enum Values Reference

**Task Status:** `pending`, `in_progress`, `completed`

**Task Priority:** `low`, `medium`, `high`
