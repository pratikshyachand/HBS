const eyeIcon= document.getElementById('eye');
const btnSignup= document.getElementById('sign-up-btn');
const passwordField= document.getElementById('password');


eyeIcon.addEventListener('click',() => {
    if(passwordField.type === "password" && passwordField.value)
    {
        passwordField.type = "text";
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');

    }
    else{
        passwordField.type = "password";
        eyeIcon.classList.add('fa-eye');
        eyeIcon.classList.remove('fa-eye-slash');
    }
});


btnSignup.addEventListener('click',() => {
    window.location.href = "signup.php";
});






