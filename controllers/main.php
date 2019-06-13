<?php
    class Main extends Controller{

      public $numvisita;

        function __construct(){
            parent::__construct();
            $incidencias = [];
            $query1 = [];
            $query2 = [];
            $query3 = [];
            $incidenciasBusqueda=[];
            $busquedan;
            $this->view->mensaje="";
            $user;
            $numincidencia=0;
            $primer;
        }

        function render(){
          if (!isset($_COOKIE['visitas'])){
            $this->numvisita = 1;
          }
          else{
            $this->numvisita = $_COOKIE["visitas"] + 1;
          }

          setcookie("visitas",$this->numvisita,time()+60*60*24*1000);

          if(!empty($_SESSION['usuario'])){
            $this->user=$this->view->user=$this->model->getPerfil($_SESSION['usuario']);
          }
          if( isset($this->model)){
            if(empty($this->incidenciasBusqueda)){
              if(isset($_GET['primero'])){
                $this->primer=$_GET['primero'];
              }else{
                $this->primer=0;
              }
              $this->incidencias=$this->view->incidencias=$this->model->consultarIncidencias($this->primer);
              $this->model->likes_dislikes();
              $this->numincidencia=$this->view->numincidencia=$this->model->countIncidencias();
              $this->busquedan=$this->view->busquedan=0;
            }else{
              $this->view->incidencias=$this->incidenciasBusqueda;
              $this->busquedan=$this->view->busquedan=1;
            }
          }else{
            $this->view->incidencias=$this->incidenciasBusqueda;
          }
          $this->query1=$this->view->query1=$this->model->masLikes();
          $this->query2=$this->view->query2=$this->model->masIncidencias();
          $this->query3=$this->view->query3=$this->model->masComentan();

        $this->view->render('main/index');
      }

        public function busqueda(){
          //Validación del formulario de registro
          $palabrasClave = trim(htmlspecialchars($_POST['palabrasClave']));

          $orden = trim(htmlspecialchars($_POST['orden']));

          $localizacion = trim(htmlspecialchars($_POST['localizacion']));

          $estado0 = trim(htmlspecialchars($_POST['estado0']));

          $estado1 = trim(htmlspecialchars($_POST['estado1']));

          $estado2 = trim(htmlspecialchars($_POST['estado2']));

          $estado3 = trim(htmlspecialchars($_POST['estado3']));

          $estado4 = trim(htmlspecialchars($_POST['estado4']));

          $estado5 = trim(htmlspecialchars($_POST['estado5']));



          $items = $this->incidenciasBusqueda=$this->model->busquedaIncidencias($orden,$palabrasClave,$localizacion,
            $estado0,$estado1,$estado2,$estado3,$estado4, $estado5);

          if(empty($items)){
            $this->view->mensaje = "<p>La búsqueda no obtuvo resultados</p>";
          }

        $this->render();
      }

      public function updateLike(){
        $idIncidencia = $_POST['idIncidencia'];
        $var=$this->numvisita;
        $mensaje=""; 
        $this->model->giveLike($idIncidencia);
        $mensaje = "<p>Su voto se ha registrado correctamente</p>";
        $this->view->mensaje=$mensaje;
        $this->render();
      }

      public function updateDislike(){
        $idIncidencia = $_POST['idIncidencia'];
        $var=$this->numvisita;
        $mensaje="";
        $this->model->giveDislike($idIncidencia);
        $mensaje =  "<p>Su voto se ha registrado correctamente</p>";
        $this->view->mensaje=$mensaje;
        $this->render();
      }

    }
?>
