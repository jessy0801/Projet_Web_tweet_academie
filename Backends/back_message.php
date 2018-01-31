<?php
class Message
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
    public function newMessage($msg, $dst)
    {
        try {
            $bd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
            $test = $bd->query("INSERT INTO messages (id_by, id_to, message) VALUES ('".$this->iduser."', '".$dst."', '".$msg."')");
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    public function lastMessage($_idby)
    {
        $bd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        $query = $bd->query("SELECT * FROM messages m INNER JOIN user u ON m.id_by = u.id WHERE (id_to = ".$this->iduser." AND id_by = ".$_idby.") OR (id_by = ".$this->iduser." AND id_to = ".$_idby.") ");
        foreach ($query->fetchAll() as $val) {
            if($val['id_by'] == $this->iduser){
                echo "<li style='margin-bottom: 20px;background-color: white;border-radius: 5px;width:  20%;overflow-wrap: break-word  '><span>Moi : </span><p style='display: inline-block'>".$val['message']."</p><br>
                <span>Envoyée le ".$val['date_env']."</span>
            </li>";
            }
            else {
                echo "<li style='margin-bottom: 20px;background-color: white;border-radius: 5px;width: 20%;overflow-wrap: break-word '><span>".$val['nom']." : </span><p style='display: inline-block'>".$val['message']."</p><br>
                <span>Envoyée le ".$val['date_env']."</span>
            </li>";
            }


        }
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
    public function getinfo($_iduser) {
        $bd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        $query = $bd->query("SELECT * FROM user WHERE id = ".$_iduser." ");
        $val = $query->fetch();
            echo "<div style='margin-bottom:50px;padding:10px;border-radius:5px;background-color: white'>
<img style='float:left;border-radius: 100%;width: 50px;height: 50px;' src='".$this->imgProfil($val['id'])."' alt='img profil'>
<p style='color:deepskyblue;display: inline-block'>".$val['nom']."</p>
<p style='color: grey'>@".$val['pseudo']."</p>
</div>";

    }
    public function getUsers()
    {
        $bd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        $query = $bd->query("SELECT * FROM messages m INNER JOIN user u ON m.id_by = u.id WHERE id_to = ".$this->iduser." ");
        foreach ($query->fetchAll() as $val) {
            echo "<li style=\"margin-bottom: 25px\"><a href=\"message_view.php?iduser=".$val['id']."\">
<img style=\"border-radius: 100%;height: 50px;width: 50px\" src=\"".$this->imgProfil($this->iduser)."\" alt=\"profil image\">
".$val['']."
<span>@".$val['pseudo']."</span>
</a>
</li>";
        }
    }
    public function getuserlist()
    {
        $str= "";
        $bd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        $query = $bd->query("SELECT * FROM user");
        foreach ($query->fetchAll() as $val) {
            $str .= "\"".$val['nom']."\",";
        }
        echo substr($str, 0, strlen($str)-1);
    }
    public function searchUsers($search)
    {
        $bd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
        $query = $bd->query("SELECT * FROM user WHERE nom = '".$search."'");
        foreach ($query->fetchAll() as $val) {
            echo "<li style=\"margin-bottom: 25px\"><a href=\"message_view.php?iduser=".$val['id']."\">
<img style=\"border-radius: 100%;height: 50px;width: 50px\" src=\"".$this->imgProfil($val['id'])."\" alt=\"profil image\">
".$val['']."
<span>@".$val['pseudo']."</span>
</a>
</li>";
        }
    }
}
if (array_key_exists('message', $_POST)) {
    $test = new Message($_POST['iduser']);
    $test->newMessage($_POST['message'], $_POST['id_dst']);
    echo "success";
}
