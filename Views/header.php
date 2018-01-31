<?php
if(array_key_exists('id', $_SESSION))
{

    ?>
    <header>
        <nav class="navbar" style='margin-bottom: 0;background-color: white'>
            <div class="container row center-block">
                <ul id="nav" class="nav navbar-nav col-lg-5">
                    <li id="accueil" ><a href="acceuil_view.php">Accueil</a></li>
                    <li id="menu" ><a href="profil_view.php">Profil</a></li>
                    <li><a href="message_view.php">Message</a></li>
                    <li><a href="../Backends/back_deconnection.php">Deconnection</a></li>
                </ul>
                <div class='nav navbar-brand col-lg-2'>
                    <img src='../Miscs/twitter_logo_formulaire.png' >
                </div>
                <form method="get" action="search_view.php" class="navbar-form navbar-right col-lg-5">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>

            </div>
        </nav>
    </header>
    <?php
}
