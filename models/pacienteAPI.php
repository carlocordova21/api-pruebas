<?php
require_once "conexion.php";
require_once "pacienteAPI.php";
require_once "responseAPI.php";

class PacienteAPI extends Conexion
{
   private $table = "pacientes";
   private $pacienteId;
   private $dni;
   private $nombre;
   private $direccion;
   private $codigoPostal;
   private $genero;
   private $telefono;
   private $fechaNacimiento = "0000-00-00";
   private $correo;
   private $token;

   public function getAllPacients($page)
   {
      $start = 0;
      $cantidad = 50;

      if ($page > 1) {
         $start = ($cantidad * ($page - 1)) + 1;
         $cantidad = $cantidad * $page;
      }

      $query = $this->connect()->prepare("SELECT * FROM $this->table LIMIT :start , :cantidad");
      $query->execute([
         "start" => $start,
         "cantidad" => $cantidad
      ]);

      return $query->rowCount() ? $query->fetchAll(PDO::FETCH_ASSOC) : "No hay pacientes";
   }

   public function getPacient($id)
   {
      $query = $this->connect()->prepare("SELECT * FROM $this->table WHERE pacienteId = :id");
      $query->execute(["id" => $id]);
      return $query->rowCount() ? $query->fetch(PDO::FETCH_OBJ) : "No existe paciente";
   }

   public function postPacient($json)
   {
      $response = new ResponseAPI();
      $data = json_decode($json, true);

      //Verificar si se envia el token como parametro
      if (!isset($data["token"])) {
         return $response->error401();
      } else {
         $this->token = $data["token"];
         $arrayToken = $this->searchToken();
         //Validamos que el token ingresado
         if (!$arrayToken) {
            return $response->error401("El token que envio es invalido o ha caducado");
         }

         if (!isset($data["dni"]) || !isset($data["nombre"]) || !isset($data["correo"])) {
            return $response->error400();
         } else {
            $this->dni = $data["dni"];
            $this->nombre = $data["nombre"];
            $this->correo = $data["correo"];

            if (isset($data["telefono"])) {
               $this->telefono = $data["telefono"];
            }
            if (isset($data["direccion"])) {
               $this->direccion = $data["direccion"];
            }
            if (isset($data["codigoPostal"])) {
               $this->codigoPostal = $data["codigoPostal"];
            }
            if (isset($data["genero"])) {
               $this->genero = $data["genero"];
            }
            if (isset($data["telefono"])) {
               $this->telefono = $data["telefono"];
            }
            if (isset($data["fechaNacimiento"])) {
               $this->fechaNacimiento = $data["fechaNacimiento"];
            }

            $verificarPaciente = $this->insertPacient();
            if ($verificarPaciente) {
               $result = $response->response;
               $result["result"] = array(
                  "pacienteId" => $this->pacienteId,
               );
               return $result;
            }
            return $response->error500();
         }
      }
   }

   private function insertPacient()
   {
      $pdo = $this->connect();
      $query = $pdo->prepare("INSERT INTO $this->table (DNI, Nombre, Direccion, CodigoPostal, Telefono, Genero, FechaNacimiento, Correo) VALUES(:dni,:nombre, :direccion, :codPostal, :tlf, :genero, :fchNac, :correo)");
      $query->execute([
         "dni" => $this->dni,
         "nombre" => $this->nombre,
         "direccion" => $this->direccion,
         "codPostal" => $this->codigoPostal,
         "tlf" => $this->telefono,
         "genero" => $this->genero,
         "fchNac" => $this->fechaNacimiento,
         "correo" => $this->correo
      ]);

      $this->pacienteId = $pdo->lastInsertId();

      return $query->rowCount() ? $this->pacienteId : false;
   }

   private function searchToken()
   {
      $query = $this->connect()->prepare("SELECT TokenId, UsuarioId, Estado FROM usuarios_token WHERE token = :token AND estado = 'Activo'");
      $query->execute(["token" => $this->token]);

      return $query->rowCount() ? $query->fetch(PDO::FETCH_OBJ) : false;
   }

   private function updateToken($tokenId)
   {
      $date = date("Y-m-d H:i:s");
      $query = $this->connect()->prepare("UPDATE usuarios_token SET fecha = :date WHERE tokenId = :tokenId");
      $query->execute([
         "fecha" => $date,
         "tokenId" => $tokenId
      ]);

      return $query->rowCount() ? true : false;
   }
}
