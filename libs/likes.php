<?php

class likes{


    function like(){
        $idIncidencia=$_POST['idIncidencia'];
        if($_COOKIE[$idIncidencia]==0){
            $_COOKIE[$idIncidencia]+=1;
        }            
    }

    function dislike(){
        $idIncidencia=$_POST['idIncidencia'];
        if($_COOKIE[$idIncidencia]==1){
            $_COOKIE[$idIncidencia]-=1;
        }            
    }
}


?>