function confirmarCerrarSesion() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas cerrar sesión?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            });
        }

        document.getElementById('cerrarSesion').addEventListener('click', function (e) {
            e.preventDefault();
            confirmarCerrarSesion();
        });

        document.getElementById('cerrarSesion2').addEventListener('click', function (e) {
            e.preventDefault();
            confirmarCerrarSesion();
        });