<?php
    $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
    $tabla = "";

    if(isset($busqueda) && $busqueda!=""){
        $consulta_datos = "SELECT * FROM usuario WHERE ((ID_USU <> '".$_SESSION["id"]."') 
                            AND (NOM_USU LIKE '%$busqueda%' OR APE_USU LIKE '%$busqueda%'
                            OR USUARIO LIKE '%$busqueda%' OR MAIL LIKE '%$busqueda%')) 
                            ORDER BY NOM_USU ASC LIMIT $inicio, $registros";

        $consulta_total = "SELECT COUNT(*) FROM usuario WHERE ((ID_USU <> '".$_SESSION["id"]."') 
                            AND (NOM_USU LIKE '%$busqueda%' OR APE_USU LIKE '%$busqueda%'
                            OR USUARIO LIKE '%$busqueda%' OR MAIL LIKE '%$busqueda%'))";
    }else{
        $consulta_datos = "SELECT * FROM usuario WHERE ID_USU <> '".$_SESSION["id"]."' 
                            ORDER BY NOM_USU ASC LIMIT $inicio, $registros";

        $consulta_total = "SELECT COUNT(*) FROM usuario WHERE ID_USU <> '".$_SESSION["id"]."'";
    }
    
    $bd = conexionBD();

    $datos = $bd->query($consulta_datos);
    $datos = $datos->fetchAll();

    $total_datos = $bd->query($consulta_total);
    $total_datos = (int) $total_datos->fetchColumn();

    $npaginas = ceil($total_datos/$registros);
    
    $tabla.='
    <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                <th>#</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Usuario</th>
                <th>Email</th>
                <th colspan="2">Opciones</th>
                </tr>
            </thead>
        <tbody>
    ';

    if($total_datos >= 1 && $pagina <= $npaginas){
        $contador = $inicio + 1;
        $pag_inicio = $inicio + 1;

        foreach ($datos as $row) {
            $tabla.='
            <tr class="has-text-centered">
                <td>'.$contador.'</td>
                <td>'.$row["NOM_USU"].'</td>
                <td>'.$row["APE_USU"].'</td>
                <td>'.$row["USUARIO"].'</td>
                <td>'.$row["MAIL"].'</td>
                <td>
                    <a href="index.php?vista=user_update&user_id_up='.$row["ID_USU"].'" class="button is-success is-rounded is-small">Actualizar</a>
                </td>
                <td>
                    <a href="'.$url.$pagina.'&user_id_del='.$row['ID_USU'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                </td>
            </tr>
            ';
            $contador++;
        }

        $pag_final = $contador - 1;
    }else{
        if ($total_datos >= 1) {
            $tabla.='
            <tr class="has-text-centered">
                <td colspan="7">
                    <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga click aquí para recargar el listado
                    </a>
                </td>
            </tr>
            ';
        } else {
            $tabla.='
            <tr class="has-text-centered">
                <td colspan="7">
                    No hay registros en el sistema
                </td>
            </tr>
            ';
        }
        
    }
    
    $tabla.= '</tbody></table></div>';

    if($total_datos >= 1 && $pagina <= $npaginas) {
        $tabla.='
        <p class="has-text-right">
            Mostrando Usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total_datos.'</strong>
        </p>
        ';
    }
    $bd = null;
    echo $tabla;

    if($total_datos >= 1 && $pagina <= $npaginas){
        echo paginar_tabla($pagina,$npaginas,$url,5);
    }

?>
