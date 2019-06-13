<?php
require_once("controllers/Cerror.php");
require_once("libs/session.php");
class App{

    function __construct()
    {

        $url = isset($_GET['url']) ? $_GET['url']: null;
        $url = rtrim($url,'/');
        $url = explode('/',$url);
        if(empty($url[0])){
            $archivoController = 'controllers/main.php';
            require_once $archivoController;
            $controller = new Main();
            $controller->loadModel('incidencia');
            $controller->render();
            return false;
        }else{
            $archivoController = 'controllers/' . $url[0] . '.php';
        }

        if(file_exists($archivoController)){
            require $archivoController;

            $controller = new $url[0]();

            switch($url[0]){
                case 'main': $controller->loadModel('incidencia'); break;
                case 'usuario':
                $controller->loadModel('usuario');
                $controller->loadModel2('log');
                break;
                case 'log': $controller->loadModel('log'); break;
                case 'usuarios': $controller->loadModel('usuario');break;
                case 'registro': $controller->loadModel('usuario'); break;
                case 'login': $controller->loadModel('usuario'); break;
                case 'bbdd': $controller->loadModel('ddbb'); break;
                case 'editPerfil': $controller->loadModel('usuario'); break;
                case 'editPass': $controller->loadModel('usuario'); break;
                case 'perfil': $controller->loadModel('usuario'); break;
                case 'nuevaIncidencia': $controller->loadModel('incidencia'); break;
                case 'visita': $controller->loadModel('incidencia'); break;
            }

            $nparam = sizeof($url);

            if($nparam > 1){
                if($nparam > 2){
                    $param=[];
                    for($i=2; $i<$nparam; $i++){
                        array_push($param, $url[$i]);
                    }
                    $controller->{$url[1]}($param);
                }else{
                    $controller->{$url[1]}();
                }
            }else{
                $controller->render();
            }
        }
        else{
            $controller = new Cerror();
        }

    }
}
?>
