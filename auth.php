<?php 
require_once "models/authAPI.php";
require_once "models/responseAPI.php";

$auth = new AuthAPI(); 
$response = new ResponseAPI();

if($_SERVER["REQUEST_METHOD"] == "POST") {
   //Recibir datos
   $body = file_get_contents("php://input");
   //Envimos los datos al manejador
   $dataResponse = $auth->login($body);
   //Devolvemos una respuesta
   header("Content-Type: application/json");
   if(isset($dataResponse["result"]["error_id"])) {
      $responseCode = $dataResponse["result"]["error_id"];
      http_response_code($responseCode);
   } else {
      http_response_code(200);
   }
   print_r(json_encode($dataResponse));
} else {
   header("Content-Type: application/json");
   $dataResponse = $response->error405();
   echo json_encode($dataResponse);
}

?>