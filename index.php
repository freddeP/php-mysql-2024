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

App::get("/upload/multi", function(){

   $form = file_get_contents("html/multiUpload.html");
   htmlResponse($form);

});

App::POST("/upload/multi", function(){

/*    debug($_POST);
   debug($_FILES); */

   foreach($_FILES['img']['tmp_name'] as $key=>$val){

      echo $key;
      debug($_FILES['img']['tmp_name'][$key]);
      debug($_FILES['img']['name'][$key]);

      $tmp_name = $_FILES['img']['tmp_name'][$key];
      $name = "multi/".$_FILES['img']['name'][$key];

      move_uploaded_file($tmp_name, $name);



   }


});

App::post("/upload", function(){

   $name = "file_".uniqid(true);
   
   $ext = Upload::getExt($_FILES['img']['name']);
 
   if(!Upload::checkExt($ext)){
      echo "wrong extention";
      return;
   }

   if(!Upload::checkSize($_FILES['img'])){
      echo "Too large file max size 3Mb";
      return;
   }
   $name = $name . "." . $ext;
   move_uploaded_file($_FILES['img']['tmp_name'], "uploads/$name");


   echo "File uploaded";
   debug($_POST);

});


class Upload{


   public static function getExt($fileName){

      $ext = explode(".",$fileName);
      $length = count($ext) - 1;
      return $ext[$length];

   }
   public static function checkExt($ext){

      $extentions = [
         "jpg"=>true,
         "JPG"=>true,
         "png"=>true,
         "PNG"=>true,
         "gif"=>true
      ];

      if(empty($extentions[$ext])) return false;

      return true;

   }

   public static function checkSize($file){

      if($file['size']>3000000) return false;

      return true;

   }


}
