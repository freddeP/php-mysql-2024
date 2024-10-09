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
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        //$result = $con->query($query);
        $data = [];

        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }

        $con->close();
        return $data;
    }

    public static function create($car){

        $query = "INSERT INTO cars (brand, model, img) VALUES (? ,? ,?)";
        $con = self::connect();

        $stmt = $con->prepare($query);
        $stmt->bind_param("sss",$car['brand'], $car['model'], $car['img']);
        $stmt->execute();

        $stmt->close();
        $con->close();
        return true;

    }


    public static function search($s){

        
        $con = self::connect();
        
        $arr = explode("%20", $s);
        //debug($arr);

        if(count($arr)>0){
            $search = [];
            foreach($arr as $x){
                $search[]= '%'.$x.'%';
            }
        }
 
        debug($search);
        $query = "SELECT * FROM cars WHERE brand LIKE ?";

        $stmt = $con->prepare($query);
        $data = [];
        foreach($search as $val){
            $stmt->bind_param("s",$val);
            $stmt->execute();
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            $result->free();
        }
   
        $con->close();
        
        return $data;
   

    }




}