<?php
  // a regisztrált felhasználók fájlból való betöltéséért felelő függvény

  function loadData($path) {
    $objects = [];                  // ez a tömb fogja tartalmazni a regisztrált felhasználókat

    $file = fopen($path, "r");    // fájl megnyitása olvasásra
    if ($file === FALSE)          // hibakezelés
      die("HIBA: A fájl megnyitása nem sikerült!");

    while (($line = fgets($file)) !== FALSE) {  // fájl tartalmának beolvasása soronként
      $object = unserialize($line);  // a sor deszerializálása (visszaalakítása az adott felhasználót reprezentáló asszociatív tömbbé)
        $objects[] = $object;            // a felhasználó hozzáadása a regisztrált felhasználókat tároló tömbhöz
    }

    fclose($file);
    return $objects;                 // a felhasználókat tároló 2D tömb visszaadása
  }

  // a regisztrált felhasználók adatait fájlba író függvény

  function saveData($path, $objects) {
    $file = fopen($path, "w");    // fájl megnyitása írásra
    if ($file === FALSE)          // hibakezelés
      die("HIBA: A fájl megnyitása nem sikerült!");

    foreach($objects as $object) {    // végigmegyünk a regisztrált felhasználók tömbjén
      $serialized_data = serialize($object);      // szerializált formára alakítjuk az adott felhasználót
      fwrite($file, $serialized_data . "\n");   // a szerializált adatot kiírjuk a kimeneti fájlba
    }

    fclose($file);
  }

  function build_table($array){
    // start table
    $html = '<table>';
    // header row
    $html .= '<tr>';
      /* foreach($array[0] as $key=>$value){
           $html .= '<th>' . htmlspecialchars($key) . '</th>';
       }
       $html .= '</tr>';
   */
    // data rows
          foreach( $array as $key=>$value) {
              $html .= '<tr>';
              foreach ($value as $key2 => $value2) {
                  $html .= '<td>' . htmlspecialchars($value2) . '</td>';
              }
              $html .= '</tr>';
          }
          // finish table and return it
          $html .= '</table>';
          return $html;

}
function IsEmptyArray($array){
      $html = '<h2>- Jelenleg a kosarad üres - </h2>';
    if(empty($array)){return $html;}
    else {
        echo build_table($array);
    }
}
function build_table_AddBasket($intotable, $intobasket){
    // start table
    $html = '<table>';
    $html .= '<tr>';
    foreach( $intotable as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td>' . htmlspecialchars($value2) . '</td>';
        }

        //$intobasket[] = [$value];
        //saveData("basket_items.txt", $intobasket);
        $html .= '<td> <a href="basket.php">Kosárba!</a> </td>';
        $html .= '</tr>';
    }
    // finish table and return it
    $html .= '</table>';
    return $html;
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