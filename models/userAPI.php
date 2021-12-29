<?php
require_once "conexion.php";

class UserAPI extends Conexion{
   private $usuarioId;
   private $username;
   private $password;
   private $estado;

   public function getUsuarioId() {
      return $this->usuarioId;
   }

   public function getUser() {
      return $this->username;
   }

   public function getPassword() {
      return $this->password;
   }

   public function getEstado() {
      return $this->estado;
   }

   public function setUser($user) {
      $query = $this->connect()->prepare("SELECT * FROM usuarios WHERE usuario = :user");
      $query->execute([
         "user" => $user
      ]);

      foreach($query as $row) {
         $this->usuarioId = $row['UsuarioId'];
         $this->username = $row["Usuario"];
         $this->password = $row["Password"];
         $this->estado = $row["Estado"];
      }
   }
   
   protected function userExists($user) {
      $query = $this->connect()->prepare("SELECT * FROM usuarios WHERE usuario = :user");
      $query->execute([
         "user" => $user
      ]);

      return $query->rowCount() ? true : false;
   }

   protected function encript($password) {
      return md5($password);
   }

   protected function insertToken($userId) {
      $val = true;
      $token = bin2hex(openssl_random_pseudo_bytes(16, $val));
      $date = date("Y-m-d H:i:s");
      $estado = "Activo";

      $query = $this->connect()->prepare("INSERT INTO usuarios_token(UsuarioId, Token, Estado, Fecha) VALUES(:userId, :token, :estado, :fecha)");
      $query->execute([
         "userId" => $userId,
         "token" => $token,
         "estado" => $estado,
         "fecha" => $date
      ]);

      return $query->rowCount() ? $token : false;
   }
}

?>