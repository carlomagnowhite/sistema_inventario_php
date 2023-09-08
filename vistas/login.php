<div class="main-container">
    <!--FORMULARIO DEL LOGIN START-->
    <form action="" method="post" class="box login" autocomplete="off" >
        <h5 class="title is-5 has-text-centered is-uppercase">Sistema de inventarios</h5>

        <div class="field">
            <label class="label">Usuario</label>
            <div class="control">
                <input type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" class="input" maxlength="20" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Contraseña</label>
            <div class="control">
                <input type="password" class="input" name="login_password" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
            </div>
        </div>

        <p class="has-text-centered mb-4 mt-3">
            <input type="submit" class="button is-info is-rounded" value="Iniciar ">
        </p>

        <?php
            if(isset($_POST["login_usuario"]) && isset($_POST["login_password"])){
                require_once("./php/main.php");
                require_once("./php/iniciar_sesion.php");
            }
        ?>
    </form>
    <!--FORMULARIO DEL LOGIN END-->
</div