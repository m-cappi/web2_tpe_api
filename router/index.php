<?php
require_once("../utils/Debug.php");
require_once("./Route.php");
require_once("./Router.php");
require_once("../view/ApiView.php");
require_once("../controller/index.php");

$r = new Router();

$r->addRoute("reviews", "GET", "ReviewsApiController", "listAll");
$r->addRoute("reviews/:bookId", "GET", "ReviewsApiController", "listByBookId");

$r->addRoute("review/:id", "GET", "ReviewsApiController", "getById");
$r->addRoute("review", "POST", "ReviewsApiController", "addOne");
$r->addRoute("review/:id", "DELETE", "ReviewsApiController", "deleteOne");

// run
$r->route($_GET['action'], $_SERVER['REQUEST_METHOD']);