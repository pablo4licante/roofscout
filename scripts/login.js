document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const username = document.getElementById('username');
    const password = document.getElementById('password');
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
        }

        input.style.border = isValid ? `${borderWidth} solid ${validColor}` : `${borderWidth} solid ${invalidColor}`;
    };

    [username, password].forEach(input => {
        input.addEventListener('input', () => validateInput(input));
    });

    form.addEventListener('submit', function(event) {
        let errorMessage = '';

        [username, password].forEach(input => {
            input.style.border = '';
        });

        const usernamePattern = /^[a-zA-Z][a-zA-Z0-9]{2,14}$/;
        if (!usernamePattern.test(username.value)) {
            errorMessage += '<li>El nombre de usuario debe tener entre 3 y 15 caracteres, solo contener letras y números, y no puede comenzar con un número.</li>';
            username.style.border = `${borderWidth} solid ${invalidColor}`; 
        }

        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d_-]{6,15}$/;
        if (!passwordPattern.test(password.value)) {
            errorMessage += '<li>La contraseña debe tener entre 6 y 15 caracteres, contener al menos una letra mayúscula, una letra minúscula y un número, y solo puede contener letras, números, guiones y guiones bajos.</li>';
            password.style.border = `${borderWidth} solid ${invalidColor}`; 
        }

        if (errorMessage !== '') {
            mostrarModal('Error', `<ul>${errorMessage}</ul>`, 'error');
            event.preventDefault();
        }
    });
});