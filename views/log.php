  <?php
  if($_SESSION['rol']==1){
?>
      <main class="usuarios">
        <div class="titulo">
          <h1>Últimos registros</h1>
        </div>

<?php
  $primero=isset($_GET['primero'])? $_GET['primero'] : 0;
  if(!is_numeric($primero) || $primero<0)
    $primero=0;

  $numitems=20;
  $n=0;
  foreach($this->log as $row){
      echo <<< HTML
        <article class="log">
          <div class="fechaHora">
HTML;
            echo"<p> $row->fechaHora </p>";
      echo <<< HTML
          </div>

          <div class="datoLog">
HTML;
            $mensaje;
            switch ($row->tipoLog) {
              case '1':
                $mensaje="El usuario ". $row->nombre . " con dni: " . $row->dni ." se ha logueado con exito";
                break;
              case '2':
                $mensaje="El usuario ". $row->nombre . " con dni: " . $row->dni ." se ha registrado con exito";
                break;
              case '3':
                $mensaje="El usuario ". $row->nombre . " con dni: " . $row->dni ." ha modificado la base de datos con exito";
                break;
              case '4':
                $mensaje="El usuario ". $row->nombre . " con dni: " . $row->dni ." ha cerrado sesión con exito";
                break;
              case '5':
                $mensaje="Intento de identificación erróneo";
                break;
            }
            echo"<p>$mensaje</p>";
      echo <<< HTML
          </div>

        </article>
HTML;

        $n=$n+1;
        if($n>20){
          exit();
        }
    }
?>



        <div class="barra">
<?php
          $ultima = ($this->numlog%$numitems) == 0 ? $this->numlog-$numitems :  ($this->numlog - ($this->numlog%$numitems));
          $anterior = ($primero-$numitems)<0 ? 0 : ($primero-$numitems);
          $siguiente = ($primero+$numitems)>=$this->numlog ? $ultima : ($primero+$numitems);

          echo '<a href="log?primero='. $anterior .'"><img class="flecha1" src=' . constant('IMG') . 'izq.png alt="Ruta mal"></a>';
          echo '<a href="log?primero='.$siguiente.'"><img class="flecha2" src=' . constant('IMG') . 'dcha.png alt="Ruta mal"></a>';

?>
        </div>
      </main>
<?php
}else{
  echo "<p>No se ha podido acceder al recurso.</p>";
}
?>
