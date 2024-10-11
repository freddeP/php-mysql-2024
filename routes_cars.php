<?php


App::get("/cars", function(){

    $cars = Db::index();
 
    $html = array_map(function($c){
 
       return "<div>".
       "<h2>".$c['brand']."</h2>".
       "<h4>".$c['model']."</h4>".
       "<img src = '".$c['img']."'  alt = 'bild'>";
 
 
    }, $cars);
  
 
    htmlResponse(implode("<hr>", $html));
 
 
 });
 
 App::get("/cars/create", function(){
 
    $form = file_get_contents("html/create.html");
    htmlResponse($form);
 
 });
 
 App::post("/cars/save", function(){
 
    debug($_POST);
    $car = $_POST;
 
    if(!empty($_POST['brand']) && !empty($_POST['model']))
    {
       Db::create($car);
       header("Location:../cars");
    }
 
 
 });
 
 App::get('/cars/search', function(){
 
    $s = $_GET['s'];
    jsonResponse(Db::search($s));
 
 
 });
 
 
 
 
 