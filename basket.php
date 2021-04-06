<?php
session_start();
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
            <table>
            </table>
            <h2>- Jelenleg a kosarad üres - </h2>
        </div>
    </section>
    <?php include 'footer.php';?>
</main>
</body>
</html>