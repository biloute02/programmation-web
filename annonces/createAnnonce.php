<?php
include 'connex.php';
	if(isset($_POST["submit"])) {		
		$type_l = $_POST["logement"];
		$date_d = $_POST["date_deb"];
		$date_f = $_POST["date_fin"];
		$adrs = trim($_POST["adresse"]);
		$ville = trim($_POST["ville"]);
		$cp = trim($_POST["CP"]);
		$pays = trim($_POST["pays"]);
		$prix = trim($_POST["prix"]);
		$surface = trim($_POST["surface"]);
		$nb_p = trim($_POST["pieces"]);
		$photo = trim($_POST["photo"]);
	
		echo $photo;
		
		if(preg_match('/^[0-9]+\ [a-zA-Z- 0-9]+/', $adrs)) {	
			$SQL_INSERT = "INSERT INTO annonce (type_logement, date_deb, date_fin, adresse, ville, cp, pays, prix, surface, nb_pieces) VALUES('$type_l', '$date_d', '$date_f', '$adrs', '$ville', $cp, '$pays', $prix, $surface, $nb_p)";
		
			$idcom = connex("clementmargotin", "login") or die("Erreur de connexion");
			mysqli_query($idcom, $SQL_INSERT);
			$oue = file_put_contents("../image", $photo);
			mysqli_close($idcom);
		}
	}
?>
