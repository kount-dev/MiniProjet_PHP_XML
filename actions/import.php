<?php 
include '../config.php';
include '../classes/DB.php';

DB::connect(DSN,USER,PASS);

$oFile = simplexml_load_file($_FILES['xml_import']['tmp_name']);
$nInt = 0;
$aFilms = array();
foreach ($oFile->children() as $FILM => $FILM_FILS){
	foreach ($FILM_FILS->children() as $CARAC => $CARAC_VALUE) {
		if($CARAC == "TITRE" || $CARAC == "GENRES" || $CARAC == "ACTEURS"){
			$nIntTMP = 0;
			foreach ($CARAC_VALUE->children() as $OBJ => $TEXT){
				$aFilms[$FILM . '_' . $nInt][$CARAC][$OBJ . '_' . $nIntTMP] = utf8_decode($TEXT);
				$nIntTMP++;
			}
		}
		else{
			$aFilms[$FILM . '_' . $nInt][$CARAC] = utf8_decode($CARAC_VALUE); 
		}
	}
	$nInt++;
}

foreach ($aFilms as $CARAC => $CARAC_VALUE) { // FILM_N
	$aMatch = DB::query('SELECT code_film FROM films WHERE titre_original = :titre && realisateur = :v_realisateur', array(':titre' => $CARAC_VALUE['TITRE']['ORIGINAL_0'], ':v_realisateur' => $CARAC_VALUE['REALISATEUR']));
	// si la paire n existe pas
	if(sizeof($aMatch) < 1){
		// test si le realisateur existe
		$aTest1 = DB::query('SELECT code_indiv FROM individus WHERE code_indiv = :v_realisateur', array(':v_realisateur' => $CARAC_VALUE['REALISATEUR']));
		if(sizeof($aTest1) >= 1){
			//on insert le titre, durée, date, pays, realisateur => FILM
			DB::query('INSERT INTO films (titre_original, titre_francais, pays, date, duree, realisateur) VALUES(:titreOR, :titreFR, :pays, :date, :duree, :realisateur)',array(':titreOR' => $CARAC_VALUE['TITRE']['ORIGINAL_0'], ':titreFR' => $CARAC_VALUE['TITRE']['FRANCAIS_1'], ':pays' => $CARAC_VALUE['PAYS'], ':date' => $CARAC_VALUE['DATE'], ':duree' => $CARAC_VALUE['DUREE'], 'realisateur' => $CARAC_VALUE['REALISATEUR']));
			$aQueryVerif = DB::query('SELECT code_film FROM films WHERE titre_original = :titre && realisateur = :v_realisateur', array(':titre' => $CARAC_VALUE['TITRE']['ORIGINAL_0'], ':v_realisateur' => $CARAC_VALUE['REALISATEUR']));
			$nCodeFilm = $aQueryVerif[0]['code_film']; 
			
			//si genre existe on relie
			foreach ($CARAC_VALUE['GENRES'] as $GENRE) {
				// test si le genre existe
				$aTest2 = DB::query('SELECT code_genre FROM genres WHERE code_genre = :v_genre', array(':v_genre' => $GENRE));
				if(sizeof($aTest2) >= 1){
					DB::query('INSERT INTO classification (ref_code_film, ref_code_genre) VALUES(:film, :genre)',array(':film' => $nCodeFilm, ':genre' => $GENRE));
					$aTest2 = 0;
				}
			}
			//si individus existe on relie
			foreach ($CARAC_VALUE['ACTEURS'] as $ACTEUR) {
				// test si le genre existe
				$aTest2 = DB::query('SELECT code_indiv FROM individus WHERE code_indiv = :v_indiv', array(':v_indiv' => $ACTEUR));
				if(sizeof($aTest2) >= 1){
					DB::query('INSERT INTO acteurs (ref_code_film, ref_code_acteur) VALUES(:film, :indiv)',array(':film' => $nCodeFilm, ':indiv' => $ACTEUR));
					$aTest2 = 0;
				}
			}
		}
	}
	
}

header("Location:../index.php");

?>