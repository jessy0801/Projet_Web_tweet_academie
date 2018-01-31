<?php
class user_abonner
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
    public function affiche_abos()
    {
        $id_user = $this->id;
        $bdd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        $followers = $bdd->query("SELECT * FROM follow INNER JOIN user ON user.id = follow.id_followers WHERE id_following = $id_user ORDER BY `id_follow` ASC ");
        foreach($followers as $value)
        {
            $id_abonner = $value['id_followers'];
            $nombreDeFollowers= $bdd->query("SELECT COUNT(id_followers) AS 'nbr_followers' FROM follow WHERE id_following = $id_abonner");
            $nombreDeFollowing = $bdd->query("SELECT COUNT(id_following) AS 'nbr_following' FROM follow WHERE id_followers = $id_abonner");
            $nombreDeTweet = $bdd->query("SELECT COUNT(id_tweet) AS 'nbr_tweet' FROM tweet WHERE id_user = $id_abonner");
            $arr['nbr_follower'] = $nombreDeFollowers->fetch()['0'];
            $arr['nbr_following'] = $nombreDeFollowing->fetch()['0'];
            $arr['nbr_tweet'] = $nombreDeTweet->fetch()['0'];
            ?>
            <div class="twPc-div" style="width: 100%; margin:10px;">
                <a class="twPc-bg twPc-block" style="background: unset;"><img src="<?php echo $value['img_couverture'];?>" width="100%" height="100%"></a>
                <div style="position: relative;">
                    <a title="Mert Salih Kaplan" href="#" class="twPc-avatarLink">
                        <img alt="Mert Salih Kaplan" style="" src="<?php echo $value['img_profil'];?>" class="twPc-avatarImg">
                    </a>
                    <div class="twPc-divUser">
                        <div class="twPc-divName">
                            <a href="#"><?php echo $value['nom']; ?></a>
                        </div>
                        <span>
                            <a href="../Views/profil_view.php?id=<?php echo $value['id_followers'];?>">@<span><?php echo $value['pseudo']; ?></span></a>
                        </span>
                    </div>
                    <div class="twPc-divStats">
                        <ul class="twPc-Arrange">
                            <li class="twPc-ArrangeSizeFit">
                                <a href="#" title="9.840 Tweet">
                                    <span style="text-align: center;" class="twPc-StatLabel twPc-block">Tweets</span>
                                    <span style="text-align: center;" class="twPc-StatValue"><?php echo $arr['nbr_tweet']; ?></span>
                                </a>
                            </li>
                            <li class="twPc-ArrangeSizeFit">
                                <a href="#" title="885 Following">
                                    <span style="text-align: center;" class="twPc-StatLabel twPc-block">Following</span>
                                    <span style="text-align: center;" class="twPc-StatValue"><?php echo $arr['nbr_following']; ?></span>
                                </a>
                            </li>
                            <li class="twPc-ArrangeSizeFit">
                                <a href="#" title="1.810 Followers">
                                    <span  style="text-align: center;" class="twPc-StatLabel twPc-block">Followers</span>
                                    <span style="text-align: center;" class="twPc-StatValue"><?php echo $arr['nbr_follower']; ?></span>
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