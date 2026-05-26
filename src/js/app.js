document.addEventListener('DOMContentLoaded', function() {
    mostrarAlertaSesion();
    dropdowns();
    confirmarEliminar();
    iniciarSelect2();
    iniciarCalendario();
    iniciarBuscador();
    iniciarTomarTicket();
});

function mostrarAlertaSesion() {
    const contenedorAlerta = document.querySelector('.alerta-exitosa');

    if (contenedorAlerta) {
        //Extraccion de HTML data-attributes
        const titulo = contenedorAlerta.dataset.titulo;
        const mensaje = contenedorAlerta.dataset.mensaje;
        const icono = contenedorAlerta.dataset.icono;

        //SweetAlert2
        Swal.fire({
            title: titulo,
            text: mensaje,
            icon: icono,
            confirmButtonColor: '#007bff',
            confirmButtonText: 'Entendido'
        });
    }
}

function dropdowns() {
    const dropdowns = document.querySelectorAll(".dropdown");

    dropdowns.forEach(dropdown => {
        const btn = dropdown.querySelector(".dropdown__btn");
        const menu = dropdown.querySelector(".dropdown__menu");
        const icono = dropdown.querySelector(".dropdown__icono");

        if(!btn || !menu) return;

        btn.addEventListener("click", (e) => {
            e.stopPropagation();

            document.querySelectorAll(".dropdown__menu").forEach(m => {
                if(m !== menu) m.classList.remove("activo");
            });

            menu.classList.toggle("activo");

            if(icono) {
                icono.classList.toggle("rotar");
            }
        });

        menu.addEventListener("click", (e) => {
            e.stopPropagation();
        });
    });

    document.addEventListener("click", () => {
        document.querySelectorAll(".dropdown__menu").forEach(menu => {
            menu.classList.remove("activo");
        });

        document.querySelectorAll(".dropdown__icono").forEach(icono => {
            icono.classList.remove("rotar");
        });
    });
}

function confirmarEliminar() {
    const forms = document.querySelectorAll(".form-eliminar");

    forms.forEach(form => {
        form.addEventListener("submit", function(e) {
            e.preventDefault();

            const nombre = form.dataset.nombre;

            Swal.fire({
                title: `¿Eliminar ${nombre}?`,
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ef4444",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if(result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
}

function iniciarSelect2() {
    const selects = document.querySelectorAll('.buscador');

    selects.forEach(selectElement => {
        const tipo = selectElement.dataset.tipo;

        if(tipo === 'empresa') {
            $(selectElement).select2({
                placeholder: "Selecciona una empresa",
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    }
                }
            });
        }
        
        if(tipo === 'tipo_equipo') {
            $(selectElement).select2({
                placeholder: 'Selecciona un tipo de equipo',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    }
                }
            });
        }

        if(tipo === 'equipo') {
            $(selectElement).select2({
                placeholder: 'Seleccione un equipo',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    }
                }
            });
        }

        if(tipo === 'prioridad') {
            $(selectElement).select2({
                placeholder: 'Selecciona la prioridad del ticket',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    }
                }
            });
        }

        if(tipo === 'especialidad') {
            $(selectElement).select2({
                placeholder: 'Selecciona una especialidad',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    }
                }
            });
        }

        if(tipo === 'rol') {
            $(selectElement).select2({
                placeholder: 'Selecciona un rol',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    }
                }
            });
        }

        if(tipo === 'categoria') {
            $(selectElement).select2({
                placeholder: 'Selecciona un Seleccione un tipo de solicitud o falla',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    }
                }
            });
        }

        if(tipo === 'estatus') {
            $(selectElement).select2({
                placeholder: 'Selecciona un estatus',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    }
                }
            });
        }
    });
}

function iniciarCalendario() {

    const calendario = document.querySelector(".calendario");
    if(!calendario) return;
    const tipo = calendario.dataset.fecha;

    if(tipo === 'inicio') {
        flatpickr(".calendario", {
            locale: "es",
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
            minDate: "today",
            disableMobile: "true"
        });
    } else if(tipo === 'vencimiento') {
        flatpickr(".calendario", {
            locale: "es",
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
            disableMobile: "true"
        });
    }
}

