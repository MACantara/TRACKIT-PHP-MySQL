<?php

class SignUpController extends SignUp
{

    private $firstName;
    private $lastName;
    private $username;
    private $email;
    private $password;
    private $confirmPassword;

    /**
     * Constructs a new instance of the SignUpController class.
     *
     * @param string $firstName The first name of the user.
     * @param string $lastName The last name of the user.
     * @param string $username The username of the user.
     * @param string $email The email address of the user.
     * @param string $password The password of the user.
     * @param string $confirmPassword The confirmation of the user's password.
     */
    public function __construct($firstName, $lastName, $username, $email, $password, $confirmPassword)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
    }

    /**
     * Sign up a user by validating input fields and redirecting to the sign-up page with error messages if necessary.
     * If all fields are valid, set the user with the provided first name, last name, username, email, and password.
     *
     * @return void
     */
    public function signUpUser()
    {
        if ($this->emptyInput() == true) {
            header("location: ../sign-up.php?error=emptyinput");
            exit();
        }
        if ($this->invalidUsername() == true) {
            header("location: ../sign-up.php?error=invalidusername");
            exit();
        }
        if ($this->invalidEmail() == true) {
            header("location: ../sign-up.php?error=invalidemail");
            exit();
        }
        if ($this->passwordComplexity() == true) {
            header("location: ../sign-up.php?error=passwordcomplexity");
            exit();
        }
        if ($this->passwordMatch() == true) {
            header("location: ../sign-up.php?error=passwordsdontmatch");
            exit();
        }
        if ($this->usernameExists() == true) {
            header("location: ../sign-up.php?error=usernametaken");
            exit();
        }
        if ($this->emailExists == true) {
            header("location: ../sign-up.php?error=emailtaken");
            exit();
        }

        $this->setUser($this->firstName, $this->lastName, $this->username, $this->email, $this->password);
    }

    /**
     * Checks if any of the input fields are empty.
     *
     * @return bool true if any input field is empty, false otherwise
     */
    private function emptyInput()
    {
        $result;
        if (empty($this->firstName) || empty($this->lastName) || empty($this->username) || empty($this->email) || empty($this->password) || empty($this->confirmPassword)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Validates the username to contain only alphanumeric characters.
     *
     * @return bool Returns true if the username is invalid, false otherwise.
     */
    private function invalidUsername()
    {
        $result;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Checks if the email is invalid.
     *
     * @return bool Returns true if the email is invalid, false otherwise.
     */
    private function invalidEmail()
    {
        $result;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;

    }

    /**
     * Checks if the password meets the complexity requirements.
     *
     * This function uses regular expressions to check if the password contains at least one lowercase letter,
     * one uppercase letter, one digit, and is at least 8 characters long.
     *
     * @return bool Returns true if the password meets the complexity requirements, false otherwise.
     */
    private function passwordComplexity()
    {
        $result;
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $this->password)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Checks if the password and the confirm password match.
     *
     * This function compares the password and the confirm password using the !== operator. If they do not match,
     * it sets the result to true. Otherwise, it sets the result to false. The function then returns the result.
     *
     * @return bool Returns true if the password and the confirm password do not match, false otherwise.
     */
    private function passwordMatch()
    {
        $result;
        if ($this->password !== $this->confirmPassword) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Checks if the username already exists.
     *
     * @return bool Returns true if the username exists, false otherwise.
     */
    private function usernameExists()
    {
        $resultCheck;
        if (!$this->checkUsername($this->username)) {
            $resultCheck = true;
        } else {
            $resultCheck = false;
        }
        return $resultCheck;
    }

    /**
     * Checks if the email already exists in the system by calling the checkEmail method.
     *
     * @throws None
     * @return bool Returns true if the email exists, false otherwise.
     */
    private function emailExists()
    {
        $resultCheck;
        if (!$this->checkEmail($this->email)) {
            $resultCheck = true;
        } else {
            $resultCheck = false;
        }
        return $resultCheck;
    }
}