function xDataLayout() {
    // Obtener el contenedor del aside
    const asideElement = document.querySelector('.contenedor_aside');

    // Recoger los valores de los atributos HTML y manejar posibles valores null
    const seleccionadoNivel1 = parseInt(asideElement.getAttribute('data-seleccionado-nivel-1'));
    const seleccionadoNivel2 = parseInt(asideElement.getAttribute('data-seleccionado-nivel-2'));
    const seleccionadoNivel3 = parseInt(asideElement.getAttribute('data-seleccionado-nivel-3'));
    const seleccionadoNivel4 = parseInt(asideElement.getAttribute('data-seleccionado-nivel-4'));

    return {
        estadoAsideAbierto: false,
        estadoNavAbierto: false,
        // Usar condicional en línea para manejar posibles valores null
        seleccionadoNivel_1: !isNaN(seleccionadoNivel1) ? seleccionadoNivel1 : null,
        seleccionadoNivel_2: !isNaN(seleccionadoNivel2) ? seleccionadoNivel2 : null,
        seleccionadoNivel_3: !isNaN(seleccionadoNivel3) ? seleccionadoNivel3 : null,
        seleccionadoNivel_4: !isNaN(seleccionadoNivel4) ? seleccionadoNivel4 : null,
        initLayout() {
            let anchoPantalla = (window.innerWidth > 0) ? window.innerWidth : screen.width;

            if (anchoPantalla < 900) {
                this.estadoAsideAbierto = false
                this.estadoNavAbierto = false
            } else {
                if (this.seleccionadoNivel_1) {
                    this.estadoNavAbierto = true
                }
            }

            window.addEventListener('resize', () => {
                if (document.body.clientWidth < 900) {
                    this.estadoAsideAbierto = false;
                } else {
                    this.estadoAsideAbierto = true;
                }
            });
        },
        toggleContenedorAside() {
            let anchoPantalla = (window.innerWidth > 0) ? window.innerWidth : screen.width;

            if (anchoPantalla < 900) {
                this.estadoAsideAbierto = true
                if (this.seleccionadoNivel_1) {
                    this.estadoNavAbierto = true
                }
            }

        },
        toggleContenedorNavLinks() {
            let anchoPantalla = (window.innerWidth > 0) ? window.innerWidth : screen.width;

            if (anchoPantalla > 900) {
                if (this.seleccionadoNivel_1) {
                    this.estadoNavAbierto = !this.estadoNavAbierto
                }
            }

            if (anchoPantalla < 900) {
                this.estadoAsideAbierto = false;
            }
        },
        toogleNivel_1(event, id) {
            if (this.seleccionadoNivel_1 !== id) {
                this.estadoNavAbierto = true

                this.seleccionadoNivel_1 = id;
                this.seleccionadoNivel_2 = null;
                this.seleccionadoNivel_3 = null;
                this.seleccionadoNivel_4 = null;
            }

        },
        toogleNivel_2(event, id) {
            if (this.seleccionadoNivel_2 === id) {
                this.seleccionadoNivel_2 = null;
            } else {
                this.seleccionadoNivel_2 = id;
            }
            this.seleccionadoNivel_3 = null;
            this.seleccionadoNivel_4 = null;
        },
        toogleNivel_3(event, id) {
            if (this.seleccionadoNivel_3 === id) {
                this.seleccionadoNivel_3 = null;
            } else {
                this.seleccionadoNivel_3 = id;
            }
            this.seleccionadoNivel_4 = null;
        },
        toogleNivel_4(event, id) {
            if (this.seleccionadoNivel_4 === id) {
                this.seleccionadoNivel_4 = null;
            } else {
                this.seleccionadoNivel_4 = id;
            }
        },
        resetMenu() {
            this.seleccionadoNivel_1 = null;
            this.seleccionadoNivel_2 = null;
            this.seleccionadoNivel_3 = null;
            this.seleccionadoNivel_4 = null;
        }
    };
}