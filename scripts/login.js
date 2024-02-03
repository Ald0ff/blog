
let signup = document.querySelector('.signup-form')
let login = document.querySelector('.login-form')
document.querySelector('.signup').addEventListener('click', function () {

    login.classList.add('d-none')
    signup.classList.remove('d-none')
});

/* document.querySelector('.login').addEventListener('click', function () {

    login.classList.remove('d-none')
    signup.classList.add('d-none')
}); */
let inputs = document.querySelectorAll('input');

inputs.forEach(function (input) {
    input.addEventListener('input', function () {
        let mensaje = this.nextElementSibling;

        if (this.value !== '') {
            this.classList.remove('error');
            if (mensaje) mensaje.classList.add('d-none');
        }
    });
});

document.querySelector('form').addEventListener('submit', function (event) {

    //event.preventDefault();
    let isValid = true;
    let inputs = this.querySelectorAll('input');


    inputs.forEach(function (input) {
        let mensaje = input.nextElementSibling;
        //console.log(mensaje)
        if (input.value === '') {
            input.classList.add('error');
            if (mensaje) mensaje.classList.remove('d-none');
            isValid = false;
        } else {
            input.classList.remove('error');
            if (mensaje) mensaje.classList.add('d-none');
        }
    });


    if (isValid == false) {
        event.preventDefault();
    }


});
