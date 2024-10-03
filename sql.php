<?php


class Db{


    private static function connect(){

        $servername = "localhost";
        $username = "pefr";
        $password = "1234";
        $db = "php1";

        // Create connection
        $con = new mysqli($servername, $username, $password, $db);

        // Check connection
        if ($con->connect_error) {
            return  $con->connect_error;
        }
        return $con;
    }


    public static function index(){

        $con = self::connect();

        $query = "SELECT * FROM cars";
        $result = $con->query($query);
        $data = [];

        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }

        return $data;
    }




}