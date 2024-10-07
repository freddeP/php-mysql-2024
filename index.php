<?php
session_start();
require_once("router_.php");
require_once("helper.php");
require_once("sql.php");

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

// Fake login to learn about sessions and client handling
App::get('/login/$name', function($name){


   $_SESSION["loggedIn"] = true;
   $_SESSION['user']= $name;

   jsonResponse(["user"=>$name, "loggedIn"=>true]);



});
App::get('/session', function(){

   debug($_SESSION);

});

App::get('/client', function(){

   include("client.html");

});

App::get('/admin', function(){

   if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']){

      jsonResponse(["secret"=>"Company Password = 12345"]);
      return;
   }
   jsonResponse(["error"=>"Forbidden data"]);

});

App::get('/logout', function(){

   session_destroy();
   jsonResponse(["loggedOut"=>true]);

});



