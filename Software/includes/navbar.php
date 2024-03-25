<nav>
    <a href="home.php">
        <img src="/assets/logo.png" class="logo" />
    </a>
    <ul>
        <li><a href="/home.php">Home</a></li>
        <?php
        if (isset($_SESSION['login']) && $_SESSION['login'] == true) { ?>
            <li><a href="/upload.php">Upload</a></li>
            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) { ?>
                <li><a href="/admin/index.php">Admin</a></li>
            <?php } ?>
            <li><a href="/logout.php">Logout</a></li>
        <?php } else { ?>
            <li><a href="/login.php">Login</a></li>
            <li><a href="/register.php">Register</a></li>
        <?php } ?>
        <li><a href="/faqs.php">FAQs</a></li>
    </ul>
</nav>