<nav>
    <a href="home.php">
        <img src="/assets/logo.png" class="logo" />
    </a>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="assets.php">Assets</a></li>
        <?php
        if (isset($_SESSION['login']) && $_SESSION['login'] == true) { ?>
            <li><a href="logout.php">Logout</a></li>
        <?php } else { ?>
            <li><a href="login.php">Login</a></li>
        <?php } ?>
        <li><a href="register.php">Register</a></li>
        <li><a href="faqs.php">FAQs</a></li>
    </ul>
</nav>