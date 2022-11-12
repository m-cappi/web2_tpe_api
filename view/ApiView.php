<?php

Class ApiView{
    public function response($data, $statusCode){
        header("Content-Type: application/json");
        header("HTTP/1.1 "+$statusCode+" " + $this->getStatusDescription($statusCode));
        echo json_encode($data);
    }

    public function getStatusDescription($statusCode){
        $possibleStatus = array(
            200 => "OK",
            201=>"Created",
            204 => "No content",
            400 => "Bad request",
            404 => "Not found",
            418=>"I'm a teapot",
            500 => "Internal Server Error",
        );
        $res = '';
        if(isset($possibleStatus[$statusCode])){
            $res = $possibleStatus[$statusCode];
        }
        else{
            $res = $possibleStatus[500];
        }
        return $res;
    }
}