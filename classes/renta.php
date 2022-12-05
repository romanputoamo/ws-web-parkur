<?php

class Renta extends DB{

    public static function getRentas(){

        #TODAS LAS RENTAS
        $query = "
        SELECT 
            DATE(rentas.inicio) inicio,
            DATE(rentas.last_update) fin,
            CONCAT(usuario.nombres,' ',usuario.apellidos) cliente,
            usuario.foto img_cliente,
            CONCAT(coche.vehiculo,' ',coche.modelo,' ',coche.color, ' ', coche.ano) auto,
            coche.foto img_coche,
            estacionamiento.lugar lugar,
            servicios.tipo servicio,
            rentas.monto monto,
            rentas.status estado
        FROM rentas
        INNER JOIN coche ON coche.id = rentas.coche_id
        INNER JOIN usuario ON coche.usuario_id = usuario.id
        INNER JOIN estacionamiento ON rentas.estacionamiento_id = estacionamiento.id
        INNER JOIN servicios ON rentas.servicios_id = servicios.id";

        $output[] = [
            "seccion"=>"todas",
            "rentas"=>DB::query($query)
        ];

        #RENTAS ACTIVAS
        $query = "
        SELECT 
            DATE(rentas.inicio) inicio,
            DATE(rentas.last_update) fin,
            CONCAT(usuario.nombres,' ',usuario.apellidos) cliente,
            usuario.foto img_cliente,
            CONCAT(coche.vehiculo,' ',coche.modelo,' ',coche.color, ' ', coche.ano) auto,
            coche.foto img_coche,
            estacionamiento.lugar lugar,
            servicios.tipo servicio,
            rentas.monto monto,
            rentas.status estado
        FROM rentas
        INNER JOIN coche ON coche.id = rentas.coche_id
        INNER JOIN usuario ON coche.usuario_id = usuario.id
        INNER JOIN estacionamiento ON rentas.estacionamiento_id = estacionamiento.id
        INNER JOIN servicios ON rentas.servicios_id = servicios.id
        WHERE rentas.status = 1";

        $output[] = [
            "seccion"=>"activas",
            "rentas"=>DB::query($query)
        ];

        #RENTAS ACTIVAS
        $query = "
        SELECT 
            DATE(rentas.inicio) inicio,
            DATE(rentas.last_update) fin,
            CONCAT(usuario.nombres,' ',usuario.apellidos) cliente,
            usuario.foto img_cliente,
            CONCAT(coche.vehiculo,' ',coche.modelo,' ',coche.color, ' ', coche.ano) auto,
            coche.foto img_coche,
            estacionamiento.lugar lugar,
            servicios.tipo servicio,
            rentas.monto monto,
            rentas.status estado
        FROM rentas
        INNER JOIN coche ON coche.id = rentas.coche_id
        INNER JOIN usuario ON coche.usuario_id = usuario.id
        INNER JOIN estacionamiento ON rentas.estacionamiento_id = estacionamiento.id
        INNER JOIN servicios ON rentas.servicios_id = servicios.id
        WHERE rentas.status = 0";

        $output[] = [
            "seccion"=>"expiradas",
            "rentas"=>DB::query($query)
        ];

        return $output;
    }

    public static function getRentasUsuario($data){

        #Rentas vigentes

        $query = "
        SELECT 
            rentas.id id, 
            usuario.id usuario_id, 
            rentas.estacionamiento_id estacionamiento_id,
            DATE(rentas.inicio) fecha, 
            estacionamiento.lugar lugar, 
            CONCAT(coche.vehiculo,' ',coche.modelo,' ',coche.ano,' ',coche.color) coche, 
            coche.foto img_coche, 
            CONCAT(usuario.nombres,' ',usuario.apellidos) cliente, 
            usuario.foto img_cliente, 
            servicios.tipo servicio, 
            rentas.monto total
        FROM rentas
        INNER JOIN coche ON coche.id = rentas.coche_id
        INNER JOIN usuario ON coche.usuario_id = usuario.id
        INNER JOIN estacionamiento ON rentas.estacionamiento_id = estacionamiento.id
        INNER JOIN servicios ON rentas.servicios_id = servicios.id
        WHERE rentas.status = 1 AND usuario.id = '$data->usuario_id'";

        $output[] = [
            "seccion"=>"vigentes",
            "rentas"=>DB::query($query)
        ];
        #Rentas expiradas

        $query = "
        SELECT 
            rentas.id id, 
            usuario.id usuario_id, 
            rentas.estacionamiento_id estacionamiento_id,
            DATE(rentas.inicio) fecha, 
            estacionamiento.lugar lugar, 
            CONCAT(coche.vehiculo,' ',coche.modelo,' ',coche.ano,' ',coche.color) coche, 
            coche.foto img_coche, 
            CONCAT(usuario.nombres,' ',usuario.apellidos) cliente, 
            usuario.foto img_cliente, 
            servicios.tipo servicio, 
            rentas.monto total
        FROM rentas
        INNER JOIN coche ON coche.id = rentas.coche_id
        INNER JOIN usuario ON coche.usuario_id = usuario.id
        INNER JOIN estacionamiento ON rentas.estacionamiento_id = estacionamiento.id
        INNER JOIN servicios ON rentas.servicios_id = servicios.id
        WHERE rentas.status = 0 AND usuario.id = '$data->usuario_id'";

        $output[] = [
            "seccion"=>"expiradas",
            "rentas"=>DB::query($query)
        ];

        return $output;

    }


}

?>