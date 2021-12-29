<?php 
require_once "models/responseAPI.php";
require_once "models/pacienteAPI.php";

$response = new ResponseAPI();
$paciente = new PacienteAPI();

if($_SERVER["REQUEST_METHOD"] == "GET") {
   echo "HOLA GET";
} else if($_SERVER["REQUEST_METHOD"] == "POST") {
   echo "HOLA POST";
} else if($_SERVER["REQUEST_METHOD"] == "PUT") {
   echo "HOLA PUT";
} else if($_SERVER["REQUEST_METHOD"] == "DELETE") {
   echo "HOLA DELETE";
} else {
   header("Content-Type: application/json");
   $dataResponse = $response->error405();
   echo json_encode($dataResponse);
}
?>