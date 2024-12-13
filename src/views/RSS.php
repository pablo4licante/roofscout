    <h1>RSS</h1>
    <div class="mensaje-ok">
    <p>Las RSS (Really Simple Syndication) son una forma de distribuir contenido actualizado frecuentemente, como noticias, blogs y otros tipos de información. Permiten a los usuarios suscribirse a sus fuentes favoritas y recibir actualizaciones automáticas en su cliente RSS.
    Para integrar un feed RSS en tu página web, puedes utilizar un enlace a tu feed RSS, como el siguiente: 
    Los usuarios pueden hacer clic en este enlace para agregar tu feed a su cliente RSS. También puedes utilizar botones con íconos, como los que se muestran a continuación, para facilitar la suscripción:</p>
    </div>
    <div class="botones-perfil">
    <button onclick="location.href='/feed/rss'">
        <img src="https://seeklogo.com/images/R/rss-feed-logo-1B4A60672D-seeklogo.com.png" alt="RSS Feed" style="width:20px; height:20px; vertical-align:middle;">
        RSS Feed
    </button>
    <button onclick="location.href='/feed/atom'">
        <img src="https://seeklogo.com/images/R/rss-feed-logo-1B4A60672D-seeklogo.com.png" alt="Atom Feed" style="width:20px; height:20px; vertical-align:middle;">
        Atom Feed
    </button>
    <?php if (isset($_SESSION['user'])): ?>
        <button onclick="location.href='/user-export/rss'">
            <img src="https://seeklogo.com/images/R/rss-feed-logo-1B4A60672D-seeklogo.com.png" alt="User RSS Export" style="width:20px; height:20px; vertical-align:middle;">
            User RSS Export
        </button>
        <button onclick="location.href='/user-export/atom'">
            <img src="https://seeklogo.com/images/R/rss-feed-logo-1B4A60672D-seeklogo.com.png" alt="User Atom Export" style="width:20px; height:20px; vertical-align:middle;">
            User Atom Export
        </button>
    <?php endif; ?>
    </div>