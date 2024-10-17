DROP DATABASE IF EXISTS ProjetoBlog;

CREATE DATABASE IF NOT EXISTS ProjetoBlog;

USE ProjetoBlog;

CREATE TABLE Usuario (
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(100) NOT NULL,
    data_criacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ativo TINYINT NOT NULL DEFAULT '0',
    adm TINYINT NOT NULL DEFAULT '0'
);

CREATE TABLE Post (
   id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
   titulo VARCHAR(100) NOT NULL,
   texto TEXT NOT NULL,
   data_criacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
   data_postagem DATETIME NOT NULL,
   usuario_id INT,
   KEY fk_post_usuario_idx (usuario_id),
   CONSTRAINT fk_post_usuario FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
);


