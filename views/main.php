<main class="principal">
  <form action="<?php echo constant('URL');?>/main/busqueda" class="busqueda" method="POST" onsubmit="return validarBusqueda();">
    <div class="busqueda-A">
      <div class="busqueda-A1">
        <input id="palabrasClave" name="palabrasClave" type="text" placeholder="Palabra">
        <input id="localizacion" name="localizacion" type="text" placeholder="Localización">
        <select name="orden" id="orden">
          <option value="0">Más nuevas</option>
          <option value="1">Más antiguas</option>
          <option value="2">Más vistas</option>
        </select>

        <div class="busqueda-B">
          <input id="buscar" type="submit" value="Buscar">
          <input id="reset" type="reset" value="Vaciar">
        </div>

      </div>

      <div class="busqueda-A2">

        <!-- Truquillo :-) -->
        <input name="estado0" value="0" type="hidden">
        <input name="estado1" value="0" type="hidden">
        <input name="estado2" value="0" type="hidden">
        <input name="estado3" value="0" type="hidden">
        <input name="estado4" value="0" type="hidden">
        <input type="hidden" name="estado5" value="0">

        <div class="elemento-A2">
          <input id="estado1" type="checkbox" name="estado0" value="1">
          <label>Comprobación</label>
        </div>
        <div class="elemento-A2">
          <input id="estado2" type="checkbox" name="estado1" value="1">
          <label>Comprobada</label>
        </div>
        <div class="elemento-A2">
          <input id="estado3" type="checkbox" name="estado2" value="1">
          <label>Tramitada</label>
        </div>
        <div class="elemento-A2">
          <input id="estado4" type="checkbox" name="estado3" value="1">
          <label>Irresoluble</label>
          </div>
        <div class="elemento-A2" >
          <input id="estado5" type="checkbox" name="estado4" value="1">
          <label>Resoluble</label>
        </div>
<?php
    if(isset($_SESSION['usuario'])){
      if($_SESSION['usuario']!=""){
?>
        <div class="elemento-A2" >
          <input id="estado6" type="checkbox" name="estado5" value="1">
          <label>Mis incidencias</label>
        </div>
<?php
      }
    }
?>
      </div>
    </div>

<?php
if(isset($_SESSION['usuario'])) {
  echo <<< HTML
    <div class="imagenEscribir">
HTML;
      echo"<a id='escribir' href='". constant('URL') ."/nuevaIncidencia'><img src='". constant('IMG') ."nuevo.png' alt='Escribir incidencia' width='50' height='50'></a>";
    echo <<< HTML
      <label id="escribe">Escribe un nuevo Post</label>
    </div>
HTML;
}
?>
    </form>

    <div class="quejas">
