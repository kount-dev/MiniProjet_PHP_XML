<?php 
include '../config.php';
include 'functions.php';

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

if(isset($_POST['action']) && $_POST['action'] == 'display'){
	echo displayBDD($aFilms, $oPDO);
}
elseif (isset($_POST['action']) && $_POST['action'] == 'export') {
	$document = new DomDocument();
	$document->formatOutput = true;
	$Films = $document->createElement('FILMS');
	$document->appendChild($Films);
	foreach($aFilms as $aDataFilm){
		$Film = $document->createElement('FILM');
		$Films->appendChild($Film);

		$Titre = $document->createElement('TITRE');
		$Film->appendChild($Titre);

		$Original = $document->createElement('ORIGINAL');
		$Titre->appendChild($Original);
		$text = $document->createTextNode(trim(utf8_encode($aDataFilm['titre_original'])));
		$Original->appendChild($text);

		$Francais = $document->createElement('FRANCAIS');
		$Titre->appendChild($Francais);
		$text = $document->createTextNode(trim(utf8_encode($aDataFilm['titre_francais'])));
		$Francais->appendChild($text);

		$oPDOStatement = $oPDO->prepare('SELECT * FROM genres g, classification c WHERE  c.ref_code_film = ' . (int)$aDataFilm['code_film'] . '	AND c.ref_code_genre = g.code_genre');
		$oPDOStatement->execute();
		$aGenres = $oPDOStatement->fetchAll();
		foreach ($aGenres as $aGenre) {
			if($nTest == 0){
				$Genres = $document->createElement('GENRES'); 
				$Film->appendChild($Genres);
				$nTest = 1;
			}
			$Genre = $document->createElement('GENRE');
			$Genres->appendChild($Genre);
			$text = $document->createTextNode($aGenre['code_genre']);
			$Genre->appendChild($text);
		}
		if ($nTest == 1) {$nTest = 0;}
		
		$Duree = $document->createElement('DUREE');
		$Film->appendChild($Duree);
		$text = $document->createTextNode($aDataFilm['duree']);
		$Duree->appendChild($text);

		$Date = $document->createElement('DATE');
		$Film->appendChild($Date);
		$text = $document->createTextNode($aDataFilm['date']);
		$Date->appendChild($text);

		$Pays = $document->createElement('PAYS');
		$Film->appendChild($Pays);
		$text = $document->createTextNode(trim(utf8_encode($aDataFilm['pays'])));
		$Pays->appendChild($text);		

		$Realisateur = $document->createElement('REALISATEUR');
		$Film->appendChild($Realisateur);
		$text = $document->createTextNode($aDataFilm['realisateur']);
		$Realisateur->appendChild($text);		

		$oPDOStatement = $oPDO->prepare('SELECT code_indiv FROM acteurs a, individus i WHERE a.ref_code_acteur = i.code_indiv AND a.ref_code_film = ' . (int)$aDataFilm['code_film']);
		$oPDOStatement->execute();
		$aFilmActeurs = $oPDOStatement->fetchAll();
		foreach ($aFilmActeurs as $aDataActeurs) {
			if($nTest == 0){
				$Acteurs = $document->createElement('ACTEURS');
				$Film->appendChild($Acteurs);
				$nTest = 1;
			}
			$Acteur = $document->createElement('ACTEUR');
			$Acteurs->appendChild($Acteur);
			$text = $document->createTextNode($aDataActeurs['code_indiv']);
			$Acteur->appendChild($text);
		}
		if ($nTest == 1) {$nTest = 0;}
	}

	$document->save('../exports/export'.date("Ymd_H.i.s").'.xml');	
	header('Location:../index.php');
}
?>