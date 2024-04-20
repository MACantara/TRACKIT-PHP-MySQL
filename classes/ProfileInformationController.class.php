<?php

class ProfileInformationController extends ProfileInformation {
    private $users_id;
    private $users_username;

    public function __construct($users_id, $users_username) {
        $this->users_id = $users_id;
        $this->users_username = $users_username;
    }

    public function defaultProfileInformation() {
        $profileAbout = "This is a default profile about section.";
        $profileTitle = "Hi! I am " . $this->users_username . ".";
        $profileText = "This is a default profile text.";
        $this->setProfileInformation($profileAbout, $profileTitle, $profileText, $this->users_id);
    }
    public function updateProfileInformation($profileAbout, $profileTitle, $profileText) {
        if ($this->emptyInputCheck($profileAbout, $profileTitle, $profileText) == true) {
            header("location: ../profile-information-settings.php?error=emptyinput");
            exit();
        }

        $this->setNewProfileInformation($profileAbout, $profileTitle, $profileText, $this->users_id);
    }

    public function emptyInputCheck($profileAbout, $profileTitle, $profileText) {
        $result;
        if (empty($profileAbout) || empty($profileTitle) || empty($profileText)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}