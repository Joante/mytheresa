# Mytheresa Test API

## Features

- **Discounts**: Products in the "boots" category receive a 30% discount. Additionally, products with SKU `000003` have a 15% discount.
- **Filters**: 
  - Filter by `category`
  - Filter by `priceLessThan` (applied before discounts are applied)
- **Returns**: The API returns a maximum of 5 products at a time with their corresponding prices and discount information.

## Endpoint

### `GET /products`

Fetch the list of products with discounts applied where necessary.

#### Query Parameters

- **category** (optional): Filter products by their category.
- **priceLessThan** (optional): Filter products by price before discounts are applied. Only products with a price less than or equal to the value provided will be returned.

#### Example Requests

1. **Without any filters**:
   ```bash
   GET /products
2. **Filtered by category (boots)**:
    ```bash
   GET /products?category=boots
3. **Filtered by category (boots) and price (priceLessThan=90000)**:
    ```bash
   GET /products?category=boots&priceLessThan=90000

## Installation and Setup

### Prerequisites

- **Docker**: Make sure Docker is installed on your machine.
- **Docker Compose**: Ensure Docker Compose is available to manage multi-container Docker applications.

### Steps to Run the Application

1. **Clone the repository**:

    ```bash
    git clone https://github.com/Joante/mytheresa.git
    cd mytheresa
    ```

2. **Build and start the application using Docker**:

    ```bash
    sh start.sh
    ```

    This script will build the Docker containers and run the application.

3. **Access the API**:

    The API will be running on `http://localhost:8000`.

    You can test the endpoint by using `curl`, Postman, or directly in your browser (for GET requests).

### Running Tests

To run the tests, use the following command:

```bash
docker-compose exec app php artisan test

## Technologies Used

- **PHP 8.0+**: The programming language used for developing the API.
- **Laravel 8**: PHP framework for building the API.
- **Docker**: Containerization for running the application in a consistent environment.
- **MySQL**: Database to store product data.
- **PHPUnit**: Testing framework for automated testing.
