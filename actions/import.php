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
	if(sizeof($aMatch) >= 1){
		//on test si le titre existe && si le realisateur existe
		$aTest1 = DB::query('SELECT titre_original, code_indiv FROM films, individus WHERE titre_original = :titre && code_indiv = :v_realisateur', array(':titre' => $CARAC_VALUE['TITRE']['ORIGINAL_0'], ':v_realisateur' => $CARAC_VALUE['REALISATEUR']));
		if(sizeof($aTest1) >= 1){
			//on insert le titre, durée, date, pays, realisateur => FILM
/*			$titre_o = $CARAC_VALUE['TITRE']['ORIGINAL_0'];
			$titre_fr = $CARAC_VALUE['TITRE']['FRANCAIS_1'];
			$pays = $CARAC_VALUE['PAYS'];
			$date = $CARAC_VALUE['DATE'];
			$duree = $CARAC_VALUE['DUREE'];
			$realisateur = $CARAC_VALUE['REALISATEUR'];
			*/
			$insert1 = DB::query('INSERT INTO films (titre_original, titre_français, pays, date, duree, realisateur) VALUES("'.$CARAC_VALUE['TITRE']['ORIGINAL_0'].'", "'.$CARAC_VALUE['TITRE']['FRANCAIS_1'].'", "'.$CARAC_VALUE['PAYS'].'", "'.$CARAC_VALUE['DATE'].'", "'.$CARAC_VALUE['DUREE'].'", "'.$CARAC_VALUE['REALISATEUR'].'")');
			//si individus existe
				//on fait le lien acteurs / films
			//si les genre existe
				//on fait le lien genres / films
		}
	}
	
}

// JE T'AI TOUT MIS DANS UN TABLEAU JE TE DONNE UN EXEMPLE DU TABLEAU
/*
array(1) { 
	["FILM_0"]=> array(7) { 
		["TITRE"]=> array(2) { 
			["ORIGINAL_0"]=> string(14) "Dédée d'Anvers" 
			["FRANCAIS_1"]=> string(14) "Dédée d'Anvers" 
		} 
		["GENRES"]=> array(3) { 
			["GENRE_0"]=> string(1) "7" 
			["GENRE_1"]=> string(1) "5" 
			["GENRE_2"]=> string(1) "1" 
		} 
		["DUREE"]=> string(2) "86" 
		["DATE"]=> string(4) "1948" 
		["PAYS"]=> string(6) "France" 
		["REALISATEUR"]=> string(3) "508" 
		["ACTEURS"]=> array(3) { 
			["ACTEUR_0"]=> string(3) "175" 
			["ACTEUR_1"]=> string(3) "509" 
			["ACTEUR_2"]=> string(3) "302" 
		} 
	} 
}
*/


?>