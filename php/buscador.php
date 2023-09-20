    <?php
    $modulo_buscador = limpiar_cadena($_POST["modulo_buscador"]);

    $modulos = ["usuario", "categoria", "producto"];

    if (in_array($modulo_buscador, $modulos)) {
        $modulos_url=
        [
            "usuario" => "user_search",
            "categoria" => "category_search",
            "producto" => "product_search"
        ];
        $modulos_url = $modulos_url[$modulo_buscador];
        $modulo_buscador = "busqueda_".$modulo_buscador;

        //Se inicia la búsqueda
        
        if (isset($_POST["txt_buscador"])){
            $txt = limpiar_cadena($_POST["txt_buscador"]);
            
            if ($txt=="") {
                # code...
                echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    INGRESE UN TÉRMINO DE BÚSQUEDA
                </div>
                ';
            } else {
                if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}",$txt)) {
                    # code...
                    echo '
                    <div class="notification is-danger is-light">
                        <strong>Ocurrió un error inesperado!</strong><br>
                        EL TÉRMINO DE BÚSQUEDA NO COINCIDE CON EL FORMATO SOLICITADO
                    </div>
                    ';
                } else {
                    $_SESSION[$modulo_buscador] = $txt;
                    header("Location: index.php?vista=$modulos_url",true,303);
                    exit();
                }
                
            }
            
        }

        //Se elimina la busqueda

        if (isset($_POST["eliminar_buscador"])){
            unset($_SESSION[$modulo_buscador]);
            header("Location: index.php?vista=$modulos_url",true,303);
            exit();
        }

    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                NO SE PUEDE PROCESAR LA PETICIÓN
            </div>
        ';
    }
