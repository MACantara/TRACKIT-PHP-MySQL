<?php

class SignUpController extends SignUp {

    private $firstName;
    private $lastName;
    private $username;
    private $email;
    private $password;
    private $confirmPassword;

    public function __construct($firstName, $lastName, $username, $email, $password, $confirmPassword) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
    }

    public function signUpUser() {
        if ($this->emptyInput() == true) {
            header("location: ../templates/sign-up.template.php?error=emptyinput");
            exit();
        }
        if ($this->invalidUsername() == true) {
            header("location: ../templates/sign-up.template.php?error=invalidusername");
            exit();
        }
        if ($this->invalidEmail() == true) {
            header("location: ../templates/sign-up.template.php?error=invalidemail");
            exit();
        }
        if ($this->passwordComplexity() == true) {
            header("location: ../templates/sign-up.template.php?error=passwordcomplexity");
            exit();
        }
        if ($this->passwordMatch() == true) {
            header("location: ../templates/sign-up.template.php?error=passwordsdontmatch");
            exit();
        }
        if ($this->usernameExists() == true) {
            header("location: ../templates/sign-up.template.php?error=usernametaken");
            exit();
        }
        if ($this->emailExists == true) {
            header("location: ../templates/sign-up.template.php?error=emailtaken");
            exit();
        }

        $this->setUser($this->firstName, $this->lastName, $this->username, $this->email, $this->password);
    }

    private function emptyInput() {
        $result;
if (empty($this->firstName) || empty($this->lastName) || empty($this->username) || empty($this->email) || empty($this->password) || empty($this->confirmPassword)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function invalidUsername() {
        $result;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function invalidEmail() {
        $result;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    
    }
    
    private function passwordComplexity() {
        $result;
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $this->password)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function passwordMatch() {
        $result;
        if ($this->password !== $this->confirmPassword) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function usernameExists() {
        $resultCheck;
        if (!$this->checkUsername($this->username)) {
            $resultCheck = true;
        } else {
            $resultCheck = false;
        }
        return $resultCheck;
    }

    private function emailExists() {
        $resultCheck;
        if (!$this->checkEmail($this->email)) {
            $resultCheck = true;
        } else {
            $resultCheck = false;
        }
        return $resultCheck;
    }
}