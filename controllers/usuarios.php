<?php
    class Usuarios extends Controller{

        function __construct(){
            parent::__construct();
            $usuarios=[];
            $numuser;
            $primer;
        }

        function render(){
            if(!empty($_SESSION['usuario'])){
                if(isset($_GET['primero'])){
                  $this->primer=$_GET['primero'];
                }else{
                  $this->primer=0;
                }
                $this->numuser=$this->view->numuser=$this->model->countUser();
                $this->usuarios=$this->view->usuarios=$this->model->usuarios($this->primer);
                $this->view->render('usuarios/index');
            }else{
                $this->view->render('error/index');
            }
        }

        public function eliminarUsuario(){
          if(!empty($_POST['user'])){
            if($_SESSION['rol']==1){
              $this->model->eliminarUsuario($_POST['user']);
            }
          }
          $this->render();
        }
    }
?>
