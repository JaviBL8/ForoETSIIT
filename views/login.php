<main class="login">

<?php echo "<p>" . $this->mensaje ."</p>"?>

  <form action="<?php echo constant('URL');?>/login/signin" class="form-login" method="POST" onsubmit="return validarLogin();">
    <h2>Login</h2>

    <label>Usuario:</label>
    <input name="email" type="email" placeholder="mail@ejemplo.algo">

    <label>Contraseña:</label>
    <input name="password" type="password" placeholder="Contraseña">

    <button type="submit" >Entrar</button>
    <label id="registrate">¿Todavía no tienes una cuenta?</label>
    <a id='registrate' href="<?php echo constant('URL')?>/registro">Regístrate</a>

  </form>

</main>
