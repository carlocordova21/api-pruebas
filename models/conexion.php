<?php 
class Conexion {
   private $server;
   private $user;
   private $password;
   private $db;
   private $port;
   private $charset;

   public function __construct() {
      $dataConexion = $this->getDataConexion();
      foreach ($dataConexion as $value) {
         $this->server = parse_url($value["server"])["host"];
         $this->user = $value["user"];
         $this->password = $value["password"];
         $this->db = $value["db"];
         $this->port = $value["port"];
         $this->charset = $value["charset"];
      }
   }

   public function connect() {
      try {
         $cnn = "mysql:host=".$this->server.":".$this->port.";dbname=".$this->db.";charset=".$this->charset;
         $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => FALSE
         );
         $pdo = new PDO($cnn, $this->user, $this->password, $options);
         return $pdo;
      } catch (PDOException $e) {
         print_r("Error connection: ". $e->getMessage());
      }
   }

   private function getDataConexion() {
      $directorio = dirname(dirname(__FILE__));
      $jsonData = file_get_contents($directorio."\config.json");
      return json_decode($jsonData, true);
   }
}

?>