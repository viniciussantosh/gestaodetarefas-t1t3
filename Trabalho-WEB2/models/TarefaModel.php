<?php
// models/TarefaModel.php

require_once CORE_PATH . 'Model.php';

class TarefaModel extends Model {
    protected $table = 'tarefas';

    public function __construct() {
        parent::__construct();
    }

    public function findByUsuario($usuarioId) {
        $sql = "SELECT * FROM {$this->table} WHERE usuario_id = :usuario_id ORDER BY data_vencimento ASC, prioridade DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':usuario_id' => $usuarioId]);
        return $stmt->fetchAll();
    }

    
    public function createTarefa($usuarioId, $data) {
        $sql = "INSERT INTO {$this->table} (usuario_id, titulo, descricao, data_vencimento, prioridade, status) 
                VALUES (:usuario_id, :titulo, :descricao, :data_vencimento, :prioridade, :status)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':usuario_id' => $usuarioId,
            ':titulo' => $data['titulo'],
            ':descricao' => $data['descricao'],
            ':data_vencimento' => $data['data_vencimento'] ?: null, // Permite NULL
            ':prioridade' => $data['prioridade'],
            ':status' => $data['status']
        ]);
    }

   
    public function updateTarefa($id, $usuarioId, $data) {
        $sql = "UPDATE {$this->table} SET 
                titulo = :titulo, 
                descricao = :descricao, 
                data_vencimento = :data_vencimento, 
                prioridade = :prioridade, 
                status = :status 
                WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':usuario_id' => $usuarioId,
            ':titulo' => $data['titulo'],
            ':descricao' => $data['descricao'],
            ':data_vencimento' => $data['data_vencimento'] ?: null,
            ':prioridade' => $data['prioridade'],
            ':status' => $data['status']
        ]);
    }

  
    public function deleteTarefa($id, $usuarioId) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':usuario_id' => $usuarioId
        ]);
    }
    
    public function findByIdAndUser($id, $usuarioId) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id, ':usuario_id' => $usuarioId]);
        return $stmt->fetch();
    }
}
