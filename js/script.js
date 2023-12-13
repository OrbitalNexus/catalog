// event listeners for password fields and getting create account button. 
let pass = document.getElementById('password1').addEventListener('keyup', validate);
let pass2 = document.getElementById('password2').addEventListener('keyup', validate);
let createBut = document.getElementById('createBut');

// source of password fields node value and regex for uppercase, number, and fully valid password.
function validate(event) {
    let source = event.srcElement.attributes['id'].nodeValue;
    let passexp = /.*[A-Z].*/;
    let numexp = /.*[0-9].*/;
    let finalpass = /^(?=.*[a-z])(?=.*\d)(?=.*[A-Z])[a-zA-Z\d]{8,}$/;
    
// if password1 box run regex for uppercase, number, and fully valid, and display messages for each. 
    if (source == 'password1') {
        document.getElementById("passThree").innerText = ((finalpass.test(password1.value)) ? "First password is valid" : "Must be at least 8 characters long");
        document.getElementById("passTwo").innerText = ((numexp.test(password1.value)) ? "" : "Must contain a number");
        document.getElementById("passOne").innerText = ((passexp.test(password1.value)) ? "" : "Must contain at an uppercase letter");
        // if password2 box run regex for uppercase, number, and fully valid, and display messages for each. 
    } else if (source == 'password2') {
        document.getElementById("passFour").innerText = ((finalpass.test(password2.value)) ? "Second password is valid" : "Must be at least 8 characters long");
        document.getElementById("passTwo").innerText = ((numexp.test(password2.value)) ? "" : "Must contain a number");
        document.getElementById("passOne").innerText = ((passexp.test(password2.value)) ? "" : "Must contain at an uppercase letter");
    }

    // if password1 equals password2 and is not empty, both passwords pass regex for fully valid
    // then say passwords match and remove disabled attribute. 
    if (document.getElementById('password1').value == document.getElementById('password2').value && document.getElementById('password1').value != '' && finalpass.test(password1.value) && finalpass.test(password2.value)) {
        document.getElementById("passSix").innerText = "Passwords match";
        createBut.disabled = false;

        // else say passwords do not match and make create account button disabled. 
    } else {
        document.getElementById("passSix").innerText = "Passwords do not match"
        createBut.disabled = true;
    }
}

