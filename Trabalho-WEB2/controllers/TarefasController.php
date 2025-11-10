<?php
// controllers/TarefasController.php

require_once CORE_PATH . 'Controller.php';
require_once MODEL_PATH . 'TarefaModel.php';

class TarefasController extends Controller {
    private $tarefaModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Proteção de acesso: Garante que apenas usuários logados acessem este controller
        if (!isset($_SESSION['usuario_id'])) {
            $_SESSION['message'] = 'Você precisa estar logado para acessar esta página.';
            $_SESSION['message_type'] = 'warning';
            $this->redirect('/auth/login');
        }
        
        $this->tarefaModel = new TarefaModel();
    }

    // READ: Lista todas as tarefas do usuário
    public function index() {
        $usuarioId = $_SESSION['usuario_id'];
        $tarefas = $this->tarefaModel->findByUsuario($usuarioId);
        $this->view('tarefas/index', ['titulo' => 'Minhas Tarefas', 'tarefas' => $tarefas]);
    }

    // CREATE: Exibe o formulário de criação
    public function create() {
        $this->view('tarefas/form', ['titulo' => 'Nova Tarefa', 'tarefa' => null]);
    }

    // CREATE/UPDATE: Processa a submissão do formulário
    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $usuarioId = $_SESSION['usuario_id'];
            
            // 1. Validação de dados (Back-end)
            $data = [
                'titulo' => trim($_POST['titulo'] ?? ''),
                'descricao' => trim($_POST['descricao'] ?? ''),
                'data_vencimento' => trim($_POST['data_vencimento'] ?? ''),
                'prioridade' => $_POST['prioridade'] ?? 'Média',
                'status' => $_POST['status'] ?? 'Pendente',
            ];

            if (empty($data['titulo'])) {
                $_SESSION['message'] = 'O título da tarefa é obrigatório.';
                $_SESSION['message_type'] = 'danger';
                $this->redirect('/tarefas/index');
            }
            
            // Validação de prioridade e status (para evitar injeção de valores inválidos)
            $prioridades = ['Baixa', 'Média', 'Alta'];
            $status = ['Pendente', 'Em Progresso', 'Concluída'];
            
            if (!in_array($data['prioridade'], $prioridades)) {
                $data['prioridade'] = 'Média';
            }
            if (!in_array($data['status'], $status)) {
                $data['status'] = 'Pendente';
            }

            if ($id) {
                // UPDATE
                $success = $this->tarefaModel->updateTarefa($id, $usuarioId, $data);
                $message = $success ? 'Tarefa atualizada com sucesso!' : 'Erro ao atualizar a tarefa.';
                $type = $success ? 'success' : 'danger';
            } else {
                // CREATE
                $success = $this->tarefaModel->createTarefa($usuarioId, $data);
                $message = $success ? 'Tarefa criada com sucesso!' : 'Erro ao criar a tarefa.';
                $type = $success ? 'success' : 'danger';
            }

            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = $type;
            $this->redirect('/tarefas/index');

        } else {
            $this->redirect('/tarefas/index');
        }
    }

    // UPDATE: Exibe o formulário de edição
    public function edit($id) {
        $usuarioId = $_SESSION['usuario_id'];
        $tarefa = $this->tarefaModel->findByIdAndUser($id, $usuarioId);

        if (!$tarefa) {
            $_SESSION['message'] = 'Tarefa não encontrada ou você não tem permissão para editá-la.';
            $_SESSION['message_type'] = 'danger';
            $this->redirect('/tarefas/index');
        }

        $this->view('tarefas/form', ['titulo' => 'Editar Tarefa', 'tarefa' => $tarefa]);
    }

    // DELETE: Deleta uma tarefa
    public function delete($id) {
        $usuarioId = $_SESSION['usuario_id'];
        
        // Verifica se a tarefa existe e pertence ao usuário antes de deletar
        if (!$this->tarefaModel->findByIdAndUser($id, $usuarioId)) {
            $_SESSION['message'] = 'Tarefa não encontrada ou você não tem permissão para deletá-la.';
            $_SESSION['message_type'] = 'danger';
            $this->redirect('/tarefas/index');
        }

        $success = $this->tarefaModel->deleteTarefa($id, $usuarioId);
        
        $_SESSION['message'] = $success ? 'Tarefa deletada com sucesso!' : 'Erro ao deletar a tarefa.';
        $_SESSION['message_type'] = $success ? 'success' : 'danger';
        
        $this->redirect('/tarefas/index');
    }
}
