<?php
// controllers/AuthController.php

require_once CORE_PATH . 'Controller.php';
require_once MODEL_PATH . 'UsuarioModel.php';

class AuthController extends Controller {
    private $usuarioModel;

    public function __construct() {
        // Inicia a sessão se ainda não estiver iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->usuarioModel = new UsuarioModel();
    }

    // Exibe o formulário de registro
    public function register() {
        $this->view('auth/register', ['titulo' => 'Registro']);
    }

    // Processa o registro de um novo usuário
    public function processRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $senha = $_POST['senha'] ?? '';
            $confirmarSenha = $_POST['confirmar_senha'] ?? '';

            // 1. Validação de dados (Front-end e Back-end)
            if (empty($nome) || empty($email) || empty($senha) || empty($confirmarSenha)) {
                $_SESSION['message'] = 'Todos os campos são obrigatórios.';
                $_SESSION['message_type'] = 'danger';
                $this->redirect('/auth/register');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['message'] = 'Formato de e-mail inválido.';
                $_SESSION['message_type'] = 'danger';
                $this->redirect('/auth/register');
            }

            if ($senha !== $confirmarSenha) {
                $_SESSION['message'] = 'As senhas não coincidem.';
                $_SESSION['message_type'] = 'danger';
                $this->redirect('/auth/register');
            }

            // 2. Verifica se o e-mail já existe
            if ($this->usuarioModel->findByEmail($email)) {
                $_SESSION['message'] = 'Este e-mail já está em uso.';
                $_SESSION['message_type'] = 'danger';
                $this->redirect('/auth/register');
            }

            // 3. Hash de Senha
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            // 4. Cria o usuário
            if ($this->usuarioModel->create($nome, $email, $senhaHash)) {
                $_SESSION['message'] = 'Registro realizado com sucesso! Faça login para continuar.';
                $_SESSION['message_type'] = 'success';
                $this->redirect('/auth/login');
            } else {
                $_SESSION['message'] = 'Erro ao registrar o usuário. Tente novamente.';
                $_SESSION['message_type'] = 'danger';
                $this->redirect('/auth/register');
            }
        } else {
            $this->redirect('/auth/register');
        }
    }

    // Exibe o formulário de login
    public function login() {
        $this->view('auth/login', ['titulo' => 'Login']);
    }

    // Processa o login do usuário
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $senha = $_POST['senha'] ?? '';

            // 1. Validação de dados
            if (empty($email) || empty($senha)) {
                $_SESSION['message'] = 'Preencha todos os campos.';
                $_SESSION['message_type'] = 'danger';
                $this->redirect('/auth/login');
            }

            // 2. Busca o usuário
            $usuario = $this->usuarioModel->findByEmail($email);

            // 3. Verifica a senha
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                // Login bem-sucedido: Cria a sessão
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['message'] = 'Login realizado com sucesso!';
                $_SESSION['message_type'] = 'success';
                
                // Redireciona para a página inicial (que redirecionará para tarefas)
                $this->redirect('/');
            } else {
                // Login falhou
                $_SESSION['message'] = 'E-mail ou senha inválidos.';
                $_SESSION['message_type'] = 'danger';
                $this->redirect('/auth/login');
            }
        } else {
            $this->redirect('/auth/login');
        }
    }

    // Realiza o logout
    public function logout() {
        // Destrói a sessão
        session_start();
        session_unset();
        session_destroy();
        
        // Redireciona para a página inicial
        $_SESSION['message'] = 'Você foi desconectado.';
        $_SESSION['message_type'] = 'info';
        $this->redirect('/');
    }
    
    // Método para recuperação de senha (apenas esqueleto, pois exige envio de e-mail)
    public function forgotPassword() {
        // Em um projeto real, aqui estaria a lógica para enviar um e-mail com um token
        $this->view('auth/forgot_password', ['titulo' => 'Recuperar Senha']);
    }
}
