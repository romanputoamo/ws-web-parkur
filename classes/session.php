<?php

include_once('../config/auth.php');

class Sesion extends DB{

    public static function login($data){
        #BUSCAMOS EL USUARIO

        $query = "SELECT *
        FROM usuario
        INNER JOIN perfil ON usuario.id = perfil.usuario_id
        WHERE perfil.superadmin = 1 AND perfil.correo = '$data->correo'";

        $usuario = DB::query($query);

        #VALIDAMOS QUE EL ARRAY NO ESTE VACIO
        if(!empty($usuario[0])){
            #SI EL USUARIO EXISTE, COMPARAMOS SU PASSWORD

            #VALIDAMOS EL PASSWORD
            if(password_verify($data->contrasena,$usuario[0]->contrasena)){
    
                $response['error']= false;
                $response['token']= Auth::SignIn($usuario[0]);
            }else{
                #SI LA CONTRASENA NO ES VALIRA, RESPONDEMOS ERROR
                $response['error']= true;
                $response['message']= "La contraseña es incorrecta";

            }
            
        }else{
            #SI EL USUARIO NO EXISTE, RESPONDEMOS ERROR
            $response['error']= true;
            $response['message']= "El usuario no existe";
        }

        return $response;

    }

    public static function verify($data){

        try{
            Auth::Check($data->token);
            $response['error']=false;
            $response['usuario']=Auth::GetData($data->token);
    
        }catch(Exception $e){

            http_response_code(401);
    
            $response['error']=true;
            $response['message']="El token ha expirado";
        }
    
        return $response;

    }

}

?>