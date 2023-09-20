<?php

    $val_user = limpiar_cadena($_GET["user_id_del"]);

    // Verificacion de que el usuario exista en la BD

    $check_usuario = conexionBD();
    $check_usuario = $check_usuario->query("SELECT ID_USU FROM usuario WHERE ID_USU = '$val_user'");

    if ($check_usuario->rowCount() == 1) {
        # code...
        $check_producto = conexionBD();
        $check_producto = $check_producto->query("SELECT ID_USU FROM productos WHERE ID_USU = '$val_user' LIMIT 1");

        if ($check_producto->rowCount() <= 0) {
            # code...
            $eliminar_usuario = conexionBD();
            $eliminar_usuario = $eliminar_usuario->prepare("DELETE FROM usuario WHERE ID_USU = :id");

            /*this section is the same -> execute([":id"=>$val_user])
            $marcador = [
                ":id" => $val_user 
            ];
            */

            $eliminar_usuario->execute([":id"=>$val_user]);

            if($eliminar_usuario->rowCount() == 1){
                echo '
                <div class="notification is-info is-light">
                    <strong>Usuario Eliminado</strong><br>
                    Usuario eliminado con éxito
                </div>
                ';
            }else{
                echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    No se pudo eliminar el usuario, intentar de nuevo.
                </div>
                ';
            }
            $eliminar_usuario = null;
        } else {
            echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                El usuario agregó productos, por lo tanto, no puede ser eliminado.
            </div>
            ';
        }
        $check_usuario = null;
        $check_producto = null;

    } else {
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocurrió un error inesperado!</strong><br>
            El usuario no existe
        </div>
        ';
    }
    
?>