<html>
<head>
    <title>Multiple columns with the same name</title>
</head>
<body>
<?php
    session_start();
    $_SESSION = array();

    if(ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time()-4200,
        $params["path"], $params["domains"],
        $params["secure"], $params["httponly"]
      );
    }

    session_destroy();
?>
</body>
</html>