function iniciarBuscador() {
    const buscadores = document.querySelectorAll('.filtro');

    buscadores.forEach(inputBusqueda => {
        const contenedor = inputBusqueda.closest('.contenedor-buscador-agregar').parentElement;
        const emptyState = contenedor.querySelector('#empty-state');
        const tabla = contenedor.querySelector('.tabla');
        
        if (!inputBusqueda || !emptyState || !tabla) return;

        const filas = tabla.querySelectorAll('tbody tr');
        const thead = tabla.querySelector('thead');

        // Creamos una función interna para reutilizar la lógica
        const refrescarVista = (valorBusqueda) => {
            const busqueda = valorBusqueda.toLowerCase().trim();
            let coincidencias = 0;

            filas.forEach(fila => {
                const textoFila = fila.textContent.toLowerCase();
                // Si la búsqueda está vacía, mostramos la fila. Si no, filtramos.
                if (busqueda === "" || textoFila.includes(busqueda)) {
                    fila.style.display = '';
                    coincidencias++;
                } else {
                    fila.style.display = 'none';
                }
            });

            // EL CAMBIO CLAVE:
            // Si no hay coincidencias (porque filtramos o porque la tabla venía vacía de origen)
            if (coincidencias === 0) {
                if (thead) thead.style.display = 'none';
                emptyState.style.setProperty('display', 'flex', 'important');
            } else {
                if (thead) thead.style.display = '';
                emptyState.style.setProperty('display', 'none', 'important');
            }
        };

        // --- ESTO ES LO QUE TE FALTABA ---
        // Ejecutamos la función una vez al inicio para detectar si la tabla ya viene vacía
        refrescarVista(inputBusqueda.value);

        // Y la dejamos escuchando para cuando el usuario escriba
        inputBusqueda.addEventListener('input', function(e) {
            refrescarVista(e.target.value);
        });
    });
}

