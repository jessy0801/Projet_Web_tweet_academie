<?php session_start();?>

<!DOCTYPE html>

<html>

<head>
    <title></title>
    <?php include('../Backends/back_profil_followers.php');
    $a = new user_abonner;
    ?>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../Styles/style_followers_view.css">
</head>

<body>

<?php include_once "header.php"; ?>

<main style="display: flex; flex-wrap: wrap;">

    <?php

    $a->affiche_abos();

    ?>
</main>

</body>

</html>