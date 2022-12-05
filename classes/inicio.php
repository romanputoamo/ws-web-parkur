<?php

class Inicio extends DB{

    public static function getInventario(){
        #PLANTA BAJA

        #OBTENER LUGARES
        $query = "SELECT *
            FROM estacionamiento
            INNER JOIN plantas ON plantas.id = estacionamiento.plantas_id
            WHERE plantas.id = 1
            ORDER BY estacionamiento.id ASC";

        $inventory = DB::query($query);

        #OBTENER DISPONIBILIDAD
        $query = "SELECT ROUND(((SELECT COUNT(id) FROM estacionamiento WHERE plantas_id = 1) - (SELECT COUNT(id) FROM estacionamiento WHERE plantas_id = 1 AND status = 1 ))*100/(SELECT COUNT(id) FROM estacionamiento WHERE plantas_id = 1)) ocupacion";
        $availability = DB::query($query);

        $response[] = [
            "seccion"=>"Planta Baja",
            "disponibilidad"=>$availability[0]->ocupacion,
            "lugares"=>$inventory,
        ];

        #PLANTA MEDIA

        #OBTENER LUGARES
        $query = "SELECT *
            FROM estacionamiento
            INNER JOIN plantas ON plantas.id = estacionamiento.plantas_id
            WHERE plantas.id = 2
            ORDER BY estacionamiento.id ASC";

        $inventory = DB::query($query);

        #OBTENER DISPONIBILIDAD

        $query = "SELECT ROUND(((SELECT COUNT(id) FROM estacionamiento WHERE plantas_id = 2) - (SELECT COUNT(id) FROM estacionamiento WHERE plantas_id = 2 AND status = 1 ))*100/(SELECT COUNT(id) FROM estacionamiento WHERE plantas_id = 2)) ocupacion";
        $availability = DB::query($query);


        $response[] = [
            "seccion"=>"Planta Media",
            "disponibilidad"=>$availability[0]->ocupacion,
            "lugares"=>$inventory,
        ];


        #PLANTA ALTA

        #OBTENER LUGARES
        $query = "SELECT *
            FROM estacionamiento
            INNER JOIN plantas ON plantas.id = estacionamiento.plantas_id
            WHERE plantas.id = 3
            ORDER BY estacionamiento.id ASC";

        $inventory = DB::query($query);

        #OBTENER DISPONIBILIDAD
        $query = "SELECT ROUND(((SELECT COUNT(id) FROM estacionamiento WHERE plantas_id = 3) - (SELECT COUNT(id) FROM estacionamiento WHERE plantas_id = 3 AND status = 1 ))*100/(SELECT COUNT(id) FROM estacionamiento WHERE plantas_id = 3)) ocupacion";
        $availability = DB::query($query);

        $response[] = [
            "seccion"=>"Planta Alta",
            "disponibilidad"=>$availability[0]->ocupacion,
            "lugares"=>$inventory,
        ];

        return $response;
    }

    public static function getRentas(){
        $query = "SELECT 
        rentas.id id, 
        rentas.estacionamiento_id estacionamiento_id,
        DATE(rentas.inicio) fecha, 
        estacionamiento.lugar lugar, 
        estacionamiento.status estatus, 
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
        WHERE rentas.status = 1 AND estacionamiento.status = 1";

        return DB::query($query);

    }

    public static function getRenta($data){
        
        $query = "SELECT 
        rentas.id id, 
        rentas.estacionamiento_id estacionamiento_id,
        DATE(rentas.inicio) fecha, 
        estacionamiento.lugar lugar, 
        estacionamiento.status estatus, 
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
        WHERE rentas.status = 1 AND estacionamiento.status = 1 AND estacionamiento.lugar = '$data->lugar'";

        $renta = DB::query($query);

        if(empty($renta)){
            $output['error'] = true;
            $output['renta'] = "El lugar está disponible";
        }else{
            $output['error'] = false;
            $output['renta'] = $renta[0];
        }

        return $output;
        //return $query;

    }

    



}

?>