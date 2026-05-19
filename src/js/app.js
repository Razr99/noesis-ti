document.addEventListener('DOMContentLoaded', function() {
    mostrarAlertaSesion();
    dropdowns();
    confirmarEliminar();
    iniciarSelect2();
    iniciarCalendario();
    iniciarBuscador();
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