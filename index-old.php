<?php

include 'config.php';
include 'actions/functions.php';
include 'classes/DB.php';

DB::connect(DSN,USER,PASS);

$aActeurs = DB::query('SELECT DISTINCT(code_indiv), nom, prenom FROM individus i, acteurs a WHERE i.code_indiv = a.ref_code_acteur ORDER BY i.nom',NULL);
$aRealisateurs = DB::query('SELECT DISTINCT(code_indiv), nom, prenom FROM individus i, films f WHERE i.code_indiv = f.realisateur ORDER BY i.nom',NULL);
$aGenres = DB::query('SELECT * FROM genres ORDER BY nom_genre',NULL);
$aAnnee = DB::query('SELECT DISTINCT date FROM films ORDER BY date',NULL);
$aPays = DB::query('SELECT DISTINCT pays FROM films ORDER BY pays',NULL);
$aFilms = DB::query('SELECT * FROM films ORDER BY titre_original',NULL);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/style.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/detect.js"></script>
</head>
<body>
	<header>
		<h1>Movies Selector</h1>
	</header>
	<div id="content">
		<section id="colonne-droite" class="grad">
			<section class="categorie">
				<h1>Filters</h1>
				<label id="acteurs" for="nom_acteur">Acteurs</label>
		<!-- <select class="select" name="nom_acteur" id="nom_acteur">
			<option value='rien'>-- Choisir --</option>
			// <?php 
			// foreach($aActeurs as $aDataActeur){
			// 	echo "<option value='" . $aDataActeur['code_indiv'] . "'>" . utf8_encode($aDataActeur['nom']) . " - " . utf8_encode($aDataActeur['prenom']) . "</option>";
			// }
			?>
		</select> -->

		<label id="realisateur" for="nom_realisateur">Réalisateurs</label>
<!-- 		<select class="select" name="nom_realisateur" id="nom_realisateur">
			<option value='rien'>-- Choisir --</option>
			<?php 
			// foreach($aRealisateurs as $aRealisateur){
			// 	echo "<option value='" . $aRealisateur['code_indiv'] . "'>" . utf8_encode($aRealisateur['nom']) . " - " . utf8_encode($aRealisateur['prenom']) . "</option>";
			// }
			?>
		</select> -->

		<label id="genre" for="genre_film">Genres</label>
<!-- 		<select class="select" name="genre_film" id="genre_film">
			<option value='rien'>-- Choisir --</option>
			<?php 
			// foreach($aGenres as $aDataGenre){
			// 	echo "<option value='" . $aDataGenre['code_genre'] . "'>" . utf8_encode($aDataGenre['nom_genre']) . "</option>";
			// }
			?>
		</select> -->

		<label id="annee" for="annee_film">Année</label>
<!-- 		<select class="select" name="annee_film" id="annee_film">
			<option value='rien'>-- Choisir --</option>
			<?php 
			// foreach($aAnnee as $aDataAnnee){
			// 	echo "<option value='" . $aDataAnnee['date'] . "'>" . $aDataAnnee['date'] . "</option>";
			// }
			?>
		</select> -->

		<label id="pays" for="pays_film">Pays</label>
<!-- 		<select class="select" name="pays_film" id="pays_film">
			<option value='rien'>-- Choisir --</option>
			<?php 
			// foreach($aPays as $aDataPays){
			// 	echo "<option value='" . utf8_encode($aDataPays['pays']) . "'>" . utf8_encode($aDataPays['pays']) . "</option>";
			// }
			?>
		</select> -->
	</section>

	<!-- 	<input type="button" id="export" value="Exporter en fichier XML"/>
	<input type="button" id="init" value="Réinitialiser les critères"/> -->
</section>
<section class="categorie">
	<h1>Export</h1>
	
</section>
<!-- 	<section id="import">
		<form  enctype="multipart/form-data" action="actions/import.php" method="POST">
			<input type="file" name="xml_import"/>
			<input type="submit" value="Importer le fichier"/>
		</form>
	</section> -->
	<section id="colonne-gauche">
		<!-- <article>
			<?php 
			// echo displayBDD($aFilms);
			?>
		</article> -->
	</section>
</div>
</body>
</html>