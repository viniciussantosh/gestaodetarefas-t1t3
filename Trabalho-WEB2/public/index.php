<?php
// public/index.php

// 1. Configuração
require_once __DIR__ . '/../config/config.php';

// 2. Autoload de Classes (simples)
spl_autoload_register(function ($class) {

    if (substr($class, -10) !== 'Controller' && file_exists(CONTROLLER_PATH . $class . 'Controller.php')) {
        $class .= 'Controller';
    } elseif (substr($class, -5) !== 'Model' && file_exists(MODEL_PATH . $class . 'Model.php')) {
        $class .= 'Model';
    }

    // Tenta carregar de core, models e controllers
    $paths = [CORE_PATH, MODEL_PATH, CONTROLLER_PATH];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// 3. Inicialização do Router
$router = new Router();


// 4. Despacho da Requisição
$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($uri);
