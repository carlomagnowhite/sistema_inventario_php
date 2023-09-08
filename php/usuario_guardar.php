    <?php
    require_once("main.php");

    #captura de datos del formulario de registro de usuario user_new.php
    $nombre = limpiar_cadena($_POST["usuario_nombre"]);
    $apellido = limpiar_cadena($_POST["usuario_apellido"]);

    $usuario = limpiar_cadena($_POST["usuario_usuario"]);
    $email = limpiar_cadena($_POST["usuario_email"]);

    $clave = limpiar_cadena($_POST["usuario_clave1"]);
    $clave_confirmar = limpiar_cadena($_POST["usuario_clave2"]);

    #verificación de campos obligatorios

    if ($nombre == "" || $apellido == "" || $usuario == "" || $clave == "" || $clave_confirmar == "") {
        echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    No has llenado todos los campos que son obligatorios
                </div>
                ';
        exit();
    }

    #verificando integridad de la información con expresiones regulares

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚ]{3,40}", $nombre)) {
        echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    EL NOMBRE NO CUMPLE CON EL FORMATO SOLICITADO
                </div>
                ';
        exit();
    }

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚ]{3,40}", $apellido)) {
        echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    EL APELLIDO NO CUMPLE CON EL FORMATO SOLICITADO
                </div>
                ';
        exit();
    }

    if (verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
        echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    EL USUARIO NO CUMPLE CON EL FORMATO SOLICITADO
                </div>
                ';
        exit();
    }

    if (verificar_datos("[a-zA-Z0-9.-]{7,100}", $clave) || verificar_datos("[a-zA-Z0-9.-]{7,100}", $clave_confirmar)) {
        echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    LAS CLAVES NO CUMPLEN CON EL FORMATO SOLICITADO
                </div>
                ';
        exit();
    }

    # verificacion de que el correco eletrónico sea valido y diferente de los registrados en la BD
    if ($email != "") {
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

    #INSERCIÓN EN LA BD

    $insertar_registro = conexionBD();
    $insertar_registro = $insertar_registro->prepare(
        "INSERT INTO usuario(NOM_USU,APE_USU,USUARIO,CLAVE,MAIL) 
        VALUES (:nombre,:apellido,:usuario,:clave_final,:email);"
    );
    $marcadores = [
        ":nombre" => $nombre,
        ":apellido" => $apellido,
        ":usuario" => $usuario,
        ":clave_final" => $clave_final,
        ":email" => $email
    ];

    $insertar_registro->execute($marcadores);

    if ($insertar_registro->rowCount() == 1) {
        echo '
            <div class="notification is-info is-light">
                <strong>USUARIO REGISTRADO</strong><br>
                REGISTRO REALIZADO CON ÉXITO.
            </div>
            ';
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                EL USUARIO NO PUDO SER REGISTRADO.
            </div>
            ';
    }
    $insertar_registro = null;

