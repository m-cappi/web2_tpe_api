<?php
require_once("../view/ApiView.php");

abstract Class ApiController{
    protected $model;
    protected $view;

    protected $data;

    public function __construct()
    {
        // toda Api usa potencialmente el mismo view
        $this->view = new ApiView();
        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

    protected function getData() {
        // devuelve el request body como objeto
        return json_decode($this->data);
    }

    public function validateToken(){
        // OPC: TOKEN REQ


    }
}