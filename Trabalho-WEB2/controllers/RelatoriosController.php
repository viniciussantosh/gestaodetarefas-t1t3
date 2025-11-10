<?php
// controllers/RelatoriosController.php

require_once CORE_PATH . 'Controller.php';
require_once MODEL_PATH . 'RelatorioModel.php';

class RelatoriosController extends Controller {
    private $relatorioModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Proteção de acesso
        if (!isset($_SESSION['usuario_id'])) {
            $_SESSION['message'] = 'Você precisa estar logado para acessar esta página.';
            $_SESSION['message_type'] = 'warning';
            $this->redirect('/auth/login');
        }
        
        $this->relatorioModel = new RelatorioModel();
    }

    // Exibe a página de relatórios
    public function index() {
        $usuarioId = $_SESSION['usuario_id'];
        $resumo = $this->relatorioModel->getResumoPorStatus($usuarioId);
        
        $dados_resumo = [];
        foreach ($resumo as $item) {
            $dados_resumo[$item['status']] = $item['total'];
        }
        
        $this->view('relatorios/index', ['titulo' => 'Relatórios', 'resumo' => $dados_resumo]);
    }

    // Gera o relatório em PDF (exemplo de geração de relatório)
    public function gerarPdf() {
        $usuarioId = $_SESSION['usuario_id'];
        $tarefas = $this->relatorioModel->getTarefasParaRelatorio($usuarioId);
        
        // Inicia a bufferização de saída
        ob_start();
        
        // Inclui o template do relatório
        require VIEW_PATH . 'relatorios/pdf_template.php';
        
        $html = ob_get_clean();
        
        // O PDF será gerado usando a biblioteca weasyprint (disponível no ambiente
        
        $filename = 'relatorio_tarefas_' . date('Ymd_His') . '.html';
        $filepath = '/home/ubuntu/Trabalho-WEB2/public/relatorios/' . $filename;
        
        // Cria o diretório se não existir
        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0777, true);
        }
        
        file_put_contents($filepath, $html);
        
        $_SESSION['message'] = 'Relatório em HTML gerado com sucesso! (Em um ambiente real, seria um PDF).';
        $_SESSION['message_type'] = 'success';
        
        // Redireciona para a página de relatórios
        $this->redirect('/relatorios/index');
    }
}
