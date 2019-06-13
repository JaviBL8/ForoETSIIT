<?php
require_once "usuario.php";
class LogList extends Model{

    public $tipoLog;
    public $idLog;
    public $fechaHora;
    public $dni;
    public $nombre;

    public function __construct(){
        parent::__construct();
    }

    public function insertLog($tipoLog,$dni){
        $query = $this->db->connect()->prepare("INSERT INTO `LOG` (tipoLog,dni) VALUES (:tipoLog,:dni)");

        try{
            $query->execute(['tipoLog' => $tipoLog, 'dni' => $dni]);

            return true;
        }catch(PDOException $e){
            return false;
        }
    }

    public function viewLog($primer){
        $query = $this->db->connect()->query("SELECT * FROM `LOG` ORDER BY idLog ASC LIMIT 20 OFFSET $primer");
        $log=[];
        try {
            while ($row=$query->fetch()) {
                $item = new LogList();
                $usuario=new Usuario();
                $item->idLog = $row['idLog'];
                $item->tipoLog = $row['tipoLog'];
                $item->fechaHora = $row['fechaHora'];
                $item->dni = $row['dni'];
                $item->nombre=$usuario->nombreUsuario($row['dni']);
                array_push($log, $item);
            }
            return $log;
        } catch (PDOException $e) {
          return [];
        }
    }

    public function countLog(){
      $query = $this->db->connect()->query("SELECT COUNT(*) FROM `LOG`");
      $num=$query->fetch();
      $numero=$num['0'];
      return $numero;
    }

}
?>
