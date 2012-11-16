jQuery(function(){
	$('.select').click(function(){
		console.log('test');
		// var nIdActeur = $('#nom_acteur option:selected').val();
		// var nIdGenre = $('#genre_film option:selected').val();
		// var nAnnee = $('#annee_film option:selected').val();
		// var nIdRealisateur = $('#nom_realisateur option:selected').val();
		// var sPays = $('#pays_film option:selected').val();
		// console.log(sPays);
		// $.ajax({
	 //  		type: "POST",
	 //  		url: "resultat.php",
	 //  		data: {nom_acteur: nIdActeur, nom_realisateur: nIdRealisateur, genre_film: nIdGenre, annee_film: nAnnee, pays_film: sPays},
	 //  		success: function (res){
	 //  			traitement(res);
		// 	}
		// });
	});
});

function traitement(aData){
	console.log(aData);
	$('#colonne-gauche article').html(aData);

}