<?php

      $primero=isset($_GET['primero'])? $_GET['primero'] : 0;

      if(!is_numeric($primero) || $primero<0)
        $primero=0;

      $numitems=5;

      foreach($this->incidencias as $row){

        //Se comprueba di el usuario es anónimo
      /*  if(empty($_SESSION['usuario'])){
          setcookie('contador', $_COOKIE['contador'] + 1, time() + 365 * 24 * 60 * 60);
        }*/
?>
          <article class="Queja">
            <div class="tituloQueja">
<?php
              echo '<a class="queja-A" href="'. constant("URL") .'/visita?id='. $row->idIncidencia .'"><h1>'. $row->titulo .'</h1></a>';
?>
              <div class="estadoQueja">

              <img src='<?php echo constant('IMG') ?>exclamacion.png' height='25' width='25'>

<?php
              switch ($row->estado) {
                case '0':
                  $estado="Comprobación";
                break;

                case '1':
                  $estado="Comprobada";
                break;

                case '2':
                  $estado="Tramitada";
                break;

                case '3':
                  $estado="Irresoluble";
                break;

                case '4':
                  $estado="Resoluble";
                break;

                default:
                  $estado="No se sabe";
                break;
              }
?>
              <h2><?php echo $estado ?></h2>
              </div>
            </div>

            <div class="datosQueja">

              <div class="lugarQueja">
                <label class="labeldato">Lugar:</label>
                <p class='lugar'><?php echo $row->localizacion?></p>
              </div>

              <div class="fechaQueja">
                <label class="labeldato">Fecha y hora:</label>
                <p class='fecha'><?php echo $row->fecha ?></p>
              </div>

              <div class="creadorQueja">
                <label class="labeldato">Creador:</label>
                <p class='creador'><?php echo $row->dni ?></p>
              </div>

              <div class="claveQueja">
                <label class="labeldato">Tags:</label>
                <p class='clave'><?php echo $row->palabrasClave?></p>
              </div>

            </div>

          <p class='descripcionQueja'><?php echo $row->descripcion ?></p>
            <div class="imagenesQueja">

<?php
// Inclusión dinámica de las fotos

          $fotos = [];
          $directorio = "public/img/incidencias/" . $row->idIncidencia ."/*";
          $total_imagenes = count(glob($directorio,GLOB_BRACE));
          $directorio = "public/img/incidencias/" . $row->idIncidencia . "/";
          if(file_exists($directorio)){
            $ficheros  = scandir($directorio, 1);
            for ($i=0; $i < $total_imagenes ; $i++) {
              echo "<img src='" . constant('IMG') . "incidencias/" . $row->idIncidencia . '/'. $ficheros[$i] ."'alt='Ruta mal'>";
            }
            if($total_imagenes==0){
              echo "<p>Todavía no hay imágenes añadidas </p>";
            }
          }else{
            echo "<p>Todavía no hay imágenes añadidas </p>";
          }


// Fin inclusión de fotos
?>

            </div>

            <div class="comentariosQueja">
<?php
            include_once "libs/coment.php";
              $i=0;
              foreach($row->comentarios as $coment2){
                $coment = new Coment();
                $coment = $coment2;
                  echo"<div class='comentario'>";
                    echo "<p class='autorComentario'>". $coment->dni ." a las: ". $coment->fechaHora ."</p>";
                    echo "<p class='comentariotxt'>". $coment->contenido ."</p>";
                  echo "</div>";
                  $i=$i+1;
              }

          echo <<< HTML
            </div>

            <div class="botonesQueja">
HTML;
?>

          <form action="<?php echo constant('URL')?>/main/updateLike" class="btn" method="POST">
            <input name="idIncidencia" type=hidden value=<?php echo $row->idIncidencia?>/>
            <input type='image' src="<?php echo constant("IMG")?>/mas.png" alt="Submit" class="btnlike" name='like'/>
            <label><?php echo $row->likes;?></label>
          </form>

          <form action="<?php echo constant('URL')?>/main/updateDislike" class="btn" method="POST">
            <input name="idIncidencia" type=hidden value=<?php echo $row->idIncidencia ?>/>
            <input type='image' src="<?php echo constant("IMG")?>/minus.png" alt="Submit" class="btnlike" name='dislike'/>
            <label><?php echo $row->dislikes;?></label>
          </form>


            </div>

          </article>

<?php
      }

      if($this->busquedan==0){
        $ultima = ($this->numincidencia%$numitems) == 0 ? $this->numincidencia-$numitems :  ($this->numincidencia - ($this->numincidencia%$numitems));
        $anterior = ($primero-$numitems)<0 ? 0 : ($primero-$numitems);
        $siguiente = ($primero+$numitems)>=$this->numincidencia ? $ultima : ($primero+$numitems);

        echo "<div class='barra'>";
        echo '<a href="'. constant('URL') .'/main?primero='.$anterior.'"><img class="flecha1" src=' . constant('IMG') . 'izq.png width="50" height="50" alt="Ruta mal"></a>';
        echo '<a href="'. constant('URL') .'/main?primero='.$siguiente.'"><img class="flecha2" src=' . constant('IMG') . 'dcha.png width="50" height="50" alt="Ruta mal"></a>';
        echo "</div>";
}
      echo "</div>";
    echo <<< HTML
    <aside class="aside">
      <div class="lista" id="miperfil">
HTML;
      if(isset($_SESSION['rol'])){
        switch ($_SESSION['rol']) {
          case '0':
            $rol='Contribuyente';
            break;

          case '1':
            $rol='Administrador';
            break;
        }
      }else{
        $rol="Anonimo";
      }
        if(isset($_SESSION['usuario'])){
          echo "<h1>". $_SESSION['nombre'] ."</h1>";
          echo "<h2>". $rol ."</h2>";
          $imgPerfil=constant('IMG'). "usuarios/".$this->user->dni ."/".$this->user->img;
          echo '<a href="' . constant('URL') .  '/perfil" class="imagenperfil"><img class="fotoPerfil" src="'. $imgPerfil .'" alt="Ruta mal"></a>';
        }else{
          echo "<h1>Anonimo</h1>";
          echo "<h2>Visitante</h2>";
          echo '<a href="'. constant('URL') .'/registro" class="imagenperfil"><img class="fotoPerfil" src="' . constant('IMG') . 'echenique1.jpeg" alt="Ruta mal"></a>';
        }

    echo <<< HTML
      </div>

      <div class="lista">
        <h1>Mejores posts</h1>
        <ol>
HTML;
          foreach($this->query1 as $q1){
            echo '<a href="'. constant("URL") .'/visita?id='. $q1->idIncidencia .'"><li>'. $q1->titulo .'</li></a>';
          }
      echo <<< HTML
        </ol>
      </div>

      <div class="lista">
        <h1>Los que más añaden</h1>
        <ol>
HTML;

       foreach($this->query2 as $q2){
          echo"<li>". $q2 ."</li>";
        }

      echo <<< HTML
        </ol>
      </div>

      <div class="lista">
        <h1>Los que más comentan</h1>
        <ol>
HTML;
          foreach ($this->query3 as $q3) {
            echo "<li>". $q3 ."</li>";
          }
      echo <<< HTML
        </ol>
      </div>
    </aside>

  </main>
HTML;
?>
