<?php 
include '../config.php';
include '../classes/DB.php';

DB::connect(DSN,USER,PASS);

$oFile = simplexml_load_file($_FILES['xml_import']['tmp_name']);

foreach ($oFile->children() as $FILM => $FILM_FILS){
	echo $FILM . '<br>';
	foreach ($FILM_FILS->children() as $CARAC => $CARAC_VALUE) {
		echo $CARAC;
		if($CARAC == "TITRE" || $CARAC == "GENRES" || $CARAC == "ACTEURS"){
			echo '<br>';
			foreach ($CARAC_VALUE->children() as $OBJ => $TEXT){
				echo $OBJ . ' = ' . utf8_decode($TEXT) . '<br>';
				
			
				// si la paire n existe pas
					// on test si le titre existe && si le realisateur existe
						// on insert le titre, durée, date, payx, realisateur => FILM
						// si individus existe
							// on fait le lien acteurs / films
						// si les genre existe
							// on fait le lien genres / films
					//sinon 
				//sinon le film existe deja


			} 
		}
		else{
			echo ' = ' . utf8_decode($CARAC_VALUE) . '<br>'; 
		}
	}
}




?>