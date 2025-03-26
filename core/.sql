DROP DATABASE IF EXISTS dev_flow;
CREATE DATABASE dev_flow;
USE dev_flow;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    password VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- GitHub
    username VARCHAR(255),
    avatar_url VARCHAR(255),
    access_token VARCHAR(255),
    github_id INT UNIQUE
);