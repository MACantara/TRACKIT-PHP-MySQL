<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
<script>
    let strengthBar = document.getElementById('strengthBar');
    let passwordInput = document.getElementById("password");
    let lengthRequirement = document.getElementById("length");
    let uppercaseRequirement = document.getElementById("uppercase");
    let lowercaseRequirement = document.getElementById("lowercase");
    let numberRequirement = document.getElementById("number");
    let specialRequirement = document.getElementById("special");

    passwordInput.oninput = function () {
        let password = passwordInput.value;
        let result = zxcvbn(password);

        // Update strength bar width
        strengthBar.style.width = (result.score * 25) + '%';


        // Update strength bar color and label
        let strengthLabel = document.getElementById('strengthLabel');
        switch (result.score) {
            case 0:
            case 1:
                strengthBar.style.background = '#b71c1c'; // dark red
                strengthLabel.style.textAlign = 'left';
                strengthLabel.style.color = '#b71c1c'
                strengthLabel.innerHTML = 'Very weak';
                break;
            case 2:
                strengthBar.style.background = '#f57c00'; // dark orange
                strengthLabel.style.textAlign = 'left';
                strengthLabel.style.color = '#f57c00'
                strengthLabel.innerHTML = 'Weak';
                break;
            case 3:
                strengthBar.style.background = '#fdd835'; // dark yellow
                strengthLabel.style.textAlign = 'left';
                strengthLabel.style.color = '#fdd835'
                strengthLabel.innerHTML = 'Strong';
                break;
            case 4:
                strengthBar.style.background = '#2e7d32'; // dark green
                strengthLabel.style.textAlign = 'left';
                strengthLabel.style.color = '#2e7d32'
                strengthLabel.innerHTML = 'Very strong';
                break;
        }

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

    function togglePasswordVisibility(id, button) {
    let passwordInput = document.getElementById(id);
    let showButton = document.getElementById(button);
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        showButton.innerHTML = "<i class='bi bi-eye-fill'></i> Hide Password";
    } else {
        passwordInput.type = "password";
        showButton.innerHTML = "<i class='bi bi-eye'></i> Show Password";
    }
}
</script>