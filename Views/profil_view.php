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
        if (array_key_exists('pseudo', $_GET)) {
            $tmp = new profil_data();
            $_GET['id'] = $tmp->pseudotoid($_GET['pseudo']);
        }
			if (array_key_exists('id', $_GET)) {
                $infosprofil = new profil_data($_GET['id']);
                $arr = $infosprofil->showData();
                //var_dump($arr);
            } else {
                $infosprofil = new profil_data();
                $arr = $infosprofil->showData();
            }

		?>
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
				<p>Abonnés <br/><a href="profil_followers_view.php"><?php echo $arr['nbr_follower']?></a></p>
				<p>Abonnements <br/><a href="profil_following_view.php"><?php echo $arr['nbr_following']?></a></p>
                <?php if ($_GET['id'] != NULL) {
                    if ($infosprofil->isFollow($_SESSION['id'])== 0) {
                        echo "<p><a onclick='follow()' id=\"follow\" href=\"#\">S'abonner</a></p>";
                    } elseif ($infosprofil->isFollow($_SESSION['id'])== 1) {
                        echo "<p><a onclick='follow()' id=\"follow\" href=\"#\">Abonné</a></p>";
                    }

                } else {
                    echo "<p><a href=\"profil_edit_view.php\">Editer profil</a></p>";
                }
                ?>

			</div>
		</div>

		</div>
	</header>
	<main>
	<div class="row">
		<div id="profil_info" class="col-md-2 col-md-offset-2" style="word-wrap: break-word;">
			<p><h1 style="color: black; font-size: 1.6em; margin:0px; font-weight: bold;"><?php echo $arr['infouser']['nom']; ?></h1>
			<span><a style="color: grey"><?php echo $arr['infouser']['pseudo']; ?></a></span></p>
			<p><?php echo $arr['infouser']['description']; ?></p>
			<ul style="list-style-type: none; padding: 0px;">
				<li><i class="fa fa-map-marker"></i><span><?php echo $arr['infouser']['ville_nom']; ?></span></li>
				<li><i class="fa fa-globe"></i><span><a><?php echo $arr['infouser']['web']; ?></a></span></li>
				<li><i class="fa fa-calendar"></i><span><?php echo $arr['infouser']['date_ins']; ?></span></li>
				<li><i class="fa fa-birthday-cake"></i><span><?php echo $arr['infouser']['date_nais']; ?></span></li>
			</ul>
		</div>
		<section class="col-md-4 row">
			<?php $infosprofil->lastTweet(); ?>
		</section>
		<div class="col-md-2">

		</div>
	</div>
	</main>
    <script>
            function editprofil() {

            }
            function follow() {
                $.post('../Backends/back_profil.php', {
                    iduser : <?php if(array_key_exists('id', $_GET)){echo $_GET['id'];}else{echo $_SESSION['id'];}?>,
                    idcurrentuser : <?php echo $_SESSION['id']?>
                }, retourFunc, 'text');
            }
            function retourFunc(str){
                if (str === "success") {
                    if ($('#follow').html() === "S'abonner") {
                        $('#follow').html("Abonné");
                        $("#nav_bar").load(location.href+" #nav_bar>*","");
                    } else {
                        $('#follow').html("S'abonner");
                        $("#nav_bar").load(location.href+" #nav_bar>*","");
                    }
                }

            }


    </script>
	</body>
	</html>
	<?php
}
else
{
	header('Location: connection_view.php');

}