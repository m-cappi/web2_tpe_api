<?php
require_once('../model/db.php');

abstract Class Model{
    protected $db; // new PDO();
    protected $tableName;

    public function __construct()
    {
        $this->db = getDataBase();
    }

    public function getById($id){
        $query = $this->db->prepare("SELECT * FROM `{$this->tableName}` WHERE `id` = ?");
        $query->execute(array($id));
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getAll(){
        $query = $this->db->prepare("SELECT * FROM `{$this->tableName}`");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function deleteById($id){
        $query = $this->db->prepare("DELETE FROM `{$this->tableName}` WHERE `id` = ?");
        $query->execute(array($id));
    }
}
