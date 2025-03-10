function alertaNormal(mensaje) {
    event.preventDefault();

    if (mensaje == "Creado") {
        Swal.fire({
            icon: 'success',
            title: mensaje,
            showConfirmButton: false,
            timer: 2500
        });
    } else if (mensaje == "Actualizado") {
        Swal.fire({
            icon: 'success',
            title: mensaje,
            showConfirmButton: false,
            timer: 2500
        });
    } else if (mensaje == "Eliminado") {
        Swal.fire({
            icon: 'success',
            title: mensaje,
            showConfirmButton: false,
            timer: 2500
        });
    } else {
    }
}

