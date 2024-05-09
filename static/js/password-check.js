let passwordInput = document.getElementById("password");
let lengthRequirement = document.getElementById("length");
let uppercaseRequirement = document.getElementById("uppercase");
let lowercaseRequirement = document.getElementById("lowercase");
let numberRequirement = document.getElementById("number");
let specialRequirement = document.getElementById("special");

passwordInput.oninput = function () {
    let password = passwordInput.value;

    // Check length
    if (password.length >= 8) {
        lengthRequirement.innerHTML =
            '<i class="bi bi-check-circle-fill text-success"></i> Must be at least 8 characters long';
    } else {
        lengthRequirement.innerHTML =
            '<i class="bi bi-x-circle-fill text-danger"></i> Must be at least 8 characters long';
    }

    // Check uppercase
    if (/[A-Z]/.test(password)) {
        uppercaseRequirement.innerHTML =
            '<i class="bi bi-check-circle-fill text-success"></i> Must contain at least one uppercase letter';
    } else {
        uppercaseRequirement.innerHTML =
            '<i class="bi bi-x-circle-fill text-danger"></i> Must contain at least one uppercase letter';
    }

    // Check lowercase
    if (/[a-z]/.test(password)) {
        lowercaseRequirement.innerHTML =
            '<i class="bi bi-check-circle-fill text-success"></i> Must contain at least one lowercase letter';
    } else {
        lowercaseRequirement.innerHTML =
            '<i class="bi bi-x-circle-fill text-danger"></i> Must contain at least one lowercase letter';
    }

    // Check number
    if (/[0-9]/.test(password)) {
        numberRequirement.innerHTML =
            '<i class="bi bi-check-circle-fill text-success"></i> Must contain at least one number';
    } else {
        numberRequirement.innerHTML =
            '<i class="bi bi-x-circle-fill text-danger"></i> Must contain at least one number';
    }

    // Check special character
    if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password)) {
        specialRequirement.innerHTML =
            '<i class="bi bi-check-circle-fill text-success"></i> Must contain at least one special character';
    } else {
        specialRequirement.innerHTML =
            '<i class="bi bi-x-circle-fill text-danger"></i> Must contain at least one special character';
    }
};

let confirmPasswordInput = document.getElementById('confirmPassword');
let passwordMatchStatus = document.getElementById('passwordMatchStatus');

confirmPasswordInput.oninput = function () {
    // Check if passwords match
    if (passwordInput.value === confirmPasswordInput.value) {
        passwordMatchStatus.style.display = 'block';
        passwordMatchStatus.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i> Passwords match';
    } else {
        passwordMatchStatus.style.display = 'block';
        passwordMatchStatus.innerHTML = '<i class="bi bi-x-circle-fill text-danger"></i> Passwords do not match';
    }
};