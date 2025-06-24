const form = document.getElementById('loginForm');
      const usuario = document.getElementById('usuario');
      const password = document.getElementById('password');

      function validarUsuario() {
        const valor = usuario.value.trim();
        const esValido = valor.length > 5;
        if (esValido) {
          usuario.classList.remove('is-invalid');
          usuario.classList.add('is-valid');
        } else {
          usuario.classList.remove('is-valid');
          usuario.classList.add('is-invalid');
        }
        return esValido;
      }

      function validarPassword() {
        const valor = password.value.trim();
        const esValido = valor.length >= 6;
        if (esValido) {
          password.classList.remove('is-invalid');
          password.classList.add('is-valid');
        } else {
          password.classList.remove('is-valid');
          password.classList.add('is-invalid');
        }
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