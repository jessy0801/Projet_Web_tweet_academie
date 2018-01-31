<?php

class user_following
{

    private $id;

    public function __construct()
    {
        if(isset($_GET['id']))
        {
            $this->id = $_GET['id'];
        }
        else
        {
            $this->id = $_SESSION['id'];
        }
    }

    public function show_following() {

        $id_user = $this->id;
        $bdd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');

        $user_following = $bdd->query("SELECT * FROM `follow` INNER JOIN user ON user.id = follow.id_following WHERE id_followers = $id_user");

        foreach ($user_following as $value) {

            $value['img_couverture'] . '<br>';
            $value['img_profil'] . '<br>';
            $value['nom'] . '<br>';
            $value['pseudo'] . '<br>';

            $followers = $value['id_following'];

            $nbr_tweet = $bdd->query("SELECT COUNT(id_tweet) FROM tweet WHERE id_user = $followers");
            $tweet_nbr = $nbr_tweet->fetch();
            $nbr_abonner = $bdd->query("SELECT COUNT(id_followers) FROM follow WHERE id_following = $followers");
            $abonner_nbr = $nbr_abonner->fetch();
            $nbr_abonnement = $bdd->query("SELECT COUNT(id_following) FROM follow WHERE id_followers = $followers");
            $abonnement_nbr = $nbr_abonnement->fetch();
            ?>

            <div class="twPc-div" style="width: 100%; margin:10px;">
                <a class="twPc-bg twPc-block" style="background: unset;"><img src="<?php echo $value['img_couverture'];?>" width="100%" height="100%"></a>
                <div style="position: relative;">
                    <a title="Mert Salih Kaplan" href="" class="twPc-avatarLink">
                        <img alt="Mert Salih Kaplan" style="" src="<?php echo $value['img_profil'];?>" class="twPc-avatarImg">
                    </a>

                    <div class="twPc-divUser">
                        <div class="twPc-divName">
                            <a href="#"><?php echo $value['nom']; ?></a>
                        </div>
                        <span>
							<a href="../Views/profil_view.php?id=<?php echo $value['id_following'];?>">@<span><?php echo $value['pseudo']; ?></span></a>
						</span>
                    </div>

                    <div class="twPc-divStats">
                        <ul class="twPc-Arrange">
                            <li class="twPc-ArrangeSizeFit">
                                <a href="#" title="9.840 Tweet">
                                    <span style="text-align: center;" class="twPc-StatLabel twPc-block">Tweets</span>
                                    <span style="text-align: center;" class="twPc-StatValue"><?php echo $tweet_nbr[0]; ?></span>
                                </a>
                            </li>
                            <li class="twPc-ArrangeSizeFit">
                                <a href="#/following" title="885 Following">
                                    <span  style="text-align: center;" class="twPc-StatLabel twPc-block">Following</span>
                                    <span style="text-align: center;" class="twPc-StatValue"><?php echo $abonner_nbr[0]; ?></span>
                                </a>
                            </li>
                            <li class="twPc-ArrangeSizeFit">
                                <a href="#/followers" title="1.810 Followers">
                                    <span style="text-align: center;" class="twPc-StatLabel twPc-block">Followers</span>
                                    <span style="text-align: center;" class="twPc-StatValue"><?php echo $abonnement_nbr[0]; ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
        }
    }

}
?>
