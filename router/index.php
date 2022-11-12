<?php
require_once("../utils/Debug.php");
require_once("./Route.php");
require_once("./Router.php");
require_once("../controller/index.php");

$r = new Router();



// run
$r->route($_GET['action'], $_SERVER['REQUEST_METHOD']);