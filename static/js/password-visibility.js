function togglePasswordVisibility(id, button) {
    let passwordInput = document.getElementById(id);
    let showButton = document.getElementById(button);
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        showButton.textContent = "Hide Password";
    } else {
        passwordInput.type = "password";
        showButton.textContent = "Show Password";
    }
}