<?php 


	include 'config.php';

	try{
		$oPDO = new PDO(DSN,USER,PASS);
	}
	catch(PDOException $e) {
    	echo 'Connexion échouée : ' . $e->getMessage();
	}

	$aActeurs = $oPDO->prepare('SELECT * FROM individus')->execute();
	$aGenres = $oPDO->prepare('SELECT * FROM genre')->execute();
	$aAnnée = $oPDO->prepare('SELECT DISTINCT date FROM films')->execute();
	$aPays = $oPDO->prepare('SELECT DISTINCT pays FROM films')->execute();
	$aFilms = $oPDO->prepare('SELECT * FROM films f, genre g, classification c
		WHERE f.code = c.ref_code_film
		AND c.ref_code_genre = g.code_genre')->execute();

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<section id="colonne-droite">
			<select class="select" name="nom_acteur" id="nom_acteur">
				<?php 
					foreach($aActeurs as $aDataActeur){
						echo "<option value='" . $aDataActeur['code_individus'] . "'>$aDataActeur['nom'] - $aDataActeur['prenom']</option>";
					}
				?>
			</select>
			<select class="select" name="genre_film" id="genre_film">
				<?php 
					foreach($aGenres as $aDataGenre){
						echo "<option value='" . $aDataGenre['code_genre'] . "'>$aDataGenre['nom_genre']</option>";
					}
				?>
			</select>
			<select class="select" name="annee_film" id="annee_film">
				<?php 
					foreach($aAnnée as $aDataAnnee){
						echo "<option value='" . $aDataAnnee['date'] . "'>$aDataAnnee['date']</option>";
					}
				?>
			</select>
			<select class="select" name="pays_film" id="pays_film">
				<?php 
					foreach($aPays as $aDataPays){
						echo "<option value='" . $aDataPays['pays'] . "'>$aDataPays['pays']</option>";
					}
				?>
			</select>
		</section>
		<section id="colonne-gauche">
			<article>
				<?php 
					foreach($aFilms as $aDataFilm){
						echo "<div>";
							echo "<h1>Titre Original: $aDataFilm['titre_original'] - ($aDataFilm['titre_francais'] - FR)</h1>";
							echo "<p>Genre : $aDataFilm['nom_genre']</p>";
							echo "<p>Dur&eacute;e : $aDataFilm['duree']</p>";
							echo "<p>Date : $aDataFilm['date']</p>";
							echo "<p>Pays : $aDataFilm['pays']</p>";
							echo "<p>R&eacute;alisateur : $aDataFilm['realisateur']</p>";
							$aFilmActeurs = $oPDO->prepare('SELECT nom, prenom FROM acteurs a, classification c WHERE ref_code_acteur = code_individus AND ref_code_film = ?', $aDataFilm['code']);
							foreach ($aFilmActeurs as $aDataActeurs) {
								echo "<p>Acteur : $aDataActeurs['nom'] - $aDataActeurs['prenom']</p>";
							}
						echo "</div>";
					}
				?>
			</article>
		</section>
	</body>
</html>