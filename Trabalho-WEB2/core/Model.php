<?php
// core/Model.php

require_once CORE_PATH . 'Database.php';

class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Método genérico para buscar todos os registros
    public function findAll() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    // Método genérico para buscar um registro por ID
    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    // Método genérico para buscar registros com condição
    public function findByCondition($condition, $params = []) {
        $sql = "SELECT * FROM {$this->table} WHERE {$condition}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
