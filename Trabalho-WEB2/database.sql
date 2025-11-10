-- Script SQL para criação do banco de dados do Sistema de Gestão de Tarefas

-- 1. Tabela de Usuários (usuarios)
-- Armazena informações dos usuários para autenticação.
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    -- A senha será armazenada como hash (password_hash)
    senha VARCHAR(255) NOT NULL,
    -- Campo para o token de recuperação de senha (opcional)
    token_recuperacao VARCHAR(255) NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2. Tabela de Tarefas (tarefas)
-- Armazena as tarefas, sendo a entidade principal para o CRUD.
CREATE TABLE tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NULL,
    data_vencimento DATE NULL,
    prioridade ENUM('Baixa', 'Média', 'Alta') NOT NULL DEFAULT 'Média',
    status ENUM('Pendente', 'Em Progresso', 'Concluída') NOT NULL DEFAULT 'Pendente',
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Chave estrangeira que liga a tarefa ao seu usuário
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Exemplo de inserção de um usuário (a senha '123456' deve ser substituída por um hash real no código PHP)
-- INSERT INTO usuarios (nome, email, senha) VALUES ('Admin', 'admin@exemplo.com', '$2y$10$xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
