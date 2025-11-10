<?php
// models/RelatorioModel.php

require_once CORE_PATH . 'Model.php';

class RelatorioModel extends Model {
    protected $table = 'tarefas';

    public function __construct() {
        parent::__construct();
    }

    public function getResumoPorStatus($usuarioId) {
        $sql = "SELECT status, COUNT(*) as total 
                FROM {$this->table} 
                WHERE usuario_id = :usuario_id 
                GROUP BY status";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':usuario_id' => $usuarioId]);
        return $stmt->fetchAll();
    }


    public function getTarefasParaRelatorio($usuarioId) {
        $sql = "SELECT titulo, descricao, data_vencimento, prioridade, status, data_criacao
                FROM {$this->table} 
                WHERE usuario_id = :usuario_id 
                ORDER BY data_vencimento ASC, prioridade DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':usuario_id' => $usuarioId]);
        return $stmt->fetchAll();
    }
}
