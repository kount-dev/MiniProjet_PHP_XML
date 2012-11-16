jQuery(function(){
	$('.select').click(function(){
		var nIdActeur = $('#nom_acteur option:selected').val();
		var nIdGenre = $('#genre_film option:selected').val();
		var nAnnee = $('#annee_film option:selected').val();
		var sPays = $('#pays_film option:selected').val();
		$.ajax({
	  		type: "POST",
	  		url: "resultat.php",
	  		data: {acteur: nIdActeur, genre: nIdGenre, annee: nAnnee, pays: sPays},
	  		dataType: "application/json",
	  		success: function (res){
	  			traitement(res);
			}
		});
	});
});

function traitement(aData){
	var oArticle = $('#colonne-gauche article').html('');
			console.log(aData);

	for(item in aData){
		console.log(item);
	}
	// $.each(aData, function(nFirstKey, aSecondArray){
	// 	console.log('test');
		// oArticle.append("div").html("<h1>Titre Original: " + aSecondArray['titre_original'] + " - (" + aSecondArray['titre_francais'] + "- FR)</h1><p>Genre : " + aSecondArray['nom_genre'] + "</br>Dur&eacute;e : " + aSecondArray['duree'] + "</br>Date : " + aSecondArray['date'] + "</br>Pays : " + aSecondArray['pays'] + "</br>R&eacute;alisateur : " + aSecondArray['realisateur'] + "</br>");

			// $oPDOStatement = $oPDO->prepare('SELECT nom, prenom FROM acteurs a, individus i WHERE a.ref_code_acteur = i.code_indiv AND a.ref_code_film = ' . (int)$aDataFilm['code_film']);
			// 				$oPDOStatement->execute();
			// 				$aFilmActeurs = $oPDOStatement->fetchAll();
			// 				foreach ($aFilmActeurs as $aDataActeurs) {
			// 					echo "Acteur : " . $aDataActeurs['nom'] . " - " . $aDataActeurs['prenom'] . "</br>";
			// 				}
			// 			echo "</p></div>";
			// 		}
			// 	?>
	// });

}