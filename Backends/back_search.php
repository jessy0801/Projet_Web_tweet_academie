<?php
include 'back_twitter.php';
class SearchTag extends Twitter
{
    private $iduser;
    public function __construct($_iduser = NULL)
    {
        if ($_iduser != NULL) {
            $this->iduser = $_iduser;
        }
        else {
            $this->iduser = $_SESSION['id'];
        }
    }
    public function searchTweets($tag)
    {

        $search = addslashes(htmlspecialchars($tag));
        $bd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        $hashtag = $bd->query("SELECT * FROM tweet t INNER JOIN user u ON u.id = t.id_user WHERE tweet LIKE  '%#$search%'");
        foreach ($hashtag->fetchAll() as $val) {
            echo "<article style=\"padding-top:10px;padding-bottom:10px;box-shadow: 0 10px 5px grey;margin-left:0;margin-top: 25px;background-color: white;border-radius: 5px;\" class=\"col-lg-12 container row\">
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
</footer><div class='col-lg-12'><a style='padding-left: 40px;margin-bottom: 15px' href='comment_view.php'>Commentaire</a><br><ul style='margin-top:15px;list-style-type: none;'>
<li><div contenteditable id='comment".$val['id_tweet']."' style='margin-bottom:15px;min-height: 50px;overflow-wrap: break-word;border: solid black 1px'></div></li>
<li><button onclick='newCom(".$val['id_tweet'].")' style='margin-bottom: 15px' class='btn btn-default'>Commenter</button></li>";

            $coms = $bd->query("SELECT * FROM commentaire c INNER JOIN user u ON u.id = c.id_user WHERE c.id_tweet = ".$val['id_tweet']." LIMIT 5");
            foreach ($coms->fetchAll() as $com) {
                echo "<li style='margin-bottom: 15px;'><a href='profil_view.php?pseudo=".$com['id_user']."' ><img style='margin-right:10px;float: left;width: 50px; height: 50px; border-radius: 100000px;' src='".$this->imgProfil($com['id'])."'><strong>".$com['nom']."</strong></a><br>".$com['com']."</li>";
            }
            echo "</ul></div></article>";

        }

    }
}