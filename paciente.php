<?php 
require_once "models/responseAPI.php";
require_once "models/pacienteAPI.php";

$response = new ResponseAPI();
$paciente = new PacienteAPI();

if($_SERVER["REQUEST_METHOD"] == "GET") {
   //Si solicitamos page (50 registros por pagina)
   if(isset($_GET["page"])) {
      $page = $_GET["page"];
      $pacientes = $paciente->getAllPacients($page);
      header("Content-Type: application/json");
      echo json_encode($pacientes);
      http_response_code(200);

   //Si solicitamos id de paciente
   } else if(isset($_GET["id"])) {
      $id = $_GET["id"];
      $pacienteBuscado = $paciente->getPacient($id);
      header("Content-Type: application/json");
      echo json_encode($pacienteBuscado); 
      http_response_code(200);
   }
   
} else if($_SERVER["REQUEST_METHOD"] == "POST") {
   //Recibimos lo datos enviados
   $body = file_get_contents("php://input");
   //Enviamos los datos al manejador
   $dataResponse = $paciente->postPacient($body);
   //Devolvemos respuesta
   header("Content-Type: application/json");
   if(isset($dataResponse["result"]["error_id"])) {
      $resposeCode = $dataResponse["result"]["error_id"];
      http_response_code($resposeCode);
   } else {
      http_response_code(200);
   }
   echo json_encode($dataResponse);

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