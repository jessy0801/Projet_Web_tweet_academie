<?php
session_start();
if(array_key_exists('id', $_SESSION))
{
    ?>
    <!DOCTYPE html>
    <html style="padding-bottom: 100px;">
    <head>
        <title>Twitter academie - Acceuil</title>
        <script src="../Scripts/jquery.min.js" type="text/javascript"></script>
        <script src="../Scripts/fontawesome.js" type="text/javascript"></script>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../Styles/style_connection_view.css">
    </head>
    <body style="background-color: rgb(90,168,223)">
    <?php
    include_once "header.php";
    include_once "../Backends/back_acceuil.php";
    ?>
    <div style="margin-top: 50px" class="container row center-block">
        <aside id="test" style="background-color: white;border-radius: 5px;" class="col-lg-3">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam commodi cupiditate dolorem error facilis in iure libero magni minus modi nihil nostrum, nulla numquam officiis possimus quas quibusdam totam voluptatum!
        </aside>

        <div id="home" class="col-lg-6">
            <article style="box-shadow: 0 10px 10px grey;padding-top:15px;padding-bottom:15px;background-color: white;border-radius: 5px" class="col-lg-12 container">
                <header>Tweeter : </header>
                <div id="tweetcontent" style="overflow-wrap: break-word;border: solid black 1px;min-height: 50px" contenteditable></div>
                <footer><button onclick="tweet()" id="tweet" class="btn btn-default">Tweeter</button></footer>
            </article>
            <section id="tweets">
                <?php
                try {
                    $user = new User();
                    if (array_key_exists('page', $_GET)) {
                        $start = $_GET['page']*15;
                    } else {
                        $start = 0;
                    }
                    $user->lastTweet($start);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }

                ?>
            </section>
        </div>
        <aside style="background-color: white;border-radius: 5px;" class="col-lg-3">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam deserunt nihil obcaecati perferendis quae quibusdam similique. Corporis dignissimos dolore fugiat quasi. At dicta dolor excepturi, facere id minima provident veritatis!
        </aside>
    </div>

    <script>
        /*var i = 0, lien = " ";
        $('#tweetcontent').on('keydown', function (e) {
         console.log(e.originalEvent.key);
         if (e.originalEvent.key === "@") {
         i++;
         $(this).append("<a id='lien"+i+"' href=''></a>");
         lien = $('#lien'+i);
         $(this).attr("contenteditable", "false");
         lien.attr("contenteditable", "true");
         lien.focus();
         }
         else if (e.originalEvent.key === " ") {

         lien.attr("href", "http://127.0.0.1/my_twitter/profil_view.php?pseudo="+lien.text().substr(1));
         $('#tweetcontent').attr("contenteditable", "true");
         lien.attr("contenteditable", "false");
         $('#tweetcontent').focus();
         }
         });
         $('#lien1').on('keydown', function (e) {
         console.log(e.originalEvent.key);
         if (e.originalEvent.key === " ") {
         lien.attr("href", "http://127.0.0.1/my_twitter/profil_view.php?pseudo="+lien.text().substr(1));
         $('#tweetcontent').attr("contenteditable", "true");
         lien.attr("contenteditable", "false");
         $('#tweetcontent').focus();
         }
         });*/
        function reTweet(idtweet) {
            $.post(
                '../Backends/back_acceuil.php',

                {

                    'id_tweet': idtweet,
                    'iduser': <?php echo $_SESSION['id']?>

                },
                nom_fonction_retour,
                'text'
            );
        }
        function like(idtweet) {
            $.post(
                '../Backends/back_acceuil.php', // Le fichier cible côté serveur.

                {
                    'like' : 1,
                    'id_tweet': idtweet, // Nous supposons que ce formulaire existe dans le DOM.
                    'iduser': <?php echo $_SESSION['id']?>

                },
                nom_fonction_retour, // Nous renseignons uniquement le nom de la fonction de retour.
                'text' // Format des données reçues
            );
        }
        function tweet() {
            var tweet = $('#tweetcontent').text();
            $.post(
                '../Backends/back_acceuil.php', // Le fichier cible côté serveur.

                {
                    'tweet': tweet, // Nous supposons que ce formulaire existe dans le DOM.
                    'iduser': <?php echo $_SESSION['id']?>
                },
                nom_fonction_retour, // Nous renseignons uniquement le nom de la fonction de retour.
                'text' // Format des données reçues
            );
        }
        function newCom(idtweet) {
            var comment = $('#comment'+idtweet).text();
            $.post(
                '../Backends/back_acceuil.php', // Le fichier cible côté serveur.

                {
                    'comment': comment, // Nous supposons que ce formulaire existe dans le DOM.
                    'id_tweet': idtweet,
                    'iduser': <?php echo $_SESSION['id']?>
                },
                nom_fonction_retour, // Nous renseignons uniquement le nom de la fonction de retour.
                'text' // Format des données reçues
            );
        }

        function nom_fonction_retour(texte_recu){
                $("#tweets").load(location.href + " #tweets");
                if (texte_recu === "toolong") {
                    alert("Tweet superieure a 140 caratére");
                }
                //$("#home div").parent().remove()
            //console.log(texte_recu);

        }
        setInterval(nom_fonction_retour, 30000)

    </script>
    <?php print_r($_SESSION); ?>
    </body>
    </html>
    <?php
}
else
{
    header('Location: connection_view.php');
}