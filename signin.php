<html>
<head>
    <title>Multiple columns with the same name</title>
</head>
<body>
<?php
    require_once "config.php";
    try {
        $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        $sth = $dbh->prepare("SELECT * FROM player");
        $sth->execute();
        $playerArray = $sth->fetchAll();
    }
    catch (PDOException $error) {
        echo "<p>Error</p>";
    }

    echo "<form action=\"game.php\" method=\"POST\"><select name=\"play\" required>";
    foreach($playerArray as $player) {
        echo "<option value=\"{$player["id"]}\">{$player["name"]}</option>";
    }
    echo "</select>";
    echo "<input type=\"submit\" value=\"login\">";
    echo "</form>";
?>
</body>
</html>
