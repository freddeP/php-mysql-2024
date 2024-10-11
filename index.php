<?php
session_start();
require_once("router_.php");
require_once("helper.php");
require_once("sql.php");
require_once("routes_cars.php");
require_once("fake_login.php");


App::get("/upload", function(){

   $form = file_get_contents("html/fileUpload.html");
   htmlResponse($form);

});

App::post("/upload", function(){

   debug($_POST);
   debug($_FILES);

   $name = "file_".uniqid();
   
   $ext = explode(".",$_FILES['img']['name']);
   $length = count($ext) - 1;
   $ext = $ext[$length];
 

   $name = $name . "." . $ext;

   echo $name;


});