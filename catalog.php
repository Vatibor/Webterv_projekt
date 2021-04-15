<?php
session_start();
include "kozos.php";
$justaboolean = false;

//foreach ($basketitems as $item)
$barberitems = loadData("barber_items.txt");
$tattooitems = loadData("tattoo_items.txt");
$basketitems = loadData("basket_items.txt");

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
        <h1>Tetováló kellékek</h1>
        <section class="scrollable-y">
            <?php
            echo build_table($tattooitems, $justaboolean);
            ?>
        </section>
        <h1>Fodrászcikkek</h1>
        <section class="scrollable-y">
            <?php
            echo build_table($barberitems, $justaboolean);
            ?>
        </section>
    </section>

    <?php include 'footer.php';?>
    
</main>
</body>
</html>