<?php
session_start();
class user_connection
{
    private $pseudo;
    private $mdp;
    public $dbh;
    public $message;

    public function __construct()
    {
        if(array_key_exists('connection_user_email', $_POST))
        {
            try {
                $mailverif = $this->pseudo = addslashes(htmlspecialchars($_POST['connection_user_email']));
                $mdpverif = $this->mdp = addslashes(htmlspecialchars(hash_hmac('ripemd160', $_POST['connection_user_password'], 'si tu aimes la wac tape dans tes mains')));
                $bdd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'islam', 'pT42BQlqNs6wN9k9');
                $user = $bdd->query("SELECT * FROM user WHERE (mail = '$mailverif' OR pseudo ='$mailverif') AND password = '$mdpverif'");
                $num_rows = $user->rowCount();
                if ($num_rows == 1) {
                    foreach ($user as $value) {
                        $_SESSION['id'] = $value['id'];
                        header('Location: acceuil_view.php');
                    }
                } else {
                    $this->message = "<p class='alert alert-danger'>Mauvais mail ou mot de passe !<p>";
                }
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }

        }
    }
}
