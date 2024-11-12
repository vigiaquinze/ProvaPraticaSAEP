# Prova prática do SAEP - Aplicação ToDo List
## Recursos utilizados
- Linguagem PHP
- PostGreSQL
- LucidChart
## Entregas
### Diagrama de entidade-relacionamento
![](docs/img/Diagrama%20de%20relacionamento.png)
### Script da criação do banco de dados no PostGreSQL
    Criar tabela usuario
    CREATE TABLE usuario (
        id SERIAL PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL
    );

    Criar tabela tarefa
    CREATE TABLE tarefa (
        id SERIAL PRIMARY KEY,
        titulo VARCHAR(255) NOT NULL,
        descricao TEXT,
        grau_importancia grau_importancia NOT NULL,
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        data_conclusao TIMESTAMP,
        status status_tarefa NOT NULL DEFAULT 'pendente',
        id_usuario INTEGER REFERENCES usuario(id)
    );
### Diagrama de caso de uso
![](docs/img/Diagrama%20de%20caso%20de%20uso.png)
