<?php
    require_once("./php/main.php");
    $id = (isset($_GET["user_id_up"])) ? $id = $_GET["user_id_up"] : 0;
    $id = limpiar_cadena($id);
?>
<div class="container is-fluid mb-6">
    <?php
        if($id == $_SESSION["id"]){
    ?>
            <h1 class="title">Mi Cuenta</h1>
            <h2 class="subtitle">Actualizar mis datos</h2>
    <?php
        }else{
    ?>
            <h1 class="title">Usuarios</h1>
            <h2 class="subtitle">Actualizar datos</h2>
    <?php
        }
    ?>

</div>

<div class="container pb-6 pt-6">
    
    <?php
        include("./inc/btn_back.php");

        $check_usuario = conexionBD();
        $check_usuario = $check_usuario->query("SELECT * FROM usuario WHERE ID_USU = '$id'");

        if($check_usuario->rowCount() > 0){
            $datos = $check_usuario->fetch();
    ?>

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/usuario_actualizar.php" method="POST" class="FormAjax" autocomplete="off">
        
        <input type="hidden" value="<?php echo $datos["ID_USU"]?>" name="usuario_id" required>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombres</label>
                    <input type="text" value="<?php echo $datos["NOM_USU"]?>" class="input" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Apellidos</label>
                    <input type="text" value="<?php echo $datos["APE_USU"]?>" class="input" name="usuario_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Usuario</label>
                    <input class="input" value="<?php echo $datos["USUARIO"]?>" type="text" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Email</label>
                    <input class="input" value="<?php echo $datos["MAIL"]?>" type="email" name="usuario_email" maxlength="70">
                </div>
            </div>
        </div>
        <br><br>

        <p class="has-text-centered">
            Si desea actualizar la clave del usuario, llenar los 2 campos a continuación.
        </p>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Clave</label>
                    <input class="input" type="password" name="usuario_clave1" pattern="[a-zA-Z0-9.-]{7,100}" maxlength="100">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Confirmar Clave</label>
                    <input class="input" type="password" name="usuario_clave2" pattern="[a-zA-Z0-9.-]{7,100}" maxlength="100">
                </div>
            </div>
        </div>
        <br><br><br>
        <p class="has-text-centered">
            Para poder actualizar los datos del usuario, verifique que es usted.
        </p>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Usuario</label>
                    <input class="input" type="text" name="administrador_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Clave</label>
                    <input class="input" type="password" name="administrador_clave" pattern="[a-zA-Z0-9.-]{7,100}" maxlength="100" required>
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-success is-rounded">Actualizar</button>
        </p>
    </form>
        
    <?php
        }else{
            include("./inc/error_alert.php");
        }
        $check_usuario = null;
    ?>



</div>