<?php 
	include '../config.php';

	try{
		$oPDO = new PDO(DSN,USER,PASS);
	}
	catch(PDOException $e) {
    	echo 'Connexion échouée : ' . $e->getMessage();
	}
	
	$sResultat = "";
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
	foreach($aFilms as $aDataFilm){
		$sResultat .= "<div>";
		$sResultat .= "<h1>Titre Original: " . utf8_encode($aDataFilm['titre_original']) . " - (" . utf8_encode($aDataFilm['titre_francais']) . "- FR)</h1>";
		$sResultat .= "<p>";
							
		$oPDOStatement = $oPDO->prepare('SELECT * FROM genres g, classification c WHERE  c.ref_code_film = ' . (int)$aDataFilm['code_film'] . '	AND c.ref_code_genre = g.code_genre');
		$oPDOStatement->execute();
		$aGenres = $oPDOStatement->fetchAll();
		foreach ($aGenres as $aGenre) {
			$sResultat .= "Genre : " . utf8_encode($aGenre['nom_genre']) . "</br>";
		}
		$sResultat .= "Dur&eacute;e : " . $aDataFilm['duree'] . " min</br>";
		$sResultat .= "Date : " . $aDataFilm['date'] . "</br>";
		$sResultat .= "Pays : " . utf8_encode($aDataFilm['pays']) . "</br>";
		
		$oPDOStatement = $oPDO->prepare('SELECT nom, prenom FROM individus WHERE code_indiv =' . (int)$aDataFilm['realisateur']);
		$oPDOStatement->execute();
		$aRealisateurs = $oPDOStatement->fetchAll();
		foreach ($aRealisateurs as $aRealisateur) {
			$sResultat .= "R&eacute;alisateur : " . utf8_encode($aRealisateur['nom']) . " - " . utf8_encode($aRealisateur['prenom']) . "</br>";
		}
		
		$oPDOStatement = $oPDO->prepare('SELECT nom, prenom FROM acteurs a, individus i WHERE a.ref_code_acteur = i.code_indiv AND a.ref_code_film = ' . (int)$aDataFilm['code_film']);
		$oPDOStatement->execute();
		$aFilmActeurs = $oPDOStatement->fetchAll();
		foreach ($aFilmActeurs as $aDataActeurs) {
			$sResultat .= "Acteur : " . utf8_encode($aDataActeurs['nom']) . " - " . utf8_encode($aDataActeurs['prenom']) . "</br>";
		}
		$sResultat .= "</p></div>";
	}
	echo $sResultat;
?>