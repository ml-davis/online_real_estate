CREATE TABLE users(
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(45),
    last_name VARCHAR(45),
    phone_number VARCHAR(45),
    email VARCHAR(60),
    password VARCHAR(20),
    reg_date DATETIME
);

CREATE TABLE user_prefs(
    user_id INT PRIMARY KEY,
    city VARCHAR(45),
    min_cost VARCHAR(10),
    max_cost VARCHAR(10),
    num_bedrooms VARCHAR(10),
    num_bathrooms VARCHAR(10),
    min_sq_ft VARCHAR(10),
    max_sq_ft VARCHAR(10),
    has_balcony ENUM('Yes', 'No', 'Any'),
    has_dishwasher ENUM('Yes', 'No', 'Any'),
    is_furnished ENUM('Yes', 'No', 'Any'),
    allows_pets ENUM('Yes', 'No', 'Any'),
    allows_smoking ENUM('Yes', 'No', 'Any'),
    extra_info TEXT,
    FOREIGN KEY(user_id) REFERENCES users(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE properties(
    property_id INT PRIMARY KEY,
    user_id INT NOT NULL,
    address VARCHAR(128),
    apartment_number VARCHAR(6),
    city VARCHAR(45),
    cost VARCHAR(10),
    num_bedrooms VARCHAR(10),
    num_bathrooms VARCHAR(10),
    sq_ft VARCHAR(10),
    has_balcony ENUM('Yes', 'No'),
    has_dishwasher ENUM('Yes', 'No'),
    is_furnished ENUM('Yes', 'No'),
    allows_pets ENUM('Yes', 'No'),
    allows_smoking ENUM('Yes', 'No'),
    extra_info TEXT,
    FOREIGN KEY(user_id) REFERENCES users(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);


