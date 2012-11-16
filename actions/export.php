<?php 
	include '../config.php';

	try{
		$oPDO = new PDO(DSN,USER,PASS);
	}
	catch(PDOException $e) {
    	echo 'Connexion échouée : ' . $e->getMessage();
	}

	$nTest = 0;

	$TABLES = "";
	$WHERE = "";

	if(isset($_POST['genre_film']) && $_POST['genre_film'] != "rien"){ 
		$TABLES .= ", genres g, classification c";
		$WHERE .= " AND g.code_genre = c.ref_code_genre AND f.code_film = c.ref_code_film AND g.code_genre = " . (int)$_POST['genre_film'];
	}
	if(isset($_POST['nom_acteur']) && $_POST['nom_acteur'] != "rien"){ 
		$TABLES .= ", acteurs a, individus i";
		$WHERE .= " AND i.code_indiv = a.ref_code_acteur AND a.ref_code_film = f.code_film AND i.code_indiv = " . (int)$_POST['nom_acteur'];
	}
	if(isset($_POST['nom_realisateur']) && $_POST['nom_realisateur'] != "rien"){ 
		$WHERE .= " AND f.realisateur = " . (int)$_POST['nom_realisateur'];
	}
	if(isset($_POST['pays_film']) && $_POST['pays_film'] != "rien"){ 
		$WHERE .=  " AND f.pays = '" . utf8_decode($_POST['pays_film']) ."'";
	}
	if(isset($_POST['annee_film']) && $_POST['annee_film'] != "rien"){ 
		$WHERE .=  " AND f.date = " . (int)$_POST['annee_film'];
	}


	$oPDOStatement = $oPDO->prepare('SELECT * FROM films f' . $TABLES . ' WHERE 1'. $WHERE .' ORDER BY f.titre_original');
	$oPDOStatement->execute();
	$aFilms = $oPDOStatement->fetchAll();

	$oFile = fopen("../export.xml", "w");

	$sXml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
	$sXml .= "<LISTE>\r\n";
    $sXml .= "<FILMS>\r\n";
	foreach($aFilms as $aDataFilm){
		$sXml .= "<FILM>\r\n";
		$sXml .= "<TITRE>\r\n";
			$sXml .= "<ORIGINAL>" . trim(utf8_encode($aDataFilm['titre_original'])) . "</ORIGINAL>\r\n";
			$sXml .= "<FRANCAIS>" . trim(utf8_encode($aDataFilm['titre_francais'])) . "</FRANCAIS>\r\n";
		$sXml .= "</TITRE>\r\n";
		
		$oPDOStatement = $oPDO->prepare('SELECT * FROM genres g, classification c WHERE  c.ref_code_film = ' . (int)$aDataFilm['code_film'] . '	AND c.ref_code_genre = g.code_genre');
		$oPDOStatement->execute();
		$aGenres = $oPDOStatement->fetchAll();
		foreach ($aGenres as $aGenre) {
			if($nTest == 0){
				$sXml .= "<GENRES>\r\n";
				$nTest = 1;
			}
			$sXml .= "<GENRE>" . trim(utf8_encode($aGenre['nom_genre'])) . "</GENRE>\r\n";
		}
		if ($nTest == 1) {
			$sXml .= "</GENRES>\r\n";
			$nTest = 0;
		}
		
		$sXml .= "<DUREE>" . $aDataFilm['duree'] . "</DUREE>\r\n";
		$sXml .= "<DATE>" . $aDataFilm['date'] . "</DATE>\r\n";
		$sXml .= "<PAYS>" . trim(utf8_encode($aDataFilm['pays'])) . "</PAYS>\r\n";
		$oPDOStatement = $oPDO->prepare('SELECT nom, prenom FROM individus WHERE code_indiv =' . (int)$aDataFilm['realisateur']);
		$oPDOStatement->execute();
		$aRealisateurs = $oPDOStatement->fetchAll();
		foreach ($aRealisateurs as $aRealisateur) {
			$sXml .= "<REALISATEUR>" . trim(utf8_encode($aRealisateur['nom'])) . " - " . trim(utf8_encode($aRealisateur['prenom'])) . "</REALISATEUR>\r\n";
		}

		$oPDOStatement = $oPDO->prepare('SELECT nom, prenom FROM acteurs a, individus i WHERE a.ref_code_acteur = i.code_indiv AND a.ref_code_film = ' . (int)$aDataFilm['code_film']);
		$oPDOStatement->execute();
		$aFilmActeurs = $oPDOStatement->fetchAll();
		foreach ($aFilmActeurs as $aDataActeurs) {
			if($nTest == 0){
				$sXml .= "<ACTEURS>\r\n";
				$nTest = 1;
			}
			$sXml .= "<ACTEUR>\r\n";
				$sXml .= "<NOM>" . trim(utf8_encode($aDataActeurs['nom'])) . "</NOM>\r\n";
				$sXml .= "<PRENOM>" . trim(utf8_encode($aDataActeurs['prenom'])) . "</PRENOM>\r\n";
			$sXml .= "</ACTEUR>\r\n";
		}
		if ($nTest == 1) {
			$sXml .= "</ACTEURS>\r\n";
			$nTest = 0;
		}
		$sXml .= "</FILM>\r\n";
	}
    $sXml .= "</FILMS>\r\n";
	$sXml .= "</LISTE>\r\n";

	fwrite($oFile, $sXml);
	header('Location:../index.php');
?>