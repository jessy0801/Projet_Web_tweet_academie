<?php
//session_start();
include 'back_twitter.php';
class User extends Twitter
{
    /*public function imgProfil($_iduser)
    {
        $_bdd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        try {
            $query = $_bdd->query("SELECT img_profil FROM user WHERE id = ".$_iduser." ");
            $arr = $query->fetch();
            if ($arr['img_profil'] != ""){
                return $arr['img_profil'];
            } else {
                return "https://assets.merriam-webster.com/mw/images/article/art-wap-article-main/egg-3442-e1f6463624338504cd021bf23aef8441@1x.jpg";
            }

        }
        catch (Exception $e) {
            echo $e->getMessage();
            return 1;
        }
    }
    public function newCom($com, $_idtweet) {
        $bd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        try {
            $com = $bd->quote($com);
            //$nbrline = $bd->query("SELECT tweet_like WHERE id_user = ".$this->iduser." AND id_tweet = ".$_idtweet.")");
            //$nbrline = $nbrline->rowCount();
            $test = $bd->query("INSERT INTO commentaire (id_user, id_tweet, com) VALUES (".$this->iduser.", ".$_idtweet.", ".$com.")");
            return $test;

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function like($_idtweet) {
        $bd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        try {
            $nbrline = $bd->query("SELECT * FROM tweet_like WHERE id_user = ".$this->iduser." AND id_tweet = ".$_idtweet." ");
            $nbrline = $nbrline->rowCount();
            if ($nbrline > 0) {
                $bd->query("DELETE FROM tweet_like WHERE id_user = ".$this->iduser." AND id_tweet = ".$_idtweet." ");
            } else {
                $bd->query("INSERT INTO tweet_like (id_user, id_tweet) VALUES (".$this->iduser.", ".$_idtweet.")");
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function reTweet($_idtweet) {
        $bd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        $tweet = $bd->query("SELECT tweet FROM tweet WHERE id_tweet = ".$_idtweet." ")->fetch()['tweet'];
        $tweet = $bd->quote($tweet);
        try {
            //$nbrline = $bd->query("SELECT tweet WHERE id_user = ".$this->iduser." AND id_retweet = ".$_idtweet.")")->rowCount();
            //if ($nbrline > 0) {
            //    $bd->exec("DELETE FROM tweet WHERE id_user = ".$this->iduser." AND id_retweet = ".$_idtweet." ");
            //}
            //else {
            $test = $bd->query("INSERT INTO tweet (id_user, id_retweet, tweet) VALUES ( ".$this->iduser.", ".$_idtweet.", ".$tweet." ) ");
            //}

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }*/
    private $iduser;
    public function __construct($_iduser = NULL)
    {
        $bd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        if ($_iduser != NULL) {
            $this->iduser = $bd->quote(htmlspecialchars($_iduser));
        }else {
            $this->iduser = $_SESSION['id'];
        }
    }
    public function lastTweet($start)
    {
        $bd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        try {
            $query = $bd->query("SELECT * FROM tweet t INNER JOIN  user u on t.id_user = u.id ORDER BY date_tweet DESC LIMIT ".$start.",10 ");
            $nbpage = $bd->query("SELECT COUNT(id_tweet) AS 'lines' FROM tweet")->fetch()['lines'];
            foreach ($query->fetchAll() as $val) {
                echo "<article style=\"padding-top:10px;padding-bottom:10px;box-shadow: 0 10px 10px grey;margin-left:0;margin-top: 25px;background-color: white;border-radius: 5px;\" class=\"col-lg-12 container row\">
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
            echo "<nav style='position:fixed;left:0px; bottom:0%;background-color:rgba(000,000,000,0.8); display:flex; justify-content:center; flex-wrap:wrap;'>";
            for ($i = 1; $i<intval($nbpage)/15;$i++) {
                echo "<a style='border-radius:unset;' class='btn btn-primary' href='acceuil_view.php?page=".$i."'>Page ".$i."</a>";
            }
            echo "</nav>";

        }
        catch (Exception $e) {
            echo $e->getMessage();
        }

    }
    /*public function newTweet($str) {
        $bd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        if (strlen($str) > 140){

            return 1;
        }
        else {
            $str = $bd->quote($str);
            $bd->exec("INSERT INTO tweet (id_user, tweet) VALUE (".$this->iduser.", ".$str.")");
            return 0;
        }
    }*/
}
if (array_key_exists('tweet', $_POST)) {
    $test = new User($_POST['iduser']);
    $ret = $test->newTweet($_POST['tweet']);
    if ($ret = 1) {
        echo "toolong";
    } else {
        echo "success";
    }



}
elseif (array_key_exists('id_tweet', $_POST) && array_key_exists('like', $_POST)) {
    echo "success";
    $test = new User($_POST['iduser']);
    $test->like($_POST['id_tweet']);

}
elseif (array_key_exists('id_tweet', $_POST) && !array_key_exists('comment', $_POST)) {
    $test = new User($_POST['iduser']);
    $test->reTweet($_POST['id_tweet']);
    echo "success";
}
elseif (array_key_exists('comment', $_POST)) {
    $test = new User($_POST['iduser']);
    $test->newCom($_POST['comment'], $_POST['id_tweet']);
    echo "success";
}