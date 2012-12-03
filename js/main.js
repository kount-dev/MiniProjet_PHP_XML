$(function(){


	/********************* SEARCHING OPTION ******************/

	$('#search_acteur').domsearch('#select_acteur');
	$('#search_realisateur').domsearch('#select_realisateur');
	$('#search_genre').domsearch('#select_genre');
	$('#search_annee').domsearch('#select_annee');
	$('#search_pays').domsearch('#select_pays');

	$('.settings .categorie').click(function(){
		var id=$(this).attr('id');
		$('.select').removeClass('active');
		$('#select_'+id).addClass('active');

		$('.search').removeClass('active');
		$('#search_'+id).addClass('active');
	});

	/************** SELECT OPTION *********************/

	var choice_acteur="rien";
	var choice_realisateur="rien";
	var choice_genre="rien";
	var choice_annee="rien";
	var choice_pays="rien";


	$('.categorie i').click(function(){
		switch($(this).parent().attr('id')){
			case "acteur":
			choice_acteur="rien";
			case "realisateur":
			choice_realisateur="rien";
			case "genre":
			choice_genre="rien";
			case "annee":
			choice_annee="rien";
			case "pays":
			choice_pays="rien";
		}
		$(this).css('display','none');
		$(this).parent().find(".choice").css('display','none');
		request("display");
	});

	$('#select_acteur li').click(function(){
		console.log()
		choice_acteur=$(this).attr('id');
		$('#acteur .choice').html($(this).html());
		$('#acteur i').css('display','block');
		request("display");
	});
	$('#select_realisateur li').click(function(){
		choice_realisateur=$(this).attr('id');
		$('#realisateur .choice').html($(this).html());
		$('#realisateur i').css('display','block');
		request("display");
	});
	$('#select_genre li').click(function(){
		choice_genre=$(this).attr('id');
		$('#genre .choice').html($(this).html());
		$('#genre i').css('display','block');
		request("display");
	});
	$('#select_annee li').click(function(){
		choice_annee=$(this).attr('id');
		$('#annee .choice').html($(this).html());
		$('#annee i').css('display','block');
		request("display");
	});
	$('#select_pays li').click(function(){
		choice_pays=$(this).attr('id');
		$('#pays .choice').html($(this).html());
		$('#pays i').css('display','block');
		request("display");
	});

	/****************** EXPORT ***********************/
	$('#export').click(function(){
		request("export");
	});

	function request(type){
		console.log("Args status:");
		console.log("choice_acteur: "+choice_acteur);
		console.log("choice_realisateur: "+choice_realisateur);
		console.log("choice_genre: "+choice_genre);
		console.log("choice_annee: "+choice_annee);
		console.log("choice_pays: "+choice_pays);

		$('header #img_title').addClass("loading");
		$.ajax({
			type: "POST",
			url: "actions/resultat.php",
			data: {nom_acteur: choice_acteur, nom_realisateur: choice_realisateur, genre_film: choice_genre, annee_film: choice_annee, pays_film: choice_pays, action: type},
			success: function (res){
				$('header #img_title').removeClass("loading");
				if(type=="display")
					$('#colonne-gauche').html(res);
				else{
					$('#popup').slideDown();
					setTimeout(function() {
						$('#popup').slideUp();
					}, 10000);
				}
			}
		});
	}

	$('#popup i').click(function(){
		$(this).parent().slideUp();
	});
})