<?php
class EditProfil
{
    private $db, $iduser;
    public function __construct()
    {
        $this->iduser = $_SESSION['id'];
        try {
            $this->db = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'wac', 'pT42BQlqNs6wN9k9');
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
    public function showFollowing()
    {
        if(is_object($this->db)) {
            $_bd = $this->db;
            $_bd->query("SELECT * FROM user u INNER JOIN follow f ON u.id=f.id_following WHERE f. = ".$this->iduser." ");
        } else {
            echo "BD non connecter !";
        }
    }
}