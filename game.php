<html>
<head>
    <title>Multiple columns with the same name</title>
</head>
<body>
<?php
    session_start();
    $_SESSION['id'] = $_POST["play"];
    require_once "config.php";
    try {
        $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        $sth = $dbh->prepare("SELECT * FROM player WHERE id = :id");
        $sth->bindValue(":id", $_SESSION['id']);
        $sth->execute();
        $playerArray = $sth->fetch();

        $sth2 = $dbh->prepare("SELECT * FROM ownership JOIN player ON ownership.player_id = player.id JOIN parkamon ON ownership.parkamon_id = parkamon.id ORDER BY player.name, parkamon.breed, ownership.nickname");
        //$sth2->bindValue(":id1", $_POST["play"]);
        $sth2->execute();
        $ownershipArray = $sth2->fetchAll();

        $sth3 = $dbh->prepare("SELECT ownership.id, player.name, parkamon.breed FROM ownership JOIN player ON ownership.player_id = player.id JOIN parkamon ON ownership.parkamon_id = parkamon.id");
        //$sth3->bindValue(":id2", $_POST["play"]);
        $sth3->execute();
        $relationArray = $sth3->fetchAll();
    }
    catch (PDOException $error) {
        echo "<p>Error</p>";
    }

    echo "User: {$playerArray['name']}";

    echo "<form action=\"catch.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"player\" value=\"{$_POST["play"]}\"/>";
    echo "<input type=\"submit\" value=\"Catch Parkamon\">";
    echo "</form>";

    echo "<form action=\"rename.php\" method=\"POST\"><select name=\"relation\" required>";
    foreach($relationArray as $ownership) {
        if($ownership["name"] == $playerArray['name']) {
          echo "<option value=\"{$ownership["id"]}\">{$ownership["breed"]}</option>";
        }
    }
    echo "</select>";
      echo "<input type=\"text\" name=\"re-name\"/>";
    echo "<input type=\"submit\" name=\"submit\" value=\"rename\">";
    echo "<input type=\"submit\" name=\"submit\" value=\"delete\">    ";
    echo "<br>MAX LETTERS 8";
    echo "</form>";

    echo "<TABLE BORDER=\"5px\">
        <tr>
          <th scope=\"column\">Owner:</th>
          <th scope=\"column\">Breed:</th>
          <th scope=\"column\">Location:</th>
          <th scope=\"column\">Nickname:</th>
        </tr>";
    foreach($ownershipArray as $ownership) {
      if($ownership["name"] == $playerArray['name']) {
      echo "<tr>
            <td>{$ownership["name"]}</td>
            <td>{$ownership["breed"]}</td>
            <td>{$ownership["location"]}</td>
            <td>{$ownership["nickname"]}</td>
          </tr>";
      }

    }
    echo "</TABLE>";
    echo "<a href=\"https://atdpsites.berkeley.edu/sjanjanam/X11/signout.php\">Signout</a>";
?>
</body>
</html>
