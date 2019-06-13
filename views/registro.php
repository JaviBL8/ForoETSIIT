

    <main class='registro'>
     <?php echo "<p>" . $this->mensaje . "</p>" ?>

    <form action="<?php echo constant('URL');?>/registro/registrar" class='form-registro' method='POST' onsubmit="return validarRegistro();">
        <h2>Registro</h2>

        <label>Nombre:</label>
        <input id="nombre" name="nombre" type="text" pattern="^[a-zA-Z-ñÑçÇ-0-9-_\.]{1,20}$" placeholder="Nombre" >

        <label>Apellidos:</label>
        <input id="apellidos" name="apellidos" type="text" pattern="[A-Za-z- -áéíóú]{1,32}" placeholder="Apellidos" >

        <label>E-mail:</label>
        <input id="email" name="email" type="email" placeholder="mail@ejemplo.algo" >

        <label>Dirección:</label>
        <input id="direccion" name="direccion" type="text" placeholder="Dirección" >

        <label>Teléfono:</label>
        <input id="telefono" name="telefono" type="number" placeholder="Teléfono" >

        <label>Rol:</label>
        <select class="" id="rol" name="rol">
          <option value="0">Colaborador</option>
          <?php
            if($_SESSION['rol']=='1'){
              echo "<option value='1'>Administrador</option>";
            }
          ?>
         <!--  <option value="1">Administrador</option> -->
        </select>

        <label>Contraseña:</label>
        <input id="contrasena" name="contrasena" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" placeholder="Contraseña" 
          oninvalid="setCustomValidity('La contraseña debe incluir una mayúscula, una minúscula y un número')" oninput="setCustomValidity('')">

        <label>Repite la contraseña:</label>
        <input id="contrasena2" name="contrasena2" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" placeholder="Contraseña" 
          oninvalid="setCustomValidity('La contraseña debe incluir una mayúscula, una minúscula y un número')" oninput="setCustomValidity('')">

        <label>DNI:</label>
        <input name="dni" name="dni" type="text" pattern="[A-Za-z0-9]{1,15}" placeholder="DNI" 
          oninvalid="setCustomValidity('Introduzca un dni del formato 00000000A')" oninput="setCustomValidity('')">

        <input class="button" type="submit" value="Registrarse">
    </form>
</main>
