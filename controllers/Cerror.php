<?php

    class Cerror extends Controller{
        function __construct(){
            parent::__construct();
            $this->view->mensaje = "Hubo un error en la solicitud";
            $this->view->render('error/index');
        }

    }
?>