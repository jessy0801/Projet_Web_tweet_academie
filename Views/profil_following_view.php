<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../Styles/style_followers_view.css">
    <?php include '../Backends/back_profil_following.php'; $following = new user_following();?>
</head>
<body>
<?php include 'header.php'; ?>
<main style="display: flex; flex-wrap: wrap;">
    <?php
    $following->show_following();
    ?>
</main>
</body>
</html>
