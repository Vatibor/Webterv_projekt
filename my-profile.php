<?php
session_start();
include "kozos.php";

  if (!isset($_SESSION["user"])) {
  	// ha a felhasználó nincs belépve (azaz a "user" munkamenet-változó értéke nem került korábban beállításra), akkor a login.php-ra navigálunk
  	header("Location: login.php");
  }

  function sex_converter($letter) {
    switch ($letter) {
        case "f" : return "Férfi"; break;
        case "n" : return "Nő"; break;
        case "other" : return "Egyéb"; break;
    }
  }

  //profilkép
  $profilkep = "src/avatar7.png";      // alapértelmezett kép, amit akkor jelenítünk meg, ha valakinek nincs feltöltött profilképe
  $utvonal = "src/" . $_SESSION["user"]["username"]; // a kép neve a felhasználó nevével egyezik meg

  $kiterjesztesek = ["png", "jpg", "jpeg"];     // a lehetséges kiterjesztések, amivel egy profilkép rendelkezhet

  foreach ($kiterjesztesek as $kiterjesztes) {  // minden kiterjesztésre megnézzük, hogy létezik-e adott kiterjesztéssel profilképe a felhasználónak
  if (file_exists($utvonal . "." . $kiterjesztes)) {
    $profilkep = $utvonal . "." . $kiterjesztes;  // ha megtaláltuk a felhasználó profilképét, eltároljuk annak az elérési útvonalát egy változóban
    }
  }



 // a profilkép módosítását elvégző PHP kód

 if (isset($_POST["upload-btn"]) && is_uploaded_file($_FILES["profile-pic"]["tmp_name"])) {  // ha töltöttek fel fájlt...
  $fajlfeltoltes_hiba = "";                                       // változó a fájlfeltöltés során adódó esetleges hibaüzenet tárolására
  uploadProfilePicture($_SESSION["user"]["username"]);      // a kozos.php-ban definiált profilkép feltöltést végző függvény meghívása

  $kit = strtolower(pathinfo($_FILES["profile-pic"]["name"], PATHINFO_EXTENSION));    // a feltöltött profilkép kiterjesztése
  $utvonal = "src/" . $_SESSION["user"]["username"] . "." . $kit;            // a feltöltött profilkép teljes elérési útvonala

  // ha nem volt hiba a fájlfeltöltés során, akkor töröljük a régi profilképet, egyébként pedig kiírjuk a fájlfeltöltés során adódó hibát

  if ($fajlfeltoltes_hiba === "") {
    if ($utvonal !== $profilkep && $profilkep !== "src/avatar7.png") {   // az ugyanolyan névvel feltöltött képet és a default.png-t nem töröljük
      unlink($profilkep);                         // régi profilkép törlése
    }

    header("Location: my-profile.php");              // weboldal újratöltése
  } else {
    echo "<p>" . $fajlfeltoltes_hiba . "</p>";
  }
}

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="src/favicon.png"/>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/commons.css">
    <link rel="stylesheet" href="css/my-profile.css">
    <title>Profilom</title>
</head>
<body>
<main class="main">
    <?php include 'nav.php';?>
</nav>
    <section id="container">
        <section class="panel bordered">
            <div class="panel left">
                <img src="<?php echo $profilkep; ?>" alt="profile_picture"/>
                <p><?php echo $_SESSION["user"]["lastname"] . " " . $_SESSION["user"]["firstname"] ?>
                    <br>
                    <span class="medium-text"><?php echo $_SESSION["user"]["email"] ?></span><br>
                    <span class="small-text">Regisztráció ideje: <?php echo $_SESSION["user"]["regDate"] ?></span>
                </p>
                <!-- profilkép mód -->
                <form action="my-profile.php" method="POST" enctype="multipart/form-data">
                  <input type="file" name="profile-pic" accept="src/*"/>
                  <input type="submit" name="upload-btn" value="Profilkép módosítása"/>
                </form>
            </div>
            <div class="panel right">
                <div class="data">
                    <div class="field">Felhasználónév:</div>
                    <div class="value"><?php echo $_SESSION["user"]["username"] ?></div>
                </div>
                <div class="data">
                    <div class="field">Születési dátum:</div>
                    <div class="value"><?php echo $_SESSION["user"]["birthdate"] ?></div>
                </div>
                <div class="data">
                    <div class="field">Telefonszám:</div>
                    <div class="value">
                      <?php if($_SESSION["user"]["tel"] === "") {
                        echo " <span class='small-text'>(nincs megadva)</span>";
                      } else {
                        echo $_SESSION["user"]["tel"];
                      } ?>
                    </div>
                </div>
                <div class="data">
                    <div class="field">Nem:</div>
                    <div class="value"><?php echo sex_converter($_SESSION["user"]["sex"]) ?></div>
                </div>
                <div class="data">
                    <div class="field">Utolsó rendelés:</div>
                    <div class="value">2020.03.20.</div>
                </div>
                <section id="secondary-content">
                    <div>
                        <iframe src="https://www.youtube.com/embed/eV-j9l6W8X0" allowfullscreen ></iframe>
                    </div>
                </section>
            </div>
        </section>
    </section>

    <?php include 'footer.php';?>
</main>
</body>

</html>