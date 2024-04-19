<?php

class ProfileInfoView extends ProfileInfo {

    public function fetchAbout($users_id) {
        $profileInfo = $this->getProfileInfo($users_id);

        echo $profileInfo[0]["profiles_about"];
    }

    public function fetchTitle($users_id) {
        $profileInfo = $this->getProfileInfo($users_id);

        echo $profileInfo[0]["profiles_introduction_title"];
    }

    public function fetchText($users_id) {
        $profileInfo = $this->getProfileInfo($users_id);

        echo $profileInfo[0]["profiles_introduction_text"];
    }
}