<?php

require_once("router_.php");
require_once("helper.php");
require_once("sql.php");

App::get("/cars", function(){


   debug( Db::index() );

});