const eyeIcon= document.getElementById('eye');
const btnSignup= document.getElementById('sign-up-btn');
const passwordField= document.getElementById('password');
const cpasswordField= document.getElementById('cpassword');

passwordField.addEventListener("input", ()=>{
       let pass = passwordField.value.trim();
       if (pass === '')
           alert1.style.display = 'none';
       else {
           if (pass.length >= 8){
               alert1.style.display = "none";
               cpasswordField.removeAttribute('disabled');
           }
           else{
               alert1.style.display = "block";
               cpasswordField.value = '';
               cpasswordField.setAttribute('disabled', 'true');
           }
       }
    });

    cpasswordField.addEventListener("input", ()=>{
        if (passwordField.value  === '' || cpasswordField.value === '')
            alert2.style.display = 'none';
        else {
            if (passwordField.value === cpasswordField.value){
                alert2.style.display = "none";
                btnSignup.removeAttribute('disabled');
            }
            else{
                alert2.style.display = "block";
                btnSignup.setAttribute('disabled', 'true');
            }

        }
    });



eyeIcon.addEventListener('click',() => {
    if(passwordField.type === "password" && passwordField.value)
    {
        passwordField.type = "text";
        cpasswordField.type = "text";
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');

    }
    else{
        passwordField.type = "password";
         cpasswordField.type = "password";
        eyeIcon.classList.add('fa-eye');
        eyeIcon.classList.remove('fa-eye-slash');
    }
});