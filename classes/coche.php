<?php

class Coche extends DB{

    public static function getCoches(){

        // Disponibles
        $query = "SELECT * FROM coche WHERE activo = 0";

        $output[] = [
            "seccion"=>"disponibles",
            "coches"=>DB::query($query)
        ];

        // Ocupados/Eliminados
        $query = "SELECT * FROM coche WHERE activo = 1";

        $output[] = [
            "seccion"=>"ocupados",
            "coches"=>DB::query($query)
        ];

        return $output;
    }

    public static function getCochesUsuario($data){

        // Disponibles
        $query = "SELECT * FROM coche WHERE activo = 0 AND usuario_id = '$data->usuario_id'";

        $output[] = [
            "seccion"=>"Disponibles",
            "coches"=>DB::query($query)
        ];

        // Ocupados/Eliminados
        $query = "SELECT * FROM coche WHERE activo = 1 AND usuario_id = '$data->usuario_id'";

        $output[] = [
            "seccion"=>"Ocupados",
            "coches"=>DB::query($query)
        ];

        return $output;
    }


}

?>