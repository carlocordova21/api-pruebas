<?php 
require_once "userAPI.php";
require_once "responseAPI.php";

class AuthAPI extends UserAPI {
   public function login($json) {
      $response = new ResponseAPI();
      $data = json_decode($json, true);

      if(!isset($data["usuario"]) || !isset(($data["password"]))) {
         //Campos erroneos
         return $response->error404();
      } else {
         //Todo OK
         $usuario = $data["usuario"];
         $password = $data["password"];
         //Encriptar password enviado en el body
         $password = $this->encript($password);

         $this->setUser($usuario);
         //Verificar si gmail del usuario existe
         if($this->userExists($this->getUser())) {
            //Verificar password de usuario
            if($password == $this->getPassword()) {
               //Verificar estado de usuario
               if($this->getEstado() == "Activo") {
                  //Crear token
                  $verificarToken = $this->insertToken($this->getUsuarioId());
                  if($verificarToken) {
                     //Se guarda el token
                     $result = $response->response;
                     $result["result"] = array(
                        "token" => $verificarToken
                     );
                     return $result;
                  }
                     return $response->error500();
                  return "El usuario esta activo";
               }
               return $response->error200("El usuario esta inactivo");
            } 
            return $response->error200("Password invalido");
         }
         return $response->error200("The user don't exist.");
      }
   }

}

?>