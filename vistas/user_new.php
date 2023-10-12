<div class="container is-fluid mb-6">
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Nuevo usuario</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/usuario_guardar.php" method="POST" class="FormAjax" 
    autocomplete="off" id="Form">
        <!--contenedores Nombre y Apellido START-->
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombres</label>
                    <input type="text" class="input" name="usuario_nombre"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚ]{3,40}" maxlength="40" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Apellidos</label>
                    <input type="text" class="input" name="usuario_apellido"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚ]{3,40}" maxlength="40" required>
                </div>
            </div>
        </div>
        <!--contenedores Nombre y Apellido END-->
        <!--contenedores Usuario y e-Mail START-->
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Usuario</label>
                    <input type="text" class="input" name="usuario_usuario"
                    pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>e-Mail</label>
                    <input type="email" class="input" name="usuario_email" maxlength="70">
                </div>
            </div>
        </div>
        <!--contenedores Usuario y e-Mail END-->
        <!--contenedores CLAVE y Confirmar Clave START-->
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Clave</label>
                    <input type="password" class="input" name="usuario_clave1" pattern="[a-zA-Z0-9.-]{7,100}"
                    maxlength="100" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Confirmar Clave</label>
                    <input type="password" class="input" name="usuario_clave2" pattern="[a-zA-Z0-9.-]{7,100}"
                    maxlength="100" required>
                </div>
            </div>
        </div>
        <!--contenedores CLAVE y Confirmar Clave END-->
        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar Usuario</button>
        </p>
    </form>
</div>

