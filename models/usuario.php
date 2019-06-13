<?php
class Usuario extends Model{

    public $dni;
    public $nombre;
    public $apellidos;
    public $email;
    public $direccion;
    public $rol;
    public $contrasena;
    public $telefono;
    public $img;

    public function __construct(){
        parent::__construct();
    }

    public function countUser(){
      $query = $this->db->connect()->query("SELECT COUNT(*) FROM `USUARIOS`");
      $num=$query->fetch();
      $numero=$num['0'];
      return $numero;
    }

    public function eliminarUsuario ($dni){
      $query = $this->db->connect()->query("DELETE FROM `USUARIOS` WHERE dni='$dni'");
    }

    public function usuarios($primer){
      $datos=[];
      $query = $this->db->connect()->query("SELECT * FROM `USUARIOS` ORDER BY rol DESC LIMIT 10 OFFSET $primer");

      while($user=$query->fetch()){
        $usuario=new Usuario();
        $usuario->nombre=$user['nombre'];
        $usuario->email=$user['email'];
        $usuario->direccion=$user['direccion'];
        $usuario->telefono=$user['telefono'];
        $usuario->rol=$user['rol'];
        $usuario->apellidos=$user['apellidos'];
        $usuario->img=$user['img'];
        $usuario->dni=$user['dni'];
        array_push($datos, $usuario);
      }
      return $datos;
    }

    public function consultarPerfil($dni){
      $query = $this->db->connect()->query("SELECT * FROM `USUARIOS` WHERE dni='$dni'");
      $user = $query->fetch();
      $usuario= new Usuario();
      $usuario->dni=$dni;
      $usuario->nombre=$user['nombre'];
      $usuario->apellidos=$user['apellidos'];
      $usuario->email=$user['email'];
      $usuario->direccion=$user['direccion'];
      $usuario->contrasena=$user['contrasena'];
      $usuario->img=$user['img'];
      return $usuario;
    }

