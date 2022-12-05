<?php

include_once('../config/db.php');
include_once('../classes/inicio.php');

$opcion = $_GET['opcion'];

$body = json_decode(file_get_contents("php://input"));

switch ($opcion) {
    case 'getInventario':
        echo json_encode(Inicio::getInventario());
        break;

    case 'getRentas':
        echo json_encode(Inicio::getRentas());
        break;

    case 'getRenta':
        echo json_encode(Inicio::getRenta($body));
        break;

}
?>