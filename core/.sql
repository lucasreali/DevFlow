DROP DATABASE IF EXISTS dev_flow;
CREATE DATABASE dev_flow;
USE dev_flow;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    avatar_url VARCHAR(255),
    access_token VARCHAR(255),
    github_id INT
);