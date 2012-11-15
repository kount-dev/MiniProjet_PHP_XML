<?php 
	$sQuery = "";
	$aValeurs = new array();

	if(isset($_POST['genre']) && $_POST['genre'] != "rien"){ $sQuery .=  "AND g.code_genre = :genre "; $aValeurs[':genre'] = $_POST['genre'];}
	if(isset($_POST['acteur']) && $_POST['acteur'] != "rien"){ $sQuery .=  "AND i.code_individus = :acteur "; $aValeurs[':acteur'] = $_POST['acteur'];}
	if(isset($_POST['pays']) && $_POST['pays'] != "rien"){ $sQuery .=  "AND f.pays = :pays ";$aValeurs[':pays'] = $_POST['pays'];}
	if(isset($_POST['annee']) && $_POST['annee'] != "rien"){ $sQuery .=  "AND f.date = :annee ";$aValeurs[':annee'] = $_POST['annee'];}

	$oPDOStatement = $oPDO->prepare('SELECT * FROM films f, genre g, classification c, acteurs a, individus i 
		WHERE f.code = c.ref_code_film
		AND c.ref_code_genre = g.code_genre
		AND a.ref_code_acteur = i.code_individus 
		AND f.code = a.ref_code_film ' . $sQuery, $aValeurs);
	$oPDOStatement->execute();
	$aFilms = $oPDOStatement->fetchAll();

	echo json_encode($aFilms);
?>