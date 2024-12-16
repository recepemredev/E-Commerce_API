<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

# E-Commerce API

## Project Overview
This E-Commerce API is a RESTful service built using Laravel, designed to handle various operations required for an e-commerce platform. The API supports functionalities such as product management, order processing, user authentication, and more. It aims to provide a robust, secure, and scalable solution for handling e-commerce transactions.


## Getting Started
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/recepemredev/E-Commerce_API.git
   cd E-Commerce_API
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   ```

3. **Set Up Environment**:
   ```bash
   cp .env.example .env
   ```

   Configure your database and API keys in the `.env` file.

4. **Run Database Migrations**:
   ```bash
   php artisan migrate
   ```

5. **Generate JWT Secret**:
   ```bash
   php artisan jwt:secret
   ```

6. **Start the Development Server**:
   ```bash
   php artisan serve
   ```

## Testing
You can test the API using tools like Postman or any HTTP client by sending requests to the specified endpoints.


## Endpoints
### Authentication
- **POST /api/auth/login**: Login user
- **POST /api/auth/register**: Register user
- **POST /api/auth/logout**: Logout user

### Products
- **GET /api/products**: List all products
- **GET /api/products/{id}**: Get product details
- **POST /api/products**: Create new product (Admin only)
- **PUT /api/products/{id}**: Update product (Admin only)
- **DELETE /api/products/{id}**: Delete product (Admin only)

### Cart
- **GET /api/cart**: View current cart
- **POST /api/cart/items**: Add item to cart
- **PUT /api/cart/items/{id}**: Update item from cart
- **DELETE /api/cart/items/{id}**: Remove item from cart

### Orders
- **POST /api/orders**: Create new order
- **GET /api/orders/{id}**: Get order details

## Development
The project uses Laravel as the backend framework.
For testing, use Postman or any HTTP client to interact with the API.
Ensure proper handling of tokens, especially for authentication and authorization.

## Postman Documentation

[Postman Request Documentation](https://documenter.getpostman.com/view/34784019/2sAYHzHPDN)

## Contributing
Contributions are welcome! If you find a bug or want to add a new feature, feel free to open a pull request.
Please ensure your code follows the project’s coding standards and passes the tests.
Follow the code of conduct for contributing to this project.

## License
This project is licensed under the MIT License. See the LICENSE file for details.
