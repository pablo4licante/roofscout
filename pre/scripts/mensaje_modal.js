function mostrarModal(titulo, mensaje, tipo) {
    let dialogo = document.createElement('dialog'),
    html = '';
    
    // Se crea el html del diálogo
    html += '<h4>' + titulo + '</h4>';
    html += '<p>' + mensaje + '</p>';
    html += '<div></div>';
    
    dialogo.innerHTML = html;
    
    // aplicar el estilo dependiendo del tipo de mensaje
    switch(tipo) {
    case 'ok': // mensaje OK
    dialogo.querySelector('h4').classList.add('ok');
    break;
    case 'error': // mensaje ERROR
    dialogo.querySelector('h4').classList.add('error');
    break;
    default: // mensaje normal
    dialogo.querySelector('h4').classList.add('normal');
    }
    // añadir los botones de interacción con el usuario

    
    // Al ser un mensaje modal debe llevar, al menos, el botón de Aceptar
    let btn = document.createElement('button');
    
    btn.innerHTML = 'Aceptar';
    btn.classList.add('btn', 'icon-ok');
    btn.onclick = function(){
    document.querySelector('dialog').close();

    if (tipo == "ok") {
      window.location.reload(true);
    }
        if(tipo=='ok2'){
        window.location.href = "login.html";
    }
    else{}
    
    };
    dialogo.querySelector('div').appendChild(btn);
    
    // Cuando se cierra el mensaje modal se elimina del documento
    dialogo.onclose = function() {
    this.remove();
    }
    
    // añadir al documento
    document.body.appendChild(dialogo);
    dialogo.showModal();
}
