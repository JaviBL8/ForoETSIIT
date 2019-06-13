<?php
class BBDD extends Controller{

    function __construct(){
        parent::__construct();
        $this->view->mensaje="";
    }

    function render(){
        $this->view->render('bbdd/index');
    }

    public function descargar(){
        
        $this->model->descargar();
        $this->view->render('bbdd/index');
    }

    public function restaurar(){

        $this->view->mensaje=$this->model->restaurar();
        $this->view->render('bbdd/index');
    }

    public function borrar(){

        $this->model->borrar();
        $this->view->render('bbdd/index');

    }

}
?>