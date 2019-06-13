<?php
  if($_SESSION['rol']==1){
?>
      <main class="usuarios">
        <div class="titulo">
          <h1>Gestión de usuarios</h1>
<?php
          echo '<a href="registro"><img class="mas" src=' . constant('IMG') . 'mas.png alt="Ruta mal"></a>';
?>
        </div>


<?php
  $primero=isset($_GET['primero'])? $_GET['primero'] : 0;
  if(!is_numeric($primero) || $primero<0)
    $primero=0;

  $numitems=5;
  $n=1;



  foreach ($this->usuarios as $row) {
?>

        <article class="user">
          <div class="fotodelPerfil">
<?php
          $imgPerfil=constant('IMG'). "usuarios/".$row->dni ."/".$row->img;
          echo '<img class="fotoPerfil" src="'. $imgPerfil .'" alt="Ruta mal">';
?>
          </div>

          <div class="datosUser">

            <div class="nombreUser">
              <label>Nombre:</label>
<?php
              echo"<p>". $row->nombre . " " . $row->apellidos ."</p>";
?>
            </div>

            <div class="mailUser">
              <label>Mail:</label>
<?php
              echo"<p>". $row->email ."</p>";
?>
            </div>

            <div class="direccionUser">
              <label>Direccion:</label>
<?php
              echo"<p>". $row->direccion ."</p>";
?>
            </div>

            <div class="tlfUser">
              <label>Telefono:</label>
<?php
              echo"<p>". $row->telefono ."</p>";
?>
            </div>

            <div class="rolUser">
              <label>Rol:</label>
<?php
              $rol;
              switch ($row->rol) {
                case '0':
                  $rol="Colaborador";
                  break;

                case '1':
                  $rol="Administrador";
                  break;
              }
              echo"<p>". $rol ."</p>";
?>
            </div>
          </div>

          <div class="botones">
            <form action="<?php echo constant('URL')?>/usuarios/eliminarUsuario" method="POST">
<?php
              echo "<input type='hidden' name='user' value='". $row->dni ."'>";
              echo '<button type="submit"><img src=' . constant("IMG") . 'minus.png alt="Ruta mal" height="20" width="20"></button>';
            echo"</form>";
?>
          </div>
        </article>
<?php
        $n=$n+1;
        if($n>5){
          break;
        }

}
?>

        <div class="barra">
<?php
          $ultima = ($this->numuser%$numitems) == 0 ? $this->numuser-$numitems :  ($this->numuser - ($this->numuser%$numitems));
          $anterior = ($primero-$numitems)<0 ? 0 : ($primero-$numitems);
          $siguiente = ($primero+$numitems)>=$this->numuser ? $ultima : ($primero+$numitems);

          echo '<a href="usuarios?primero='.$anterior.'"><img class="flecha1" src=' . constant('IMG') . 'izq.png alt="Ruta mal"></a>';
          echo '<a href="usuarios?primero='.$siguiente.'"><img class="flecha2" src=' . constant('IMG') . 'dcha.png alt="Ruta mal"></a>';
?>
        </div>
      </main>
<?php
}else{
  echo"<p>No se ha podido acceder al recurso<p>";
}

?>
