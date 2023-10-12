<?php
require_once("../inc/inicios_sesion.php");
require_once("main.php");

if (isset($_POST["usuario_id"])) {

    $id = limpiar_cadena($_POST["usuario_id"]);

    //Verificación de usuario 

    $check_usuario = conexionBD();
    $check_usuario = $check_usuario->query("SELECT * FROM usuario WHERE ID_USU = '$id'");

    if ($check_usuario->rowCount() <= 0) {
        echo '
        <div class="notification is-danger is-light mb-6 mt-6">
            <strong>Ocurrió un error inesperado!</strong>
            USUARIO NO EXISTENTE.
        </div>
            ';
        exit();
    } else {
        $datos_usuario = $check_usuario->fetch();
    }
    $check_usuario = null;

    $admin_usuario = limpiar_cadena($_POST["administrador_usuario"]);
    $admin_clave = limpiar_cadena($_POST["administrador_clave"]);

    if ($admin_usuario == "" || $admin_clave == "") {
        echo '
        <div class="notification is-danger is-light mb-6 mt-6">
            <strong>Ocurrió un error inesperado!</strong>
            NO HAS LLENADO LOS CAMPOS OBLIGATORIOS
        </div>
            ';
        exit();
    }

    #verificando integridad de la información con expresiones regulares

    if (verificar_datos("[a-zA-Z0-9]{4,20}", $admin_usuario)) {
        echo '
        <div class="notification is-danger is-light mb-6 mt-6">
            <strong>Ocurrió un error inesperado!</strong>
            FORMATO DE USUARIO NO VÁLIDO.
        </div>
            ';
        exit();
    }

    if (verificar_datos("[a-zA-Z0-9.-]{7,100}", $admin_clave)) {
        echo '
        <div class="notification is-danger is-light mb-6 mt-6">
            <strong>Ocurrió un error inesperado!</strong>
            LA CLAVE NO CUMPLE CON EL FORMATO SOLICITADO.
        </div>
            ';
        exit();
    }

    #verificando existencia de administrador

    $check_admin = conexionBD();
    $check_admin = $check_admin->query("SELECT USUARIO, CLAVE FROM 
    usuario WHERE USUARIO = '$admin_usuario' AND ID_USU = '" . $_SESSION["id"] . "'");

    if ($check_admin->rowCount() == 1) {
        $check_admin = $check_admin->fetch();

        if ($check_admin["USUARIO"] != $admin_usuario || !password_verify($admin_clave, $check_admin["CLAVE"])) {
            echo '
            <div class="notification is-danger is-light mb-6 mt-6">
                <strong>Ocurrió un error inesperado!</strong>
                CREDENCIALES DE ADMINISTRADOR INCORRECTAS
            </div>
                ';
            exit();
        }
    } else {
        echo '
        <div class="notification is-danger is-light mb-6 mt-6">
            <strong>Ocurrió un error inesperado!</strong>
            ERROR, ADMINISTRADOR NO EXISTENTE.
        </div>
            ';
        exit();
    }
    $check_admin = null;

    #captura de datos del formulario de actualización de usuario user_update.php (vista)
    $nombre = limpiar_cadena($_POST["usuario_nombre"]);
    $apellido = limpiar_cadena($_POST["usuario_apellido"]);

    $usuario = limpiar_cadena($_POST["usuario_usuario"]);
    $email = limpiar_cadena($_POST["usuario_email"]);

    $clave = limpiar_cadena($_POST["usuario_clave1"]);
    $clave_confirmar = limpiar_cadena($_POST["usuario_clave2"]);

    #verificando campos obligatorios

    if ($nombre == "" || $apellido == "" || $usuario == "") {
        echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    No has llenado todos los campos que son obligatorios
                </div>
            ';
        exit();
    }

    #verificando integridad de la información con expresiones regulares => NOMBRE

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
        echo '
        <div class="notification is-danger is-light mb-6 mt-6">
            <strong>Ocurrió un error inesperado!</strong>
            FORMATO DE NOMBRE NO VÁLIDO.
        </div>
            ';
        exit();
    }

    #verificando integridad de la información con expresiones regulares => APELLIDO

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
        echo '
        <div class="notification is-danger is-light mb-6 mt-6">
            <strong>Ocurrió un error inesperado!</strong>
            FORMATO DE APELLIDO NO VÁLIDO.
        </div>
            ';
        exit();
    }

    #verificando integridad de la información con expresiones regulares => USUARIO

    if (verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
        echo '
        <div class="notification is-danger is-light mb-6 mt-6">
            <strong>Ocurrió un error inesperado!</strong>
            FORMATO DE USUARIO NO VÁLIDO.
        </div>
            ';
        exit();
    }

    #verificacion de email

    if ($email != "" && $email != $datos_usuario["MAIL"]) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $check_mail = conexionBD();
            $check_mail = $check_mail->query("SELECT MAIL FROM usuario WHERE MAIl = '$email'");
            if ($check_mail->rowCount() > 0) {
                echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    EL CORREO ELECTRÓNICO YA ESTÁ REGISTRADO.
                </div>
                ';
                exit();
            }
            $check_mail = null;
        } else {
            echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    EL CORREO ELECTRÓNICO NO ES VÁLIDO.
                </div>
                ';
            exit();
        }
    }

    # verificación de usuario válido y diferente de los registrados en la BD
    if ($usuario != $datos_usuario["USUARIO"]) {
        $check_usuario = conexionBD();
        $check_usuario = $check_usuario->query("SELECT USUARIO FROM usuario WHERE USUARIO = '$usuario';");
        if ($check_usuario->rowCount() > 0) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    EL USUARIO YA ESTÁ REGISTRADO.
                </div>
                ';
            exit();
        }
        $check_usuario = null;
    }

    #verificacion de claves

    if ($clave != "" || $clave_confirmar != "") {
        # code...
        if (verificar_datos("[a-zA-Z0-9.-]{7,100}", $clave) || verificar_datos("[a-zA-Z0-9.-]{7,100}", $clave_confirmar)) {
            echo '
                    <div class="notification is-danger is-light">
                        <strong>Ocurrió un error inesperado!</strong><br>
                        LAS CLAVES NO CUMPLEN CON EL FORMATO SOLICITADO
                    </div>
                    ';
            exit();
        } else {
            if ($clave != $clave_confirmar) {
                echo '
                    <div class="notification is-danger is-light">
                        <strong>Ocurrió un error inesperado!</strong><br>
                        LAS CLAVES NO COINCIDEN.
                    </div>
                    ';
                exit();
            } else {
                $clave_final = password_hash($clave, PASSWORD_BCRYPT, ["cost" => 10]);
            }
        }
    } else {
        $clave_final = $datos_usuario["CLAVE"];
    }

    #actualizacion de datos

    $actualizar = conexionBD();
    $actualizar = $actualizar->prepare("UPDATE usuario SET 
        NOM_USU=:nombre,
        APE_USU=:apellido,
        USUARIO=:usuario,
        CLAVE=:clave_final,
        MAIL=:email
        WHERE ID_USU =:id;
    ");
    $marcadores = [
        ":nombre" => $nombre,
        ":apellido" => $apellido,
        ":usuario" => $usuario,
        ":clave_final" => $clave_final,
        ":email" => $email,
        ":id" => $id
    ];
    if ($actualizar->execute($marcadores)) {
        # code...
        echo '
            <div class="notification is-info is-light">
                <strong>MENSAJE DEL SISTEMA</strong><br>
                USUARIO ACTUALIZADO CON ÉXITO.
            </div>
            ';
    } else {
        # code...
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                NO SE PUDO ACTUALIZAR EL USUARIO
            </div>
            ';
    }

    $actualizar = null;
}
