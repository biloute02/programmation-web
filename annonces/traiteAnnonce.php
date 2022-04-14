<?php
if(isset($_POST["submit"])) {
	date_default_timezone_set('Europe/Paris');
	include '../include/connex.inc.php';
	session_start();
	$U_ID = $_SESSION['U_ID'];
	
	$idcom = connex("myparam");

	$titre = mysqli_real_escape_string($idcom, $_POST["titre"]);
	$type_l = $_POST["logement"];
	$date_d = $_POST["date_deb"];
	$date_f = $_POST["date_fin"];
	$date_p = date('Y-m-d');
	$adrs = mysqli_real_escape_string($idcom, trim($_POST["adresse"]));
	$ville = mysqli_real_escape_string($idcom, trim($_POST["ville"]));
	$cp = trim($_POST["CP"]);
	$pays = mysqli_real_escape_string($idcom, trim($_POST["pays"]));
	$desc = mysqli_real_escape_string($idcom, trim($_POST["desc"]));
	$prix = trim($_POST["prix"]);
	$surface = trim($_POST["surface"]);
	$nb_p = trim($_POST["pieces"]);
	$file = $_FILES['photo'];
	$SQL_INSERT = "INSERT INTO annonce (statut, titre, type_logement, date_deb, date_fin, date_post, adresse, ville, cp, pays, contenu_annonce, prix, surface, nb_pieces, U_ID) VALUES(1, '$titre', '$type_l', '$date_d', '$date_f', '$date_p', '$adrs', '$ville', $cp, '$pays','$desc', $prix, $surface, $nb_p, $U_ID)";
	if (strlen($pays) <= 50 && strlen($ville) <= 50 && strlen($adrs) <= 50 && strlen($titre) <= 30 && $cp >= 0 && $cp <= 99999) {

					if(preg_match('/^[0-9]+\ [a-zA-Z- 0-9]+/', $adrs)) {	
					mysqli_query($idcom, $SQL_INSERT);
					
					$selectaid = "SELECT MAX(A_ID) FROM annonce WHERE  U_ID = $U_ID";
					$A_ID = mysqli_query($idcom, $selectaid);
					$A_ID = $A_ID->fetch_array();
					$A_ID = $A_ID['MAX(A_ID)'];			

					for ($i = 0; $i < count($file['name']); $i++) {
						$ext = pathinfo($file['name'][$i], PATHINFO_EXTENSION);
						$nom = $A_ID . "_" . $i . "." . $ext;
						$origine = $file['tmp_name'][$i];
						$destination = '../photos/'.$nom;
						move_uploaded_file($origine,$destination);

						$destination = './photos/'.$nom;
						$query = "INSERT INTO photo VALUES(null, '$destination', $U_ID, $A_ID, $i)";
						mysqli_query($idcom, $query);
					}
					mysqli_close($idcom);		
				}else{
					echo "Adresse invalide <a href='./createAnnonce.html'>Retour sur la page de creation</a>";
					die();
				}
				echo "Votre annonce a bien ete poste <a href='../index.php'>Retour sur la page d'accueil</a>";
				}
				else echo "Taille d'un champs invalide, titre : 30, pays, adresse, ville : 50 et code postal compris entre 0 et 99999";
			}
	
?>
