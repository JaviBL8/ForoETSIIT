<?php
class Login extends Controller{

    function __construct(){
        parent::__construct();
        $this->view->mensaje="";
    }

    function render(){
        $this->view->render('login/index');
    }

    public function signin(){

        //Sticky form
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            if(empty($_POST['email'])){
                $mensaje="No ha rellenado el email";
            }else{
                $email = trim(htmlspecialchars($_POST['email']));
            }

            if(empty($_POST['password'])){
                $mensaje="No ha rellenado la password";
            }else{
                $password = trim(htmlspecialchars($_POST['password']));
            }
        }

        if($this->model->existeUsuario($email,$password)){

            $dni =$this->model->obtenerDniUsuario($email);
            $rol=$this->model->getRolUser($dni);
            $this->session->setCurrentUser($dni);
            $this->session->setCurrentRol($rol);
            $nombre=$this->model->nombreUsuario($dni);
            $this->session->setCurrentNombre($nombre);
            $user=$this->model->consultarPerfil($dni);
            $img=$user->img;
            $this->session->setImg($img);
            include "models/log.php";
            $log = new LogList();
            $log->insertLog(1,$dni);

            echo "<script language='javascript'> window.location.replace('" . constant('URL') . "/main '); </script>";
        }
        else{
            include "models/log.php";
            $log = new LogList();
            //DNI 0 = USUARIO MAL IDENTIFICADO INTENTANDO ACCEDER
            $log->insertLog(5,0);
            echo "<script language='javascript'> alert('Login incorrecto'); </script>";;
        }
        $this->render();
    }
}
?>
