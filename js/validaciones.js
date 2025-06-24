// ======================= VALIDACIÓN LOGIN =======================

function inicializarValidacionLogin() {
    const form = document.getElementById('loginForm');
    const usuario = document.getElementById('usuario');
    const password = document.getElementById('password');

    if (!form || !usuario || !password) return; // evita errores si no están presentes

    function validarUsuario() {
        const valor = usuario.value.trim();
        const esValido = valor.length > 5;
        usuario.classList.toggle('is-valid', esValido);
        usuario.classList.toggle('is-invalid', !esValido);
        return esValido;
    }

    function validarPassword() {
        const valor = password.value.trim();
        const esValido = valor.length >= 6;
        password.classList.toggle('is-valid', esValido);
        password.classList.toggle('is-invalid', !esValido);
        return esValido;
    }

    usuario.addEventListener('input', validarUsuario);
    password.addEventListener('input', validarPassword);

    form.addEventListener('submit', function (e) {
        const usuarioOk = validarUsuario();
        const passOk = validarPassword();
        if (!usuarioOk || !passOk) {
            e.preventDefault();
        }
    });
}
