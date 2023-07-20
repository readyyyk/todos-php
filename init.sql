DROP DATABASE todos;

CREATE DATABASE IF NOT EXISTS todos;

use todos;

create table users (
   id int AUTO_INCREMENT NOT NULL,
   username varchar(255) NOT NULL,
   password varchar(255) NOT NULL,
   registered_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
   PRIMARY KEY (id)
);

create table todos (
    id int AUTO_INCREMENT NOT NULL,
    owner int NOT NULL,
    title varchar(255) NOT NULL,
    state varchar(30) NOT NULL DEFAULT 'passive',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (owner) REFERENCES users(id)
);
