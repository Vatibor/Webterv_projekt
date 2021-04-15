<?php
session_start();
include "kozos.php";


if (!isset($_SESSION["user"])) {
    // ha a felhasználó nincs belépve (azaz a "user" munkamenet-változó értéke nem került korábban beállításra), akkor a login.php-ra navigálunk
    header("Location: login.php");
}

$basketitems = loadData("basket_items.txt");

$i_name = "asd";
$i_type = "asd";
$i_unit = "asd";
$i_price = "asd";



$basketitems[] = ["i_name" => $i_name,
    "i_type" => $i_type,
    "i_unit" => $i_unit,
    "i_price" => $i_price,
];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalógus</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/catalog.css">
    <link rel="stylesheet" href="css/commons.css">
</head>
<body>
<main class="main">
    <?php include 'nav.php';?>
    <section id="container">
        <h1>Kosár tartalma:</h1>
        <div class="scrollable-y">
            <?php
            echo IsEmptyArray($basketitems);
            ?>
        </div>
    </section>
    <?php include 'footer.php';?>
</main>
</body>
</html>