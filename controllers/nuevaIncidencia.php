<?php
    class nuevaIncidencia extends Controller{

        function __construct(){
            parent::__construct();
            $this->view->mensaje = "";
        }

        function render(){
            if(!empty($_SESSION['usuario'])){
                $this->view->render('nuevaIncidencia/index');
            }else{
                $this->view->render('error/index');
            }
        }

        public function registrarIncidencia(){
            $mensaje = "";
            //Validación del formulario de registro
            if($_SERVER["REQUEST_METHOD"] == "POST"){

                if(empty($_POST['titulo']) || strlen($_POST['titulo'])>40){
                    $mensaje="Error de validación de datos";
                }else{
                    $titulo = trim(htmlspecialchars($_POST['titulo']));
                }

                if(empty($_POST['localizacion']) || strlen($_POST['localizacion'])>255){
                    $mensaje="Error de validación de datos";
                }else{
                    $localizacion = trim(htmlspecialchars($_POST['localizacion']));
                }

                if(empty($_POST['palabrasClave']) || strlen($_POST['palabrasClave'])>50){
                    $mensaje="Error de validación de datos";
                }else{
                    $palabrasClave = trim(htmlspecialchars($_POST['palabrasClave']));
                }

                if(empty($_POST['descripcion']) || strlen($_POST['descripcion'])>2500){
                    $mensaje="Error de validación de datos";
                }else{
                    $descripcion = trim(htmlspecialchars($_POST['descripcion']));
                }

            }
            if(empty($mensaje)){

                //Paso los datos
                $mensaje = $this->model->nuevaIncidencia(['titulo' => $titulo, 'localizacion' => $localizacion,
                    'palabrasClave' => $palabrasClave, 'descripcion' => $descripcion]);

                if($mensaje == ""){
                    include "models/log.php";
                    $log = new LogList();
                    $log->insertLog(3,$_SESSION['usuario']);
                    echo "<script language='javascript'> alert('La incidencia se ha añadido correctamente'); </script>";
                }else{
                    echo "<script language='javascript'> alert('Se ha producido un error'); </script>";
                }
            }else{
                echo "<script language='javascript'> alert('Se ha producido un error'); </script>";
            }

            $this->view->mensaje = $mensaje;
            $this->render();
            //render("main/index");
        }
    }
?>
