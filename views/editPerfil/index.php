<?php
  require 'views/comun.php';

  HTMLHead("editstyle");
  HTMLHeader();
?>

<main class="editar-perfil">
  <?php echo "<p>" . $this->mensaje . "</p>";?>
  <form class="form-editar" enctype="multipart/form-data" action="<?php echo constant('URL');?>/editPerfil/editar" method="POST" onsubmit="return validarEditar();">

      <h2>Perfil</h2>
      
      <?php $imgPerfil=constant('IMG'). "usuarios/". $_SESSION['usuario'] ."/". $_SESSION['img']; ?>
      <img class='fotoPerfil' src='<?php echo $imgPerfil ?>'>
      <input type="file" name="img" value="">

      <label>Nombre:</label>
      <input type='text' id='nombre' name='nombre' placeholder='<?php echo $this->user->nombre ?>'>

      <label>Apellidos:</label>
      <input type='text' id='apellidos' name='apellidos' placeholder='<?php echo $this->user->apellidos ?>'>

      <label>E-mail:</label>
      <input type='text' id='email' name='email' placeholder='<?php echo $this->user->email ?>'>

      <label>Dirección:</label>
      <input type='text' id='direccion' name='direccion' placeholder='<?php echo $this->user->direccion ?>'>

      <input class="button" type="submit" value="Guardar">
  </form>
</main>

<?php HTMLFooter();?>
