<?php
require_once("../controller/ApiController.php");
require_once("../model/ReviewModel.php");
require_once("../utils/Debug.php");

Class ReviewsApiController extends ApiController{
    public function __construct()
    {
        parent::__construct();
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
        $sortDirection = empty($_GET["isOrderReversed"]) ? "ASC" : "DESC";
        $parsedSortCriteria = $this->model->parseCriteria($sortCriteria);

        // OPC: PAGINATION
        $amount = empty($_GET["amount"]) ? 100 : $_GET["amount"];
        $offset = empty($_GET["nPage"]) ? 0 : $_GET["nPage"] * $amount;

        // OPC: FILTER BY
        $filterCriteria = empty($_GET["filterCriteria"]) ? null : $_GET["filterCriteria"];
        $filterValue = empty($_GET["filterValue"]) ? null : $_GET["filterValue"];
        $parsedFilterCriteria = $this->model->parseCriteria($filterCriteria);

        if (!$parsedSortCriteria || 
        ($filterCriteria && !$parsedFilterCriteria) || 
        ($parsedFilterCriteria && !$filterValue)){
            $statusCode = 400;
            $this->view->response("Bad query", $statusCode);
            return;
        }

        if ($parsedFilterCriteria && $filterValue){
            $reviews = $this->model->listByBookIdSortedByFilteredBy($bookId, $parsedSortCriteria, $sortDirection, $amount, $offset, $parsedFilterCriteria, $filterValue);
        } else {
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
        // el id es obligatorio para poder entrar en esta ruta, no hace falta verificar q exista
        $reviewId = $params["id"];
        $statusCode = 500;

        $res = $this->model->getById($reviewId);

        if(empty($res)){
            $statusCode = 404;
            $res = "There's no review with id=$reviewId";
        }else{
            $statusCode = 200;
        }

        $this->view->response($res, $statusCode);
    }

    public function addOne(){
        $review = $this->getData();
        $statusCode = 500;

        // OPC: TOKEN REQ
        $this->validateToken();

        if (empty($review->comment) || empty($review->rating) || empty($review->bookId)){
            $statusCode = 400;
            $res = "Missing data";
        } else {
            $userId = empty($review->userId) ? null : $review->userId;
            $rating = $review->rating >= 5 ? 5 : ($review->rating <= 1 ? 1 : $review->rating);

            $id = $this->model->addOne($review->comment, $rating, $review->bookId, $userId);
            $res = $this->model->getById($id);
            if(!empty($res)){
                $statusCode = 201;
            }
        }

        $this->view->response($res, $statusCode);
    }

    public function deleteOne($params = null){
        $reviewId = $params["id"];
        $statusCode = 500;
        $res = null;

        // OPC: TOKEN REQ
        $this->validateToken();

        $review = $this->model->getById($reviewId);
    
        if (empty($review)){
            $res = "There's no review with id=$reviewId";
            $statusCode = 404;
        } else {
            $this->model->deleteById($reviewId);
            $res="DELETED";
            $statusCode = 200;
        }

        $this->view->response($res, $statusCode);
    }
}
