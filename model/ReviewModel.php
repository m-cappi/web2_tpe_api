<?php

require_once('../model/Model.php');

Class ReviewModel extends Model{
    public function __construct()
    {
        $this->db=getDataBase();
        $this->tableName='reviews';
    }
}