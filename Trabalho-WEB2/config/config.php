<?php
// Arquivo de configuração do sistema

// Configurações do Banco de Dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Alterar para o usuário real
define('DB_PASS', 'password'); // Alterar para a senha real
define('DB_NAME', 'web2_tarefas'); // Nome do banco de dados

// Configurações da Aplicação
define('APP_NAME', 'Gestão de Tarefas WEB2');
define('BASE_URL', 'http://localhost:8000'); // Ajustar conforme o ambiente de execução

// Configurações de Segurança
define('SECRET_KEY', 'sua_chave_secreta_aqui_para_sessoes'); // Chave para segurança de sessões/cookies

// Configurações de Caminhos
define('ROOT_PATH', dirname(__DIR__));
define('VIEW_PATH', ROOT_PATH . '/views/');
define('CONTROLLER_PATH', ROOT_PATH . '/controllers/');
define('MODEL_PATH', ROOT_PATH . '/models/');
define('CORE_PATH', ROOT_PATH . '/core/');

// Configuração de exibição de erros (desativar em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
