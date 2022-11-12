<?php

function getDataBase(){
    return new PDO('mysql:host=localhost;'
    .'dbname=web2_tpe;charset=utf8'
    , 'root', '');
}


