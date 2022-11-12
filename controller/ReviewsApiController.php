<?php
require_once("../controller/ApiController.php");
require_once("../model/ReviewModel.php");

Class ReviewsApiController extends ApiController{
    public function __construct()
    {
        $this->model = new ReviewModel();
    }
}
