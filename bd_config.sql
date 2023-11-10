CREATE DATABASE infostore;
USE infostore;

CREATE TABLE posts (
    id INT PRIMARY KEY,
    userId INT,
    title VARCHAR(255),
    body TEXT
);


CREATE TABLE comments (
    id INT PRIMARY KEY,
    postId INT,
    name VARCHAR(255),
    email VARCHAR(255),
    body TEXT
);