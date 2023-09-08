<?php
    #conexión a la BD
    function conexionBD(){
        $pdo = new PDO("mysql:host=localhost;dbname=inventario","root","");
        return $pdo;
    }
    #verificar datos de formulario
    function verificar_datos($filtro,$cadena){
        if (preg_match("/^$filtro$/",$cadena)) {
            return false;
        }else{
            return true;
        }
    }
    #evitar inyecciones SQL
    function limpiar_cadena($cadena){
        $cadena=trim($cadena);
        $cadena=stripslashes($cadena);
        $cadena=str_ireplace("<script>","",$cadena);
        $cadena=str_ireplace("</script>","",$cadena);
        $cadena=str_ireplace("<script src>","",$cadena);
        $cadena=str_ireplace("<script type=>","",$cadena);
        $cadena=str_ireplace("SELECT * FROM","",$cadena);
        $cadena=str_ireplace("DELETE FROM","",$cadena);
        $cadena=str_ireplace("INSERT INTO","",$cadena);
        $cadena=str_ireplace("DROP TABLE","",$cadena);
        $cadena=str_ireplace("DROP DATABASE","",$cadena);
        $cadena=str_ireplace("TRUNCATE TABLE","",$cadena);
        $cadena=str_ireplace("SHOW TABLES;","",$cadena);
        $cadena=str_ireplace("SHOW DATABASES;","",$cadena);
        $cadena=str_ireplace("<?php","",$cadena);
        $cadena=str_ireplace("?>","",$cadena);
        $cadena=str_ireplace("--","",$cadena);
        $cadena=str_ireplace("==","",$cadena);
        $cadena=str_ireplace("^","",$cadena);
        $cadena=str_ireplace("<","",$cadena);
        $cadena=str_ireplace("[","",$cadena);
        $cadena=str_ireplace("]","",$cadena);
        $cadena=str_ireplace(";","",$cadena);
        $cadena=str_ireplace("::","",$cadena);
        $cadena=trim($cadena);
        $cadena=stripslashes($cadena);
        return $cadena;
    }

    #funcion para renombrar fotos

    function renombrar_fotos($nombre){
        $nombre = str_ireplace(" ","_",$nombre);
        $nombre = str_ireplace("/","_",$nombre);
        $nombre = str_ireplace("#","_",$nombre);
        $nombre = str_ireplace("-","_",$nombre);
        $nombre = str_ireplace("$","_",$nombre);
        $nombre = str_ireplace(".","_",$nombre);
        $nombre = str_ireplace(",","_",$nombre);
        $nombre = $nombre."_".rand(0,100);
    }

    #funcion para paginar tablas
    ################################
    function paginar_tabla($pagina,$npaginas,$url,$botones){
        $tabla = '<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';
        ##boton anterior y primero
        if($pagina <= 1){
            $tabla.='
            <a disabled class="pagination-previous is-disabled">Anterior</a>
            <ul class="pagination-list">
            ';
        }else{
            $tabla.='
            <a href="'.$url.($pagina-1).'" class="pagination-previous ">Anterior</a>
            <ul class="pagination-list">
                <li><a href="'.$url.'1" class="pagination-link">1</a></li> 
                <li><span class="pagination-ellipsis">&hellip;</span></li>
            ';
        }
        #botones intermedios
        $ci = 0;
        
        for($i = $pagina; $i <= $npaginas; $i++){
            if($ci >= $botones){
                break;
            }
            if($pagina == $i){
                $tabla.='
                <li><a href="'.$url.$i.'" class="pagination-link is-current">'.$i.'</a></li> 
                ';
            }else{
                $tabla.='
                <li><a href="'.$url.$i.'" class="pagination-link">'.$i.'</a></li> 
                ';
            }

            $ci++;
        }

        #boton ultimo y boton siguiente
        if($pagina == $npaginas){
            $tabla.='
            </ul>
            <a class="pagination-next is-disabled" disabled>Siguiente</a>
            ';
        }else{
            $tabla.='
                <li><span class="pagination-ellipsis">&hellip;</span></li>
                <li><a class="pagination-link" href="'.$url.$npaginas.'">'.$npaginas.'</a></li>
            </ul>
            <a class="pagination-next" href="'.$url.($pagina+1).'">Siguiente</a>
            ';
        }
        $tabla.='</nav>';

        return $tabla;
    }
?>