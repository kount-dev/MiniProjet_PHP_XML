<?php

	include 'config.php';

	try{
		$oPDO = new PDO(DSN,USER,PASS);
	}
	catch(PDOException $e) {
    	echo 'Connexion échouée : ' . $e->getMessage();
	}

	$oPDOStatement = $oPDO->prepare('SELECT * FROM individus');
	$oPDOStatement->execute();
	$aActeurs = $oPDOStatement->fetchAll();

	$oPDOStatement = $oPDO->prepare('SELECT * FROM genres');
	$oPDOStatement->execute();
	$aGenres = $oPDOStatement->fetchAll();
	
	$oPDOStatement = $oPDO->prepare('SELECT DISTINCT date FROM films');
	$oPDOStatement->execute();
	$aAnnée = $oPDOStatement->fetchAll();
	
	$oPDOStatement = $oPDO->prepare('SELECT DISTINCT pays FROM films');
	$oPDOStatement->execute();
	$aPays = $oPDOStatement->fetchAll();
	
	$oPDOStatement = $oPDO->prepare('SELECT * FROM films f, genres g, classification c
		WHERE f.code_film = c.ref_code_film
		AND c.ref_code_genre = g.code_genre');
	$oPDOStatement->execute();
	$aFilms = $oPDOStatement->fetchAll();

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<script type="text/javascript" src="jquery.js"></script>
		<script type="text/javascript" src="actions.js"></script>
	</head>
	<body>
		<section id="colonne-droite">
			<form action="export.php" method="POST">
				<select class="select" name="nom_acteur" id="nom_acteur">
					<option value='rien'>-- Choisir --</option>
					<?php 
						foreach($aActeurs as $aDataActeur){
							echo "<option value='" . $aDataActeur['code_indiv'] . "'>" . utf8_encode($aDataActeur['nom']) . " - " . utf8_encode($aDataActeur['prenom']) . "</option>";
						}
					?>
				</select>
				<select class="select" name="genre_film" id="genre_film">
					<option value='rien'>-- Choisir --</option>
					<?php 
						foreach($aGenres as $aDataGenre){
							echo "<option value='" . $aDataGenre['code_genre'] . "'>" . utf8_encode($aDataGenre['nom_genre']) . "</option>";
						}
					?>
				</select>
				<select class="select" name="annee_film" id="annee_film">
					<option value='rien'>-- Choisir --</option>
					<?php 
						foreach($aAnnée as $aDataAnnee){
							echo "<option value='" . $aDataAnnee['date'] . "'>" . $aDataAnnee['date'] . "</option>";
						}
					?>
				</select>
				<select class="select" name="pays_film" id="pays_film">
					<option value='rien'>-- Choisir --</option>
					<?php 
						foreach($aPays as $aDataPays){
							echo "<option value='" . utf8_encode($aDataPays['pays']) . "'>" . utf8_encode($aDataPays['pays']) . "</option>";
						}
					?>
				</select>
				<input type="submit" value="Exporter en fichier XML">
			</form>
		</section>
		<section id="colonne-gauche">
			<article>
				<?php 
					foreach($aFilms as $aDataFilm){
						echo "<div>";
							echo "<h1>Titre Original: " . utf8_encode($aDataFilm['titre_original']) . " - (" . utf8_encode($aDataFilm['titre_francais']) . "- FR)</h1>";
							echo "<p>Genre : " . utf8_encode($aDataFilm['nom_genre']) . "</br>";
							echo "Dur&eacute;e : " . $aDataFilm['duree'] . "</br>";
							echo "Date : " . $aDataFilm['date'] . "</br>";
							echo "Pays : " . utf8_encode($aDataFilm['pays']) . "</br>";
							echo "R&eacute;alisateur : " . utf8_encode($aDataFilm['realisateur']) . "</br>";
							$oPDOStatement = $oPDO->prepare('SELECT nom, prenom FROM acteurs a, individus i WHERE a.ref_code_acteur = i.code_indiv AND a.ref_code_film = ' . (int)$aDataFilm['code_film']);
							$oPDOStatement->execute();
							$aFilmActeurs = $oPDOStatement->fetchAll();
							foreach ($aFilmActeurs as $aDataActeurs) {
								echo "Acteur : " . utf8_encode($aDataActeurs['nom']) . " - " . utf8_encode($aDataActeurs['prenom']) . "</br>";
							}
						echo "</p></div>";
					}
				?>
			</article>
		</section>
	</body>
</html>