<?php

class ProfileInformation extends DbConnection {

    protected function getProfileInformation($users_id) {
        $sql = "SELECT * FROM profiles WHERE users_id = ?";
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt->execute([$users_id])) {
            $stmt = null;
            header("location: ../profile.php?error=stmtfailed");
            exit();
        }

        if (!$stmt->rowCount() > 0) {
            $stmt = null;
            header("location: ../profile.php?error=profilenotfound");
            exit();
        }
        $profileData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $profileData;
    }

    protected function setNewProfileInformation($profileAbout, $profileTitle, $profileText, $users_id) {
        $sql = "UPDATE profiles SET profiles_about = ?, profiles_introduction_title = ?, profiles_introduction_text = ? WHERE users_id = ?";
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt->execute(array($profileAbout, $profileTitle, $profileText, $users_id))) {
            $stmt = null;
            header("location: ../profile.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }

    protected function setProfileInformation($profileAbout, $profileTitle, $profileText, $users_id) {
        $sql = "INSERT INTO profiles (profiles_about, profiles_introduction_title, profiles_introduction_text, users_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt->execute(array($profileAbout, $profileTitle, $profileText, $users_id))) {
            $stmt = null;
            header("location: ../profile.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }
}