<main class="editarQueja" >
  <article class="Queja">
    <div class="tituloQueja">

    <form action="<?php echo constant('URL')?>/visita/editarIncidencia" method="POST" enctype="multipart/form-data" onsubmit="return validarIncidencia();">
  <?php
    if(!empty($_SESSION['rol']) && $_SESSION['rol']==1 || !empty($_SESSION['usuario']) && $_SESSION['usuario']==$this->incidencia->dni){
      echo "<div class=cabeceraI>";
      echo "<div class=tituloI>";
      echo "<h2>Titulo:</h2>";
      echo "<input name='titulo' class='titulo' placeholder='Título' value='".$this->incidencia->titulo."'>";
      echo "</div>";
    }else{
      echo "<h1>" . $this->incidencia->titulo . "</h1>";
    }

  echo '<div class="estadoQueja">';

  if(!empty($_SESSION['rol']) && $_SESSION['rol']==1){

    echo <<< HTML
    <div class="estadoI">
      <h2>Estado:</h2>
      <select name="orden" id="orden">
          <option value="0">Comprobación</option>
          <option value="1">Comprobada</option>
          <option value="2">Tramitada</option>
          <option value="3">Irresoluble</option>
          <option value="4">Resoluble</option>
        </select>
      </div>
    </div>
HTML;
  }else{
    switch ($this->incidencia->estado) {
      case '0':
        $estado="Comprobación";
      break;

      case '2':
        $estado="Comprobada";
      break;

      case '3':
        $estado="Tramitada";
      break;

      case '4':
        $estado="Irresoluble";
      break;

      case '5':
        $estado="Resoluble";
      break;

      default:
        $estado="No se sabe";
      break;
    }
    echo "<img src='" . constant('IMG') . "exclamacion.png' height='25' width='25'>";
    echo "<h2>" . $estado  . "</h2>";
  }
?>
        </div>
      </div>

        <div class="datosQueja">

          <div class="lugarQueja">
            <label class="labeldato">Lugar:</label>
            <?php
              if(!empty($_SESSION['rol']) && $_SESSION['rol']==1 || !empty($_SESSION['usuario']) && $_SESSION['usuario']==$this->incidencia->identificador){
                echo "<input name='lugar' class='lugar' placeholder='Localizacion' value='".$this->incidencia->localizacion."'>";
              }else{
                echo "<p class='lugar'> " . $this->incidencia->localizacion . "</p>";
              }
            ?>
          </div>

          <div class="fechaQueja">
            <label class="labeldato">Fecha:</label>
            <p class='fecha'><?php echo $this->incidencia->fecha?></p>
          </div>

          <div class="creadorQueja">
            <label class="labeldato">Creador:</label>
            <p class='creador'><?php echo $this->incidencia->dni ?></p>
          </div>

          <div class="claveQueja">
            <label class="labeldato">Tags:</label>
            <?php
              if(!empty($_SESSION['rol']) && $_SESSION['rol']==1 || !empty($_SESSION['usuario']) && $_SESSION['usuario']==$this->incidencia->identificador){
                echo "<input name='clave' class='clave' placeholder='palabrasClave' value='".$this->incidencia->palabrasClave."'>";
              }else{
                echo "<p class='clave'> "  . $this->incidencia->palabrasClave . "</p>";
              }
            ?>
          </div>

        </div>

        <?php
          if(!empty($_SESSION['rol']) && $_SESSION['rol']==1 || !empty($_SESSION['usuario']) && $_SESSION['usuario']==$this->incidencia->identificador){
            echo "<textarea name='descripcionQueja' class='descripcionQueja' placeholder='Descripcion'> ".$this->incidencia->descripcion ."</textarea>";
          }else{
            echo "<p class='descripcionQueja'> "  . $this->incidencia->descripcion . "</p>";
          }
        ?>
        <div class="imagenesQueja">
<?php
// Inclusión dinámica de las fotos
    $fotos = [];
    $directorio = "public/img/incidencias/" . $this->incidencia->idIncidencia ."/*";
    $total_imagenes = count(glob($directorio,GLOB_BRACE));
    $directorio =  "public/img/incidencias/" . $this->incidencia->idIncidencia . "/";
    if(file_exists($directorio)){
      $ficheros  = scandir($directorio, 1);
      for ($i=0; $i < $total_imagenes ; $i++) {
          echo "<img src='" . constant('IMG') . "incidencias/" . $this->incidencia->idIncidencia . '/'. $ficheros[$i] ."'alt='Ruta mal'>";
      }
      if($total_imagenes==0){
        echo "<p>Todavía no hay imágenes añadidas </p>";
      }
    }else{
      echo "<p style='color: red'>Todavía no hay imágenes añadidas </p>";
    }
?>
<!-- Fin inclusión de fotos -->
        </div>

        <div class="comentariosQueja">
          <?php
            $i=0;
            foreach($this->incidencia->comentarios as $coment2){
              $coment = new Coment();
              $coment = $coment2;
                echo"<div class='comentario'>";
                  echo "<p class='autorComentario'>". $coment->dni ." a las: ". $coment->fechaHora ."</p>";
                  echo "<p class='comentariotxt'>". $coment->contenido ."</p>";
                echo "</div>";
                $i=$i+1;
            }
          ?>

          <div class="escribe-comentario">
            <textarea class="textarea" name="comentario" placeholder="Escribe tu comentario..."></textarea>
          </div>

          <input type="hidden" value="<?php echo $this->incidencia->idIncidencia?>" name="idIncidencia" />
          <input type="hidden" value="<?php echo $this->dni?>" name="dni" />
        </div>

        <button type="submit" class='enviar'>Actualizar</button>
        </form>

<?php
  if(isset($_SESSION['usuario']))
    if($_SESSION['rol']=='1' || $_SESSION['usuario']==$this->incidencia->identificador){
?>
        <form class="imgAdd" action="<?php echo constant('URL')?>/visita/addImg" method="post" enctype="multipart/form-data">
          <input type="file"  name="foto" value="">
          <input type="hidden" name="id" value="<?php echo $this->incidencia->idIncidencia; ?>">
          <button type="submit" class="fotoadd" name="button">Añadir imagen</button>
        </form>
<?php } ?>
        <div class="botonesQueja">

          <img src="<?php echo constant('IMG') ?>mas.png"  height="20" width="20">
          <label class='like'><?php echo $this->incidencia->likes ?></label>

          <img src="<?php echo constant("IMG")?>minus.png" alt="Ruta mal" height="20" width="20">
          <label class='like'><?php echo $this->incidencia->dislikes ?></label>

          <img src="<?php echo constant("IMG") ?>comentar.png" alt="Ruta mal" height="20" width="20">
          <label class='like'><?php echo $this->incidencia->ncomentarios ?></label>

        </div>
  </article>
</main>
