<?php
include 'back_twitter.php';
class profil_data extends Twitter
{
    private $id;
    public function __construct($id = NULL)
    {
        if ($id != NULL) {
            $this->id = $id;
        } else {
            $this->id = $_SESSION['id'];
        }
    }
    public function showData()
    {
        $arr = [];
        $_bdd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        $nombreDeFollower = $_bdd->query("SELECT COUNT(id_followers) AS 'nbr_followers' FROM follow WHERE id_following = '$this->id'");
        $nombreDeFollowing = $_bdd->query("SELECT COUNT(id_following) AS 'nbr_following' FROM follow WHERE id_followers = '$this->id'");
        $nombreDeTweet = $_bdd->query("SELECT COUNT(id_tweet) AS 'nbr_tweet' FROM tweet WHERE id_user = '$this->id'");
        $infouser = $_bdd->query("SELECT * FROM user u LEFT JOIN villes_france_free v ON v.ville_id = u.ville_id WHERE id = ".$this->id." ");
        $arr['nbr_follower'] = $nombreDeFollower->fetch()['0'];
        $arr['nbr_following'] = $nombreDeFollowing->fetch()['0'];
        $arr['nbr_tweet'] = $nombreDeTweet->fetch()['0'];
        $arr['infouser'] = $infouser->fetch();
        return $arr;
    }
    public function pseudotoid($_pseudo) {
        $_bdd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        $query = $_bdd->query("SELECT * FROM user WHERE pseudo LIKE '$_pseudo'");
        return $query->fetch()['id'];
    }
    public function lastTweet()
    {
        $bd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        try {
            $query = $bd->query("SELECT * FROM tweet t INNER JOIN  user u on t.id_user = u.id WHERE id_user = ".$this->id." ORDER BY date_tweet DESC LIMIT 10");
            foreach ($query->fetchAll() as $val) {
                echo "<article style=\"width:500px;padding-top:10px;box-shadow: 0 10px 10px grey;margin-left:0;margin-top: 25px;background-color: white;border-radius: 5px;\" class=\"col-lg-12 container row\">
<header  class='col-lg-12' style='float: left'>
<strong>
<a href='../Views/profil_view.php?id=".$val['id']."'>
<img style='margin-right:10px;float: left;width: 50px; height: 50px; border-radius: 100000px;' src='".$this->imgProfil($val['id'])."'>
".$val['nom']."<br></a>
</strong>
<span style='color:grey;position: absolute'>@".$val['pseudo']."</span>
</header>
<p style='overflow-wrap: break-word' class='col-lg-offset-1 col-lg-6'>".$this->formatTweet($val['tweet'])."</p>
<footer class='col-lg-5' style='float: right'>
<button onclick='reTweet(".$val['id_tweet'].")' class='btn btn-default'>".$bd->query("SELECT COUNT(id_tweet) AS 'retweets' FROM tweet WHERE id_retweet = ".$val['id_tweet']." ")->fetch()['retweets']." Retweet</button>
<button onclick='like(".$val['id_tweet'].")' class='btn btn-default'>".$bd->query("SELECT COUNT(id_tweet_like) AS 'like' FROM tweet_like WHERE id_tweet = ".$val['id_tweet']." ")->fetch()['like']." Like</button>
</footer><footer class='col-lg-12'><a style='padding-left: 40px;margin-bottom: 15px' href='comment_view.php'>Commentaire</a><br><ul style='margin-top:15px;list-style-type: none;'>
<li><div contenteditable id='comment".$val['id_tweet']."' style='margin-bottom:15px;min-height: 50px;overflow-wrap: break-word;border: solid black 1px'></div></li>
<li><button onclick='newCom(".$val['id_tweet'].")' style='margin-bottom: 15px' class='btn btn-default'>Commenter</button></li>";

                $coms = $bd->query("SELECT * FROM commentaire c INNER JOIN user u ON u.id = c.id_user WHERE c.id_tweet = ".$val['id_tweet']." LIMIT 5");
                foreach ($coms->fetchAll() as $com) {
                    echo "<li style='margin-bottom: 15px;'><a href='profil_view.php?pseudo=".$com['id_user']."' ><img style='margin-right:10px;float: left;width: 50px; height: 50px; border-radius: 100000px;' src='".$this->imgProfil($com['id'])."'><strong>".$com['nom']."</strong></a><br>".$com['com']."</li>";
                }
                echo "</ul></div></article>";

            }
            //echo "<nav><a href=\"acceuil_view.php?page=1\">1</a><a href=\"acceuil_view.php?page=2\">2</a><a href=\"acceuil_view.php?page=3\">3</a><a href=\"acceuil_view.php?page=4\">4</a><a href=\"acceuil_view.php?page=5\">5</a> Suivant</nav>";
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function isFollow($_idcurentuser){
        $_bdd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        try {
            $query = $_bdd->query("SELECT * FROM follow WHERE id_followers = ".$_idcurentuser." AND id_following = ".$this->id." ");
            if($query->rowCount() === 0) {
                return 0;
            } else {
                return 1;
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
            return 2;
        }
    }
    public function userFollow($_idcurentuser)
    {
        $_bdd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        try {
            $query = $_bdd->query("SELECT * FROM follow WHERE id_followers = ".$_idcurentuser." AND id_following = ".$this->id." ");
            if($query->rowCount() === 0) {
                $_bdd->exec("INSERT INTO follow (id_followers, id_following) VALUES (".$_idcurentuser.", ".$this->id.")");
            } else {
                $_bdd->exec("DELETE FROM follow WHERE id_followers = ".$_idcurentuser." AND id_following = ".$this->id." ");
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
            return 1;
        }
    }
}
if (array_key_exists('iduser', $_POST) AND array_key_exists('idcurrentuser', $_POST)){
    echo "success";
    $user = new profil_data($_POST['iduser']);
    $user->userFollow($_POST['idcurrentuser']);
}
