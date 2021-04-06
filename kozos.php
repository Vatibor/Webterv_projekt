<?php
  // a regisztrált felhasználók fájlból való betöltéséért felelő függvény

  function loadUsers($path) {
    $users = [];                  // ez a tömb fogja tartalmazni a regisztrált felhasználókat

    $file = fopen($path, "r");    // fájl megnyitása olvasásra
    if ($file === FALSE)          // hibakezelés
      die("HIBA: A fájl megnyitása nem sikerült!");

    while (($line = fgets($file)) !== FALSE) {  // fájl tartalmának beolvasása soronként
      $user = unserialize($line);  // a sor deszerializálása (visszaalakítása az adott felhasználót reprezentáló asszociatív tömbbé)
      $users[] = $user;            // a felhasználó hozzáadása a regisztrált felhasználókat tároló tömbhöz
    }

    fclose($file);
    return $users;                 // a felhasználókat tároló 2D tömb visszaadása
  }

  // a regisztrált felhasználók adatait fájlba író függvény

  function saveUsers($path, $users) {
    $file = fopen($path, "w");    // fájl megnyitása írásra
    if ($file === FALSE)          // hibakezelés
      die("HIBA: A fájl megnyitása nem sikerült!");

    foreach($users as $user) {    // végigmegyünk a regisztrált felhasználók tömbjén
      $serialized_user = serialize($user);      // szerializált formára alakítjuk az adott felhasználót
      fwrite($file, $serialized_user . "\n");   // a szerializált adatot kiírjuk a kimeneti fájlba
    }

    fclose($file);
  }


   // a profilkép feltöltését végző függvény

   function uploadProfilePicture($username) {
    global $fajlfeltoltes_hiba;    // ez a változó abban a fájlban található, amiben ezt a függvényt meghívjuk, ezért újradeklaráljuk globálisként

    if (isset($_FILES["profile-pic"]) && is_uploaded_file($_FILES["profile-pic"]["tmp_name"])) {  // ha töltöttek fel fájlt...
      $allowed_extensions = ["png", "jpg", "jpeg"];                                           // az engedélyezett kiterjesztések tömbje
      $extension = strtolower(pathinfo($_FILES["profile-pic"]["name"], PATHINFO_EXTENSION));  // a feltöltött fájl kiterjesztése

      if (in_array($extension, $allowed_extensions)) {      // ha a fájl kiterjesztése megfelelő...
        if ($_FILES["profile-pic"]["error"] === 0) {        // ha a fájl feltöltése sikeres volt...
          if ($_FILES["profile-pic"]["size"] <= 31457280) { // ha a fájlméret nem nagyobb 30 MB-nál
            $path = "src/" . $username . "." . $extension;   // a cél útvonal összeállítása

            if (!move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $path)) { // fájl átmozgatása a cél útvonalra
              $fajlfeltoltes_hiba = "A fájl átmozgatása nem sikerült!";
            }
          } else {
            $fajlfeltoltes_hiba = "A fájl mérete túl nagy!";
          }
        } else {
          $fajlfeltoltes_hiba = "A fájlfeltöltés nem sikerült!";
        }
      } else {
        $fajlfeltoltes_hiba = "A fájl kiterjesztése nem megfelelő!";
      }
    }
  }
?>