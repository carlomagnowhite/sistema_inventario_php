
<div class="container is-fluid">
    <h1 class="title">Home</h1>
    <h2 class="subtitle">Bienvenido <?php echo $_SESSION["nombre"]."\t".$_SESSION["apellido"]?></h2>
</div>

<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">
    
    <a href="#" class="pagination-previous">Anterior</a>
    <ul class="pagination-list">
        <li><a href="#" class="pagination-link">1</a></li>  
        <li><span class="pagination-ellipsis">&hellip;</span></li>
        <li><a href="#" class="pagination-link is-current">2</a></li>
        <li><a href="#" class="pagination-link">3</a></li>
        <li><span class="pagination-ellipsis">&hellip;</span></li>
        <li><a class="pagination-link" href="#">3</a></li>
    </ul>

    <a href="#" class="pagination-next">Siguiente</a>
</nav>