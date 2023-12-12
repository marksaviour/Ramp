function checkPassword() {
    var password = document.getElementById("password").value;
    var message = document.getElementById("passwordHelp");
    var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$");

    if(strongRegex.test(password)) {
        message.style.color = 'green';
        message.innerHTML = "Password is strong.";
    } else {
        message.style.color = 'red';
        message.innerHTML = "Password must be at least 8 characters long, contain a number and an uppercase letter.";
    }
}
