<?php
class Visita extends Controller{

    function __construct(){
        parent::__construct();
        $this->view->mensaje="";
    }

    function render(){
        if(empty($_SESSION['usuario'])){
            $this->view->mensaje="Debe registrarse para poder comentar";
        }

        if(isset($_GET['id'])){
            $this->idIncidencia=$_GET['id'];
            $this->incidencia=$this->view->incidencia=$this->model->consultarIncidencia($this->idIncidencia);
            if(!empty($_SESSION['nombre']) && !empty($_SESSION['usuario'])){
                $this->view->nombre=$_SESSION['nombre'];
                $this->view->dni=$_SESSION['usuario'];
            }
            $this->view->render('visita/index');
        }else{
        $this->view->render('error/index');
        }
    }

    public function registrarComentario(){

        $comentario="";
        $id="";
        $dni="";

        //Validación del formulario de registro
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            if(empty($_POST['comentario'])){
                $mensaje="No ha rellenado el campo comentario";
            }else{
                $comentario = trim(htmlspecialchars($_POST['comentario']));
            }

            if(empty($_POST['id'])){
                $mensaje="Error de validacion";
            }else{
                $id = trim(htmlspecialchars($_POST['id']));
            }

            if(empty($_POST['dni'])){
                $mensaje="Error de validacion";
            }else{
                $dni = trim(htmlspecialchars($_POST['dni']));
            }
        }

        //Paso los datos
        $mensaje = $this->model->nuevoComentario($comentario,$id,$dni);
        $this->view->mensaje = $mensaje;
        if($mensaje == ""){
            include "models/log.php";
            $log = new LogList();
            $log->insertLog(3,$dni);
            echo "<script language='javascript'> alert('El comentario se ha añadido correctamente'); </script>";
            $_GET['id']=$id;
            $this->render();
        }else{
            echo "<script language='javascript'> alert('Registrate para comentar'); </script>";
            $this->view->render('login/index');
        }
    }


    public function imgDel(){

    }
    public function addImg(){
      $img=$_FILES['foto']['name'];
      if($img!=""){
        $ruta="public/img/incidencias/" . $_POST['id'] . "/" . $img;
        $mover_imagen=copy($_FILES['foto']['tmp_name'], $ruta);
      }
      echo "<script language='javascript'> window.location.replace('". constant('URL') ."/visita?id=".$_POST['id']."');</script>";
    }

    public function editarIncidencia(){
        $mensaje="";

        //Validación del formulario de registro
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $incidencia = [];
            $incidencia=$this->model->consultarIncidencia($_POST['idIncidencia']);

            if(empty($_POST['titulo']) && empty($_POST['clave']) && empty($_POST['lugar']) && empty($_POST['comentario'])){
                $mensaje="Al menos un campo es necesario";
            }

            if(!empty($_POST['titulo'])){
                $titulo = trim(htmlspecialchars($_POST['titulo']));
            }else{
                $titulo = $incidencia->titulo;
            }
            if(!empty($_POST['clave'])){
                $palabrasClave = trim(htmlspecialchars($_POST['clave']));
            }else{
                $palabrasClave = $incidencia->palabrasClave;
            }
            if(!empty($_POST['lugar'])){
                $lugar = trim(htmlspecialchars($_POST['lugar']));
            }else{
                $lugar = $incidencia->localizacion;
            }
            if(!empty($_POST['orden'])){
                $estado = trim(htmlspecialchars($_POST['orden']));
            }else{
                $estado = $incidencia->estado;
            }
            if(!empty($_POST['comentario'])){
                $comentario = trim(htmlspecialchars($_POST['comentario']));
            }else{
                $comentario="";
            }

            if(!empty($_POST['descripcionQueja'])){
              $descripcionQueja=trim(htmlspecialchars($_POST['descripcionQueja']));
            }else{
              $descripcionQueja=$incidencia->descripcion;
            }

            if($_POST['comentario']!=""){
              $comentario=trim(htmlspecialchars($_POST['comentario']));
              $mensaje2=$this->model->nuevoComentario($comentario, $_POST['idIncidencia'], $_POST['dni']);
            }

            $id = trim(htmlspecialchars($_POST['idIncidencia']));
            $dni = trim(htmlspecialchars($_POST['dni']));
        }

        //Actualizar el resto de campos
        $mensaje=$this->model->updateIncidencia($titulo, $palabrasClave, $lugar, $estado, $id, $dni, $descripcionQueja);


        if($mensaje == ""){
            include "models/log.php";
            $log = new LogList();
            $log->insertLog(3,$dni);
        }else{
            echo "<script language='javascript'> alert('Registrate para comentar'); </script>";
            $this->view->render('login/index');
        }

        $this->view->mensaje=$mensaje;
        $_GET['id']=$id;
        $this->render();
    }

}
?>
