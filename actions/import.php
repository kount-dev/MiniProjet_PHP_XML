<?php 
$test = simplexml_load_file($_FILES['xml_import']['tmp_name']);

foreach ($test->children() as $FILM => $FILS){
	echo $FILM . '<br>';
	foreach ($FILS->children() as $DESC => $VALUE) {
		echo $DESC;
		if($DESC == "TITRE" || $DESC == "GENRES" || $DESC == "ACTEURS"){
			echo '<br>';
			foreach ($VALUE->children() as $OBJ => $TRUCK){
				echo $OBJ . ' = ' . utf8_decode($TRUCK) . '<br>';
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
			echo ' = ' . utf8_decode($VALUE) . '<br>'; 
		}
	}
}




?>