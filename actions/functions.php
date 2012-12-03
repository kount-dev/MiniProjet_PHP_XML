<?php
function displayBDD($aFilms){
	$sResultat = "";
	foreach($aFilms as $aDataFilm){
		$sResultat .= '<div class="movie">';
		$sResultat .= "<h1>".utf8_encode($aDataFilm['titre_original']) . " - (" . utf8_encode($aDataFilm['titre_francais']) . "- FR)</h1>";

		$aGenres = DB::query('SELECT * FROM genres g, classification c WHERE  c.ref_code_film = :ref_film AND c.ref_code_genre = g.code_genre', array(':ref_film' => (int)$aDataFilm['code_film']));
		$tmp = 0;
		foreach ($aGenres as $aGenre) {
			if($tmp == 0){
				$sResultat .= "<ul>";
				$tmp = 1;
			}
			$sResultat .= '<li class="data genre">' . utf8_encode($aGenre['nom_genre']) . '</li>';
		}
		$sResultat .= "</ul>";
		$sResultat .= '<p><p class="data duree">' . $aDataFilm['duree'] . ' min</p></p>';
		$sResultat .= '<p><p class="data date">' . $aDataFilm['date'] . '</p></p>';
		$sResultat .= '<p><p class="data pays">' . utf8_encode($aDataFilm['pays']) . '</p></p>';

		$aRealisateurs = DB::query('SELECT nom, prenom FROM individus WHERE code_indiv = :indiv',array(':indiv' => (int)$aDataFilm['realisateur']));
		foreach ($aRealisateurs as $aRealisateur) {
			$sResultat .= '<p class="data realisateur">' . utf8_encode($aRealisateur['prenom']) . " " . utf8_encode($aRealisateur['nom']) . '</p>';
		}

		$aFilmActeurs = DB::query('SELECT nom, prenom FROM acteurs a, individus i WHERE a.ref_code_acteur = i.code_indiv AND a.ref_code_film = :code_film', array('code_film' => (int)$aDataFilm['code_film']));
		$tmp = 0;
		foreach ($aFilmActeurs as $aDataActeurs) {
			if($tmp == 0){
				$sResultat .= '<ul class="acteurs">';
				$tmp = 1;
			}
			$sResultat .= '<li class="data">' . utf8_encode($aDataActeurs['prenom']) . ' ' . utf8_encode($aDataActeurs['nom']) . '</li>';
		}
		$sResultat .= "</ul>";
		$sResultat .= "</div>";
	}
	return $sResultat;
}

?>