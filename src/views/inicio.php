<h1 id="tituloMovil">RoofScout.</h1>

<form action="/busqueda" method="get" class="search-bar">
      <input type="text" name="query" placeholder="Buscar...">
      <button type="submit" class="fa fa-search"></button>
</form>
    

<div id="galeria">
        <?php foreach ($anuncios as $anuncio): ?>
            <?php include('./src/views/templates/card.inc.php'); ?>
        <?php endforeach; ?>
</div>