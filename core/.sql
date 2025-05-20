DROP DATABASE IF EXISTS dev_flow;
CREATE DATABASE dev_flow;
USE dev_flow;

-- Tabela de usuários
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255),
    email VARCHAR(255) UNIQUE,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de amizades
CREATE TABLE friendships (
    user_id INT NOT NULL,
    friend_id INT NOT NULL,
    status ENUM('pending', 'accepted', 'rejected') NOT NULL DEFAULT 'pending',
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (friend_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela de contas vinculadas ao GitHub
CREATE TABLE accounts (
    github_id INT PRIMARY KEY,
    user_id INT NOT NULL,
    username VARCHAR(255) NOT NULL,
    avatar_url VARCHAR(255),
    access_token VARCHAR(255) NOT NULL,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela de projetos
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    user_id INT NOT NULL,
    description TEXT,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela de quadros (boards)
CREATE TABLE boards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    color ENUM('red', 'green', 'blue', 'yellow', 'purple') NOT NULL,
    project_id INT NOT NULL,

    position INT NOT NULL,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

-- Tabela de tarefas
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    board_id INT NOT NULL,
    user_id INT NOT NULL,
    expired_at DATETIME,

    position INT NOT NULL,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (board_id) REFERENCES boards(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela de etiquetas (labels)
CREATE TABLE labels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    color VARCHAR(255) NOT NULL,

    project_id INT NOT NULL,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

-- Tabela de associação entre tarefas e rótulos
CREATE TABLE task_labels (
    task_id INT NOT NULL,
    label_id INT NOT NULL,

    PRIMARY KEY (task_id, label_id),

    FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
    FOREIGN KEY (label_id) REFERENCES labels(id) ON DELETE CASCADE
);

-- Tabela de documentos do projeto
CREATE TABLE documentation(
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_by INT,
    user_id INT,
    project_id INT,

    title VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    content TEXT,


    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);


CREATE OR REPLACE VIEW friends_view AS
SELECT
    f.user_id,
    u.name            AS user_name,
    a1.username       AS user_username,
    a1.avatar_url     AS user_avatar,
    f.friend_id,
    uf.name           AS friend_name,
    a2.username       AS friend_username,
    a2.avatar_url     AS friend_avatar
FROM friendships f
JOIN users u
  ON f.user_id = u.id
LEFT JOIN accounts a1
  ON u.id = a1.user_id
JOIN users uf
  ON f.friend_id = uf.id
LEFT JOIN accounts a2
  ON uf.id = a2.user_id;



