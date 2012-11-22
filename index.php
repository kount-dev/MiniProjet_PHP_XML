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
			echo displayBDD($aFilms, $oPDO);
			?>
		</article>
	</section>
</body>
</html>