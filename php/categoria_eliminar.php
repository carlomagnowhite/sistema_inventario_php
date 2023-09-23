<?php
    $categoria_id = limpiar_cadena($_GET["category_id_del"]);

    $check_cat = conexionBD();
    $check_cat = $check_cat->query("SELECT * FROM categorias WHERE ID_CAT = '$categoria_id';");

    if($check_cat->rowCount() == 1){
        //verificación de productos existentes en la categoria
        $check_productos = conexionBD();
        $check_productos = $check_productos->query("SELECT ID_CAT FROM productos WHERE ID_CAT = '$categoria_id' LIMIT 1;");

        if ($check_productos->rowCount() <= 0) {
            # code...
            $eliminar_categoria = conexionBD();
            $eliminar_categoria = $eliminar_categoria->prepare("DELETE FROM categorias WHERE ID_CAT = :id_cat;");
            $eliminar_categoria->execute([":id_cat"=>$categoria_id]);

            if ($eliminar_categoria->rowCount()==1) {
                # code...
                echo '
                <div class="notification is-info is-light">
                    <strong>Mensaje del Sistema</strong><br>
                    Categoría eliminada con éxito.
                </div>
                ';
            } else {
                # code...
                echo '
                <div class="notification is-danger is-light">
                    <strong>Ocurrió un error inesperado!</strong><br>
                    LA CATEGORIA NO PUDO SER ELIMINADA. INTENTE MÁS TARDE.
                </div>
                ';
            }
            $eliminar_categoria = null;
        } else {
            # code...
            echo '
            <div class="notification is-danger is-light">
                <strong>Ocurrió un error inesperado!</strong><br>
                LA CATEGORIA NO PUEDE SER ELIMINADA, PORQUE TIENE PRODUCTOS EXISTENTES.
            </div>
            ';
            exit();
        }
        

        $check_productos = null;
    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocurrió un error inesperado!</strong><br>
            CATEGORIA NO EXISTENTE.
        </div>
        ';
    }
    $check_cat = null;
?>