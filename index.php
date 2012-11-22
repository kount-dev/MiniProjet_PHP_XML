<?php

include 'config.php';
include 'actions/functions.php';
try{
	$oPDO = new PDO(DSN,USER,PASS);
}
catch(PDOException $e) {
	echo 'Connexion échouée : ' . $e->getMessage();
}

$oPDOStatement = $oPDO->prepare('SELECT DISTINCT(code_indiv), nom, prenom FROM individus i, acteurs a WHERE i.code_indiv = a.ref_code_acteur ORDER BY i.nom');
$oPDOStatement->execute();
$aActeurs = $oPDOStatement->fetchAll();

$oPDOStatement = $oPDO->prepare('SELECT DISTINCT(code_indiv), nom, prenom FROM individus i, films f WHERE i.code_indiv = f.realisateur ORDER BY i.nom');
$oPDOStatement->execute();
$aRealisateurs = $oPDOStatement->fetchAll();

$oPDOStatement = $oPDO->prepare('SELECT * FROM genres ORDER BY nom_genre');
$oPDOStatement->execute();
$aGenres = $oPDOStatement->fetchAll();

$oPDOStatement = $oPDO->prepare('SELECT DISTINCT date FROM films ORDER BY date');
$oPDOStatement->execute();
$aAnnée = $oPDOStatement->fetchAll();

$oPDOStatement = $oPDO->prepare('SELECT DISTINCT pays FROM films ORDER BY pays');
$oPDOStatement->execute();
$aPays = $oPDOStatement->fetchAll();

$oPDOStatement = $oPDO->prepare('SELECT * FROM films ORDER BY titre_original');
$oPDOStatement->execute();
$aFilms = $oPDOStatement->fetchAll();

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
	<section id="colonne-droite">
		<label for="nom_acteur">Acteurs : </label>
		<select class="select" name="nom_acteur" id="nom_acteur">
			<option value='rien'>-- Choisir --</option>
			<?php 
			foreach($aActeurs as $aDataActeur){
				echo "<option value='" . $aDataActeur['code_indiv'] . "'>" . utf8_encode($aDataActeur['nom']) . " - " . utf8_encode($aDataActeur['prenom']) . "</option>";
			}
			?>
		</select>
		<br/>

		<label for="nom_realisateur">Réalisateurs : </label>
		<select class="select" name="nom_realisateur" id="nom_realisateur">
			<option value='rien'>-- Choisir --</option>
			<?php 
			foreach($aRealisateurs as $aRealisateur){
				echo "<option value='" . $aRealisateur['code_indiv'] . "'>" . utf8_encode($aRealisateur['nom']) . " - " . utf8_encode($aRealisateur['prenom']) . "</option>";
			}
			?>
		</select>
		<br/>

		<label for="genre_film">Genres : </label>
		<select class="select" name="genre_film" id="genre_film">
			<option value='rien'>-- Choisir --</option>
			<?php 
			foreach($aGenres as $aDataGenre){
				echo "<option value='" . $aDataGenre['code_genre'] . "'>" . utf8_encode($aDataGenre['nom_genre']) . "</option>";
			}
			?>
		</select>
		<br/>

		<label for="annee_film">Année : </label>
		<select class="select" name="annee_film" id="annee_film">
			<option value='rien'>-- Choisir --</option>
			<?php 
			foreach($aAnnée as $aDataAnnee){
				echo "<option value='" . $aDataAnnee['date'] . "'>" . $aDataAnnee['date'] . "</option>";
			}
			?>
		</select>
		<br/>

		<label for="pays_film">Pays : </label>
		<select class="select" name="pays_film" id="pays_film">
			<option value='rien'>-- Choisir --</option>
			<?php 
			foreach($aPays as $aDataPays){
				echo "<option value='" . utf8_encode($aDataPays['pays']) . "'>" . utf8_encode($aDataPays['pays']) . "</option>";
			}
			?>
		</select>
		<br/>

		<input type="button" id="export" value="Exporter en fichier XML"/>
		<input type="button" id="init" value="Réinitialiser les critères"/>
	</section>
	<section id="import">
		<form  enctype="multipart/form-data" action="actions/import.php" method="POST">
			<input type="file" name="xml_import"/>
			<input type="submit" value="Importer le fichier"/>
		</form>
	</section>
	<section id="colonne-gauche">
		<article>
			<?php 
			// foreach($aFilms as $aDataFilm){
			// 	echo "<div>";
			// 	echo "<h1>Titre Original: " . utf8_encode($aDataFilm['titre_original']) . " - (" . utf8_encode($aDataFilm['titre_francais']) . "- FR)</h1>";
			// 	echo "<p>";

			// 	$oPDOStatement = $oPDO->prepare('SELECT * FROM genres g, classification c WHERE  c.ref_code_film = ' . (int)$aDataFilm['code_film'] . '	AND c.ref_code_genre = g.code_genre');
			// 	$oPDOStatement->execute();
			// 	$aGenres = $oPDOStatement->fetchAll();
			// 	foreach ($aGenres as $aGenre) {
			// 		echo "Genre : " . utf8_encode($aGenre['nom_genre']) . "</br>";
			// 	}
			// 	echo "Dur&eacute;e : " . $aDataFilm['duree'] . " min</br>";
			// 	echo "Date : " . $aDataFilm['date'] . "</br>";
			// 	echo "Pays : " . utf8_encode($aDataFilm['pays']) . "</br>";

			// 	$oPDOStatement = $oPDO->prepare('SELECT nom, prenom FROM individus WHERE code_indiv =' . (int)$aDataFilm['realisateur']);
			// 	$oPDOStatement->execute();
			// 	$aRealisateurs = $oPDOStatement->fetchAll();
			// 	foreach ($aRealisateurs as $aRealisateur) {
			// 		echo "R&eacute;alisateur : " . utf8_encode($aRealisateur['nom']) . " - " . utf8_encode($aRealisateur['prenom']) . "</br>";
			// 	}

			// 	$oPDOStatement = $oPDO->prepare('SELECT nom, prenom FROM acteurs a, individus i WHERE a.ref_code_acteur = i.code_indiv AND a.ref_code_film = ' . (int)$aDataFilm['code_film']);
			// 	$oPDOStatement->execute();
			// 	$aFilmActeurs = $oPDOStatement->fetchAll();
			// 	foreach ($aFilmActeurs as $aDataActeurs) {
			// 		echo "Acteur : " . utf8_encode($aDataActeurs['nom']) . " - " . utf8_encode($aDataActeurs['prenom']) . "</br>";
			// 	}
			// 	echo "</p></div>";
			// }
			echo displayBDD($aFilms, $oPDO);
			?>
		</article>
	</section>
</body>
</html>