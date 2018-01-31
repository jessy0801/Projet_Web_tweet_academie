<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../Scripts/jquery.min.js" type="text/javascript"></script>
    <script src="../Scripts/fontawesome.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../Styles/style_connection_view.css">
    <link rel="stylesheet" type="text/css" href="../Styles/style_message.css">
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>

    <title>Twiiter Academie - Messages</title>
</head>

<body>
<?php include_once "header.php";
include_once "../Backends/back_message.php";
echo 'test';?>
<section class="center-block container-fluid row">
    <aside id="aside_user" style="height:55em;background-color:#2aabd2;border-right: grey solid 1px;margin-bottom: 10px" class="col-lg-3">
        <form method="get" action="message_view.php" style="background-color: white;border: solid grey 1px">
            <label for="usersearch">Chercher : </label>
            <input name="usersearch" id="usersearch" type="text">
            <input type="submit" class="btn btn-default">
        </form>
        <ul id="users" style="background-color: white;">
            <?php
                $msg = new Message($_SESSION['id']);
                if (array_key_exists('usersearch', $_GET)) {
                    $msg->searchUsers($_GET['usersearch']);
                }
                else {
                    $msg->getUsers();
                }

            ?>
        </ul>
    </aside>
    <div style="height:55em;background-color: #2aabd2" class="col-lg-9">
        <div class="">
            <?php
            if (array_key_exists('iduser', $_GET)) {
                $msg->getinfo($_GET['iduser']);
            } else {
                echo "<span>Selectioner un utilisateur</span>";
            }
            ?>
        </div>
        <ul id="msg_list" style="border-bottom: solid grey 1px;margin-bottom: 10px">
            <?php
            if (array_key_exists('iduser', $_GET)) {
                $msg = new Message($_SESSION['id']);
                $msg->lastMessage($_GET['iduser']);
            } else {

            }

            ?>
        </ul>
        <article style="background-color: #2aabd2">
            <div contenteditable id="message" ></div>
            <button onclick="sendMsg()" style="float: right" class="btn btn-default">Envoyer</button>
        </article>
    </div>
</section>
<script>
    var liste = [
        <?php $msg->getuserlist() ?>
    ];

    $('#usersearch').autocomplete({
        source : liste
    });
    function sendMsg() {
        var msg = $("#message").text();
        $.post('../Backends/back_message.php', {
            'message' : msg,
            'id_dst' : <?php echo $_GET['iduser'] ?>,
            'iduser' : <?php echo $_SESSION['id'] ?>
        }, retourfunc, 'text');
    }
    function searchUser() {
        var query = $("#usersearch").val();
        $.post('message_view.php', {
            'query' : query
        }, retourfunc, 'text');
    }
    function retourfunc(str) {
        $("#users").load(location.href + " #users");
        $("#msg_list").load(location.href + " #msg_list");
    }
    setInterval(retourfunc , 30000);
</script>
</body>
</html>