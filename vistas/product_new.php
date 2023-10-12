<div class="container is-fluid mb-6">
    <div class="title">Productos</div>
    <div class="subtitle">Crear nuevo producto</div>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once("./php/main.php");
    ?>
    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/producto_guardar.php" class="FormAjax" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Código de barra</label>
                    <input class="input" type="text" name="producto_codigo" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="producto_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Precio</label>
                    <input class="input" type="text" name="producto_precio" pattern="[0-9.]{1,25}" maxlength="25" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Stock</label>
                    <input class="input" type="number" name="producto_stock" pattern="[0-9]" required>
                </div>
            </div>
            <div class="column">
                <label>Categoría</label><br>
                <div class="select is-rounded">
                    <select name="producto_categoria">  
                    <option value="" selected="">Seleccione una opción</option>
                        <?php
                            $categorias = conexionBD();
                            $categorias = $categorias->query("SELECT * FROM categorias");
                            if($categorias->rowCount() > 0){
                                $categorias = $categorias->fetchAll();
                                foreach($categorias as $row){
                                    echo '<option value="'.$row["ID_CAT"].'">'.$row["NOM_CAT"].'</option>';
                                }
                            }
                            $categorias = null;
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <label>Foto o imagen del producto</label><br><br>
                <div class="file is-small has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="producto_foto" accept=".jpg, .png, .jpeg">
                        <span class="file-cta">
                            
                            <span class="file-label">Imagen</span>
                        </span>
                        <span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
                        <span></span>
                        <script>
                            
                        </script>
                    </label>
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>