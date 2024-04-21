<?php

class LogInController extends LogIn {

    private $username;
    private $password;

    /**
     * Constructs a new instance of the LogInController class.
     *
     * @param string $username The username for the user.
     * @param string $password The password for the user.
     */
    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Logs in a user if the input is not empty.
     *
     * This function checks if the input is empty using the `emptyInput` method. If the input is empty, it redirects the user to the `../log-in.php` page with the `error=emptyinput` parameter and exits the script. Otherwise, it calls the `getUser` method with the `username` and `password` properties as arguments.
     *
     * @throws None
     * @return void
     */
    public function logInUser() {
        if ($this->emptyInput() == true) {
            header("location: ../log-in.php?error=emptyinput");
            exit();
        }

        $this->getUser($this->username, $this->password);
    }

    /**
     * Checks if the username or password input is empty.
     *
     * @return bool Returns true if either the username or password is empty, false otherwise.
     */
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