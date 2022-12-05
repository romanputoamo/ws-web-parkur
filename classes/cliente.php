<?php

class Cliente extends DB{

    public static function getClientes(){

        // TODOS
        $query = "SELECT u.* FROM usuario u INNER JOIN perfil p ON u.id = p.usuario_id WHERE p.superadmin = '0'";

        $output[] = [
            "tipo"=>"Todos",
            "clientes"=>DB::query($query)
        ];
        return $output;

        // ACTIVOS
        $query = "SELECT *
        FROM usuario
        INNER JOIN perfil ON usuario.id = perfil.usuario_id
        WHERE perfil.superadmin = 0 AND perfil.eliminado = 0";

        $output[] = [
            "tipo"=>"Activos",
            "clientes"=>DB::query($query)
        ];

        // INACTIVOS
        $query = "SELECT *
        FROM usuario
        INNER JOIN perfil ON usuario.id = perfil.usuario_id
        WHERE perfil.superadmin = 0 AND perfil.eliminado = 1";

        $output[] = [
            "tipo"=>"Inactivos",
            "clientes"=>DB::query($query)
        ];

        return $output;
    }

    public static function getRentas(){
        
        $query = "SELECT 
            rentas.id id, 
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
            WHERE rentas.status = 1";

        return DB::query($query);

    }

    public static function perfilCliente($data){

        # OBTENEMOS EL PERFIL

        $query = "SELEC";

        # OBTENEMOS EL COCHES DEL USUARIO

        # OBTENEMOS EL RENTAS DEL USUARIO


    }
    

}

?>