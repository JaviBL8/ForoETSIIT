<?php
    class Registro extends Controller{

        function __construct(){
            parent::__construct();
            $this->view->mensaje = "";
        }

        function render(){
            $this->view->render('registro/index');
        }

        function registrar(){
            $mensaje = "";
            //Validación del formulario de registro
            if($_SERVER["REQUEST_METHOD"] == "POST"){

                if(empty($_POST['dni'])){
                    $mensaje="Error de validación";
                }else{
                    $dni = trim(htmlspecialchars($_POST['dni']));
                }

                if(empty($_POST['nombre'])){
                    $mensaje="Error de validación";
                }else{
                    $nombre = trim(htmlspecialchars($_POST['nombre']));
                }

                if(empty($_POST['apellidos'])){
                    $mensaje="Error de validación";
                }else{
                    $apellidos = trim(htmlspecialchars($_POST['apellidos']));
                }

                if(empty($_POST['email'])){
                    $mensaje="Error de validación";
                }else{
                    $email = trim(htmlspecialchars($_POST['email']));
                }

                if(empty($_POST['direccion'])){
                    $mensaje="Error de validación";
                }else{
                    $direccion = trim(htmlspecialchars($_POST['direccion']));
                }

                $rol = trim(htmlspecialchars($_POST['rol']));

                if(empty($_POST['contrasena'])){
                    $mensaje="Error de validación";
                }else{
                    $contrasena = trim(htmlspecialchars($_POST['contrasena']));
                }

                if(empty($_POST['contrasena2'])){
                    $mensaje="Error de validación";
                }else{
                    $contrasena2 = trim(htmlspecialchars($_POST['contrasena2']));
                }

                if(empty($_POST['telefono'])){
                    $mensaje="Error de validación";
                }else{
                    $telefono = trim(htmlspecialchars($_POST['telefono']));
                }
            }

            if($mensaje!=""){
                $this->view->mensaje = $mensaje;
                $this->render("login/index");
            }else{

                //Paso los datos
                $mensaje = $this->model->registrarUsuario(['dni' => $dni, 'nombre' => $nombre, 'contrasena' => $contrasena,
                'contrasena2' => $contrasena2 , 'telefono' => $telefono, 'apellidos' => $apellidos, 'email' => $email,
                'direccion' => $direccion, 'rol' => $rol]);

                $correcto=0;

                if($mensaje == ""){
                    include "models/log.php";
                    $log = new LogList();
                    $log->insertLog(2,$dni);
                    echo "<script language='javascript'> alert('Se ha registrado correctamente'); </script>";
                    $correcto=1;
                }

                if(!empty($_SESSION['usuario']) && $correcto == 1 ){
                    $this->view->render('usuarios/index');
                }else if($correcto){
                    $this->view->render('login/index');
                }else{
                    $this->view->mensaje = $mensaje;
                    $this->render("login/index");
                }
            }
        }

    }
?>
