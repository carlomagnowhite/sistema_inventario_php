<?php
require_once("main.php");

if (isset($_POST["categoria_nombre"]) && isset($_POST["categoria_ubicacion"])) {
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
        $enviar_categoria = conexionBD();
        $enviar_categoria = $enviar_categoria->prepare("INSERT INTO categorias
            (NOM_CAT,UBI_CAT) VALUES (:nombre_categoria,:ubicacion_categoria);");
        $marcadores = [
            ":nombre_categoria" => $cat_nombre,
            ":ubicacion_categoria" => $cat_ubicacion
        ];

        $enviar_categoria->execute($marcadores);

        if ($enviar_categoria->rowCount() == 1) {
            echo '
            <div class="notification is-info is-light">
                <strong>REGISTRO EXITOSO!</strong><br>
                CATEGORIA REGISTRADA CON ÉXITO.
            </div>
            ';
        } else {
            echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                ERROR AL ENVIAR EL REGISTRO.
                NO SE PUDO COMPLETAR LA PETICIÓN.
            </div>
            ';
        }
        $enviar_categoria = null;
    }
    $check_nom_cat = null;
}
