<?php

header("Access-Control-Allow-Headers: Authorization, Cache-Control, Content-Type, X-Requested-With");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

class DB{

    static $host ="us-cdbr-east-06.cleardb.net";
    static $dbname ="heroku_304c268196df410";
    static $username ="bfae7891696d04";
    static $password ="ee03caa4";

    public static function connect(){

        return new mysqli(
            self::$host,
            self::$username,
            self::$password, 
            self::$dbname
        );
    }

    public static function query($query){
        $results = []; 

        $db = self::connect();

        $result = $db->query($query);
        
        while($row = $result->fetch_object()){ 
            $results[] = $row;
        }
        return $results;
        
        $db->close(); 
    }
    
    public static function queryUpdate($sql){
        $results = []; 

        $db = self::connect();
        $result = $db->query($sql);
        
        if (!$result){
            $data["error"] = true;
            $data["message"] = "Ha ocurrido un error";
            $data["errno"] = self::typeError($db->errno);
            $data["query"] = $sql;
        }else{
            $data["error"] = false;
            $data["message"] = "Se actualizo el registro con exito";
        }
        
        return $data;

        $db->close(); 
    }

    public static function insert($array,$table){

        $db = self::connect();

        $sql  = "INSERT INTO {$table}";

        $sql .= "(`".implode("`, `", array_keys($array))."`)";
        $sql .= " VALUES ('".implode("', '", $array)."') ";

        $result = $db->query($sql);

        if (!$result){
            $data["error"] = true;
            $data["message"] = "Ha ocurrido un error";
            $data["errno"] = self::typeError($db->errno);
            $data["query"] = $sql;
        }else{
            $data["error"] = false;
            $data["message"] = "Se creó el registro con exito";
        }

        return $data;
    }

    public static function customInsert($query){

        $db = self::connect();
        $result = $db->query($query);

        if (!$result){
            $data["error"] = true;
            $data["message"] = "Ha ocurrido un error";
            $data["errno"] = self::typeError($db->errno);
            $data["query"] = $query;
        }else{
            $data["error"] = false;
            $data["message"] = "Se creó el registro con exito";
        }

        return $data;
    }

    public static function update($p_datos,$p_table,$p_where){
        
        $db = self::connect();

        $sql = "UPDATE $p_table SET ";
        
        foreach ($p_datos as $key => $value) {
            $valor[] = $key . "='" . $value."'";
        }
    
        $sql  .= implode(', ',$valor);
        $sql .= " WHERE $p_where";

        $result = $db->query($sql);
    
        if (!$result){
           $data["error"] = true;
           $data["message"] = "Ha ocurrido un error";
           $data["errno"] = self::typeError($db->errno);
           $data["query"] = $sql;
         }else{
            $data["error"] = false;
            $data["message"] = "Se actualizo el registro con exito";
        }

        return $data;
    }

    public static function delete($p_table,$p_query){
        $db = self:: connect();

        $sql ="DELETE FROM";
        $sql .=" $p_table WHERE";
        $sql .=" $p_query";
    
    
       $result = $db->query($sql);
    
       if (!$result){
          $data["error"] = true;
          $data["message"] = "Ha ocurrido un error";
          $data["errno"] = self::typeError($db->errno);
          $data["query"] = $sql;
        }else{
           $data["error"] = false;
           $data["message"] = "Se elimino el registro con exito";
        }
        return $data;
    }

    public static function typeError($errno){
        $_typeError = null;

        switch($errno){
          case 1062:
            $_typeError = "Registro duplicado";
            break;
      
          case 1451:
            $_typeError = "El registro no se puede eliminar por que esta siendo utilizado por otro recurso.";
            break;
      
          default: 
            $_typeError = "Error desconocido";
            break;
        }
      
        return $_typeError;
    }

    public static function idGenerator()
    {
        $characters = '0123456789QWERTYUIOPASDFGHJKLZXCVBNM';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return strval(date("YmdHis")).$randomString;
    }

}