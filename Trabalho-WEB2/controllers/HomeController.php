<?php
// controllers/HomeController.php

require_once CORE_PATH . 'Controller.php';

class HomeController extends Controller {
    public function index() {
        // Verifica se o usuário está logado
        if (isset($_SESSION['usuario_id'])) {
            // Se estiver logado, redireciona para a lista de tarefas
            $this->redirect('/tarefas/index');
        } else {
            // Se não estiver logado, exibe a página inicial (landing page ou login)
            $this->view('home/index', ['titulo' => 'Bem-vindo']);
        }
    }
}
