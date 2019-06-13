<main class="nuevaQueja" >

  <p><?php echo $this->mensaje;?></p>
  <div class="nuevaINC">
    <form class="Queja" action="<?php echo constant('URL')?>/nuevaIncidencia/registrarIncidencia" method="POST" enctype="multipart/form-data" onsubmit="return validarIncidencia();">

      <div class="tituloQueja">
        <input id="titulo" name="titulo" type="text" placeholder="Título de la incidencia" required>
      </div>

      <div class="datosQueja">

        <div class="itemQueja">
          <label class="labeldato">Lugar:</label>
          <input id="localizacion" name="localizacion" class="lugar" placeholder="Lugar" required>
        </div>

        <div class="itemQueja">
          <label class="labeldato">Tags:</label>
          <input id="palabrasClave" name="palabrasClave" class="clave" placeholder="Tags" required>
        </div>

          <div class="itemQueja">
              <label class="labeldato">Descripción:</label>
          </div>

        <div class="itemQueja">
          <textarea id="descripcion" name="descripcion" id="descripcion" cols="30" rows="10" required></textarea>
        </div>

      </div>

      <div class="itemQueja">
          <input type="submit" placeholder="Registrar">
      </div>

    </form>
  </div>
</main>
