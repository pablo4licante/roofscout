document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const email = document.getElementById('email');
    const dob = document.getElementById('dob');
    const gender = document.getElementById('gender');
    const validColor = '#006400'; 
    const invalidColor = '#8B0000'; 
    const borderWidth = '3px';

    const validateInput = (input) => {
        let isValid = true;

        switch (input.id) {
            case 'username':
                const usernamePattern = /^[a-zA-Z][a-zA-Z0-9]{2,14}$/;
                isValid = usernamePattern.test(input.value);
                break;
            case 'password':
                const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d_-]{6,15}$/;
                isValid = passwordPattern.test(input.value);
                break;
            case 'confirm_password':
                isValid = input.value === password.value;
                break;
            case 'email':
                const emailPattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]{1,64}@[a-zA-Z0-9-]{1,63}(\.[a-zA-Z0-9-]{1,63}){1,254}$/;
                isValid = emailPattern.test(input.value) && validarEmail(input.value).valido;
                break;
            case 'dob':
                isValid = validateDOB(input.value);
                break;
            case 'gender':
                isValid = input.value !== '';
                break;
        }

        input.style.border = isValid ? `${borderWidth} solid ${validColor}` : `${borderWidth} solid ${invalidColor}`;
    };

    const validarEmail = (email) => {
        if (!email || email.length === 0) {
          return { valido: false, mensaje: "El email no puede estar vacío." };
        }
      
        if (email.length > 254) {
          return { valido: false, mensaje: "El email no puede exceder los 254 caracteres." };
        }
      
        const regex = /^([a-zA-Z0-9!#$%&'*+\-/=?^_`{|}~](\.?[a-zA-Z0-9!#$%&'*+\-/=?^_`{|}~]){0,63})@([a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/;
      
        if (!regex.test(email)) {
          return { valido: false, mensaje: "El formato del email no es válido." };
        }
      
        const [parteLocal, dominio] = email.split("@");
      
        if (parteLocal.length > 64) {
          return { valido: false, mensaje: "La parte local no puede exceder los 64 caracteres." };
        }
      
        if (dominio.length > 255) {
          return { valido: false, mensaje: "El dominio no puede exceder los 255 caracteres." };
        }
      
        const subdominios = dominio.split(".");
        for (let subdominio of subdominios) {
          if (subdominio.length > 63) {
            return { valido: false, mensaje: "Cada subdominio no puede exceder los 63 caracteres." };
          }
          if (/^-|-$/.test(subdominio)) {
            return { valido: false, mensaje: "Un subdominio no puede comenzar ni terminar con un guion." };
          }
        }
      
        return { valido: true, mensaje: "El email es válido." };
      }

    const validateDOB = (dobValue) => {
        const dobDate = new Date(dobValue);
        const today = new Date();
        const age = today.getFullYear() - dobDate.getFullYear();
        const monthDiff = today.getMonth() - dobDate.getMonth();
        const dayDiff = today.getDate() - dobDate.getDate();

        if (isNaN(dobDate.getTime())) {
            return false;
        }

        if (age > 18 || (age === 18 && (monthDiff > 0 || (monthDiff === 0 && dayDiff >= 0)))) {
            return true;
        }

        return false;
    };

    [username, password, confirmPassword, email, dob, gender].forEach(input => {
        input.addEventListener('input', () => validateInput(input));
    });

    form.addEventListener('submit', function(event) {
        let errorMessage = '';

        [username, password, confirmPassword, email, dob, gender].forEach(input => {
            input.style.border = '';
        });

        const usernamePattern = /^[a-zA-Z][a-zA-Z0-9]{3,15}$/;
        if (!usernamePattern.test(username.value)) {
            errorMessage += '<li>El nombre de usuario debe tener entre 3 y 15 caracteres, solo contener letras y números, y no puede comenzar con un número.</li>';
            username.style.border = `${borderWidth} solid ${invalidColor}`; 
        }

        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d_-]{6,15}$/;
        if (!passwordPattern.test(password.value)) {
            errorMessage += '<li>La contraseña debe tener entre 6 y 15 caracteres, contener al menos una letra mayúscula, una letra minúscula y un número, y solo puede contener letras, números, guiones y guiones bajos.</li>';
            password.style.border = `${borderWidth} solid ${invalidColor}`; 
        }

        if (password.value !== confirmPassword.value) {
            errorMessage += '<li>Las contraseñas no coinciden.</li>';
            confirmPassword.style.border = `${borderWidth} solid ${invalidColor}`; 
        }

        const emailPattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]{1,64}@[a-zA-Z0-9-]{1,63}(\.[a-zA-Z0-9-]{1,63}){1,255}$/;
        if (!emailPattern.test(email.value) && !validarEmail(email.value).valido) {
            errorMessage += '<li>Por favor, introduce un correo electrónico válido.</li>';
            email.style.border = `${borderWidth} solid ${invalidColor}`; 
        }

        if (!validateDOB(dob.value)) {
            errorMessage += '<li>La fecha de nacimiento es obligatoria y debes tener al menos 18 años.</li>';
            dob.style.border = `${borderWidth} solid ${invalidColor}`; 
        }

        if (gender.value === '') {
            errorMessage += '<li>El sexo es obligatorio.</li>';
            gender.style.border = `${borderWidth} solid ${invalidColor}`; 
        }

        if (errorMessage !== '') {
            mostrarModal('Error', `<ul>${errorMessage}</ul>`, 'error');
            event.preventDefault();
        }
    });
});
