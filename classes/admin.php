<?php

include_once('../config/db.php');


class Admin extends DB{

    public static function addUsuario($data){

        #VERIFICAR SI EXISTE EL USUARIO O NO
        $query = "SELECT COUNT(id) existe FROM perfil WHERE superadmin = 1 AND correo = '$data->correo'";

        $busqueda = DB::query($query);

        #EN CASO DE QUE NO EXISTA SE CREA
        if($busqueda[0]->existe == 0){

            #CREAMOS EL ID DEL USUARIO Y PERFIL
            $usuario_id = DB::idGenerator();
            $perfil_id = DB::idGenerator();

            #CREAMOS CONTRASEÑA
            $data->contrasena = password_hash($data->contrasena,PASSWORD_DEFAULT);
            $data->id=$usuario_id;

            #ARRAY DE INSERCION
            $usuario['id']=$usuario_id;
            $usuario['foto']="";
            $usuario['nombres']=$data->nombres;
            $usuario['apellidos']=$data->apellidos;
            $usuario['genero_id']=$data->genero_id;
            $usuario['fecha_nac']=$data->fecha_nac;
            $usuario['numero_telefono']=$data->numero_telefono;

            #query INSERT USUARIO

            $registroUsuario = DB::insert($usuario,'usuario');

            if($registroUsuario['error']==false){

                $perfil['id']=$perfil_id;
                $perfil['usuario_id']=$usuario_id;
                $perfil['superadmin']=1;
                $perfil['correo']=$data->correo;
                $perfil['contrasena']=$data->contrasena;

                $registroPerfil = DB::insert($perfil,'perfil');

                if($registroPerfil['error']==false){

                    return [
                        "error"=>false,
                        "message"=>"El usuario se regristó con éxito",
                        "id"=>$usuario_id
                    ];

                }
            }
        #EN CASO DE QUE IS EXISTA SE DEVUELVE EL MENSAJE DE ERROR
        }else{
            
            return [
                "error"=>true,
                "message"=>"El usuario ya existe"
            ];
        }
    }

    public static function updateUsuario($data){
        #BUSCAR EL USUARIO
        $query = "SELECT COUNT(id) existe FROM perfil WHERE superadmin = 1 AND usuario_id = '$data->usuario_id'";
        $busqueda = DB::query($query);

        if(!$busqueda[0]->existe == 0){

            #CREAMOS EN ARRAY DE UPDATE
            $usuario['foto']="";
            $usuario['nombres']=$data->nombres;
            $usuario['apellidos']=$data->apellidos;
            $usuario['genero_id']=$data->genero_id;
            $usuario['fecha_nac']=$data->fecha_nac;
            $usuario['numero_telefono']=$data->numero_telefono;

            $updateUsuario = DB::update($usuario,'usuario',"id = '$data->usuario_id'");

            #SI LA ACTUALIZACION FUE EXITOSA
            if($updateUsuario['error']==false){

                #CREAMOS ARRAY UPDATDE DE PERFIL
                $perfil['correo']=$data->correo;
                $perfil['contrasena']=password_hash($data->contrasena,PASSWORD_DEFAULT);

                $updatePerfil = DB::update($perfil,'perfil',"usuario_id = '$data->usuario_id'");

                if($updatePerfil['error']== false){
                    $output['error'] = false;
                    $output['message'] = "El usuario se actualizó con éxito";
                }
            }
        }else{
            $output['error'] = true;
            $output['message'] = "El usuario no existe";
        }

    
        return $output;


    }

    public static function deleteUsuario($data){
        #BUSCAR EL USUARIO
        $query = "SELECT COUNT(id) existe FROM perfil WHERE superadmin = 1 AND usuario_id = '$data->usuario_id'";
        $busqueda = DB::query($query);

        if(!$busqueda[0]->existe == 0){

            #CREAMOS EN ARRAY DE UPDATE
            $usuario['activo']=0;
            $usuario['eliminado']=1;

            $updateUsuario = DB::update($usuario,'usuario',"id = '$data->usuario_id'");

            #SI LA ACTUALIZACION FUE EXITOSA
            if($updateUsuario['error']==false){

                #CREAMOS ARRAY UPDATDE DE PERFIL
                $perfil['activo']=0;
                $perfil['eliminado']=1;

                $updatePerfil = DB::update($perfil,'perfil',"usuario_id = '$data->usuario_id'");

                if($updatePerfil['error']== false){
                    $output['error'] = false;
                    $output['message'] = "El usuario se eliminó con éxito";
                }
            }
        }else{
            $output['error'] = true;
            $output['message'] = "El usuario no existe";
        }
    
        return $output;


    }

    public static function getUsuarios(){

        #SE EXTRAEN TODOS LOS USUARIOS TIPO ADMIN
        $query = "SELECT *
        FROM usuario
        INNER JOIN perfil ON usuario.id = perfil.usuario_id
        WHERE perfil.superadmin = 1";

        $data[] = [
            "tipo"=>"Todos",
            "usuarios"=>DB::query($query)
        ];

        #SE EXTRAEN TODOS LOS USUARIOS TIPO ADMIN ACTIVOS
        $query = "SELECT *
        FROM usuario
        INNER JOIN perfil ON usuario.id = perfil.usuario_id
        WHERE perfil.superadmin = 1 AND perfil.eliminado = 0";

        $data[] = [
            "tipo"=>"Activos",
            "usuarios"=>DB::query($query)
        ];

        #SE EXTRAEN TODOS LOS USUARIOS TIPO ADMIN INACTIVOS
        $query = "SELECT *
        FROM usuario
        INNER JOIN perfil ON usuario.id = perfil.usuario_id
        WHERE perfil.superadmin = 1 AND perfil.eliminado = 1";

        $data[] = [
            "tipo"=>"Expirados",
            "usuarios"=>DB::query($query)
        ];

        return $data;
    }

    public static function getUsuario($data){
        $query = "SELECT *
        FROM usuario
        INNER JOIN perfil ON usuario.id = perfil.usuario_id
        WHERE perfil.superadmin = 1 AND perfil.eliminado = 0 AND perfil.usuario_id = '$data->usuario_id'";

        return DB::query($query);
    }
}


?>