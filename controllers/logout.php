<?php
class Logout extends Controller{

    function __construct(){
        parent::__construct();
        $this->view->mensaje="";
    }

    function render(){
        $this->session->close();
        $this->view->render('logout/index');
    }
}
?>
