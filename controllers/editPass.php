<?php
    class editPass extends Controller{

        function __construct(){
            parent::__construct();
            $user;
            $this->view->mensaje="";
        }

        function render(){
            if(!empty($_SESSION['usuario'])){
                $this->user=$this->view->user=$this->model->consultarPerfil($_SESSION['usuario']);
                $this->view->render('editPass/index');
            }else{
                $this->view->render('error/index');
            }
        }

        public function editar(){
            $mensaje = "";
            //Sticky form
            if($_SERVER["REQUEST_METHOD"] == "POST"){

                if(empty($_POST['antigua'])){
                    $mensaje="No ha rellenado la contraseña";
                }else{
                    $antigua = trim(htmlspecialchars($_POST['antigua']));
                }

                if(empty($_POST['nueva'])){
                    $mensaje="No ha rellenado la contraseña";
                }else{
                    $nueva = trim(htmlspecialchars($_POST['nueva']));
                }

                if(empty($_POST['nueva2'])){
                    $mensaje="No ha rellenado la contraseña";
                }else{
                    $nueva2 = trim(htmlspecialchars($_POST['nueva2']));
                }
            }

            if(empty($mensaje)){
                $mensaje = $this->model->editarPassword($antigua,$nueva,$nueva2);
            }
            $this->view->mensaje = $mensaje;
            $this->render();
        }

    }
?>