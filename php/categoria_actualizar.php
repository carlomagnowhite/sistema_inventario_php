<?php

    require_once("main.php");

    $id = limpiar_cadena($_POST["categoria_id"]);

    //Verificación de usuario 

    $check_categoria = conexionBD();
    $check_categoria = $check_categoria->query("SELECT * FROM categorias WHERE ID_CAT = '$id'");

    if ($check_categoria->rowCount() <= 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                CATEGORIA NO EXISTENTE EN EL SISTEMA.
            </div>
                ';
        exit();
    } else {
        $datos_categoria = $check_categoria->fetch();
    }

    $check_categoria = null;

    $cat_nombre = limpiar_cadena($_POST["categoria_nombre"]);
    $cat_ubicacion = limpiar_cadena($_POST["categoria_ubicacion"]);

    #verificando información

    if ($cat_nombre == "") {
        echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    EL NOMBRE DE LA CATEGORÍA ES OBLIGATORIO.
                </div>
                ';
        exit();
    }

    if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}", $cat_nombre)) {
        echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    NOMBRE DE CATEGORIA NO VÁLIDO.
                </div>
                ';
        exit();
    }

    if ($cat_ubicacion != "") {
        if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}", $cat_ubicacion)) {
            echo '
                    <div class="notification is-danger is-light">
                        <strong>Ocurrió un error inesperado!</strong><br>
                        UBICACIÓN DE CATEGORÍA NO VÁLIDO.
                    </div>
                    ';
            exit();
        }
    }

    if ($cat_nombre != $datos_categoria["NOM_CAT"]) {
        $check_nom_cat = conexionBD();
        $check_nom_cat = $check_nom_cat->query("SELECT * FROM categorias WHERE NOM_CAT = '$cat_nombre'");

        if ($check_nom_cat->rowCount() > 0) {
            echo '
                    <div class="notification is-danger is-light">
                        <strong>Ocurrió un error inesperado!</strong><br>
                        LA CATEGORÍA YA EXISTE.
                    </div>
                    ';
            exit();
        } else {

            #actualizacion de datos

            $actualizar = conexionBD();
            $actualizar = $actualizar->prepare("UPDATE categorias SET 
                NOM_CAT=:nombre,
                UBI_CAT=:ubicacion
                WHERE ID_CAT=:id;
            ");
            $marcadores = [
                ":nombre" => $cat_nombre,
                ":ubicacion" => $cat_ubicacion,
                ":id" => $id
            ];
            if ($actualizar->execute($marcadores)) {
                # code...
                echo '
                <div class="notification is-info is-light">
                    <strong>MENSAJE DEL SISTEMA</strong><br>
                    CATEGORIA ACTUALIZADA CON ÉXITO.
                </div>
                ';
            } else {
                # code...
                echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    NO SE PUDO ACTUALIZAR LA CATEGORIA
                </div>
                ';
            }

            $actualizar = null;
        }
        $check_nom_cat = null;
    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocurrió un error inesperado!</strong><br>
            LA CATEGORIA NUEVA DEBE SER DIFERENTE A LA ACTUAL
        </div>
        ';
    }
?>
