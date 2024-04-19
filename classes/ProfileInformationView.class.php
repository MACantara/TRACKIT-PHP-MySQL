<?php

class ProfileInformationView extends ProfileInformation {

    public function fetchAbout($users_id) {
        $profileInformation = $this->getProfileInformation($users_id);

        echo $profileInformation[0]["profiles_about"];
    }

    public function fetchTitle($users_id) {
        $profileInformation = $this->getProfileInformation($users_id);

        echo $profileInformation[0]["profiles_introduction_title"];
    }

    public function fetchText($users_id) {
        $profileInformation = $this->getProfileInformation($users_id);

        echo $profileInformation[0]["profiles_introduction_text"];
    }
}