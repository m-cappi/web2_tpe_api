<?php
require_once("../controller/ApiController.php");
require_once("../model/ReviewModel.php");

Class ReviewsApiController extends ApiController{
    public function __construct()
    {
        $this->model = new ReviewModel();
    }

    public function listAll(){
        $reviews = $this->model->getAll();
        if (empty($reviews)){
            $this->view->response(null, 204);
        } else{
            $this->view->response($reviews, 200);
        }
    }

    public function listByBookId($params = null){
        $bookId = $params["bookId"];
        $reviews = null;
        $statusCode = 500;

        // OPC: COMPLEX SORTED BY
        $sortCriteria = empty($_GET["sortCriteria"]) ? "reviewId" : $_GET["sortCriteria"];
        $sortDirection = empty($_GET["sortDirection"]) ? "ASC" : $_GET["sortDirection"];
        $parsedSortCriteria = $this->model->parseCriteria($sortCriteria);

        // OPC: PAGINATION
        $amount = empty($_GET["amount"]) ? 5 : $_GET["amount"];
        $offset = empty($_GET["nPage"]) ? 0 : $_GET["nPage"] * $amount;

        // OPC: FILTER BY
        $filterCriteria = empty($_GET["filterCriteria"]) ? null : $_GET["filterCriteria"];
        $filterValue = empty($_GET["filterValue"]) ? null : $_GET["filterValue"];
        $parsedFilterCriteria = $this->model->parseCriteria($filterCriteria);

        if (!$parsedSortCriteria || ($filterCriteria && !$parsedFilterCriteria)){
            $statusCode = 400;
            $this->view->response($reviews, $statusCode);
            return;
        }

        if ($parsedFilterCriteria && $filterValue){
            $reviews = $this->model->listByBookIdSortedByFilteredBy($bookId, $parsedSortCriteria, $sortDirection, $amount, $offset, $parsedFilterCriteria, $filterValue);
        } else{
            $reviews = $this->model->listByBookIdSortedBy($bookId, $parsedSortCriteria, $sortDirection, $amount, $offset);
        }

        if(empty($reviews)){
            $statusCode = 204;
        }else{
            $statusCode = 200;
        }

        $this->view->response($reviews, $statusCode);
        return;
    }

    public function getById($params = null){
        $reviewId = $params["id"];
        $statusCode = 500;

        $review = $this->model->getById($reviewId);

        if(empty($res)){
            $statusCode = 404;
        }else{
            $statusCode = 200;
        }

        $this->view->response($review, $statusCode);
    }

    public function addOne(){
        $data = $this->getData();
        // OPC: TOKEN REQ
        $this->validateToken();
    }

    public function updateOne(){
        $data = $this->getData();
        // OPC: TOKEN REQ
        $this->validateToken();
        
    }

    public function deleteOne(){
        // OPC: TOKEN REQ
        $this->validateToken();
    }
}
