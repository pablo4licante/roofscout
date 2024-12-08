
<h1 id="tituloMovil">RoofScout.</h1>

<form action="/busqueda" method="get" class="search-bar">
      <input type="text" name="query" placeholder="Buscar...">
      <button type="submit" class="fa fa-search"></button>
</form>
    

<?php
if (isset($_SESSION['flashdata'])) {
  echo '<div class="mensaje-ok">' . htmlspecialchars($_SESSION['flashdata']) . '</div>';
  unset($_SESSION['flashdata']);
}
?>

<div id="galeria">
        <?php foreach ($anuncios as $anuncio): ?>
            <?php include('./src/views/templates/card.inc.php'); ?>
        <?php endforeach; ?>
</div>


<?php
if (!empty($anuncios_favoritos)) {
  $random_key = array_rand($anuncios_favoritos);
  $anuncio_favorito = $anuncios_favoritos[$random_key];
  include('./src/views/templates/recomendacion.inc copy.php');
}
?>
<?php 
$consejo_id = array_rand($consejos);
$consejo = $consejos[$consejo_id];
?>
<div class="cool-quote">
  <blockquote>
    <h4>💡 Consejos para la <?php echo $consejo['categoria']?> de inmuebles</h4>
    <h3><?php echo $consejo['titulo']?></h3>
    <p><b>Importancia:</b> <?php echo $consejo['importancia']?></p>
    <p><?php echo $consejo['descripcion']?></p>
  </blockquote>
</div>