<?php 
	include 'config.php';

	try{
		$oPDO = new PDO(DSN,USER,PASS);
	}
	catch(PDOException $e) {
    	echo 'Connexion échouée : ' . $e->getMessage();
	}

	$sQuery = "";

	if(isset($_POST['genre']) && $_POST['genre'] != "rien"){ $sQuery .=  "AND g.code_genre = " . (int)$_POST['genre'];}
	if(isset($_POST['acteur']) && $_POST['acteur'] != "rien"){ $sQuery .=  "AND i.code_indiv = " . (int)$_POST['acteur'];}
	if(isset($_POST['pays']) && $_POST['pays'] != "rien"){ $sQuery .=  "AND f.pays = " . $_POST['pays'];}
	if(isset($_POST['annee']) && $_POST['annee'] != "rien"){ $sQuery .=  "AND f.date = " . (int)$_POST['annee'];}

	$oPDOStatement = $oPDO->prepare('SELECT * FROM films f, genres g, classification c, acteurs a, individus i WHERE f.code_film = c.ref_code_film AND c.ref_code_genre = g.code_genre	AND a.ref_code_acteur = i.code_indiv AND f.code_film = a.ref_code_film ' . $sQuery);

	$oPDOStatement->execute();
	$aFilms = $oPDOStatement->fetchAll();

	$oFile = fopen("export.xml", "w");

	$sXml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
	$sXml .= "<LISTE>\r\n";
    $sXml .= "<FILMS>\r\n";
	foreach($aFilms as $aDataFilm){
		$sXml .= "<FILM>\r\n";
		$sXml .= "<TITRE>\r\n";
			$sXml .= "<ORIGINAL>" . trim(utf8_encode($aDataFilm['titre_original'])) . "</ORIGINAL>\r\n";
			$sXml .= "<FRANCAIS>" . trim(utf8_encode($aDataFilm['titre_francais'])) . "</FRANCAIS>\r\n";
		$sXml .= "</TITRE>\r\n";
		$sXml .= "<GENRE>" . trim(utf8_encode($aDataFilm['nom_genre'])) . "</GENRE>\r\n";
		$sXml .= "<DUREE>" . $aDataFilm['duree'] . "</DUREE>\r\n";
		$sXml .= "<DATE>" . $aDataFilm['date'] . "</DATE>\r\n";
		$sXml .= "<PAYS>" . trim(utf8_encode($aDataFilm['pays'])) . "</PAYS>\r\n";
		$sXml .= "<REALISATEUR>" . utf8_encode($aDataFilm['realisateur']) . "</REALISATEUR>\r\n";

		$oPDOStatement = $oPDO->prepare('SELECT nom, prenom FROM acteurs a, individus i WHERE a.ref_code_acteur = i.code_indiv AND a.ref_code_film = ' . (int)$aDataFilm['code_film']);
		$oPDOStatement->execute();
		$aFilmActeurs = $oPDOStatement->fetchAll();
		foreach ($aFilmActeurs as $aDataActeurs) {
			$sXml .= "<ACTEUR>\r\n";
				$sXml .= "<NOM>" . trim(utf8_encode($aDataActeurs['nom'])) . "</NOM>\r\n";
				$sXml .= "<PRENOM>" . trim(utf8_encode($aDataActeurs['prenom'])) . "</PRENOM>\r\n";
			$sXml .= "</ACTEUR>\r\n";
		}
		$sXml .= "</FILM>\r\n";
	}
    $sXml .= "</FILMS>\r\n";
	$sXml .= "</LISTE>\r\n";

	fwrite($oFile, $sXml);
	header('Location:index.php');
?>