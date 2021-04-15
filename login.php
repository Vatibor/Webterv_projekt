<?php
session_start();
include "kozos.php";              
$fiokok = loadData("users.txt");

$uzenet = ""; 

// űrlapfeldolgozás

if (isset($_POST["login"])) {
  if (!isset($_POST["username"]) || trim($_POST["username"]) === "" || !isset($_POST["password"]) || trim($_POST["password"]) === "") {
    $uzenet = "<strong>Adj meg minden adatot!</strong>";
  } else {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $uzenet = "Sikertelen belépés! A belépési adatok nem megfelelők!";

    foreach ($fiokok as $fiok) {
      if ($fiok["username"] === $username && $fiok["passwd"] === $password) { // sikeres bejelentkezés
        $uzenet = "Sikeres belépés!";
        $_SESSION["user"] = $fiok;           // a "user" nevű munkamenet-változó a bejelentkezett felhasználót reprezentáló tömböt fogja tárolni
        header("Location: my-profile.php");      
      }
    }
  }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/commons.css">
    <link rel="stylesheet" href="css/registration.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/png" href="src/favicon.png"/>
    <title>Bejelentkezés</title>
</head>
<body>
    <main class="main">
    <?php include 'nav.php';?>
    
    <section id="container" class="container-login">
        <div class="panel">
        <h1>Bejelentkezés</h1>
        <form action="login.php" method="POST">
            <label for="username">Felhasználónév: </label>
            <input type="text" id="username" name="username"/>
            <label for="password">Jelszó: </label>
            <input type="password" id="password" name="password"/></label> <br/>
            <input type="submit" name="login" value="Bejelentkezés"/>
          </form>
        </div>
        <?php echo $uzenet . "<br/>"; ?>
    </section>
    <?php include 'footer.php';?>
    </main>
    
</body>
</html>