<?php 

require_once("includes/setup.php"); 

if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <Title>Assets|Bradford Council</Title>
    <link rel="stylesheet" href="/assets/stylesheet.css">
</head>

<body class="main">
    <?php require_once("includes/navbar.php"); ?>

    <div class="lr">
        <h1>Assets</h1>
    </div>

    <div class="upload-form">
        <h2>Upload CSV File</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload" accept=".csv">
            <input type="submit" value="Upload" name="submit">
        </form>
    </div>

</body>

<?php require_once("includes/footer.php"); ?>