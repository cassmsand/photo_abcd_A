-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- START TRANSACTION;
-- SET time_zone = "+00:00"
-- unsure about ^^ appeared in XAMPP sql file

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('regular_user', 'admin') DEFAULT 'regular_user',
    user_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
);

CREATE TABLE blogs (
    blog_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    cdate_of_event DATE NOT NULL,
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    default_image BOOLEAN DEFAULT TRUE, 
    is_public BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);


CREATE TABLE photos (
    photo_id INT AUTO_INCREMENT PRIMARY KEY,
    blog_id INT NOT NULL,
    photo_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (blog_id) REFERENCES blogs(blog_id) ON DELETE CASCADE
);

CREATE TABLE preferences (
    name VARCHAR(255) PRIMARY KEY,
    value VARCHAR(255) NOT NULL

);

CREATE TABLE alphabet_book_progress (
    progress_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    letter CHAR(1) NOT NULL,
    blog_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (blog_id) REFERENCES blogs(blog_id) ON DELETE CASCADE
);

INSERT INTO users (email, password, role, user_created, last_login)
VALUES 
('john.doe@example.com', 'password_1', 'regular_user', NOW(), NULL),
('jane.smith@example.com', 'password_2', 'regular_user', NOW(), NULL),
('admin@example.com', 'password_3', 'admin', NOW(), NOW());

INSERT INTO blogs (user_id, title, description, cdate_of_event, creation_date, modification_date, default_image, is_public)
VALUES 
(1, 'A for Apple', 'A blog about apples.', '2024-08-01', NOW(), NOW(), TRUE, FALSE),
(2, 'B for Basketball', 'A blog about basketballs.', '2024-07-15', NOW(), NOW(), TRUE, TRUE),
(1, 'C for Camping', 'A blog about camping.', '2024-06-10', NOW(), NOW(), FALSE, FALSE);

INSERT INTO preferences (name, value)
VALUES 
('site_title', 'Photo ABCD'),
('max_upload_size', '10MB');


