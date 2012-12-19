<?php

include_once 'alexfacebookclass.php';

/**
 * Description of AlexFacemashClass
 *
 * @author Alex Nevsky
 */
class AlexFacemashClass {

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

    private function dbConnect() {
        $result = new mysqli($this->dbServer, $this->dbUserName, $this->dbUserPassword, $this->dbName);
        if (!$result)
            return false;
        return $result;
    }

    public function addFacebookUser($facebookUserId) {
        if (is_numeric($facebookUserId)) {
            $conn = $this->dbConnect();

            $result = $conn->query("SELECT userId FROM UserId_FacebookUserId WHERE facebookUserId = $facebookUserId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $userId = $row[0];

            $result = $conn->query("SELECT facemashUserId FROM FacemashUser WHERE userId = $userId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $facemashUserId = $row[0];

            if (!$facemashUserId) {
                $conn->query("INSERT INTO FacemashUser VALUES (DEFAULT, $userId, DEFAULT)");
                $result = $conn->query("SELECT facemashUserId FROM FacemashUser WHERE userId = $userId");
                if (!$result) {
                    return false;
                }
                $row = $result->fetch_row();
                $facemashUserId = $row[0];
            }

            $result = $conn->query("SELECT userGender FROM UserGender WHERE userId = $userId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $userGender = $row[0];

            if ($userGender == 'F') {
                $conn->query("INSERT INTO FacemashGirlsRatings VALUES ($facemashUserId, 1400)");
                if (!$result) {
                    return false;
                }
            } else if ($userGender == 'M') {
                $conn->query("INSERT INTO FacemashBoysRatings VALUES ($facemashUserId, 1400)");
                if (!$result) {
                    return false;
                }
            }

            $result = $conn->query("SELECT userId FROM UserSocialServices WHERE userId = $userId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $isUser = $row[0];

            if ($isUser) {
                $conn->query("UPDATE UserSocialServices SET isFacemash = 'Y' WHERE userId = $userId");
                if (!$result) {
                    return false;
                }
            } else {
                $conn->query("INSERT INTO UserSocialServices (userId, isFacemash) VALUES ($userId, 'Y')");
                if (!$result) {
                    return false;
                }
            }
        }
    }

    public function getFacebookUserId($facemashUserId) {
        if (is_numeric($facemashUserId)) {
            $conn = $this->dbConnect();

            $result = $conn->query("SELECT userId FROM FacemashUser WHERE facemashUserId = $facemashUserId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $userId = $row[0];

            $result = $conn->query("SELECT facebookUserId FROM UserId_FacebookUserId WHERE userId = $userId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $facebookUserId = $row[0];

            return $facebookUserId;
        }
    }

    public function getFacebookUserName($facemashUserId) {
        if (is_numeric($facemashUserId)) {
            $conn = $this->dbConnect();

            $result = $conn->query("SELECT userId FROM FacemashUser WHERE facemashUserId = $facemashUserId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $userId = $row[0];

            $result = $conn->query("SELECT userName FROM AtenUser WHERE userId = $userId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $userName = $row[0];

            return $userName;
        }
    }

    public function updateFacemashUserRating($hotFacemashUserId, $notHotFacemashUserId, $showMode) {
        if ($showMode === 'FacemashGirlsRatings' || $showMode === 'FacemashCelebritiesRatings' || $showMode === 'FacemashBoysRatings') {
            if (is_numeric($hotFacemashUserId) && is_numeric($notHotFacemashUserId)) {
                $conn = $this->dbConnect();

                $result = $conn->query("SELECT facemashUserRating FROM $showMode WHERE facemashUserId = $hotFacemashUserId");
                if (!$result) {
                    return false;
                }
                $row = $result->fetch_row();
                $ra = $row[0];

                $result = $conn->query("SELECT facemashUserRating FROM $showMode WHERE facemashUserId = $notHotFacemashUserId");
                if (!$result) {
                    return false;
                }
                $row = $result->fetch_row();
                $rb = $row[0];

                $k = 15;
                $ea = 1 / (1 + pow(10, ( ($rb - $ra) / 400)));
                $eb = 1 / (1 + pow(10, ( ($ra - $rb) / 400)));

                $ra += ( $k * (1 - $ea));
                settype($ra, 'int');
                $rb += ( $k * (0 - $eb));
                settype($rb, 'int');

                $conn->query("UPDATE $showMode SET facemashUserRating = $ra WHERE facemashUserId = $hotFacemashUserId");
                $conn->query("UPDATE $showMode SET facemashUserRating = $rb WHERE facemashUserId = $notHotFacemashUserId");
            }
        }
    }

    public function getFacemashUserRating($facebookUserId) {
        if (is_numeric($facebookUserId)) {
            $conn = $this->dbConnect();

            $result = $conn->query("SELECT userId FROM UserId_FacebookUserId WHERE facebookUserId = $facebookUserId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $userId = $row[0];

            $result = $conn->query("SELECT facemashUserId FROM FacemashUser WHERE userId = $userId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $facemashUserId = $row[0];

            if ($facemashUserId) {
                $result = $conn->query("SELECT userGender FROM UserGender WHERE userId = $userId");
                if (!$result) {
                    return false;
                }
                $row = $result->fetch_row();
                $userGender = $row[0];

                if ($userGender == 'F') {
                    $table = 'FacemashGirlsRatings';
                } else if ($userGender == 'M') {
                    $table = 'FacemashBoysRatings';
                }

                $result = $conn->query("SELECT facemashUserRating FROM $table WHERE facemashUserId = $facemashUserId");
                $row = $result->fetch_row();
                $rating = $row[0];

                return $rating;
            } else {
                return 0;
            }
        }
    }

    public function getFacemashUserGameStatus($facebookUserId) {
        if (is_numeric($facebookUserId)) {
            $conn = $this->dbConnect();

            $result = $conn->query("SELECT userId FROM UserId_FacebookUserId WHERE facebookUserId = $facebookUserId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $userId = $row[0];

            if ($userId) {
                $result = $conn->query("SELECT isFacemash FROM UserSocialServices WHERE userId = $userId");
                if (!$result) {
                    return false;
                }
                $row = $result->fetch_row();
                $userGameStatus = $row[0];

                if ($userGameStatus == 'Y') {
                    $status = 'on';
                } else if ($userGameStatus == 'N') {
                    $status = 'off';
                }

                $result = $conn->query("SELECT userId FROM FacemashUser WHERE userId = $userId");
                if (!$result) {
                    return false;
                }
                $row = $result->fetch_row();

                if (!$row[0]) {
                    $status = 'off';
                }

                return $status;
            }
        }
    }

    public function setFacemashUserGameStatus($facebookUserId, $gameStatus) {
        if (is_numeric($facebookUserId) && ($gameStatus === 'on' || $gameStatus === 'off')) {
            $conn = $this->dbConnect();

            $result = $conn->query("SELECT userId FROM UserId_FacebookUserId WHERE facebookUserId = $facebookUserId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $userId = $row[0];

            if (!$userId && $gameStatus == 'on') {
                $alexfacebookclass = new AlexFacebookClass();
                $alexfacebookclass->addFacebookUserInfoInDB($facebookUserId);
                $this->addFacebookUser($facebookUserId);

                $result = $conn->query("SELECT userId FROM UserId_FacebookUserId WHERE facebookUserId = $facebookUserId");
                if (!$result) {
                    return false;
                }
                $row = $result->fetch_row();
                $userId = $row[0];
            } else if ($userId && $gameStatus == 'on') {
                $this->addFacebookUser($facebookUserId);

                $result = $conn->query("SELECT userId FROM UsersId_FacebookUsersId WHERE facebookUserId = $facebookUserId");
                if (!$result) {
                    return false;
                };
                $row = $result->fetch_row();
                $userId = $row[0];
            }

            if (!$userId && $gameStatus == 'off') {
                return false;
            }

            if ($userId && $gameStatus == 'off') {
                $result = $conn->query("SELECT facemashUserId FROM FacemashUser WHERE userId = $userId");
                if (!$result) {
                    return false;
                }
                $row = $result->fetch_row();
                $facemashUserId = $row[0];

                $result = $conn->query("SELECT userGender FROM UserGender WHERE userId = $userId");
                if (!$result) {
                    return false;
                }
                $row = $result->fetch_row();
                $userGender = $row[0];

                if ($userGender == 'F') {
                    $conn->query("DELETE FROM FacemashGirlsRatings WHERE facemashUserId = $facemashUserId");
                    if (!$result) {
                        return false;
                    }
                } else if ($userGender == 'M') {
                    $conn->query("DELETE FROM FacemashBoysRatings WHERE facemashUserId = $facemashUserId");
                    if (!$result) {
                        return false;
                    }
                }
            }

            if ($gameStatus == 'on') {
                $status = "'Y'";
            } else {
                $status = "'N'";
            }

            if ($userId) {
                $conn->query("UPDATE UserSocialServices SET isFacemash = $status WHERE userId = $userId");
            }
        }
    }

    public function getFacemashUserRatingStatus($facebookUserId) {
        if (is_numeric($facebookUserId)) {
            $conn = $this->dbConnect();

            $result = $conn->query("SELECT userId FROM UserId_FacebookUserId WHERE facebookUserId = $facebookUserId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $userId = $row[0];

            $result = $conn->query("SELECT facemashUserId, userRatingStatus FROM FacemashUser WHERE userId = $userId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $facemashUserId = $row[0];
            $userRatingStatus = $row[1];

            if ($facemashUserId) {
                return $userRatingStatus;
            }
        }
    }

    public function setFacemashUserRatingStatus($facebookUserId, $ratingStatus) {
        if (is_numeric($facebookUserId) && ($ratingStatus === 'private' || $ratingStatus === 'public')) {
            $conn = $this->dbConnect();

            $result = $conn->query("SELECT userId FROM UserId_FacebookUserId WHERE facebookUserId = $facebookUserId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $userId = $row[0];

            if ($userId) {
                $conn->query("UPDATE FacemashUser SET userRatingStatus = '$ratingStatus' WHERE userId = $userId");
            }
        }
    }

    public function getFacemashUserId($facebookUserId) {
        if (is_numeric($facebookUserId)) {
            $conn = $this->dbConnect();

            $result = $conn->query("SELECT userId FROM UserId_FacebookUserId WHERE facebookUserId = $facebookUserId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $userId = $row[0];

            $result = $conn->query("SELECT facemashUserId FROM FacemashUser WHERE userId = $userId");
            if (!$result) {
                return false;
            }
            $row = $result->fetch_row();
            $facemashUserId = $row[0];

            if ($facemashUserId) {
                return $facemashUserId;
            }
        }
    }

    public function getTop100($showMode) {
        if ($showMode === 'FacemashGirlsRatings' || $showMode === 'FacemashCelebritiesRatings' || $showMode === 'FacemashBoysRatings') {
            $conn = $this->dbConnect();

            $result = $conn->query("SELECT * FROM $showMode ORDER BY facemashUserRating LIMIT 100");
            if (!$result) {
                return false;
            }

            $facemashUsersArray = array(array());

            for ($i = 0; $row = $result->fetch_row(); ++$i) {
                $facemashUsersArray[$i][0] = $row[0];
                $facemashUsersArray[$i][1] = $row[1];
            }

            return $facemashUsersArray;
        }
    }

}

?>
