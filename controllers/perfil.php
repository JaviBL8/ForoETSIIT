<?php
    class Perfil extends Controller{

        function __construct(){
            parent::__construct();
            $user;
            $this->view->mensaje = "";
        }

        function render(){
            if(!empty($_SESSION['usuario'])){
                $this->user=$this->view->user=$this->model->consultarPerfil($_SESSION['usuario']);
                $this->view->render('perfil/index');
            }else{
                $this->view->render('error/index');
            }
        }

    }
?>
