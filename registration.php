<?php
session_start();
include "kozos.php";              // beágyazzuk a loadUsers() és saveUsers() függvényeket tartalmazó PHP fájlt
$fiokok = loadUsers("users.txt"); // betöltjük a regisztrált felhasználók adatait, és eltároljuk őket a $fiokok változóban

$siker = FALSE;
$hibak = [];

if (isset($_POST["submit"])) {   // ha submit gomb megnyomva
    // a kötelezően kitöltendő mezők ellenőrzése
    if (!isset($_POST["lastname"]) || trim($_POST["lastname"]) === "")
      $hibak[] = "A vezetéknév megadása kötelező!";

    if (!isset($_POST["firstname"]) || trim($_POST["firstname"]) === "")
      $hibak[] = "A keresztnév megadása kötelező!";

    //email validation
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $hibak[] = "Adj meg egy valid formátumú email címet";
    } else if((!isset($_POST["email"]) || trim($_POST["email"]) === "")){
        $hibak[] = "Az email cím megadása kötelező!";
    }

    //username validation
    if (!isset($_POST["username"]) || trim($_POST["username"]) === ""){
        $hibak[] = "A felhasználónév megadása kötelező!";
    }else if (!ctype_alnum($_POST["username"])) {
        $hibak[] = "A felhasználónév csak betűket és számokat tartalmazhat!";
    }

    //pw validation
    if (!isset($_POST["passwd"]) || trim($_POST["passwd"]) === "" || !isset($_POST["passwd2"]) || trim($_POST["passwd2"]) === ""){
        $hibak[] = "A jelszó és az ellenőrző jelszó megadása kötelező!";
    }
    if(strlen($_POST["passwd"]) < 8){
        $hibak[] = "A jelszónak legalább 8 karakter hosszúnak kell lennie!";
    }
    if(!preg_match('@[A-Z]@', $_POST["passwd"]) && !preg_match('@[0-9]@', $_POST["passwd"])){
        $hibak[] = "A jelszónak tartalmaznia kell legalább egy nagybetűt és egy számot!";
    }
    if ($_POST["passwd"] !== $_POST["passwd2"])
      $hibak[] = "A jelszó és az ellenőrző jelszó nem egyezik!";
    

    //terms & conditions
    if(!isset($_POST["terms"])) {
        $hibak[] = "A felhasználási feltételeket el kell fogadni.";
    }


    // űrlapadatok lementése változókba
    $sex = $_POST["sex"];
    $lastname = $_POST["lastname"];
    $firstname = $_POST["firstname"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $username = $_POST["username"];
    $password = $_POST["passwd"];
    $birthdate = $_POST["birthdate"];
    $regDate = $_POST["regDate"];
    // $terms = $_POST["terms"];
  
    // foglalt felhasználónév ellenőrzése
    foreach ($fiokok as $fiok) {
        if ($fiok["username"] === $username)  // ha egy regisztrált felhasználó neve megegyezik az űrlapon megadott névvel...
            $hibak[] = "A felhasználónév már foglalt!";
    }

    
    
    // regisztráció sikerességének ellenőrzése
    if (count($hibak) === 0) {   // ha nem történt hiba a regisztráció során, hozzáadjuk az újonnan regisztrált felhasználót a $fiokok tömbhöz
        // hozzáfűzzük az újonnan regisztrált felhasználó adatait a rendszer által ismert felhasználókat tároló tömbhöz
        $fiokok[] = ["sex" => $sex,
                     "lastname" => $lastname,
                     "firstname" => $firstname,
                     "email" => $email,
                     "tel" => $tel,
                     "username" => $username,
                     "passwd" => $password,
                     "birthdate" => $birthdate,
                     "regDate" => $regDate,
    ];
        // elmentjük a kibővített $fiokok tömböt a users.txt fájlba
        saveUsers("users.txt", $fiokok);
        $siker = TRUE;
    } else {                    // ha voltak hibák, akkor a regisztráció sikertelen
        $siker = FALSE;
    }
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/commons.css">
    <link rel="stylesheet" href="css/registration.css">
    <link rel="icon" type="image/png" href="src/favicon.png"/>
    
    <title>Regisztráció</title>
</head>
<body>
<main class="main">
<?php include 'nav.php';?>
</nav>
    <section id="container">
        <div class="panel">
            <br>
            <?php
                if (isset($siker) && $siker === TRUE) {  // ha nem volt hiba, akkor a regisztráció sikeres
                    echo "<p>Sikeres regisztráció! Átirányítás...</p>";
                
                    header("Location: login.php");
                } else {                                // az esetleges hibákat kiírjuk egy-egy bekezdésben
                    foreach ($hibak as $hiba) {
                        echo "<p>" . $hiba . "</p>";
                    }
                }
            ?> 
            <form action="registration.php" method="POST">
                <fieldset>
                <div id="general-info">
                    <label>Nem: <span class="star">*</span></label>
                    <div id="sex">
                        <input type="radio" id="op1" name="sex" value="f"
                        <?php if (isset($_POST['sex']) && $_POST['sex'] === 'f') echo 'checked'; ?>/>
                        <label for="op1">Férfi</label>
                        <input type="radio" id="op2" name="sex" value="n"
                        <?php if (isset($_POST['sex']) && $_POST['sex'] === 'n') echo 'checked'; ?>/>
                        <label for="op2">Nő</label>
                        <input type="radio" id="op3" name="sex" value="other" 
                        <?php if (isset($_POST['sex']) && $_POST['sex'] === 'other') echo 'checked'; ?>/>
                        <label for="op3">Egyéb</label>
                    </div>
                    <br>

                    <label for="lastname">Vezetéknév: <span class="star">*</span></label>
                    <input type="text" id="lastname" name="lastname" placeholder="Minta" 
                    value="<?php if (isset($_POST['lastname'])) echo $_POST['lastname']; ?>" required/>

                    <label for="firstname">Keresztnév: <span class="star">*</span></label>
                    <input type="text" id="firstname" name="firstname" placeholder="Máté"
                    value="<?php if (isset($_POST['firstname'])) echo $_POST['firstname']; ?>" required/>

                    <label for="email">Email: <span class="star">*</span></label>
                    <input type="email" id="email" name="email" placeholder="minta.mate@email.hu" 
                    value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" required/>

                    <label for="tel">Telefonszám: </label>
                    <input type="tel" id="tel" name="tel" placeholder="+36301233456" 
                    value="<?php if (isset($_POST['tel'])) echo $_POST['tel']; ?>" />

                    <label for="birthdate">Születési idő:</label>
                    <input type="text" id="birthdate" name="birthdate" placeholder="éééé. hh. nn."
                    value="<?php if (isset($_POST['birthdate'])) echo $_POST['birthdate']; ?>"/>

                    <label for="username">Felhasználónév: <span class="star">*</span></label>
                    <input type="text" id="username" name="username"
                    value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" required/>

                    <label for="my-passwd">Jelszó: <span class="star">*</span></label>
                    <input type="password" id="my-passwd" name="passwd" required/> <br/>
                    
                    <label for="my-passwd2">Jelszó mégegyszer: <span class="star">*</span></label>
                    <input type="password" id="my-passwd2" name="passwd2" required/>

                    <input type="hidden" id="register-date" 
                    value="<?php echo date("Y-m-d"); ?>" name="regDate">
                </div>
                </fieldset>

                <div class="approvals">
                    <label for="newsletter">Szeretnék feliratkozni a hírlevélre!</label>
                    <input type="checkbox" id="newsletter" name="newsletter">
                    <br>
                    <label for="terms">Elfogadom a felhasználási feltételeket. <span class="star">*</span></label>
                    <input type="checkbox" id="terms" name="terms">
                </div>


                <p id="login-q">Van már fiókod?
                    <a href="#">Jelentkezz be!</a>
                </p>
                <input type="reset" value="Törlés">
                <input type="submit" value="Regisztráció" name="submit">
                
            </form>
             
           
        </div>
    </section>

    <?php include 'footer.php';?>
</main>

</body>
</html>
