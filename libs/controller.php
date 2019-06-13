<?php
require 'libs/session.php';

class Controller{
    function __construct(){
        $this->view = new View();

        if(!isset($_SESSION['usuario'])){
            $this->session = new Session();
        }
    }

    function loadModel($model){
        $url = 'models/'.$model.'.php';

        if(file_exists($url)){
            require $url;

            $modelName = $model;
            $this->model = new $modelName();
        }
    }

    function loadModel2($model){
        $url = 'models/'.$model.'.php';

        if(file_exists($url)){
            require $url;

            $modelName = $model;
            $this->model2 = new $modelName();
        }
    }
}
?>
