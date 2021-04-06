<nav>
    <ul>
        <li><a href="index.php">Főoldal</a></li>
        <li><a href="catalog.php">Katalógus</a></li>
        
        <?php if (isset($_SESSION["user"])) { ?>
        <li><a href="my-profile.php">Profilom</a></li>
        <?php } else { ?>
        <li><a href="login.php">Bejelentkezés</a></li>
        <li><a href="registration.php">Regisztráció</a></li>
        <?php } ?>
        
        <?php if (isset($_SESSION["user"])) { ?>
        <li><a href="logout.php">Kijelentkezés</a></li>
        <?php } ?>
        
    </ul>
</nav>