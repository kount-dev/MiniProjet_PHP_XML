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
	<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="js/liquidmetal.js"></script>
	<script type="text/javascript" src="js/domsearch.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>
	<header>
		<span id="img_title"></span>
		<h1>Movies Selector</h1>
	</header>
	<section id="colonne-droite" class="grad">
		<input id="search_acteur" class="search" type="text" placeholder="Search..."/>
		<input id="search_realisateur" class="search" type="text" placeholder="Search..."/>
		<input id="search_genre" class="search" type="text" placeholder="Search..."/>
		<input id="search_annee" class="search" type="text" placeholder="Search..."/>
		<input id="search_pays" class="search" type="text" placeholder="Search..."/>
		<section class="settings">
			<h1>Filters</h1>
			<div class="categorie" id="acteur">Acteurs<i></i><span class="choice"></span></div>
			<div class="categorie" id="realisateur">Réalisateurs<i></i><span class="choice"></span></div>
			<div class="categorie" id="genre">Genres<i></i><span class="choice"></span></div>
			<div class="categorie" id="annee">Année<i></i><span class="choice"></span></div>
			<div class="categorie" id="pays">Pays<i></i><span class="choice"></span></div>
		</section>
		<section class="settings">
			<h1>Export</h1>
			<input type="button" id="export" class="btn" value="Exporter en fichier XML"/>
		</section>
		<section class="settings">
			<h1>Import</h1>
			<form enctype="multipart/form-data" action="actions/import.php" method="POST">
				<input type="file" id="choose_file" name="xml_import"/>
				<input type="button" id="import" class="btn" value="Parcourir"/>
				<input type="submit" id="file_submit" class="btn" value="Importer le fichier"/>
			</form>
		</section>
	</section>
	<div id="content">
		<section id="colonne-middle">
			<ul id="select_acteur" class="select">
				<?php 
				foreach($aActeurs as $aDataActeur){
					echo '<li id="' . $aDataActeur['code_indiv'] . '">' . strtoupper(utf8_encode($aDataActeur['nom'])) . ' ' . utf8_encode($aDataActeur['prenom']) . '</li>';
				}
				?>
			</ul>
			<ul id="select_realisateur" class="select">
				<?php 
				foreach($aRealisateurs as $aRealisateur){
					echo '<li id="' . $aRealisateur['code_indiv'] . '">' . strtoupper(utf8_encode($aRealisateur['nom'])) . ' ' . utf8_encode($aRealisateur['prenom']) . '</li>';
				}
				?>
			</ul>
			<ul id="select_genre" class="select">
				<?php 
				foreach($aGenres as $aDataGenre){
					echo '<li id="' . $aDataGenre['code_genre'] . '">' . utf8_encode($aDataGenre['nom_genre']) . '</li>';
				}
				?>
			</ul>
			<ul id="select_annee" class="select">
				<?php 
				foreach($aAnnee as $aDataAnnee){
					echo '<li id="' . $aDataAnnee['date'] . '">' . $aDataAnnee['date'] . '</li>';
				}
				?>
			</ul>
			<ul id="select_pays" class="select">
				<?php 
				foreach($aPays as $aDataPays){
					echo '<li id="' . utf8_encode($aDataPays['pays']) . '">' . utf8_encode($aDataPays['pays']) . '</li>';
				}
				?>
			</ul>
		</section>
		<section id="colonne-gauche">
			<?php 
			echo displayBDD($aFilms);
			?>
		</section>
	</div>
	<footer>
		<pre>Designed & Developped by [ Virtual-Dev ]  [ Kount-Dev ]  [ Antoninh ] </pre>
	</footer>
	<div id="popup">
		<i></i>
		<h3>Notification</h3>
		<p>Content of notification</p>
	</div>
</body>
</html>