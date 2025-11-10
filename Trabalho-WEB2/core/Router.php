<?php
// core/Router.php

class Router {
    private $routes = [];

    public function add($route, $controller, $action) {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch($uri) {
        // Remove a BASE_URL e limpa a URI
        $uri = trim(str_replace(BASE_URL, '', $uri), '/');
        $uri = empty($uri) ? '/' : $uri;

        // Roteamento simples: /controller/action/param1/param2
        $segments = explode('/', $uri);
        
        // Tenta encontrar uma rota exata
        if (isset($this->routes[$uri])) {
            $controllerName = $this->routes[$uri]['controller'];
            $actionName = $this->routes[$uri]['action'];
            $params = [];
        } else {
            // Roteamento dinâmico
            $controllerName = ucfirst(array_shift($segments)) . 'Controller';
            $actionName = array_shift($segments);
            $actionName = empty($actionName) ? 'index' : $actionName;
            $params = $segments;
        }

        // Se o nome do controller for vazio (ex: acesso a /), usa o HomeController
        if (empty($controllerName) || $controllerName === 'Controller') {
            $controllerName = 'HomeController';
        }
        
        // Se a ação for vazia, usa a ação index
        if (empty($actionName)) {
            $actionName = 'index';
        }

        $controllerFile = CONTROLLER_PATH . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            // Verifica se a classe existe
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                
                // Verifica se o método (ação) existe
                if (method_exists($controller, $actionName)) {
                    // Chama o método com os parâmetros
                    call_user_func_array([$controller, $actionName], $params);
                } else {
                    // Ação não encontrada
                    $this->handleError("Ação '{$actionName}' não encontrada no controller '{$controllerName}'.");
                }
            } else {
                // Classe Controller não encontrada
                $this->handleError("Controller '{$controllerName}' não encontrado.");
            }
        } else {
            // Controller não encontrado
            $this->handleError("Controller '{$controllerName}' não encontrado.");
        }
    }

    private function handleError($message) {
        // Em um projeto real, você renderizaria uma página 404 ou de erro
        http_response_code(404);
        echo "<h1>404 - Página Não Encontrada</h1>";
        echo "<p>{$message}</p>";
    }
}
