<?php
// models/UsuarioModel.php

require_once CORE_PATH . 'Model.php';

class UsuarioModel extends Model {
    protected $table = 'usuarios';

    public function __construct() {
        parent::__construct();
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function create($nome, $email, $senhaHash) {
        $sql = "INSERT INTO {$this->table} (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => $senhaHash
        ]);
    }
}
