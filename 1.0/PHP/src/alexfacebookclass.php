<?php

/**
 * Description of AlexFacebookClass
 *
 * @author Alex Nevsky
 */
class AlexFacebookClass {

    private $dbServer = 'localhost';
    private $dbUserName = ''; //TODO
    private $dbUserPassword = ''; //TODO
    private $dbName = ''; //TODO

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    static public function getFacebookPublicUserInfo($facebookUserId) {
        if (is_numeric($facebookUserId)) {
            $facebookPublicUserInfo = json_decode(file_get_contents('https://graph.facebook.com/' . $facebookUserId));
            if (!$facebookPublicUserInfo) {
                return false;
            }
            return $facebookPublicUserInfo;
        }
    }

    static public function getFacebookUserImageUrl($facebookUserId, $size = 'large') {
        if (is_numeric($facebookUserId)) {
            return 'http://graph.facebook.com/' . $facebookUserId . '/picture?type=' . $size;
        }
    }

    private function dbConnect() {
        $result = new mysqli($this->dbServer, $this->dbUserName, $this->dbUserPassword, $this->dbName);
        if (!$result)
            return false;
        return $result;
    }

    public function addFacebookUserInfoInDB($facebookUserId) {
        if (is_numeric($facebookUserId)) {
            $facebookUserInfo = json_decode(file_get_contents('https://graph.facebook.com/' . $facebookUserId));
            if (!$facebookUserInfo) {
                echo '<p>Can\'t access to Facebook User Info: ' . $facebookUserId . '</p>';
                return false;
            }

            if ($facebookUserInfo->id) {
                $conn = $this->dbConnect();

                $result = $conn->query("SELECT userId FROM AtenUser WHERE userSpecialCharId = '" . "fb_" . $facebookUserInfo->id . "'");
                $row = $result->fetch_row();
                $userId = $row[0];

                if (!$userId) {
                    if ($facebookUserInfo->first_name) {
                        $conn->query("INSERT INTO AtenUser VALUES (DEFAULT, '" . $facebookUserInfo->first_name . "', '" . "fb_" . $facebookUserInfo->id . "', CURDATE())");
                    } else {
                        $conn->query("INSERT INTO AtenUser VALUES (DEFAULT, '" . $facebookUserInfo->name . "', '" . "fb_" . $facebookUserInfo->id . "', CURDATE())");
                    }

                    $result = $conn->query("SELECT userId FROM AtenUser WHERE userSpecialCharId = '" . "fb_" . $facebookUserInfo->id . "'");
                    if (!$result) {
                        return false;
                    }
                    $row = $result->fetch_row();
                    $userId = $row[0];

                    if ($facebookUserInfo->first_name && $facebookUserInfo->last_name) {
                        $conn->query("INSERT INTO UserNames VALUES ($userId, '" . $facebookUserInfo->first_name . "', '" . $facebookUserInfo->last_name . "',
                            '" . $facebookUserInfo->first_name . "')");
                    }
                    if ($facebookUserInfo->gender == 'male') {
                        $conn->query("INSERT INTO UserGender VALUES ($userId, 'M')");
                    } else if ($facebookUserInfo->gender == 'female') {
                        $conn->query("INSERT INTO UserGender VALUES ($userId, 'F')");
                    }

                    $conn->query("INSERT INTO UserId_FacebookUserId VALUES ($userId, $facebookUserInfo->id)");

                    $result = $conn->query("SELECT userId FROM UserSocialServices WHERE userId = $userId");
                    if (!$result) {
                        return false;
                    }
                    $row = $result->fetch_row();
                    $isUser = $row[0];

                    if ($isUser) {
                        $conn->query("UPDATE UserSocialServices SET isFacebook = 'Y' WHERE userId = $userId");
                    } else {
                        $conn->query("INSERT INTO UserSocialServices (userId, isFacebook) VALUES ($userId, 'Y')");
                    }
                }
            }
        }
    }
}

?>
