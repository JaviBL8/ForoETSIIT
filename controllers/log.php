<?php
    class Log extends Controller{

        function __construct(){
            parent::__construct();
            $log = [];
            $numlog;
            $primer;
        }

        function render(){
            if(!empty($_SESSION['usuario'])){
                if(isset($_GET['primero'])){
                  $this->primer=$_GET['primero'];
                }else{
                  $this->primer=0;
                }
                $logs = new LogList();
                $this->log=$this->view->log=$logs->viewLog($this->primer);
                $this->numlog=$this->view->numlog=$logs->countLog();
                $this->view->render('log/index');
            }else{
                $this->view->render('error/index');
            }
        }

    }
?>
