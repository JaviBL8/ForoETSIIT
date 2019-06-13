<?php
require_once "libs/coment.php";
require_once "usuario.php";
class Incidencia extends Model{

  public $idIncidencia;
  public $titulo;
  public $localizacion;
  public $descripcion;
  public $palabrasClave;
  public $estado;
  public $identificador;
  public $dni;
  public $likes;
  public $dislikes;
  public $ncomentarios=0;
  public $fecha;
  public $comentarios=[];



  public function getPerfil($dni){
    $usuario = new Usuario();
    $user=$usuario->consultarPerfil($dni);
    return $user;
  }


  public function countIncidencias(){
    $query = $this->db->connect()->query("SELECT COUNT(*) FROM `INCIDENCIA`");
    $num=$query->fetch();
    $numero=$num['0'];
    return $numero;
  }


  public function consultarIncidencias($primer){

    $items = [];

    try {
      $query = $this->db->connect()->query("SELECT * FROM `INCIDENCIA` ORDER BY idIncidencia DESC LIMIT 5 OFFSET $primer");

      while ($row=$query->fetch()) {
        $incidencia= new Incidencia();
        $usuario=new Usuario();
        $incidencia->idIncidencia = $row['idIncidencia'];
        $incidencia->titulo = $row['titulo'];
        $incidencia->localizacion = $row['localizacion'];
        $incidencia->descripcion = $row['descripcion'];
        $incidencia->palabrasClave = $row['palabrasClave'];
        $incidencia->estado=$row['estado'];
        $incidencia->dni=$row['dni'];
        $incidencia->dni=$usuario->nombreUsuario($row['dni']);
        $incidencia->likes=$row['likes'];
        $incidencia->dislikes=$row['dislikes'];
        $incidencia->fecha=$row['fecha'];
        $query3 = $this->db->connect()->query("SELECT * FROM `COMENTARIO` WHERE idIncidencia='$incidencia->idIncidencia'");
        while($row3=$query3->fetch()){
          $comentario= new Coment();
          $comentario->contenido=$row3['contenido'];
          $comentario->fechaHora=$row3['fechaHora'];
          $comentario->dni=$usuario->nombreUsuario($row3['dni']);
          $comentario->idIncidencia=$row3['idIncidencia'];
          $incidencia->ncomentarios=$incidencia->ncomentarios+1;
          array_push($incidencia->comentarios, $comentario);
        }
        array_push($items, $incidencia);
      }
      return $items;

    } catch (PDOException $e) {
      return [];
    }
  }


  public function consultarIncidencia($idIncidencia){

    $query = $this->db->connect()->prepare("SELECT * FROM `INCIDENCIA` WHERE idIncidencia = :idIncidencia");

    try {
      $query->execute(['idIncidencia' => $idIncidencia]);
      $row=$query->fetch();
      $incidencia= new Incidencia();
      $usuario = new Usuario();
      $incidencia->idIncidencia = $row['idIncidencia'];
      $incidencia->titulo = $row['titulo'];
      $incidencia->localizacion = $row['localizacion'];
      $incidencia->descripcion = $row['descripcion'];
      $incidencia->palabrasClave = $row['palabrasClave'];
      $incidencia->estado=$row['estado'];
      $incidencia->dni=$row['dni'];
      $incidencia->identificador=$row['dni'];
      $incidencia->dni=$usuario->nombreUsuario($row['dni']);
      $incidencia->likes=$row['likes'];
      $incidencia->dislikes=$row['dislikes'];
      $incidencia->fecha=$row['fecha'];
      $query3 = $this->db->connect()->query("SELECT * FROM `COMENTARIO` WHERE idIncidencia='$incidencia->idIncidencia'");
      while($row3=$query3->fetch()){
        $comentario= new Coment();
        $comentario->contenido=$row3['contenido'];
        $comentario->fechaHora=$row3['fechaHora'];
        $comentario->dni=$usuario->nombreUsuario($row3['dni']);
        $comentario->idIncidencia=$row3['idIncidencia'];
        $incidencia->ncomentarios=$incidencia->ncomentarios+1;
        array_push($incidencia->comentarios, $comentario);
      }
      return $incidencia;
    } catch (PDOException $e) {
      return [];
    }
  }

