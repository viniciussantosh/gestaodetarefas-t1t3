# Sistema de Gestão de Tarefas (Trabalho WEB2)

Este projeto é um sistema web completo de Gestão de Tarefas (To-Do List) desenvolvido em PHP puro com MySQL, seguindo o padrão arquitetural MVC (Model-View-Controller). O objetivo é demonstrar a implementação de funcionalidades essenciais como autenticação, CRUD completo, geração de relatórios e medidas de segurança.

## Requisitos

*   Servidor Web (Apache, Nginx, etc.)
*   PHP 7.4+
*   MySQL/MariaDB
*   Extensões PHP: `pdo_mysql`

## Instalação e Execução

Siga os passos abaixo para configurar e executar o projeto em seu ambiente local.

### 1. Configuração do Banco de Dados

1.  Crie um banco de dados MySQL com o nome `web2_tarefas`.
2.  Execute o script SQL fornecido para criar as tabelas necessárias:

    ```bash
    mysql -u seu_usuario -p web2_tarefas < database.sql
    ```

3.  **Ajuste as credenciais de acesso** no arquivo `config/config.php`:

    ```php
    // config/config.php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'root');   
    define('DB_NAME', 'web2_tarefas');
    ```

### 2. Configuração do Servidor Web

1.  Coloque a pasta `Trabalho-WEB2` no diretório raiz do seu servidor web (ex: `htdocs` ou `www`).
2.  Configure o servidor web para que o diretório raiz do projeto aponte para a pasta `public/`.
    *   **Alternativa Simples (PHP Built-in Server):** Para um teste rápido, você pode executar o servidor embutido do PHP a partir da pasta `Trabalho-WEB2`:

        ```bash
        php -S localhost:8000 -t public
        ```

3.  Acesse a aplicação no seu navegador: `http://localhost:8000`

## Diagrama do Banco de Dados (Modelo Entidade-Relacionamento)

O sistema utiliza duas entidades principais: `usuarios` e `tarefas`.

| Tabela | Coluna | Tipo | Descrição |
| :--- | :--- | :--- | :--- |
| **usuarios** | `id` | INT (PK) | Identificador único do usuário. |
| | `nome` | VARCHAR(100) | Nome completo do usuário. |
| | `email` | VARCHAR(100) | E-mail do usuário (ÚNICO). |
| | `senha` | VARCHAR(255) | Senha hasheada (`password_hash`). |
| | `data_criacao` | DATETIME | Data de criação do registro. |
| **tarefas** | `id` | INT (PK) | Identificador único da tarefa. |
| | `usuario_id` | INT (FK) | Chave estrangeira para a tabela `usuarios`. |
| | `titulo` | VARCHAR(255) | Título da tarefa. |
| | `descricao` | TEXT | Descrição detalhada. |
| | `data_vencimento` | DATE | Data limite para conclusão. |
| | `prioridade` | ENUM | 'Baixa', 'Média', 'Alta'. |
| | `status` | ENUM | 'Pendente', 'Em Progresso', 'Concluída'. |
| | `data_criacao` | DATETIME | Data de criação da tarefa. |

**Relacionamento:** `usuarios` 1:N `tarefas` (Um usuário pode ter muitas tarefas).

## Estrutura do Projeto (MVC)

```
Trabalho-WEB2/
├── config/
│   └── config.php         # Configurações da aplicação e DB
├── controllers/
│   ├── AuthController.php   # Lógica de Autenticação (Login, Registro, Logout)
│   ├── HomeController.php   # Controlador da página inicial
│   ├── TarefasController.php  # Lógica do CRUD de Tarefas
│   └── RelatoriosController.php # Lógica de Geração de Relatórios
├── core/
│   ├── Controller.php       # Classe base para Controllers
│   ├── Database.php         # Conexão PDO com o Banco de Dados
│   ├── Model.php            # Classe base para Models
│   └── Router.php           # Sistema de Roteamento (URL -> Controller/Action)
├── models/
│   ├── UsuarioModel.php     # Interação com a tabela 'usuarios'
│   ├── TarefaModel.php      # Interação com a tabela 'tarefas'
│   └── RelatorioModel.php   # Consultas específicas para relatórios
├── public/
│   └── index.php          # Ponto de entrada (Front Controller)
├── views/
│   ├── auth/              # Views de Autenticação
│   ├── home/              # View da Página Inicial
│   ├── layout/            # Header e Footer (Bootstrap)
│   ├── tarefas/           # Views do CRUD de Tarefas
│   └── relatorios/        # Views de Relatórios
└── database.sql           # Script de criação do banco de dados
```
