CREATE DATABASE IF NOT EXISTS db_montink;
USE db_montink;

CREATE TABLE IF NOT EXISTS customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(50),
    state VARCHAR(50),
    postal_code VARCHAR(20),
    country VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    total DECIMAL(10,2) DEFAULT 0.00
);

CREATE TABLE IF NOT EXISTS stock (
    stock_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    variation VARCHAR(100),
    quantity INT NOT NULL DEFAULT 0,
    last_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

CREATE TABLE IF NOT EXISTS coupons (
    coupon_id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    discount_value DECIMAL(10,2) NOT NULL,
    valid_from DATE,
    valid_until DATE,
    active BOOLEAN DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS variations (
    variation_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS variation_options (
    variation_option_id INT AUTO_INCREMENT PRIMARY KEY,
    variation_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    FOREIGN KEY (variation_id) REFERENCES variations(variation_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS product_variations (
    product_variation_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    variation_option_id INT NOT NULL,
    price DECIMAL(10,2),
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    FOREIGN KEY (variation_option_id) REFERENCES variation_options(variation_option_id)
);

CREATE TABLE IF NOT EXISTS order_product_variations (
    order_product_variation_id INT AUTO_INCREMENT PRIMARY KEY,
    product_variation_id INT NOT NULL,
    order_id INT NOT NULL,
    FOREIGN KEY (product_variation_id) REFERENCES product_variations(product_variation_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS stock_variations (
    stock_variation_id INT AUTO_INCREMENT PRIMARY KEY,
    product_variation_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    last_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_variation_id) REFERENCES product_variations(product_variation_id) ON DELETE CASCADE
);
