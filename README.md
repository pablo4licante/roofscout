# roofscout
Roof Scout es el proyecto de Desarrollo de Aplicaciones Web (Ingenieria Multimedia, UA)

Accede al proyecto hosteado en [RoofScout.one](https://roofscout.one)

## Importante!
Para que la aplicacion funcione se ha de realizar las siguientes configuraciones en el servidor

En `.httpd.conf`:
```
Alias /roofscout "C:\xampp\htdocs\roofscout"

<Directory "C:\xampp\htdocs\roofscout">
    Options Indexes FollowSymLinks Includes ExecCGI
    AllowOverride All
    Require all granted
</Directory>
```

y 

```
DocumentRoot "C:/xampp/htdocs/roofscout"
<Directory "C:/xampp/htdocs/roofscout">
```

En esta entrega se pueden observar los siguientes archivos:
- **index.html**: Contiene la página inicial de la aplicación, con una búsqueda rápida, una barra de navegación que se encuentra en el resto de las páginas (con opciones como volver al inicio, visualizar el centro de mensajes, hacer una búsqueda avanzada y ver el perfil del usuario), además de los 5 últimos anuncios publicados.

Carpeta **html**:
- **index-logueado.html**: Página de inicio donde se simula que hay un usuario logueado (de momento no tenemos nada que no sea HTML, por lo que no es funcional).
- **login.html**: Tiene el formulario de inicio de sesión.
- **registro.html**: Posee el formulario para el registro de un nuevo usuario.
- **perfil.html**: Información del usuario que ha iniciado sesión, además de los anuncios que ha publicado.
- **busqueda.html**: Filtro avanzado para realizar una búsqueda específica, por parámetros como el tipo de vivienda, su precio, etc...
- **resultado-busqueda.html**: Mismo formulario de filtro avanzado que en busqueda.html, pero mostrando los resultados obtenidos de esa búsqueda.
- **anuncio.html**: Información de un anuncio concreto, al que se ha accedido mediante un click, por donde también se puede contactar con el anunciante e incluso enviar un mensaje.
- **anuncio-enviarmensaje.html**: Formulario para enviar mensaje al anunciante indicando el asunto y tipo de mensaje.
- **mensajes.html**: Centro de mensajes donde se muestran los mensajes enviados y respuestas recibidas de cada uno de los anunciantes contactados.
- **nuevo-anuncio.html**: Pagina formulario para crear un nuevo anuncio.
- **solicitar-folleto.html**: Página con un formulario para solicitar un folleto publicitario.
- **respuesta-solicitar-folleto.html**: Página que simula la respuesta a la solicitud de un folleto publicitario.
- **respuesta-mensaje.html**: Página que simula la respuesta de un mensaje enviado con éxito.

