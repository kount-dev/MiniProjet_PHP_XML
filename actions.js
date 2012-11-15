$('.select').change(function(){
	var nIdAuteur = $('#nom_auteur option:selected').val();
	var nIdGenre = $('#genre_film option:selected').val();
	var nAnnee = $('#annee_film option:selected').val();
	var sPays =$('#pays_film option:selected').val();

	$.ajax({
  		type: "POST",
  		url: "resultat.php",
  		dataType: "json",
  		data {auteur: nIdAuteur, genre: nIdGenre, annee: nAnnee, pays: sPays},
  		success: function (res){
  			traitement(res);
  		}
	});
});

function traitement(jsonData){
	
}