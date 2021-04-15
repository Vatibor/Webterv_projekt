<?php
$tokens = explode("/", $_SERVER['REQUEST_URI']);
$last_token = explode("?", end($tokens))[0];
?>
<nav>
    <ul>
        <li <?php if($last_token == 'index.php') echo 'class="selected"' ?>><a href="index.php">Főoldal</a></li>
        <li <?php if($last_token == 'catalog.php') echo 'class="selected"' ?>><a href="catalog.php">Katalógus</a></li>
        
        <?php if (isset($_SESSION["user"])) { ?>
        <li <?php if($last_token == 'my-profile.php') echo 'class="selected"' ?>><a href="my-profile.php">Profilom</a></li>
        <?php } else { ?>
        <li <?php if($last_token == 'login.php') echo 'class="selected"' ?>><a href="login.php">Bejelentkezés</a></li>
        <li <?php if($last_token == 'registration.php') echo 'class="selected"' ?>><a href="registration.php">Regisztráció</a></li>
        <?php } ?>
        
        <?php if (isset($_SESSION["user"])) { ?>
        <li><a href="logout.php">Kijelentkezés</a></li>
        <?php } ?>
        
    </ul>
</nav>