    public function registrarUsuario($datos){
        //validacion de datos
        $mensaje = $this->validacion($datos);

        if($mensaje!=""){
            return $mensaje;
        }

        //Encriptamos la contraseña antes de guardarla en la bd
        $salt = md5($datos['contrasena']);
        $bdcrypt = crypt($datos['contrasena'], $salt);

        //insertar datos en la BD
        try{
            $query = $this->db->connect()->prepare('INSERT INTO USUARIOS (dni, nombre, contrasena, telefono, apellidos, email, direccion, rol)
                VALUES (:dni, :nombre, :contrasena, :telefono, :apellidos, :email, :direccion, :rol)');

            $query->execute(['dni' => $datos['dni'],'nombre' => $datos['nombre'], 'contrasena' => $bdcrypt,
                'telefono' => $datos['telefono'], 'apellidos' => $datos['apellidos'], 'email' => $datos['email'],
                'direccion' => $datos['direccion'], 'rol' => $datos['rol']]);

            $ruta=  "./public/img/usuarios/" . $datos['dni'];
            if(!mkdir($ruta, 0777)){
              die("ERROR");
            }else{
              chmod($ruta, 0777);
            }
            $fichero = "./public/img/echenique1.jpeg";
            $copia = $ruta ."/echenique1.jpeg";
            copy($fichero, $copia);
            return "";
        }catch(PDOException $e){
            return $e;
        }
    }

    public function validacion($datos){
        if(strlen($datos['dni']) != 9 ){
           return "<p>El DNI introducido no es correcto</p>";
        }
        if(strlen($datos['nombre']) > 20){
            return "<p>Longitud máxima para apellidos 20</p>";
        }
        if(strlen($datos['apellidos']) > 40){

            return "<p>Longitud máxima para apellidos 40</p>";
        }
        if(strlen($datos['contrasena']) > 20){
            return "<p>La contraseña no puede superar 20 carácteres</p>";
        }
        if($datos['contrasena'] != $datos['contrasena2']){
            return "<p>Las contraseñas no coinciden</p>";
        }
        if(strlen($datos['direccion']) > 30){
            return "<p>La dirección no puede superar los 30 caracteres</p>";
        }
        if(strlen($datos['email']) > 30){
            return "<p>Introduzca un email más corto</p>";
        }
        if($datos['rol'] > 3 && $datos['rol'] < 0 ){
            return "<p>Introduzca un rol más corto</p>";
        }
        return "";
    }

    public function existeUsuario($email, $contrasena){

        //Encripto la contraseña y la comparo con la de la BD
        $salt = md5($contrasena);
        $bdcrypt = crypt($contrasena, $salt);

        $query = $this->db->connect()->query("SELECT COUNT(*) FROM `USUARIOS` WHERE (email = '$email' AND contrasena = '$bdcrypt')");
        $result = $query->fetch();
        $count = $result[0];
        try {

            if($count==1)
            {
                return true;
            }
            else{
                return false;
            }
        } catch (PDOException $e) {
          return [];
        }
    }

    public function nombreUsuario($dni){
      $query = $this->db->connect()->query("SELECT nombre FROM `USUARIOS` WHERE dni='$dni'");

      try {
        $row=$query->fetch();
        $nombre=$row['nombre'];
        return $nombre;
      } catch (PDOException $e) {
        return $nombre;
      }

    }

    public function obtenerDniUsuario($email){

        try{
            $query = $this->db->connect()->query("SELECT dni FROM `USUARIOS` WHERE email = '$email'");
            $row = $query->fetch();
            $datos = $row['dni'];
            return $datos;
        }catch(PDOException $e){
            return [];
        }
    }

    public function getRolUser($dni){
      try{
          $query = $this->db->connect()->query("SELECT rol FROM `USUARIOS` WHERE dni = '$dni'");
          $row = $query->fetch();
          $datos = $row['rol'];

          return $datos;
      }catch(PDOException $e){
          return [];
      }
    }

    public function setUsuario($dni){
        $query = $this->db->connect()->prepare('SELECT * FROM usuarios WHERE dni = :dni');
        $query->execute(['dni' => $dni]);

        foreach ($query as $currentUser) {
            $this->nombre = $currentUser['nombre'];
            $this->apellidos = $currentUser['apellidos'];
            $this->email = $currentUser['email'];
            $this->direccion = $currentUser['direccion'];
            $this->rol = $currentUser['rol'];
            $this->contrasena = $currentUser['contrasena'];
            $this->dni = $currentUser['dni'];
            $this->telefono = $currentUser['telefono'];
        }
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function editarPerfil($nombre,$apellidos,$email,$direccion){

        try{
            if(!empty($_FILES['img'])){
              $img=$_FILES['img']['name'];
              if($img!=""){
                $ruta="public/img/usuarios/". $_SESSION['usuario'] . "/" . $img;
                $mover_imagen=copy($_FILES['img']['tmp_name'], $ruta);
                $query1 = $this->db->connect()->prepare('UPDATE `USUARIOS` SET img = :img WHERE dni = :dni');
                $query1->execute(['img' => $img, 'dni'=> $_SESSION['usuario']]);
              }
              $_SESSION['img']=$img;
            }

            if(!empty($nombre)){
                $query1 = $this->db->connect()->prepare('UPDATE `USUARIOS` SET nombre = :nombre WHERE dni = :dni');
                $query1->execute(['nombre' => $nombre, 'dni'=> $_SESSION['usuario']]);
                $_SESSION['nombre']=$nombre;
            }

            if(!empty($apellidos)){
                $query2 = $this->db->connect()->prepare('UPDATE `USUARIOS` SET apellidos = :apellidos WHERE dni = :dni');
                $query2->execute(['apellidos' => $apellidos, 'dni'=> $_SESSION['usuario']]);
            }

            if(!empty($email)){
                $query3 = $this->db->connect()->prepare('UPDATE `USUARIOS` SET email = :email WHERE dni = :dni');
                $query3->execute(['email' => $email, 'dni'=> $_SESSION['usuario']]);
            }

            if(!empty($direccion)){
                $query4 = $this->db->connect()->prepare('UPDATE `USUARIOS` SET direccion = :direccion WHERE dni = :dni');
                $query4->execute(['direccion' => $direccion, 'dni'=> $_SESSION['usuario']]);
            }
            $mensaje = "Los datos se han actualizado correctamente";

            return $mensaje;
        }catch(PDOException $e){
            return $e;
        }
    }

    public function editarPassword($antigua,$nueva,$nueva2){

        //Validacion de las contraseñas
        $contrasena = $this->db->connect()->prepare('SELECT contrasena FROM `USUARIOS` WHERE dni = :dni');
        $contrasena->execute(['dni'=> $_SESSION['usuario']]);

        $contrasena = $contrasena->fetch();
        
        //Falta comprobar si la antigua coincide
        if($antigua == $nueva || $nueva != $nueva2){
            return "Error de validación";
        }

        //Encriptamos la contraseña antes de guardarla en la bd
        $salt = md5($nueva);
        $bdcrypt = crypt($nueva, $salt);

        $query = $this->db->connect()->prepare('UPDATE `USUARIOS` SET contrasena = :contrasena WHERE dni = :dni');

        try{
            $query->execute(['contrasena' => $bdcrypt, 'dni'=> $_SESSION['usuario']]);
            return "Las contraseña se ha actualizado con éxito";
        }catch(PDOException $e){
            return $e;
        }
    }

}

?>
