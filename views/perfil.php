<main class="registro">

        <div class="form-registro">

                <h2>Perfil</h2>

                <?php $imgPerfil=constant('IMG'). "usuarios/".$this->user->dni ."/".$this->user->img; ?>
                <img class='fotoPerfil' src='<?php echo $imgPerfil ?>'>

                <label>Nombre:</label>
                <p><?php echo $this->user->nombre ?></p>

                <label>Apellidos:</label>
                <p><?php echo $this->user->apellidos ?></p>

                <label>E-mail:</label>
                <p><?php echo $this->user->email ?></p>

                <label>Dirección:</label>
                <p><?php echo $this->user->direccion ?></p>

                <div class="editarBotones">
                        <a href="<?php echo constant('URL')?>/editPerfil" class="button" type="submit">Editar perfil</a>
                        <a href="<?php echo constant('URL')?>/editPass" class="button" type="submit">Editar contraseña</a>
                </div>

        </div>

</main>
