# 🛒 Multi-Vendor Marketplace API (Laravel)

A RESTful backend API built with **Laravel 12** that simulates a real-world **multi-vendor marketplace checkout system**.

Customers can add products from multiple vendors to a cart and, on checkout, the system **splits the cart into separate vendor-specific orders**, handles stock deduction, payments, and admin order management.

## ✅ Features

### 👤 Authentication & Authorization
- Token-based authentication using **Laravel Sanctum**
- Role-based access (`admin`, `customer`)
- Policies & Gates for secure access control

### 🏪 Marketplace
- Vendors with multiple products
- Products with price and stock management
- Database seeding using factories

### 🛒 Cart System
- Add products from multiple vendors to cart
- Update/remove cart items
- Stock validation
- Cart grouped by vendor

### 🧾 Checkout & Orders
- Multi-vendor checkout
- Cart split into separate orders per vendor
- Order items with price snapshot
- Payment simulation
- Stock deduction
- Transaction-safe checkout

### 🛡 Admin Features
- View all orders
- Filter orders by vendor, customer, or status
- View full order details

### 📣 Events & Listeners (Bonus)
- `OrderPlaced` event
- Listener logs order placement (mock notification)

## 🧠 Architecture Highlights
- Service Layer (CartService, CheckoutService)
- Thin Controllers
- FormRequest validation
- Policies for authorization
- Events for decoupled side-effects
- Database transactions for consistency

## 📦 Requirements
- PHP >= 8.3
- Composer
- MySQL
- Laravel 12+

## 🚀 Installation

### 1. Clone Repository
```bash
git clone https://github.com/your-username/multi_vendor_marketplace.git
cd multi_vendor_marketplace
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Copy Environment File
```bash
cp .env.example .env
```

### 4. Configure Database
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=multi_vendor_marketplace
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate App Key
```bash
php artisan key:generate
```

### 6. Run Migrations & Seeders
```bash
php artisan migrate --seed
```

### 7. Clear Cache
```bash
php artisan optimize:clear
```

### 8. Run Server
```bash
php artisan serve | composer run dev
```

App URL:
```
http://localhost:8000
```

## 🔑 Sample Credentials

### Admin
- Email: admin@altrone.com
- Password: password

### Customer
- Email: anilkumarbind06@gmail.com
- Password: password

## 🔐 Authentication

### Login
```
POST /api/login
```

Request:
```json
{
  "email": "anilkumarbind06@gmail.com",
  "password": "password"
}
```

Use token in header:
```
Authorization: Bearer TOKEN
```

## 📎 API Endpoints

### Products & Vendors
- GET /api/products
- GET /api/products/{id}
- GET /api/vendors
- GET /api/vendors/{id}

### Cart
- POST /api/cart/add
- GET /api/cart
- PUT /api/cart/item/{id}
- DELETE /api/cart/item/{id}

### Checkout & Orders
- POST /api/checkout
- GET /api/orders
- GET /api/orders/{id}

### Admin
- GET /api/admin/orders
- GET /api/admin/orders/{id}

Filters:
```
/api/admin/orders?vendor_id=1
/api/admin/orders?user_id=2
/api/admin/orders?status=placed
```

## 🔒 Authorization
- Gate for admin role
- OrderPolicy for order ownership

## 🔁 Race Condition Protection
- Checkout uses DB transactions
- Row-level locking with `lockForUpdate()`
- Prevents overselling

## 📝 Notes
- API-only project (no frontend)
- Payment is simulated
- Cart does not reserve stock

## 📄 License
MIT
