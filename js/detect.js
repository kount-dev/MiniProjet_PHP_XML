jQuery(function(){
	$('.select').change(function(){
		var nIdActeur = $('#nom_acteur option:selected').val();
		var nIdGenre = $('#genre_film option:selected').val();
		var nAnnee = $('#annee_film option:selected').val();
		var nIdRealisateur = $('#nom_realisateur option:selected').val();
		var sPays = $('#pays_film option:selected').val();
		$.ajax({
	  		type: "POST",
	  		url: "actions/resultat.php",
	  		data: {nom_acteur: nIdActeur, nom_realisateur: nIdRealisateur, genre_film: nIdGenre, annee_film: nAnnee, pays_film: sPays, action: 'display'},
	  		success: function (res){
	  			$('#colonne-gauche article').html(res);
			}
		});
	});
	$('input#export').click(function(){
		var nIdActeur = $('#nom_acteur option:selected').val();
		var nIdGenre = $('#genre_film option:selected').val();
		var nAnnee = $('#annee_film option:selected').val();
		var nIdRealisateur = $('#nom_realisateur option:selected').val();
		var sPays = $('#pays_film option:selected').val();
		$.ajax({
	  		type: "POST",
	  		url: "actions/resultat.php",
	  		data: {nom_acteur: nIdActeur, nom_realisateur: nIdRealisateur, genre_film: nIdGenre, annee_film: nAnnee, pays_film: sPays, action: 'export'},
		});
	});
	$('input#init').click(function(){
		location.reload();
	}
});	