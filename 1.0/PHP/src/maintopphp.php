<?php

function dbConnect($dbServer, $dbUserName, $dbUserPassword, $dbName) {
    $result = new mysqli($dbServer, $dbUserName, $dbUserPassword, $dbName);
    if (!$result)
        return false;
    return $result;
}

function getNextPlayers($dbServer, $dbUserName, $dbUserPassword, $dbName) {
    $conn = dbConnect($dbServer, $dbUserName, $dbUserPassword, $dbName);

    $randLimit = 100;

    $_SESSION['facemash_nextPlayer'] = 1;

    if (empty($_SESSION['facemash_showMode'])) {
        $_SESSION['facemash_showMode'] = 'FacemashGirlsRatings';
    }

    if ($_SESSION['facemash_showMode'] != 'FacemashGirlsRatings'
            && $_SESSION['facemash_showMode'] != 'FacemashBoysRatings'
            && $_SESSION['facemash_showMode'] != 'FacemashCelebritiesRatings') {
        $_SESSION['facemash_showMode'] = 'FacemashGirlsRatings';
    }    

    $result = $conn->query("SELECT facemashUserId FROM " . $_SESSION['facemash_showMode'] . " ORDER BY RAND() LIMIT " . $randLimit . "");
    if (!$result) {
        return false;
    }
    for ($randMax = 1; $row = $result->fetch_row(); ++$randMax) {
        $_SESSION[('facemash_player_' . $randMax)] = $row[0];
    }
    $_SESSION['facemash_randMax'] = $randMax - 2;

    $nextPlayer = $_SESSION['facemash_nextPlayer'];
    $_SESSION['facemash_userAId'] = $_SESSION[('facemash_player_' . $nextPlayer)];
    $_SESSION['facemash_userBId'] = $_SESSION[('facemash_player_' . ($nextPlayer + 1))];

    doNextPlayers();
}

function doNextPlayers() {
    if (is_numeric($_SESSION['facemash_randMax']) && is_numeric($_SESSION['facemash_nextPlayer'])) {
        $randMax = $_SESSION['facemash_randMax'];
        $nextPlayer = $_SESSION['facemash_nextPlayer'];

        $_SESSION['facemash_leftUserAId'] = $_SESSION['facemash_userAId'];
        $_SESSION['facemash_rightUserBId'] = $_SESSION['facemash_userBId'];

        $_SESSION['facemash_userAId'] = $_SESSION[('facemash_player_' . $nextPlayer)];
        $_SESSION['facemash_userBId'] = $_SESSION[('facemash_player_' . ($nextPlayer + 1))];
        $_SESSION['facemash_nextPlayer'] = ($nextPlayer + 2);

        if ($_SESSION['facemash_nextPlayer'] > $randMax) {
            $_SESSION['facemash_nextPlayer'] = 0;
        }
    }
}

/*
 * fast
 * www.akinas.com/pages/en/blog/mysql_random_row/
 *
 * Solution 3 [PHP]
 *
  if (empty($_SESSION['facemash_showMode'])) {
  $_SESSION['facemash_showMode'] = 'FacemashGirlsRatings';
  }

  if ($_SESSION['facemash_showMode'] != 'FacemashGirlsRatings'
  && $_SESSION['facemash_showMode'] != 'FacemashBoysRatings'
  && $_SESSION['facemash_showMode'] != 'FacemashCelebritiesRatings') {
  $_SESSION['facemash_showMode'] = 'FacemashGirlsRatings';
  }
  $offset_result = mysql_query("SELECT FLOOR(RAND() * COUNT(*)) AS 'offset' FROM ' . $_SESSION['facemash_showMode'] . '");
  $offset_row = mysql_fetch_object($offset_result);
  $offset = $offset_row->offset;
  $result = mysql_query("SELECT * FROM ' . $_SESSION['facemash_showMode'] . ' LIMIT $offset, 1");
  $row = $result->fetch_row();
  $selectedUser = $row[0];
 */

