<?php

class LogInController extends LogIn {

    private $username;
    private $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function logInUser() {
        if ($this->emptyInput() == true) {
            header("location: ../log-in.php?error=emptyinput");
            exit();
        }

        $this->getUser($this->username, $this->password);
    }

    private function emptyInput() {
        $result;
        if (empty($this->username) || empty($this->password)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}