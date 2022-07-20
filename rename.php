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
        $playerID = htmlspecialchars($_POST["relation"]);
        $newName = htmlspecialchars($_POST["re-name"]);
        // if(strlen($newName) > 8) {
        //   $newName = "Idiot";
        // }
        $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        if($_POST["submit"] == 'rename'){
        if(!(strlen($newName) > 8)) {
          if(checkPlayer($playerID, $dbh)) {
            $sth = $dbh->prepare("UPDATE ownership SET nickname = :ncName WHERE id = :pokID");
            $sth->bindValue(":ncName", $newName);
            $sth->bindValue(":pokID", $playerID);
            $hi = $sth->execute();
            echo "Successfully changed nickname to " . $newName;
          }
          else {
            echo "Ha nooooooob!!!! - Idiot from Berkeley";
          }
        }
        else {
          echo "I'm sorry but your new nickname is too long!";
          header("Location: https://atdpsites.berkeley.edu/sjanjanam/X10/game.php");
          exit();
        }
      }
      elseif($_POST["submit"] == 'delete') {
        $sth = $dbh->prepare("DELETE FROM ownership WHERE id = :pokID");
        $sth->bindValue(":pokID", $playerID);
        $hi = $sth->execute();
        echo "Successfully deleted relationship";
      }
    }
    catch (PDOException $error) {
        echo "<p>Error</p>";
    }
    echo "<br><a href=\"https://atdpsites.berkeley.edu/sjanjanam/X11/game.php\">Back to Home</a>";
?>
</body>
</html>