/*
 * for very big table, for example 100/200k
 * www.rndblog.com/how-to-select-random-rows-in-mysql/
 *
  function doNextPlayersFromBigTable() {

  if (!isset($_SESSION['randMax'])) {
  $result = $conn->query("SELECT COUNT(*) FROM FacemashGirlsRatings");
  if (!$result) {
  return false;
  }
  $row = $result->fetch_row();
  $_SESSION['randMax'] = $row[0];
  }

  if (is_numeric($_SESSION['randMax'])) {
  $randMax = $_SESSION['randMax'];
  } else {
  $randMax = 5;
  }

  $randLimit = 100;
  $randFactor = ($randLimit / $randMax);
  $result = $conn->query("SELECT * FROM FacemashGirlsRatings WHERE RAND()<='" . $randFactor . "' LIMIT " . $randLimit . "");
  }
 *
 */

function hotUserProcess() {
    if ($_SESSION['facemash_showMode'] === 'FacemashGirlsRatings'
            || $_SESSION['facemash_showMode'] === 'FacemashBoysRatings'
            || $_SESSION['facemash_showMode'] === 'FacemashCelebritiesRatings') {
        if (is_numeric($_SESSION['facemash_hotUserId']) && is_numeric($_SESSION['facemash_notHotUserId'])) {
            $facemash = new AlexFacemashClass();

            $facemash->updateFacemashUserRating($_SESSION['facemash_hotUserId'], $_SESSION['facemash_notHotUserId'], $_SESSION['facemash_showMode']);
        }
    }
}

//----------------------------------------------------

if (empty($_SESSION['facemash_showMode'])) {
    $_SESSION['facemash_showMode'] = 'FacemashCelebritiesRatings';
}

//----------------------------------------------------

if ($_GET['mode']) {
    if ($_GET['mode'] === "boys" && $_SESSION['facemash_showMode'] != 'FacemashBoysRatings') {
        for ($i = 0; $i != 101; ++$i) {
            unset($_SESSION[('facemash_player_' . $i)]);
        }
    } else if ($_GET['mode'] === "celebrities" && $_SESSION['facemash_showMode'] != 'FacemashCelebritiesRatings') {
        for ($i = 0; $i != 101; ++$i) {
            unset($_SESSION[('facemash_player_' . $i)]);
        }
    } else if ($_GET['mode'] === "random" && $_SESSION['facemash_showMode'] != 'FacemashGirlsRatings') {
        for ($i = 0; $i != 101; ++$i) {
            unset($_SESSION[('facemash_player_' . $i)]);
        }
    }

    if ($_GET['mode'] === 'random') {
        $_SESSION['facemash_showMode'] = 'FacemashGirlsRatings';
    } else if ($_GET['mode'] === 'celebrities') {
        $_SESSION['facemash_showMode'] = 'FacemashCelebritiesRatings';
    } else if ($_GET['mode'] === 'boys') {
        $_SESSION['facemash_showMode'] = 'FacemashBoysRatings';
    } else {
        $_SESSION['facemash_showMode'] = 'FacemashGirlsRatings';
    }
    getNextPlayers($facemash->dbServer, $facemash->dbUserName,
            $facemash->dbUserPassword, $facemash->dbName);
}

//----------------------------------------------------

if ($_GET['face'] === 'left') {
    if (is_numeric($_SESSION['facemash_leftUserAId']) && is_numeric($_SESSION['facemash_rightUserBId'])) {
        $_SESSION['facemash_hotUserId'] = $_SESSION['facemash_leftUserAId'];
        $_SESSION['facemash_notHotUserId'] = $_SESSION['facemash_rightUserBId'];

        hotUserProcess();
    }
} else if ($_GET['face'] === 'right') {
    if (is_numeric($_SESSION['facemash_leftUserAId']) && is_numeric($_SESSION['facemash_rightUserBId'])) {
        $_SESSION['facemash_hotUserId'] = $_SESSION['facemash_rightUserBId'];
        $_SESSION['facemash_notHotUserId'] = $_SESSION['facemash_leftUserAId'];

        hotUserProcess();
    }
}

//----------------------------------------------------

if (($_SESSION['facemash_nextPlayer'] == 0) || ($_SESSION['facemash_nextPlayer'] > 101)) {
    getNextPlayers($facemash->dbServer, $facemash->dbUserName,
            $facemash->dbUserPassword, $facemash->dbName);
} else {
    doNextPlayers();
}
?>
