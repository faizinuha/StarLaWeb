function validateForm() {
    var emailOrUsername = document.getElementById("emailOrUsername").value;
    var password = document.getElementById("password").value;
    var errorMessage = document.getElementById("errorMessage");

    if (emailOrUsername === "" || password === "") {
        errorMessage.textContent = "Please fill in all fields";
        errorMessage.style.display = "block";
        return false;
    } else {
        errorMessage.style.display = "none";
        return true;
    }
}
