CREATE DATABASE ecommerce;

CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories(
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL
);

CREATE TABLE products(
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    product_name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(category_id)
    REFERENCES categories(id)
    ON DELETE SET NULL
);

CREATE TABLE cart(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT DEFAULT 1,

    FOREIGN KEY(user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    FOREIGN KEY(product_id)
    REFERENCES products(id)
    ON DELETE CASCADE
);


CREATE TABLE orders(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10,2),
    status ENUM(
        'Pending',
        'Processing',
        'Shipped',
        'Delivered',
        'Cancelled'
    ) DEFAULT 'Pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(user_id)
    REFERENCES users(id)
    ON DELETE CASCADE
);


CREATE TABLE order_items(
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10,2),

    FOREIGN KEY(order_id)
    REFERENCES orders(id)
    ON DELETE CASCADE,

    FOREIGN KEY(product_id)
    REFERENCES products(id)
    ON DELETE CASCADE
);


INSERT INTO users
(name,email,username,password,role)
VALUES
(
'Admin',
'admin@gmail.com',
'admin',
'admin123',
'admin'
);

INSERT INTO categories(category_name)
VALUES
('Electronics'),
('Fashion'),
('Books'),
('Home Appliances'),
('Sports');



CREATE TABLE products(
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    product_name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(category_id)
    REFERENCES categories(id)
    ON DELETE SET NULL
);


CREATE TABLE cart(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,

    FOREIGN KEY(user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    FOREIGN KEY(product_id)
    REFERENCES products(id)
    ON DELETE CASCADE
);


CREATE TABLE orders(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM(
        'Pending',
        'Processing',
        'Shipped',
        'Delivered',
        'Cancelled'
    ) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(user_id)
    REFERENCES users(id)
    ON DELETE CASCADE
);


CREATE TABLE order_items(
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,

    FOREIGN KEY(order_id)
    REFERENCES orders(id)
    ON DELETE CASCADE,

    FOREIGN KEY(product_id)
    REFERENCES products(id)
    ON DELETE CASCADE
);

ALTER TABLE users
ADD status ENUM('active','blocked')
DEFAULT 'active';

ALTER TABLE orders
ADD shipping_address TEXT;ALTER TABLE orders
ADD shipping_address TEXT;

ALTER TABLE orders
ADD payment_method VARCHAR(50);

CREATE TABLE wishlist(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT
);

CREATE TABLE reviews(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    rating INT,
    review TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);