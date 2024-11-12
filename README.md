# Prova prática do SAEP - Aplicação ToDo List
## Recursos utilizados
- Linguagem PHP
- PostGreSQL
- LucidChart
## Entregas
### Diagrama de entidade-relacionamento
![](docs/img/Diagrama%20de%20relacionamento.png)
### Script da criação do banco de dados no PostGreSQL
    -- Conectar ao PostgreSQL e criar o banco de dados
    CREATE DATABASE gerenciamentotarefas;

    -- Criar tipo enum para grau_importancia
    CREATE TYPE grau_importancia AS ENUM ('Baixa', 'Média', 'Alta');

    -- Criar tipo enum para status
    CREATE TYPE status_tarefa AS ENUM ('A fazer', 'Fazendo', 'Pronto');

    -- Criar tabela usuarios
    CREATE TABLE usuarios (
        id_usuario SERIAL PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE
    );

    -- Criar tabela tarefas
    CREATE TABLE tarefas (
        id_tarefa SERIAL PRIMARY KEY,
        titulo VARCHAR(255) NOT NULL,
        descricao TEXT,
        grau_importancia grau_importancia NOT NULL,
        status status_tarefa NOT NULL DEFAULT 'A fazer',
        id_usuario INTEGER REFERENCES usuario(id)
    );
### Diagrama de caso de uso
![](docs/img/Diagrama%20de%20caso%20de%20uso.png)
