<?php
// core/Controller.php

class Controller {
    protected function view($viewName, $data = []) {
        // Extrai os dados para que as variáveis possam ser acessadas diretamente na view
        extract($data);
        
        // Inclui o arquivo da view
        $viewPath = VIEW_PATH . $viewName . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            // Em caso de erro, exibe uma mensagem simples
            echo "Erro: View '{$viewName}' não encontrada.";
        }
    }

    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit();
    }
}
