<?php

include_once('../config/db.php');


class Genero extends DB{

    public static function getGeneros(){
        return DB::query("SELECT * FROM genero");
    }

}


?>