<?php

function Debug($obj){
    $isDebugEnabled = true;
    if ($isDebugEnabled){
        echo "<pre>";
        var_dump($obj);
        echo "</pre>";
        die();
    }
}


function ApiDebug($obj){
    $isDebugEnabled = true;
    if ($isDebugEnabled){
        header("Content-Type: application/json");
        header("HTTP/1.1 418 I'm a teapot");
        echo json_encode($obj);
        die();
    }
}