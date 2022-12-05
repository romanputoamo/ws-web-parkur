<?php

include_once('../config/db.php');
include_once('../classes/session.php');

$opcion = $_GET['opcion'];
$body = json_decode(file_get_contents("php://input"));

switch ($opcion) {

    case 'login':
        echo json_encode(Sesion::login($body));
        break;

    case 'verify':
        echo json_encode(Sesion::verify($body));
        break;
}
?>