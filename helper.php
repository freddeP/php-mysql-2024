<?php

function debug($arr){

    echo "<pre>";
    var_dump($arr);
    echo "</pre>";

}

function path($path){
    $base = explode("/", $_SERVER['PHP_SELF'])[1];
    return "/$base/$path";
}

function jsonResponse($data){
    header("Content-Type:application/json");
    echo json_encode($data);
}

function htmlResponse($content){

    $template = file_get_contents("html/template.html");
    $html = str_replace("{content}",$content, $template);
    echo $html;

}