<?php 
class user_inscription
{
	private $nom;
	private $mdp;
	private $email;
	private $pseudo;
	public $message;

	public function __construct()
	{
		$bool = false;
		foreach($_POST as $key => $value)
			{
				if(!empty($_POST[$key]))
				$bool = true;
			}
		if($bool)
		{
			$nom = $this->nom = addslashes(htmlspecialchars($_POST['nom_inscription']));
			$pseudo = $this->pseudo = str_replace(" ", "", $nom);
			$email = $this->email = addslashes(htmlspecialchars($_POST['email_inscription']));
			$mdp = $this->mdp = addslashes(htmlspecialchars(hash_hmac('ripemd160', $_POST['password_inscription'], 'si tu aimes la wac tape dans tes mains')));
			$bdd = new PDO('mysql:host=185.41.154.194;dbname=common-database', 'wac', 'pT42BQlqNs6wN9k9');
			$emailverif = $bdd->query("SELECT mail FROM user WHERE mail ='$email'");
			$countemail = $emailverif->rowCount();
			if($countemail == 0)
				{
					try
						{
							if(preg_match("#[a-zA-Z\s]$#", $nom))
							{
								$bdd->query("INSERT INTO user (pseudo, nom, mail, password) VALUES('$pseudo','$nom','$email','$mdp')");
								header('Location: ../Views/connection_view.php');
							}
							else
							{
								$this->message = "<p class='alert alert-danger'> <b>Nom : </b>Seul les lettres majuscules et miniscules sont autorisées !</p>";
							}
						}
					catch(Exception $e)
						{
							echo $e;
						}
				}
			else
				{
					$this->message = "<p class='alert alert-danger'> Email déjà utilisé !</p>";
				}
		}
	}
}
?>