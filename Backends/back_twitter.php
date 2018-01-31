<?php
class Twitter
{
    public function formatTweet($_tweet)
    {
        $str = preg_replace('/@(\w+)/', '<a href="profil_view.php?pseudo=$1">@$1</a>' ,$_tweet);
        $str = preg_replace('/#(\w+)/', '<a href="search_view.php?search=$1">#$1</a>' ,$str);
        $str = preg_replace('/http:\/\/(.*\/\w+.\w+)/', '<img style="width:400px; height: auto;" alt="share img" src="http://$1">' ,$str);

        return $str;
    }

    public function imgProfil($_iduser)
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
    }
    public function newTweet($str) {
        $bd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        if (strlen($str) > 140){
            echo "Tweet trop long max 140 charctere";
            return 1;
        }
        else {
            $str = $bd->quote($str);
            $bd->exec("INSERT INTO tweet (id_user, tweet) VALUE (".$this->iduser.", ".$str.")");
            return 0;
        }
    }
}
