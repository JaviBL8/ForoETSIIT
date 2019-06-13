<?php
require_once "usuario.php";
class Ddbb extends Model{

    public function __construct(){
        parent::__construct();
    }

    public function descargar(){
        
        $fecha = date("Ymd-His");

        $salida_sql = 'backupfile.sql';

        $dump = 'mysqldump --single-transaction -u '. constant('USER').' -p'.constant('PASSWORD').' '.constant('DB').' > '.$salida_sql.'';

        system($dump, $output);

        return true;
    }

    public function restaurar(){

        $command = "mysql --user={".constant('USER')."} --password='".constant('PASSWORD')."' "."-h ".constant('HOST')." -D ".constant('DB')." < {".constant('URL')."}/backupfile.sql";

        $output = system($command,$retval);

        return $retval;
    }

    public function borrar(){

        //$query0 = $this->db->connect()->query("TRUNCATE TABLE USUARIOS");
        $query1 = $this->db->connect()->query("TRUNCATE TABLE INCIDENCIA");
        $query2 = $this->db->connect()->query("TRUNCATE TABLE LOG");
        $query3 = $this->db->connect()->query("TRUNCATE TABLE COMENTARIO");

        return true;
    }

}
?>