function imprimirFicha(numeroTicket) {
    // 1. Capturamos el contenedor interno de la ficha
    const elementoAImprimir = document.querySelector('.tarjeta-detalle');
    
    // 2. Creamos la ventana emergente
    const ventanaImpresion = window.open('', '_blank', 'width=900,height=700');
    
    ventanaImpresion.document.write(`<html><head><title>Reporte de Ticket - ${numeroTicket}</title>`);
    
    // Inyectamos tus estilos base (opcional, pero dejamos los estilos inline blindados para impresión)
    ventanaImpresion.document.write('<link rel="stylesheet" href="/build/css/app.css" type="text/css" />');
    
    // 3. Estilos de impresión corregidos y blindados contra encimamientos
    ventanaImpresion.document.write(`
        <style>
            body { 
                background: #ffffff !important; 
                color: #000000 !important; 
                padding: 30px; 
                font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
                font-size: 14px;
                line-height: 1.6;
            }
            .btn-imprimir { display: none !important; }
            
            /* Encabezado corporativo centrado */
            .marca-reporte {
                text-align: center;
                margin-bottom: 30px;
                border-bottom: 3px double #0f172a;
                padding-bottom: 15px;
            }
            .marca-reporte h1 {
                font-size: 32px;
                font-weight: 800;
                letter-spacing: 2px;
                color: #0f172a !important;
                margin: 0;
            }
            .marca-reporte p {
                font-size: 12px;
                text-transform: uppercase;
                color: #475569 !important;
                margin: 5px 0 0 0;
                letter-spacing: 3px;
            }

            .tarjeta-detalle { margin: 0 !important; padding: 0 !important; background: #ffffff !important; border: none !important; box-shadow: none !important; }
            
            .detalle-header {
                border-bottom: 2px solid #000000 !important;
                margin-bottom: 25px !important;
                padding-bottom: 10px;
            }
            .detalle-header h4 { color: #000000 !important; font-size: 24px !important; margin: 0; }
            .detalle-header p { color: #334155 !important; font-size: 14px !important; margin: 5px 0 0 0; font-weight: 600; }

            /* 🛠️ SOLUCIÓN AQUÍ: Forzamos un diseño de filas limpias e independientes para el PDF */
            .ficha-tecnica-grid { 
                background-color: #f8fafc !important; 
                border: 1px solid #cbd5e1 !important; 
                padding: 20px !important; 
                border-radius: 6px;
                margin-bottom: 30px;
                display: block !important; /* Rompemos el grid que causaba el encimamiento */
            }
            
            /* Cada fila de información se autoajusta sin estorbar a la de al lado */
            .ficha-item {
                display: flex !important;
                flex-direction: row !important;
                align-items: center;
                justify-content: flex-start;
                padding: 8px 0;
                border-bottom: 1px dashed #e2e8f0;
            }
            
            .ficha-item:last-child {
                border-bottom: none;
            }
            
            /* La etiqueta (Label) ocupará un ancho fijo a la izquierda */
            .ficha-item .ficha-label { 
                color: #475569 !important; 
                font-weight: 700;
                text-transform: uppercase;
                font-size: 11px;
                letter-spacing: 0.5px;
                width: 180px; /* Margen forzado para alinear los datos */
                min-width: 180px;
                display: inline-block;
            }
            
            /* El valor real (Value) se despliega limpiamente a la derecha */
            .ficha-item .ficha-value { 
                color: #000000 !important; 
                font-size: 14px;
                font-weight: 500;
                flex-grow: 1;
            }
            
            /* Ajuste para que descripciones largas rompan renglón correctamente abajo */
            .ficha-item.ancho-completo {
                flex-direction: column !important;
                align-items: flex-start !important;
            }
            .ficha-item.ancho-completo .ficha-label {
                margin-bottom: 5px;
            }

            /* 🏷️ Estilizado de Badges limpios para la hoja de papel */
            .detalle-badge {
                display: inline-block !important;
                border: 1px solid #000000 !important;
                color: #000000 !important;
                background: #f1f5f9 !important;
                padding: 2px 10px !important;
                font-size: 11px !important;
                font-weight: 700 !important;
                text-transform: uppercase;
                border-radius: 4px !important;
                margin: 0 !important;
            }

            /* 📊 Tabla de Historial perfectamente alineada */
            .tabla-historial-contenedor { margin-top: 20px; width: 100%; }
            .tabla-detalle-interna { border: 1px solid #cbd5e1 !important; width: 100% !important; border-collapse: collapse; }
            .tabla-detalle-interna thead { background-color: #f1f5f9 !important; }
            .tabla-detalle-interna thead th { 
                color: #000000 !important; 
                font-weight: 700;
                padding: 10px 12px !important;
                border-bottom: 2px solid #cbd5e1 !important; 
                text-align: left;
            }
            .tabla-detalle-interna tbody tr td { 
                color: #334155 !important; 
                padding: 12px !important;
                border-bottom: 1px solid #e2e8f0 !important; 
                font-size: 13px;
            }
        </style>
    `);
    
    ventanaImpresion.document.write('</head><body>');
    
    // Encabezado corporativo centrado
    ventanaImpresion.document.write(`
        <div class="marca-reporte">
            <h1>NOESIS TI</h1>
            <p>Sistemas de Gestión de Activos e Infraestructura</p>
        </div>
    `);
    
    ventanaImpresion.document.write(elementoAImprimir.innerHTML);
    ventanaImpresion.document.write('</body></html>');
    
    ventanaImpresion.document.close();
    
    // Lanzar la previsualización nativa de impresión
    setTimeout(() => {
        ventanaImpresion.focus();
        ventanaImpresion.print();
        ventanaImpresion.close();
    }, 500);
}

function iniciarTomarTicket() {
    const btnTomar = document.getElementById('btn-tomar-ticket');
    
    // Validamos que el botón exista en la vista actual para evitar errores en consola
    if (!btnTomar) return; 

    btnTomar.addEventListener('click', function() {
        // Extraemos el ID del ticket desde el atributo data-id
        const ticketId = this.getAttribute('data-id');
        
        // Configuramos la alerta de SweetAlert2
        Swal.fire({
            title: '¿Estás seguro de tomar este ticket?',
            text: "Se te asignará como el técnico responsable de este reporte.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, tomar ticket',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            // Si confirma, redirigimos a la ruta de seguimiento con el ID
            if (result.isConfirmed) {
                window.location.href = `/tickets/seguimiento?id=${ticketId}`;
            }
        });
    });
}