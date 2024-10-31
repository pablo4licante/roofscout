document.addEventListener("DOMContentLoaded", function() {

    const numPaginas = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
    const numFotos = [3, 6, 9, 12, 15, 18, 21, 24, 27, 30, 33, 36, 39, 42, 45];

    const generarTablaCostos = () => {
        const contenedor = document.getElementById("albumTableContainer");
        const tabla = document.createElement("table");

        const encabezado = tabla.insertRow();
        ["Número de páginas", "Número de fotos", "B/N 150-300 dpi", "B/N 450-900 dpi", "Color 150-300 dpi", "Color 450-900 dpi"].forEach(texto => {
            const th = document.createElement("th");
            th.textContent = texto;
            encabezado.appendChild(th);
        });

        for (let i = 0; i < numPaginas.length; i++) {
            var paginas = numPaginas[i];
            var fotos = numFotos[i];

            
            const fila = tabla.insertRow();

            fila.insertCell().textContent = paginas;
            fila.insertCell().textContent = fotos;

            var precio = 10.0;
            for(let numeroDeLaPagina = 1; numeroDeLaPagina <= paginas; numeroDeLaPagina++) {
                if(numeroDeLaPagina < 5){                    
                    precio += 2.0;
                } else if (numeroDeLaPagina <= 10) {
                    precio += 1.8;
                } else {
                    precio += 1.6;
                }
            }

            precio_fotos_high_dpi = fotos * 0.2;
            precio_fotos_color = fotos * 0.5;

            // BYN
            // 150-300 dpi
            fila.insertCell().textContent = (precio).toFixed(2) + " €";
            // 450-900 dpi
            fila.insertCell().textContent = (precio + precio_fotos_high_dpi).toFixed(2) + " €";

            // COLOR
            // 150-300 dpi
            fila.insertCell().textContent = (precio + precio_fotos_color).toFixed(2) + " €";
            // 450-900 dpi
            fila.insertCell().textContent = (precio + precio_fotos_color + precio_fotos_high_dpi).toFixed(2) + " €";
        }

        contenedor.appendChild(tabla);
    }

    document.getElementById("toggleTableButton").addEventListener("click", function() {
        const contenedor = document.getElementById("albumTableContainer");
        if (contenedor.style.display === "none") {
            contenedor.style.display = "block";
            if (contenedor.innerHTML === "") {
                generarTablaCostos();
            }
        } else {
            contenedor.style.display = "none";
        }
    });
});
