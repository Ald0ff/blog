
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


document.querySelector('.signup-form').addEventListener('submit', function (event) {
    
    //event.preventDefault();
    let isValid = true;
    let inputs = this.querySelectorAll('input');

    
    inputs.forEach(function (input) {
        if (input.value === '' ) {
            input.classList.add('error');
            isValid = false;

        } else {
            input.classList.remove('error');
        }
    });

    
    if (!isValid) {
        event.preventDefault();
    }

    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            
            if (this.value !== '') {
                this.classList.remove('error');
            }
        });
    });
});
