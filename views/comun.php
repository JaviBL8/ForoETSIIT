<?php
function HTMLHead($css){
  echo <<< HTML
  <!DOCTYPE html>
  <!-- Página de inicio de la librería  -->
    <html lang="es" dir="ltr">
    <head>
    <meta charset="utf-8">
    <title>Foro ETSIIT</title>
    <meta name="author" content="Humberto A. Iglesias González - Javier Bueno López">

HTML;
    echo "<link rel='stylesheet' type='text/css' href='" . constant('URL') . "/public/css/styles.css'>";
    echo "<link rel='stylesheet' type='text/css' href='" . constant('URL') . "/public/css/" . $css . ".css'>";

    echo <<< HTML
    </head>
    <body>
HTML;
}

function HTMLHeader (){
  echo <<< HTML
    <header class="titulo">
      <div class="header-A">

      <div class="header-imagen">
HTML;
    echo "<a href='". constant('URL') ."/main'> <img src='" . constant('IMG') . "etsiit.png' alt=''></a>";

    echo <<< HTML
        </div>

      <div class="header-titulo">
        <h1>Foro ETSIIT</h1>
      </div>

      <div class="header-redes">
HTML;

      echo "<img src='" . constant('IMG') . "facebook.png' alt=''>";
      echo "<img src='" . constant('IMG') . "instagram.png' alt=''>";
      echo "<img src='" . constant('IMG') . "mail.png' alt=''>";
      echo "<a href='https://twitter.com/bertoiglesias4'><img src='" . constant('IMG') . "twitter.png' alt=''></a>";

echo <<< HTML
      </div>

      </div>

      <div class="header-B">
        <nav class="menu">
HTML;
        echo "<a id='main' href=" . constant('URL') . "/main>Inicio</a>";
        if(!isset($_SESSION['usuario'])){
          echo "<a id='login' href=" . constant('URL') . "/login>Login</a>";
          echo "<a id='registro' href=" . constant('URL') . "/registro>Registro</a>";
        }else{
          if($_SESSION['rol']==1){
            echo "<a id='gestion' href=" . constant('URL') . "/usuarios>Gestion</a>";
            echo "<a id='log' href=" . constant('URL') . "/log>Log</a>";
            echo "<a id='log' href=" . constant('URL') . "/bbdd>BBDD</a>";
          }
          echo "<a id='perfil' href=" . constant('URL') . "/perfil?editar=no>Perfil</a>";
          echo "<a id='salir' href=" . constant('URL') . "/logout>Salir</a>";
        }

        echo <<< HTML
         </nav>
      </div>
    </header>
HTML;
}

function HTMLFooter(){
  echo <<< HTML
      <footer>
        <p class="primero">C/Periodista Daniel Saucedo Aranda, s/n · E-18071 GRANADA (Spain)</p>
HTML;
        echo "<a class='doc' href='". constant('URL') ."/public/documentacion.pdf'>Documentación de la entrega</a>";
        echo <<< HTML
        <div class="contactos">
          <p class="segundo">bertoig@correo.ugr.es</p>
          <p class="tercero">javibl8@correo.ugr.es</p>
        </div>

      </footer>
  </body>
</html>
HTML;
}
?>
