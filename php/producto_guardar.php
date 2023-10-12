<?php
    require_once("main.php");
    require_once("../inc/inicios_sesion.php");

    #capturando datos
    $codigo_producto = limpiar_cadena($_POST["producto_codigo"]);
    $nombre_producto = limpiar_cadena($_POST["producto_nombre"]);
    $precio_producto = limpiar_cadena($_POST["producto_precio"]);
    $stock_producto = limpiar_cadena($_POST["producto_stock"]);
    $categoria_producto = limpiar_cadena($_POST["producto_categoria"]);

    if($codigo_producto == "" || $nombre_producto == "" || $precio_producto == "" || $stock_producto == "" || $categoria_producto == ""){
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocurrió un error inesperado!</strong><br>
            TODOS LOS CAMPOS DEL FORMULARIO SON OBLIGATORIOS.
        </div>
        ';
        exit();
    }

    #VERIFICANDO INTEGRIDAD DE LOS DATOS

    if (verificar_datos("[a-zA-Z0-9- ]{1,70}", $codigo_producto)) {
        echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    EL CÓDIGO DEL PRODUCTO NO CUMPLE CON EL FORMATO SOLICITADO
                </div>
                ';
        exit();
    }

    if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $nombre_producto)) {
        echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    EL NOMBRE DEL PRODUCTO NO CUMPLE CON EL FORMATO SOLICITADO
                </div>
                ';
        exit();
    }

    if (verificar_datos("[0-9.]{1,25}", $precio_producto)) {
        echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    EL PRECIO DEL PRODUCTO NO CUMPLE CON EL FORMATO SOLICITADO
                </div>
                ';
        exit();
    }

    if (verificar_datos("[0-9]{1,25}", $stock_producto)) {
        echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    EL STOCK DEL PRODUCTO NO CUMPLE CON EL FORMATO SOLICITADO
                </div>
                ';
        exit();
    }

    # verificando registros existentes de los códigos de productos

    $check_codigo = conexionBD();
    $check_codigo = $check_codigo->query("SELECT COD_PRO FROM productos WHERE COD_PRO = '$codigo_producto';");
    if ($check_codigo->rowCount() > 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                EL CÓDIGO DE PRODUCTO YA EXISTE, INTENTAR CON OTRO.
            </div>
            ';
        exit();
    }
    $check_codigo = null;

    # verificando registros existentes de los nombres de productos

    $check_nombre = conexionBD();
    $check_nombre = $check_nombre->query("SELECT NOM_PRO FROM productos WHERE NOM_PRO = '$nombre_producto';");
    if ($check_nombre->rowCount() > 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                EL NOMBRE DEL PRODUCTO YA EXISTE, INTENTAR CON OTRO.
            </div>
            ';
        exit();
    }
    $check_nombre = null;

    # verificando categorías

    $check_categoria = conexionBD();
    $check_categoria = $check_categoria->query("SELECT ID_CAT FROM categorias WHERE ID_CAT  = '$categoria_producto';");
    if ($check_categoria->rowCount() <= 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                LA CATEGORIA DEL PRODUCTO NO EXISTE.
            </div>
            ';
        exit();
    }
    $check_categoria = null;

    # directorio de imágenes
    $img_dir = "../img/producto/";

    # comprobacion si una imagen fue seleccionada para subir

    if($_FILES["producto_foto"]["name"] != "" && $_FILES["producto_foto"]["size"] > 0){
        
        #creando directorio para imágenes de productos
        if(!file_exists($img_dir)){
            if(!mkdir($img_dir, 0777)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>Ocurrió un error inesperado!</strong><br>
                        EL DIRECTORIO NO PUDO SER CREADO.
                    </div>
                ';
                exit();
            }
        }

        #verificando formato admitido de imágenes
        if(mime_content_type($_FILES["producto_foto"]["tmp_name"]) != "image/jpeg" &&
        mime_content_type($_FILES["producto_foto"]["tmp_name"]) != "image/png"){
            echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                EL FORMATO DE LA IMAGEN SELECCIONADA, NO ES VÁLIDA.
            </div>
            ';
            exit();
        }

        #verificando el tamaño de la imagen
        if($_FILES["producto_foto"]["size"]/1024 > 3072){
            echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                EL TAMAÑO DE LA IMAGEN, SUPERÓ EL LÍMITE PERMITIDO.
            </div>
            ';
            exit();
        }

        #extension de la imagen
        switch(mime_content_type($_FILES["producto_foto"]["tmp_name"])){
            case "image/jpeg":
                $img_ext = ".jpg";
            break;
            case "image/png":
                $img_ext = ".png";
            break;
        }

        chmod($img_dir,0777);
        $img_nombre = renombrar_fotos($nombre_producto);
        $foto = $img_nombre.$img_ext;

        #moviendo imagen al servidor

        if(!move_uploaded_file($_FILES["producto_foto"]["tmp_name"],$img_dir.$foto)){
            echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    LA IMAGEN NO PUDO SER CARGADA EN EL SERVIDOR.
                </div>
                ';
            exit();
        }
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                PARA REGISTRAR EL PRODUCTO, DEBE CARGAR UNA IMAGEN
            </div>
        ';
        exit();
        $foto = "";
    }

    #guardando producto

    $guardar_producto = conexionBD();
    $guardar_producto = $guardar_producto->prepare
    ("INSERT INTO productos (COD_PRO, NOM_PRO, PRE_PRO, STOCK, IMG_PRO, ID_CAT, ID_USU)
    VALUES (:codigo, :nombre, :precio, :stock, :imagen, :categoria, :usuario)");

    $marcadores = 
    [
        ":codigo" => $codigo_producto,
        ":nombre" => $nombre_producto,
        ":precio" => $precio_producto,
        ":stock" => $stock_producto,
        ":imagen" => $foto,
        ":categoria" => $categoria_producto,
        ":usuario" => $_SESSION["id"]
    ];

    $guardar_producto->execute($marcadores);

    if ($guardar_producto->rowCount() == 1) {
        echo '
            <div class="notification is-info is-light">
                <strong>USUARIO REGISTRADO</strong><br>
                PRODUCTO REGISTRADO CON ÉXITO.
            </div>
            ';
    } else {
        if(is_file($img_dir.$foto)){
            chmod($img_dir.$foto,0777);
            unlink($img_dir.$foto);
        }
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                EL PRODUCTO NO PUDO SER REGISTRADO.
            </div>
            ';
    }
    $guardar_producto = null;

?>