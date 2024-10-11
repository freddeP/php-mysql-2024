<?php

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
 
 
 
 /* Exemplekod för passwordless inloggning */
 App::get("/login", function ( ){
 
    $form = file_get_contents("html/login.html");
    htmlResponse($form);
 
 });
 
 App::post("/login", function ( ){
 
    // Simulera att kod skickas till en mail...
    $code = createCode();
    file_put_contents("code.txt", $code);
 
    $_SESSION['code'] = password_hash($code, PASSWORD_DEFAULT);
    $_SESSION['time'] = time();
    $_SESSION['email'] = $_POST['email'];
 
    header("Location:./verify");
 
 });
 
 App::get("/verify", function(){
 
    $form = file_get_contents("html/verify.html");
    htmlResponse($form);
 
 });
 
 App::post("/verify", function(){
 
    $time = time();
    if($time-$_SESSION['time']>120){
       htmlResponse("code expired");
       return;
    }
    $code = $_POST['code'];
 
   $check = password_verify($code, $_SESSION['code']);
 
   if(!$check){
    session_destroy();
    htmlResponse("Wrong code <a href = './login'>Try again</a>");
    return;
   }
 
   $_SESSION["loggedIn"]= true;
   unset($_SESSION['code']);
   unset($_SESSION['time']);
   header("Location: ./session");
 
 
 });
 
 
 function createCode(){
 
    $chars = [0,1,2,3,4,5,6,7,8,9,"A","B", "C", "D", "E", "F"];
    shuffle($chars);
 
    $code = "";
    for($i = 0; $i<8; $i++){
       $code = $code . $chars[$i];
    }
 
    return $code;
 
 
 }