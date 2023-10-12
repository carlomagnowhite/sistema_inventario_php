<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php?vista=home">
            <img src="./img/logo.png" width="100" height="20">
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <!--dropdown menú de usuarios START-->
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Usuarios</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?vista=user_new">Crear</a>
                    <a class="navbar-item" href="index.php?vista=user_list">Listar</a>
                    <a class="navbar-item" href="index.php?vista=user_search">Buscar</a>
                </div>
            </div>
            <!--dropdown menú de usuarios END-->
            <!--dropdown menú de CATEGORÍAS START-->
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Categorías</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?vista=category_new">Nueva</a>
                    <a class="navbar-item" href="index.php?vista=category_list">Listar</a>
                    <a class="navbar-item" href="index.php?vista=category_search">Buscar</a>
                </div>
            </div>
            <!--dropdown menú de CATEGORÍAS END-->
            <!--dropdown menú de PRODUCTOS START-->
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Productos</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?vista=product_new">Crear</a>
                    <a class="navbar-item" href="index.php?vista=product_list">Listar</a>
                    <a class="navbar-item" href="index.php?vista=product_category">Por categorías</a>
                    <a class="navbar-item" href="index.php?vista=product_search">Buscar</a>
                </div>
            </div>
            <!--dropdown menú de PRODUCTOS END-->
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a href="index.php?vista=user_update&user_id_up=<?php echo $_SESSION['id']?>" class="button is-primary is-rounded">
                        Mi cuenta
                    </a>
                    <a class="button is-link is-rounded" href="index.php?vista=logout">
                        Salir
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>