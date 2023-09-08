<?php
    require_once("./php/main.php");
    #captura de datos
    $usuario = limpiar_cadena($_POST["login_usuario"]);
    $clave = limpiar_cadena($_POST["login_password"]);

    #verificacion de datos

    if($usuario == "" || $clave == ""){
        echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    CAMPOS VACÍOS.
                </div>
                ';
        exit();
    }

    #VERIFICANDO INTEGRIDAD DE LA INFORMACION CON EXPRESIONES REGULARES

    if (verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
        echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    EL USUARIO NO CUMPLE CON EL FORMATO SOLICITADO
                </div>
                ';
        exit();
    }

    if (verificar_datos("[a-zA-Z0-9.-]{7,100}",$clave)) {
        echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    LA CLAVE NO CUMPLE CON EL FORMATO SOLICITADO
                </div>
                ';
        exit();
    }

    $check_user = conexionBD();
    $check_user = $check_user->query("SELECT * FROM usuario WHERE USUARIO = '$usuario'");

    if($check_user->rowCount() == 1){
        $check_user = $check_user->fetch();
        if($check_user["USUARIO"] == $usuario && password_verify($clave,$check_user["CLAVE"])){
            
            $_SESSION["id"] = $check_user["ID_USU"];
            $_SESSION["nombre"] = $check_user["NOM_USU"];
            $_SESSION["apellido"] = $check_user["APE_USU"];
            $_SESSION["usuario"] = $check_user["USUARIO"];

            if(headers_sent()){
                echo "<script> window.location.href='index.php?vista=home' </script>";
            }else{
                header("Location: index.php?vista=home");
            }
        }else{

            echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                USUARIO O CLAVE INCORRECTAS.
            </div>
            ';
        }
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                USUARIO O CLAVE INCORRECTAS.
            </div>
            ';
    }
    $check_user == null;
?>