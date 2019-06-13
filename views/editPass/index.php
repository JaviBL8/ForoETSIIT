<?php
  require 'views/comun.php';

  HTMLHead("editstyle");
  HTMLHeader();
?>

<main class="editar-perfil">
  <?php echo "<p>" . $this->mensaje . "</p>";?>
  <form class="form-editar" action="<?php echo constant('URL');?>/editPass/editar" method="POST" onsubmit="return validarPassword();">
    <h2>Perfil</h2>

    <img class="fotoPerfil" src="<?php echo constant('IMG') ?>usuarios/<?php echo $this->user->dni ?>/echenique1.jpeg">

    <label>Introduce tu antigua contraseña:</label>
    <input type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" name="antigua" id="antigua">

    <label>Introduce tu nueva contraseña:</label>
    <input type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" name="nueva" id="nueva">

    <label>Confirma tu nueva contraseña:</label>
    <input type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" name="nueva2" id="nueva2">

    <input class="button" type="submit" value="Guardar">
  </form>
</main>

<?php  HTMLFooter(); ?>