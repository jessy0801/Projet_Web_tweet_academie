<?php
session_start();
$bool = false;
foreach($_SESSION as $key => $value)
{
    if(!empty($_SESSION[$key]))
        $bool = true;
}
if($bool)
{
    ?>
    <!DOCTYPE html>
    <html>
    <head>

        <meta charset="utf-8">
        <script src="../Scripts/jquery.min.js" type="text/javascript"></script>
        <script src="../Scripts/fontawesome.js" type="text/javascript"></script>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../Styles/style_profil_view.css">
        <?php
        include('../Backends/back_profil.php');
        if (array_key_exists('id', $_GET)) {
            $infosprofil = new profil_data($_GET['id']);
            $arr = $infosprofil->showData();
            //var_dump($arr);
        } else {
            $infosprofil = new profil_data();
            $arr = $infosprofil->showData();
        }

        ?>
        <?php

        function villes_option()
        {
            $bdd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
            $villes = $bdd->query("SELECT ville_nom FROM villes_france_free");
            {
                foreach($villes as $ville)
                {
                    echo "<option>". $ville['ville_nom']."</option>";
                }
            }
        }
        ?>
        <script>
            var villes = [
                <?php $bdd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
                $villes = $bdd->query("SELECT ville_nom, ville_code_postal FROM villes_france_free");
                {
                    echo "{";
                    foreach($villes as $ville)
                    {
                        echo "'cpostal' : '". $ville['ville_code_postal']."', ";
                        echo "'ville' : '". $ville['ville_nom']."'";

                    }
                    echo "}";
                } ?>
            ];
            console.log(villes);

        </script>
        <title>Twitter academie - <?php echo $arr['infouser']['pseudo']?></title>
    </head>
    <body>
    <?php include_once "header.php" ?>
    <header>
        <div id="header_profil_container" style="background:<?php if(!empty($arr['infouser']['img_couverture'])){echo 'url('.$arr['infouser']['img_couverture'];}?>) no-repeat center; background-size: 100% 100%">
            <div class="cercle_photo" style="">
                <?php if($arr['infouser']['img_profil'] != "")
                {
                    ?><img src="<?php echo $arr['infouser']['img_profil']; ?>" style="width: 100%; height: 100%; border-radius: 100000px;"/>
                    <?php
                }
                else
                {
                    ?><a><i class="fa fa-camera-retro fa-5x"></i></a><?php
                }
                ?>
            </div>
        </div>
        <div id="nav_container" >
            <div style="position: absolute; left: 33%;">
                <div id="nav_bar">
                    <p>Tweets <br/><a href="#"><?php echo $arr['nbr_tweet']?></a></p>

                    <p>Abonnés <br/><a href="profil_followers_view.php<?php if (isset($_GET['id'])){echo '?id=' . $_GET['id'];} ?>"><?php echo $arr['nbr_follower']?></a></p>

                    <p>Abonnements <br/><a href="profil_following_view.php<?php if (isset($_GET['id'])){echo '?id=' . $_GET['id'];} ?>"><?php echo $arr['nbr_following']?></a></p>
                    <p>
                        <a href="profil_view.php">Annuler</a>
                    </p>
                </div>
            </div>

        </div>
    </header>
    <main>
        <div class="row">
            <div id="profil_info" class="col-md-4 col-md-offset-2" style="word-wrap: break-word;">
                <form method="post" action="../Backends/back_profil_edit.php">
                    <p>
                        <label for="newNom">Nom :</label>
                        <input type="text" name="newNom" id="newNom" value="<?php echo $arr['infouser']['nom']; ?>">
                    </p>
                    <p>
                        <label for="newPseudo">Pseudo :</label>
                        @<input type="text" name="newPseudo" id="newPseudo" value="<?php echo $arr['infouser']['pseudo']; ?>">
                    </p>
                    <p>
                        <label for="newVille"><i class="fa fa-map-marker"></i></label>
                        <select name="newVille"><option selected style="background-color:rgba(211,92,219,0.3);"><?php echo $arr['infouser']['ville_nom']; ?></option><?php villes_option();?></select>
                    </p>
                    <p>
                        <label for="newWeb"><i class="fa fa-globe"></i></label>
                        <input type="text" name="newWeb" id="newWeb" value="<?php echo $arr['infouser']['web']; ?>">
                    </p>
                    <p>
                        <label for="newBirth"><i class="fa fa-birthday-cake"></i></label>
                        <input type="text" name="newBirth" id="newBirth" value="<?php echo $arr['infouser']['date_nais']; ?>">
                    </p>
                    <p>
                        <input type="submit" value="mettre à jour">
                    </p>
                </form>
            </div>
        </div>
    </main>
    </body>
    </html>
    <?php
}
else
{
    header('Location: connection_view.php');

}