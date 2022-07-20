<?php
    require_once "config.php";
    function checkPlayer($playID, $dbh) {
        $sth = $dbh->prepare("SELECT id FROM player");
        $sth->execute();
        $players = $sth->fetchAll();

        foreach($players as $player) {
            if($player["id"] == $playID) {
                return true;
            }
        }
        return false;
    }
?>
<html>
<head>
    <title>Multiple columns with the same name</title>
</head>
<body>
<?php
    try {
        $playerID = htmlspecialchars($_POST["player"]);
        $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

        if(checkPlayer($playerID, $dbh)) {
        $sth = $dbh->prepare("SELECT id FROM parkamon ORDER BY RAND() LIMIT 1");
        $sth->execute();
        $parkamon = $sth->fetch();
        $sth = $dbh->prepare("INSERT INTO ownership(`player_id`,`parkamon_id`,`nickname`) VALUES (:pokID,:parkID,:nickNM)");
        $sth->bindValue(":pokID", $playerID);
        $sth->bindValue(":parkID", $parkamon["id"]);
        $sth->bindValue(":nickNM", "Idiot");
        $ifISR = $sth->execute();
        if($ifISR) {
            echo "<p> Successfully caught pokemon!!!</p>";
        }
        else {
            echo "YOU FAILED...";
        }
        }
        else {
            echo "Ha nooooooob!!!! - Idiot from Berkeley";
        }
    }
    catch (PDOException $error) {
        echo "<p>Error</p>";
    }
    echo "<a href=\"https://atdpsites.berkeley.edu/sjanjanam/X11/game.php\">Back to Home</a>";
?>
</body>
</html>
