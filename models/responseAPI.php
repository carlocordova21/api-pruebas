<?php 
class ResponseAPI {
   public $response = array(
      "status" => "ok",
      "result" => array()
   );

   public function error200($msg = "Datos incorrectos") {
      $this->response["status"] = "error";
      $this->response["result"] = array(
         "error_id" => "405",
         "error_msg" => $msg,
      );
      return $this->response;
   }

   public function error400() {
      $this->response["status"] = "error";
      $this->response["result"] = array(
         "error_id" => "400",
         "error_msg" => "Bad request",
      );
      return $this->response;
   }

   public function error401($msg = "Unauthorized") {
      $this->response["status"] = "error";
      $this->response["result"] = array(
         "error_id" => "401",
         "error_msg" => $msg,
      );
      return $this->response;
   }

   public function error403() {
      $this->response["status"] = "error";
      $this->response["result"] = array(
         "error_id" => "403",
         "error_msg" => "Forbidden",
      );
      return $this->response;
   }

   public function error404() {
      $this->response["status"] = "error";
      $this->response["result"] = array(
         "error_id" => "404",
         "error_msg" => "Not found",
      );
      return $this->response;
   }

   public function error405() {
      $this->response["status"] = "error";
      $this->response["result"] = array(
         "error_id" => "404",
         "error_msg" => "Method Not Allowed",
      );
      return $this->response;
   }

   public function error500() {
      $this->response["status"] = "error";
      $this->response["result"] = array(
         "error_id" => "500",
         "error_msg" => "Internal Server Error",
      );
      return $this->response;
   }
}

?>