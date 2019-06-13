<?php
    class editPerfil extends Controller{

        function __construct(){
            parent::__construct();
            $user;
            $this->view->mensaje="";
        }

        function render(){
            if(!empty($_SESSION['usuario'])){
                $this->user=$this->view->user=$this->model->consultarPerfil($_SESSION['usuario']);
                $this->view->render('editPerfil/index');
            }else{
                $this->view->render('error/index');
            }
        }

        public function editar(){
            $mensaje = "";

            //Sticky form
            if($_SERVER["REQUEST_METHOD"] == "POST"){

                $nombre = trim(htmlspecialchars($_POST['nombre']));
                $apellidos = trim(htmlspecialchars($_POST['apellidos']));
                $email = trim(htmlspecialchars($_POST['email']));
                $direccion = trim(htmlspecialchars($_POST['direccion']));
            }

            $mensaje = $this->model->editarPerfil($nombre,$apellidos,$email,$direccion);
            $this->view->mensaje = $mensaje;
            $this->render();
        }

    }
?>

