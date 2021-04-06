<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" type="image/png" href="src/favicon.png"/>
    <link rel="stylesheet" href="css/commons.css">
    <title>Főoldal</title>
</head>
<body>
<main class="main anim fix">
    <?php include 'nav.php';?>
    <img id="fixed-logo" src="src/logo_transparent.png" alt="fixed-logo">

    <section id="container">
        <div class="container-card">
            <img src="src/logo_transparent.png" alt="logo">
            <h1>  <strong>Barber & Tattoo Webshop</strong></h1>
            <p>Hallgass <em >ZENÉT</em> vásárlás közben.</p>
            <audio controls>
                <source src="src/Linkin Park-Breakin .mp3" type="audio/mpeg"/>
                <source src="src/Linkin-Park-Breakin-.wav" type="audio/wav"/>
               A böngésző nem támogatja a hangállományok beágyazását.
              </audio>
            
        </div>
    </section>

    <?php include 'footer.php';?>
</main>
</body>
</html>