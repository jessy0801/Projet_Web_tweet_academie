<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script src="../Scripts/jquery.min.js" type="text/javascript"></script>
    <script src="../Scripts/fontawesome.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body style="background-color: rgb(90,168,223)">
<?php include_once 'header.php';
include_once '../Backends/back_search.php'?>

<main class="col-md-4 col-md-offset-3" style="position: relative; left: 100px;">
    <section id="tweets">
        <?php
        $search = new SearchTag();
        $search->searchTweets($_GET['search']); ?>
    </section>
    <script>
        //var i = 0, lien = " ";
        /*$('#tweetcontent').on('keydown', function (e) {
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
         this.attr("href", "http://127.0.0.1/my_twitter/test.php?membre="+this.html().substr(1));
         $('#tweetcontent').attr("contenteditable", "true");
         this.attr("contenteditable", "false");
         $('#tweetcontent').focus();
         }
         });
         $('#lien1').on('keydown', function (e) {
         console.log(e.originalEvent.key);
         if (e.originalEvent.key === " ") {
         this.attr("href", "http://127.0.0.1/my_twitter/test.php?membre="+this.html().substr(1));
         $('#tweetcontent').attr("contenteditable", "true");
         this.attr("contenteditable", "false");
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
            //$("#home div").parent().remove()
            //console.log(texte_recu);

        }
        setInterval(nom_fonction_retour, 35000)

    </script>
</main>
</body>
</html>
