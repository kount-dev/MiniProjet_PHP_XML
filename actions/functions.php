<?php
function displayBDD($aFilms, $oPDO){
	$sResultat = "";
	foreach($aFilms as $aDataFilm){
		$sResultat .= "<div>";
		$sResultat .= "<h1>Titre Original: " . utf8_encode($aDataFilm['titre_original']) . " - (" . utf8_encode($aDataFilm['titre_francais']) . "- FR)</h1>";
		$sResultat .= "<p>";

		$oPDOStatement = $oPDO->prepare('SELECT * FROM genres g, classification c WHERE  c.ref_code_film = ' . (int)$aDataFilm['code_film'] . '	AND c.ref_code_genre = g.code_genre');
		$oPDOStatement->execute();
		$aGenres = $oPDOStatement->fetchAll();
		$tmp = 0;
		foreach ($aGenres as $aGenre) {
			if($tmp == 0){
				$sResultat .= "<p>Genre :</p>";
				$sResultat .= "<ul>";
				$tmp = 1;
			}
			$sResultat .= "<li>" . utf8_encode($aGenre['nom_genre']) . "</li>";
		}
		$sResultat .= "</ul>";
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
		$tmp = 0;
		foreach ($aFilmActeurs as $aDataActeurs) {
			if($tmp == 0){
				$sResultat .= "<p>Acteurs :</p>";
				$sResultat .= "<ul>";
				$tmp = 1;
			}
			$sResultat .= "<li>" . utf8_encode($aDataActeurs['nom']) . " - " . utf8_encode($aDataActeurs['prenom']) . "</li>";
		}
		$sResultat .= "</ul>";
		$sResultat .= "</p></div>";
	}
	return $sResultat;
}

?>