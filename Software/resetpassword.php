<?php
require_once("includes/setup.php");
$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/db.php";

$sql = "SELECT * FROM users
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <Title>Reset Password|Bradford Council</Title>
    <link rel="stylesheet" href="stylesheet.css">
</head>

<body class="main">

    <?php require_once("includes/navbar.php"); ?>
    <div class="log">
        <form action="processreset.php" method="post">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <label class="placeholder">New Password</label>
            <input class="log input" type="password" id="password" name="password" minlength="8"> />
            <button class="log button" type="submit">Change</button>
        </form>
    </div>
</body>

<?php require_once("includes/footer.php"); ?>

</html>