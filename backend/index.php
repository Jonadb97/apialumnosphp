<?php

// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

require 'rb.php';

R::setup( 'mysql:host=localhost;dbname=apialumnos', 'root', '' );

// Create Router instance
$router = new \Bramus\Router\Router();

$router->options('.*', function() {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: *');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-with');
    exit();
});

// Define routes
$router->get('/allalumnos', function() {
    //    echo 'Beep';
    $alumnos = R::find('alumnos');
    // echo json_encode($alumnos);
    header('Content-Type: application/json');

    print json_encode(r::exportAll($alumnos));
});

$router->post('/crearalumno', function() {
    // echo json_encode($alumnos);
    $data = json_decode(file_get_contents('php://input'), true);
    
    $alumno = R::dispense('alumnos');
    $alumno->nombres = $data['nombres'];
    $alumno->apellidos = $data['apellidos'];
    $id = R::store($alumno);
    
    print_r($data);
    
    
});

$router->delete('/{id}', function($id) {
   
    $alumno = R::trash('alumnos', $id);
    print_r($alumno);
    
});

// Run it!
$router->run();

?>