  public function nuevaIncidencia($datos){

    //validacion
    $mensaje="";

    try{

      $query = $this->db->connect()->prepare('INSERT INTO INCIDENCIA (titulo, localizacion , descripcion, palabrasClave, dni)
        VALUES (:titulo,:localizacion ,:descripcion, :palabrasClave, :dni)');

      $query->execute(['titulo' => $datos['titulo'], 'localizacion' => $datos['localizacion'], 'descripcion' => $datos['descripcion'],
      'palabrasClave' => $datos['palabrasClave'], 'dni' => $_SESSION['usuario']]);

      $id=$this->getCurrentId();
      $ruta=  "./public/img/incidencias/" . $id;
      if(!mkdir($ruta, 0777)){
        die("Debe borrar el directorio");
      }else{
        chmod($ruta, 0777);
      }

    } catch(PDOexception $e){
      $mensaje = $e;
    }
    return $mensaje;
  }

  public function getCurrentId(){
    $query = $this->db->connect()->query("SELECT `idIncidencia` FROM `INCIDENCIA` ORDER BY `idIncidencia` DESC LIMIT 1");
    $num=$query->fetch();
    $ai=$num['idIncidencia'];
    return $ai;
  }

  public function masLikes(){
    $query = $this->db->connect()->query('SELECT titulo, idIncidencia FROM `INCIDENCIA` ORDER BY likes DESC LIMIT 3');
    $items=[];
    try {
      while ($row=$query->fetch()) {
        $incidencia = new Incidencia();
        $incidencia->titulo=$row['titulo'];
        $incidencia->idIncidencia=$row['idIncidencia'];
        array_push($items, $incidencia);
      }

      return $items;
    } catch (PDOexception $e) {
      return 'false';
    }

  }

  public function masIncidencias(){
    $query = $this->db->connect()->query('SELECT dni FROM `INCIDENCIA` GROUP BY dni DESC LIMIT 3');
    $items=[];
    try {
      while ($row=$query->fetch()) {
        $dni=$row['dni'];
        $user = new Usuario();
        $nombre=$user->nombreUsuario($dni);
        array_push($items, $nombre);
      }
      return $items;
    } catch (PDOexception $e) {
      return 'false';
    }

  }

  public function masComentan(){
    $query = $this->db->connect()->query('SELECT dni FROM `COMENTARIO` GROUP BY dni DESC LIMIT 3');
    $items=[];
    try{
      while($row=$query->fetch()){
        $dni=$row['dni'];
        $user = new Usuario();
        $nombre=$user->nombreUsuario($dni);
        array_push($items, $nombre);
      }
      return $items;
    } catch(PDOException $e){
      return [];
    }
  }

  public function busquedaIncidencias($orden,$palabrasClave,$localizacion,$estado0,$estado1,$estado2,$estado3,$estado4, $estado5){

    $sql = "SELECT * FROM `INCIDENCIA`";


    $sql = $sql . " WHERE (palabrasClave LIKE " . "'%" . $palabrasClave . "%')";

    if(!empty($localizacion)){
      $sql = $sql . " AND (localizacion = " . "'" . $localizacion . "')";
    }

    if(isset($_SESSION['usuario']))
      $dni=$_SESSION['usuario'];

    if($estado5 != 0){
      $sql = $sql . " AND (dni = '". $dni . "')";
    }

    $i=0;

    if($estado0 != 0){
      $sql = $sql . " AND (estado = 0)";
      $i=1;
    }

    if($estado1 != 0){
      if($i==1){
        $sql = $sql . " OR (estado = 1)";
      }else{
        $sql = $sql . " AND (estado = 1)";
        $i=1;
      }
    }

    if($estado2 != 0){
      if($i==1){
        $sql = $sql . " OR (estado = 2)";
      }else{
        $sql = $sql . " AND (estado = 2)";
        $i=1;
      }
    }

    if($estado3 != 0){
      if($i==1){
        $sql = $sql . " OR (estado = 3)";
      }else{
        $sql = $sql . " AND (estado = 3)";
        $i=1;
      }
    }

    if($estado4 != 0){
      if($i==1){
        $sql = $sql . " OR (estado = 4)";
      }else{
        $sql = $sql . " AND (estado = 4)";
        $i=1;
      }
    }

    if($orden=='0'){
      $sql = $sql . " ORDER BY fecha DESC";
    }

    if($orden=='1'){
      $sql = $sql . " ORDER BY fecha";
    }

    if($orden=='2'){
      $sql = $sql . " ORDER BY likes DESC";
    }



    try{
      $query = $this->db->connect()->query($sql);

      $items=[];
      while ($row=$query->fetch()) {
        $incidencia= new Incidencia();
        $usuario=new Usuario();
        $incidencia->idIncidencia = $row['idIncidencia'];
        $incidencia->titulo = $row['titulo'];
        $incidencia->localizacion = $row['localizacion'];
        $incidencia->descripcion = $row['descripcion'];
        $incidencia->palabrasClave = $row['palabrasClave'];
        $incidencia->estado=$row['estado'];
        $incidencia->dni=$row['dni'];
        $incidencia->dni=$usuario->nombreUsuario($row['dni']);
        $incidencia->likes=$row['likes'];
        $incidencia->dislikes=$row['dislikes'];
        $incidencia->fecha=$row['fecha'];
        $query3 = $this->db->connect()->query("SELECT * FROM `COMENTARIO` WHERE idIncidencia='$incidencia->idIncidencia'");
        while($row3=$query3->fetch()){
          $comentario= new Coment();
          $comentario->contenido=$row3['contenido'];
          $comentario->fechaHora=$row3['fechaHora'];
          $comentario->dni=$usuario->nombreUsuario($row['dni']);
          $comentario->idIncidencia=$row3['idIncidencia'];
          $incidencia->ncomentarios=$incidencia->ncomentarios+1;
          array_push($incidencia->comentarios, $comentario);
        }
        array_push($items, $incidencia);
      }
      return $items;

    }catch(PDOException $e){
      return [];
    }
  }


  public function likes_dislikes(){

    if(isset($_SESSION['usuario'])){
      //Hay un usuario logeado
      $dni = $_SESSION['usuario'];

      if (isset($_POST['action'])) {

        $idIncidencia = $_POST['idIncidencia'];
        $action = $_POST['action'];

        switch ($action) {
          case 'like':
            $sql="UPDATE `INCIDENCIA` SET likes = likes+1  WHERE idIncidencia = " . $idIncidencia;
            break;
          case 'dislike':
            $sql="UPDATE `INCIDENCIA` SET dislikes = dislikes+1  WHERE idIncidencia = " . $idIncidencia;
            break;
          case 'unlike':
            $sql="UPDATE `INCIDENCIA` SET dislikes = dislikes-1  WHERE idIncidencia = " . $idIncidencia;
            break;
          case 'undislike':
            $sql="UPDATE `INCIDENCIA` SET likes = likes-1  WHERE idIncidencia = " . $idIncidencia;
            break;
          default:
            break;
        }

        $likes = $this->db->connect()->query($sql);
      }
    }
  }

  public function nuevoComentario($comentario,$id,$dni){

    if(empty($_SESSION['usuario'])){
      return "Identifiquese para comentar";
    }

    $query = $this->db->connect()->prepare('INSERT INTO COMENTARIO (contenido, dni, idIncidencia) VALUES (:contenido, :dni, :idIncidencia)');

    try{
      $query->execute(['contenido' => $comentario, 'dni' => $dni,'idIncidencia' => $id]);
      return "";

    }catch(PDOException $e){
      return $e;
    }
  }

  public function updateIncidencia($titulo,$palabrasClave,$localizacion,$estado,$idIncidencia,$dni, $descripcionQueja){

    if(empty($_SESSION['usuario'])){
      return "Identifiquese para comentar";
    }
    try{
      $query = $this->db->connect()->query("UPDATE `INCIDENCIA` SET titulo=$titulo, localizacion=$localizacion, descripcion=$descripcionQueja, palabrasClave=$palabrasClave, estado=$estado WHERE idIncidencia=$idIncidencia");

      return "";

    }catch(PDOException $e){
      return $e;
    }
  }

  public function giveLike($idIncidencia){

    try{

     $query = $this->db->connect()->prepare("UPDATE `INCIDENCIA` SET likes= likes+1 WHERE idIncidencia = :idIncidencia");

     $query->execute(['idIncidencia' => $idIncidencia]);

    }catch(PDOException $e){
      return $e;
    }

  }

  public function givedislike($idIncidencia){

    try{

      $query = $this->db->connect()->prepare("UPDATE `INCIDENCIA` SET dislikes= dislikes+1 WHERE idIncidencia = :idIncidencia");

      $query->execute(['idIncidencia' => $idIncidencia]);

    }catch(PDOException $e){
      return $e;
    }

  }

}

?>
