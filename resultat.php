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
		var_dump(json_encode($aFilms));
	echo json_encode($aFilms);
?>