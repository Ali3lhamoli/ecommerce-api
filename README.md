# 🛒 Laravel E-commerce RESTful API

A simple e-commerce RESTful API built with **Laravel 12**, featuring user authentication, role-based access, product management, order processing, and Docker-ready local setup.

---

## 🚀 Features

* ✅ **User Authentication** (Register/Login/Logout) using Laravel Sanctum
* ✅ **Role-based Access Control** (admin/user)
* ✅ **Products CRUD** (admin only)
* ✅ **Order creation with stock validation and total amount calculation**
* ✅ **Consistent JSON response structure** using a custom `ApiResponse` trait
* ✅ **Form Request Validation** with unified error formatting
* ✅ **Docker support** for running PHP/MySQL locally
* ✅ **Postman Collection + Public Docs**
* ✅ **Feature Tests** covering login and order creation

---

## 📁 Project Structure Highlights

| Feature      | Implementation                                               |
| ------------ | ------------------------------------------------------------ |
| Auth         | `AuthController.php`, Sanctum, tests                         |
| Products     | `ProductController.php`, `ProductRequest.php`                |
| Orders       | `OrderController.php`, transaction logic, `OrderRequest.php` |
| API Response | `App\Traits\ApiResponse`                                     |
| Validation   | Via `FormRequest` + `Handler.php`                            |
| Admin Access | `AdminMiddleware`                                            |

---

## ✅ Framework Choice

This project uses **Laravel 12** because it offers:

* Modern and clean structure
* Built-in support for Sanctum (token-based auth)
* Powerful Eloquent ORM for DB management
* Convenient request validation and routing
* First-class testing tools and Artisan CLI

Laravel allows rapid development and is well-suited for scalable APIs.

---

## 📌 Assumptions Made During Development

* Users can only access their own orders
* Admins have full access to all product management endpoints
* Order placement must validate product stock
* No product image upload required
* No frontend, only backend API with JSON responses
* Token authentication done via Laravel Sanctum (not JWT)

---

## 🐳 Docker Setup

> Note: Due to system limitations, Docker Desktop could not be tested locally. However, the provided `docker-compose.yml` and `Dockerfile` are fully functional and ready to run on any compatible environment with Docker installed.

### 🛠 Prerequisites

* Docker Desktop (Windows 10+ version 19044 or above)

### 🧪 Steps

1. Copy `.env.example` to `.env` and update credentials if needed.

2. Run Docker containers:

```bash
docker-compose up -d
```

3. Enter the app container:

```bash
docker exec -it laravel_app bash
```

4. Install dependencies and migrate database:

```bash
composer install
php artisan key:generate
php artisan migrate
```

5. Access the app:

* Laravel API: [http://localhost:8000](http://localhost:8000)
* MySQL: `localhost:3306`, user: `root`, pass: `root`

---

## 🧪 Testing

Feature tests are written for core functionalities:

### ✅ Login Test (`AuthTest`)

* Tests valid login and checks for `access_token`, `user`, `token_type`

### ✅ Order Test (`OrderTest`)

* Authenticated user can place order with multiple items
* Ensures stock is updated and order saved

To run tests:

```bash
php artisan test
```

---

## 📎 API Documentation

### 🔗 Online Docs (Postman):

👉 [View API Docs](https://documenter.getpostman.com/view/31946109/2sB2x6nshZ)

### 📥 Local Postman Collection

File path: `postman/ecommerce-api.postman_collection.json`

You can import this into Postman directly.

---

## 📦 Example Endpoints

### 🔐 Auth

| Method | URL                  | Description             |
| ------ | -------------------- | ----------------------- |
| POST   | `/api/auth/register` | Register user           |
| POST   | `/api/auth/login`    | Login, get token        |
| POST   | `/api/auth/logout`   | Logout (requires token) |

### 📦 Products

| Method | URL                  | Role  | Description          |
| ------ | -------------------- | ----- | -------------------- |
| GET    | `/api/products`      | All   | List products        |
| GET    | `/api/products/{id}` | All   | View product details |
| POST   | `/api/products`      | Admin | Create product       |
| PUT    | `/api/products/{id}` | Admin | Update product       |
| DELETE | `/api/products/{id}` | Admin | Delete product       |

### 🛒 Orders

| Method | URL                | Role | Description         |
| ------ | ------------------ | ---- | ------------------- |
| GET    | `/api/orders`      | Auth | List user orders    |
| GET    | `/api/orders/{id}` | Auth | View specific order |
| POST   | `/api/orders`      | Auth | Place an order      |

---

## 👨‍💻 Author

**Ali Alhamoli**
Backend Developer
[LinkedIn](https://linkedin.com/in/ali-alhamoli)

---

## 📝 License

This project was developed as part of a technical evaluation for Digital Bond.
